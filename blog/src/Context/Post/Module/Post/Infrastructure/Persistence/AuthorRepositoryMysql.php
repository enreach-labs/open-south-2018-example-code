<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence;

use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;
use Voiceworks\Context\Post\Module\Post\Domain\PostCollectionResponse;
use Voiceworks\Context\Post\Module\Post\Domain\PostResponse;
use Voiceworks\Context\Post\Module\Post\Domain\ReadPostRepository;
use PDO;
use Voiceworks\Context\Post\Module\Post\Domain\Service\AuthorExistanceChecker;

class AuthorRepositoryMysql implements AuthorExistanceChecker
{
    private $pdo;

    /**
     * ReadPostRepositoryMysql constructor.
     *
     * @param $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function check(PostAuthor $author): bool
    {
        $query = $this->pdo->prepare('SELECT * FROM `user` WHERE email = ?');
        $query->bindValue(1, (string) $author);
        $query->execute();

        return $query->fetch() ? true : false;
    }
}