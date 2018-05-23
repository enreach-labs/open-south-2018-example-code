<?php
/**
 * Created by IntelliJ IDEA.
 * User: pedroparraortega
 * Date: 27/02/2018
 * Time: 13:59
 */

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
use Voiceworks\Context\Post\Module\Post\Infrastructure\Middleware\QueryHandler\ProophRetrievePostCollectionQueryHandler;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Middleware\QueryHandler\ProophRetrievePostQueryHandler;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence\ReadPostRepositoryMysql;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence\WritePostRepositoryMysql;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Projection\PostProjection;

trait ConfigurationTrait
{
    /** @var \PDO */
    public $pdo;
    public $readPostRepository;
    public $postRepository;
    public $uuidGenerator;
    public $eventStore;
    public $eventEmitter;
    public $eventBus;
    public $eventPublisher;
    public $pdoSnapshotStore;
    public $editorPost;
    public $projectionManager;
    public $commandBus;
    public $queryBus;
    public $router;
    public $postPublisher;
    public $postDelete;
    public $postFinder;
    public $postCollectionFinder;
    public $postProjector;
    public $eventRouter;
    public $queryRouter;
    public $serviceLocator;
    public $mapper;


    /**
     * @Given The application is configured
     */
    public function theApplicationIsConfigured()
    {
        $this->pdo = new PDO('mysql:host=database;dbname=blog_db;port=3306', 'root', 'rootdevpass');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->cleanDatabase();
        $this->eventStore   = new MySqlEventStore(
            new FQCNMessageFactory(), $this->pdo, new MySqlAggregateStreamStrategy()
        );
        $this->eventEmitter = new ProophActionEventEmitter();
        $this->eventStore   = new ActionEventEmitterEventStore($this->eventStore, $this->eventEmitter);

        $this->eventBus       = new EventBus($this->eventEmitter);
        $this->eventPublisher = new EventPublisher($this->eventBus);
        $this->eventPublisher->attachToEventStore($this->eventStore);

        $this->pdoSnapshotStore = new PdoSnapshotStore($this->pdo);
        $this->postRepository   = new WritePostRepositoryMysql($this->eventStore, $this->pdoSnapshotStore);
        $this->editorPost       = new PostEditor($this->postRepository);

        $this->projectionManager = new MySqlProjectionManager($this->eventStore, $this->pdo);

        $this->readPostRepository   = new ReadPostRepositoryMysql($this->pdo);
        $this->postPublisher        = new PostPublisher($this->postRepository);
        $this->postDelete           = new PostDelete($this->postRepository);
        $this->postFinder           = new PostFinder($this->readPostRepository);
        $this->postCollectionFinder = new PostCollectionFinder($this->readPostRepository);
        $this->uuidGenerator        = new UuidGenerator();

        $this->postProjector = new PostProjection($this->pdo);
        $this->eventRouter   = new EventRouter();
        $this->eventRouter->route(PostWasPublished::class)->to([$this->postProjector, 'onPostPublished']);
        $this->eventRouter->route(PostTitleWasUpdated::class)->to([$this->postProjector, 'onPostTitleUpdated']);
        $this->eventRouter->route(PostContentWasUpdated::class)->to([$this->postProjector, 'onPostContentUpdated']);
        $this->eventRouter->route(PostWasDeleted::class)->to([$this->postProjector, 'onPostDeleted']);
        $this->eventRouter->attachToMessageBus($this->eventBus);

        $this->mapper = new JsonMapper();
    }

    private function cleanDatabase()
    {
        $sql = file_get_contents(dirname(__FILE__).'/../_data/mysql.sql');
        $this->pdo->exec($sql);
    }

}