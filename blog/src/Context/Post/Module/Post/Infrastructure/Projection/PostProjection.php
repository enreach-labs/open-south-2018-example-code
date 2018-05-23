<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Projection;

use DateTime;
use PDOException;
use Voiceworks\Context\Post\Module\Post\Domain\Event\PostWasDeleted;
use Voiceworks\Context\Post\Module\Post\Domain\Event\PostWasPublished;
use Voiceworks\Context\Post\Module\Post\Domain\Event\PostContentWasUpdated;
use Voiceworks\Context\Post\Module\Post\Domain\Event\PostTitleWasUpdated;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\PostTitleAlreadyExistsException;

class PostProjection
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function onPostPublished(PostWasPublished $event)
    {
        $publishedOn = new DateTime($event->getPublishedOn());
        $query = $this->pdo->prepare(<<<'SQL'
        INSERT INTO `post` SET id = ?, title = ?, content = ?, author = ?, tags = ?, publishedOn = ?
SQL
);
        $query->bindValue(1, $event->aggregateId());
        $query->bindValue(2, $event->getTitle());
        $query->bindValue(3, $event->getContent());
        $query->bindValue(4, $event->getAuthor());
        $query->bindValue(5, $event->getTags());
        $query->bindValue(6, $publishedOn->format("Y:m:d H:i:s.u"));
        try {
            $query->execute();
        } catch (PDOException $exception) {
            $this->catchTitleUniqueException($exception);
        }
    }

    public function onPostTitleUpdated(PostTitleWasUpdated $event)
    {
        $query = $this->pdo->prepare('UPDATE `post` set title=? WHERE id = ?');
        $query->bindValue(1, $event->getTitle());
        $query->bindValue(2, $event->aggregateId());
        try {
            $query->execute();
        } catch (PDOException $exception) {
            $this->catchTitleUniqueException($exception);
        }
    }

    public function onPostContentUpdated(PostContentWasUpdated $event)
    {
        $query = $this->pdo->prepare('UPDATE `post` set content=? WHERE id = ?');
        $query->bindValue(1, $event->getContent());
        $query->bindValue(2, $event->aggregateId());
        $query->execute();
    }

    public function onPostDeleted(PostWasDeleted $event)
    {
        $query = $this->pdo->prepare('DELETE FROM `post` WHERE id = ?');
        $query->bindValue(1, $event->aggregateId());
        $query->execute();
    }

    private function catchTitleUniqueException(PDOException $exception): void
    {
        if (strpos($exception->getMessage(), 'title_UNIQUE') !== false) {
            throw new PostTitleAlreadyExistsException();
        }
    }
}