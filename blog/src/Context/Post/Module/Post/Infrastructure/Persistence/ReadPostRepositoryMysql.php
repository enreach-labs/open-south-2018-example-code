<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence;

use Voiceworks\Context\Post\Module\Post\Domain\PostCollectionResponse;
use Voiceworks\Context\Post\Module\Post\Domain\PostResponse;
use Voiceworks\Context\Post\Module\Post\Domain\ReadPostRepository;
use PDO;

class ReadPostRepositoryMysql implements ReadPostRepository
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

    public function find(string $id): ?PostResponse
    {
        $query = $this->pdo->prepare('SELECT * FROM `post` WHERE id = ?');
        $query->bindValue(1, $id);
        $query->execute();
        return $query->fetchObject(PostResponse::class) ? : null;
    }

    public function findAll(int $limit = null, int $offset = null): PostCollectionResponse
    {
        $query = $this->pdo->prepare('SELECT * FROM `post` ORDER BY title ASC LIMIT ? OFFSET ?');
        $query->bindValue(1, $limit ? : 100, PDO::PARAM_INT);
        $query->bindValue(2, $offset ? : 0, PDO::PARAM_INT);
        $query->execute();
        $array = $query->fetchAll(PDO::FETCH_CLASS, PostResponse::class);
        return new PostCollectionResponse($array);
    }
}