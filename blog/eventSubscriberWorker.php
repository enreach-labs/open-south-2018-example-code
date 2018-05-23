<?php

use Superbalist\PubSub\Redis\RedisPubSubAdapter;
use Voiceworks\Context\Post\Module\Post\Infrastructure\EventSubscriber\RedisEventSubscriber;

require_once "./vendor/autoload.php";

$pdo = new PDO('mysql:host=blog-database;dbname=blog_db;port=3306', 'root', 'rootdevpass');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$client = new Predis\Client([
    'scheme' => 'tcp',
    'host' => 'redis',
    'port' => 6379,
    'database' => 0,
    'read_write_timeout' => 3000
]);
$adapter = new RedisPubSubAdapter($client);
$subscriber = new RedisEventSubscriber($adapter, $pdo);
$adapter->subscribe("user_channel", [$subscriber, "subscribe"]);