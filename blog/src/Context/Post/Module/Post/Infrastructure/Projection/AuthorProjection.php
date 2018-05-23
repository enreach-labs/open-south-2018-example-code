<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Projection;

use DateTime;
use PDOException;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Event\UserWasCreated;

class AuthorProjection
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function onUserWasCreated(UserWasCreated $event)
    {
        $query = $this->pdo->prepare(<<<'SQL'
        INSERT INTO `user` SET email = ?
SQL
);
        $query->bindValue(1, $event->email());
        $query->execute();
    }
}