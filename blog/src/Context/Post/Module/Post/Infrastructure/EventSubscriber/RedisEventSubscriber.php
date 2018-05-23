<?php
/**
 * Created by IntelliJ IDEA.
 * User: pedroparraortega
 * Date: 08/03/2018
 * Time: 10:53
 */

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\EventSubscriber;


use Superbalist\PubSub\Redis\RedisPubSubAdapter;
use PDO;

class RedisEventSubscriber
{
    private $adapter;
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * RedisEventSubscriber constructor.
     *
     * @param $adapter
     */
    public function __construct(RedisPubSubAdapter $adapter, PDO $pdo)
    {
        $this->adapter = $adapter;
        $this->pdo = $pdo;
    }

    public function subscribe($message)
    {
        $query = $this->pdo->prepare(<<<'SQL'
        INSERT INTO `user` SET email = ?
SQL
    );
        $query->bindValue(1, $message["email"]);
        $query->execute();
    }

}