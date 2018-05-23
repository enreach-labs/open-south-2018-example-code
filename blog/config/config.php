<?php

namespace {
    use Operator\Common\Infrastructure\Value\UuidGenerator;
    use Prooph\Common\Event\ProophActionEventEmitter;
    use Prooph\Common\Messaging\FQCNMessageFactory;
    use Prooph\EventStore\ActionEventEmitterEventStore;
    use Prooph\EventStore\Pdo\MySqlEventStore;
    use Prooph\EventStore\Pdo\PersistenceStrategy\MySqlAggregateStreamStrategy;
    use Prooph\EventStore\Pdo\Projection\MySqlProjectionManager;
    use Prooph\EventStoreBusBridge\EventPublisher;
    use Prooph\ServiceBus\CommandBus;
    use Prooph\ServiceBus\EventBus;
    use Prooph\ServiceBus\Plugin\Router\CommandRouter;
    use Prooph\ServiceBus\Plugin\Router\EventRouter;
    use Prooph\ServiceBus\Plugin\Router\QueryRouter;
    use Prooph\ServiceBus\Plugin\ServiceLocatorPlugin;
    use Prooph\ServiceBus\QueryBus;
    use Prooph\SnapshotStore\Pdo\PdoSnapshotStore;
    use Psr\Container\ContainerInterface;
    use Superbalist\PubSub\Redis\RedisPubSubAdapter;
    use Voiceworks\Context\Post\Module\Post\Application\Delete\DeletePostCommand;
    use Voiceworks\Context\Post\Module\Post\Application\Delete\DeletePostCommandHandler;
    use Voiceworks\Context\Post\Module\Post\Application\Delete\PostDelete;
    use Voiceworks\Context\Post\Module\Post\Application\Edit\EditPostCommand;
    use Voiceworks\Context\Post\Module\Post\Application\Edit\EditPostCommandHandler;
    use Voiceworks\Context\Post\Module\Post\Application\Edit\PostEditor;
    use Voiceworks\Context\Post\Module\Post\Application\Find\PostCollectionFinder;
    use Voiceworks\Context\Post\Module\Post\Application\Find\PostFinder;
    use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostCollectionQuery;
    use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostQuery;
    use Voiceworks\Context\Post\Module\Post\Application\Publish\PostPublisher;
    use Voiceworks\Context\Post\Module\Post\Application\Publish\PublishPostCommand;
    use Voiceworks\Context\Post\Module\Post\Application\Publish\PublishPostCommandHandler;
    use Voiceworks\Context\Post\Module\Post\Domain\Event\PostContentWasUpdated;
    use Voiceworks\Context\Post\Module\Post\Domain\Event\PostTitleWasUpdated;
    use Voiceworks\Context\Post\Module\Post\Domain\Event\PostWasDeleted;
    use Voiceworks\Context\Post\Module\Post\Domain\Event\PostWasPublished;
    use Voiceworks\Context\Post\Module\Post\Domain\PostFactory;
    use Voiceworks\Context\Post\Module\Post\Domain\ReadPostRepository;
    use Voiceworks\Context\Post\Module\Post\Infrastructure\EventSubscriber\RedisEventSubscriber;
    use Voiceworks\Context\Post\Module\Post\Infrastructure\Middleware\QueryHandler\ProophRetrievePostCollectionQueryHandler;
    use Voiceworks\Context\Post\Module\Post\Infrastructure\Middleware\QueryHandler\ProophRetrievePostQueryHandler;
    use Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence\AuthorRepositoryMysql;
    use Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence\ReadPostRepositoryMysql;
    use Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence\WritePostRepositoryMysql;
    use Voiceworks\Context\Post\Module\Post\Infrastructure\Projection\PostProjection;

    include "../vendor/autoload.php";

    $pdo = new PDO('mysql:host=blog-database;dbname=blog_db;port=3306', 'bloguser', 'blogdevpass');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $eventStore = new MySqlEventStore(new FQCNMessageFactory(), $pdo, new MySqlAggregateStreamStrategy());
    $eventEmitter = new ProophActionEventEmitter();
    $eventStore = new ActionEventEmitterEventStore($eventStore, $eventEmitter);

    $eventBus = new EventBus($eventEmitter);
    $eventPublisher = new EventPublisher($eventBus);
    $eventPublisher->attachToEventStore($eventStore);

    $pdoSnapshotStore = new PdoSnapshotStore($pdo);
    $postRepository   = new WritePostRepositoryMysql($eventStore, $pdoSnapshotStore);
    $editorPost       = new PostEditor($postRepository);

    $projectionManager = new MySqlProjectionManager($eventStore, $pdo);

    $commandBus = new CommandBus();
    $router = new CommandRouter();
    $postAuthorChecker = new AuthorRepositoryMysql($pdo);
    $postFactory = new PostFactory($postAuthorChecker);
    $postPublisher = new PostPublisher($postRepository, $postFactory);
    $postDelete = new PostDelete($postRepository);
    $uuidGenerator = new UuidGenerator();
    $router->route(PublishPostCommand::class)->to(new PublishPostCommandHandler($postPublisher, $uuidGenerator));
    $router->route(EditPostCommand::class)->to(new EditPostCommandHandler($editorPost, $uuidGenerator));
    $router->route(DeletePostCommand::class)->to(new DeletePostCommandHandler($uuidGenerator, $postDelete));
    $router->attachToMessageBus($commandBus);

    $postProjector = new PostProjection($pdo);
    $eventRouter = new EventRouter();
    $eventRouter->route(PostWasPublished::class)->to([$postProjector, 'onPostPublished']);
    $eventRouter->route(PostTitleWasUpdated::class)->to([$postProjector, 'onPostTitleUpdated']);
    $eventRouter->route(PostContentWasUpdated::class)->to([$postProjector, 'onPostContentUpdated']);
    $eventRouter->route(PostWasDeleted::class)->to([$postProjector, 'onPostDeleted']);
    $eventRouter->attachToMessageBus($eventBus);


    $queryBus = new QueryBus();
    $queryRouter = new QueryRouter();
    $queryRouter->route(
        RetrievePostQuery::class
    )->to(
        ProophRetrievePostQueryHandler::class
    );

    $queryRouter->route(
        RetrievePostCollectionQuery::class
    )->to(
        ProophRetrievePostCollectionQueryHandler::class
    );
    $readPostRepository = new ReadPostRepositoryMysql($pdo);
    $queryRouter->attachToMessageBus($queryBus);
    $container = new class ($readPostRepository, $uuidGenerator) implements ContainerInterface {
        private $keys = array();
        private $postRepository;
        private $postFinder;
        private $postCollectionFinder;
        private $uuidGenerator;
        public function __construct(ReadPostRepository $postRepository, UuidGenerator $uuidGenerator)
        {
            $this->postRepository = $postRepository;
            $this->postFinder = new PostFinder($this->postRepository);
            $this->postCollectionFinder = new PostCollectionFinder($this->postRepository);
            $this->uuidGenerator = $uuidGenerator;
            $this->keys[ProophRetrievePostQueryHandler::class] = new ProophRetrievePostQueryHandler(
                $this->postFinder,
                $this->uuidGenerator
            );
            $this->keys[ProophRetrievePostCollectionQueryHandler::class] =
                new ProophRetrievePostCollectionQueryHandler(
                    $this->postCollectionFinder
                );
        }

        public function get($id)
        {
            switch ($id) {
                case ProophRetrievePostQueryHandler::class:
                    return $this->keys[$id];
                    break;
                case ProophRetrievePostCollectionQueryHandler::class:
                    return $this->keys[$id];
                    break;
            }
        }
        public function has($id)
        {
            return isset($this->keys[$id]);
        }
    };
    $serviceLocator = new ServiceLocatorPlugin($container);
    $serviceLocator->attachToMessageBus($queryBus);

    $mapper = new JsonMapper();
}