<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence;

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Prooph\SnapshotStore\SnapshotStore;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\PostNotFoundException;
use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;

class WritePostRepositoryMysql extends AggregateRepository implements WritePostRepository
{
    public function __construct(EventStore $eventStore, SnapshotStore $snapshotStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(Post::class),
            new AggregateTranslator(),
            $snapshotStore,
            null,
            true
        );
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }

    public function save(Post $post): void
    {
        $this->saveAggregateRoot($post);
    }

    public function find(string $id): ?Post
    {
        if (!$post = $this->getAggregateRoot($id)) {
            throw new PostNotFoundException();
        }
        return $post;
    }


}