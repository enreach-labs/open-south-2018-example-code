<?php

use Voiceworks\Context\Post\Module\Post\Infrastructure\CommandBus\TacticianCommandBus;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Exception\CustomExceptionHandler;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Exception\ExceptionStatusHttpMapper;
use Voiceworks\Context\Post\Module\Post\Infrastructure\QueryBus\ProophQueryBus;
use Voiceworks\Context\Post\Module\Post\Infrastructure\RestController\EditPostController;
use Voiceworks\Context\Post\Module\Post\Infrastructure\RestController\DeletePostController;
use Voiceworks\Context\Post\Module\Post\Infrastructure\RestController\GetPostController;
use Voiceworks\Context\Post\Module\Post\Infrastructure\RestController\GetPostDetailController;
use Voiceworks\Context\Post\Module\Post\Infrastructure\RestController\PublishPostController;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require '../vendor/autoload.php';
include_once '../config/config.php';
define('C3_CODECOVERAGE_ERROR_LOG_FILE', '/path/to/c3_error.log'); //Optional (if not set the default c3 output dir will be used)
include '../c3.php';
define('MY_APP_STARTED', true);
$app = new \Slim\App;

$container = $app->getContainer();

$paths = array("../src/");
$isDevMode = false;

$container['commandBus'] = $commandBus;
$container['queryBus'] = $queryBus;
$container['mapper'] = $mapper;
$container['errorHandler'] = function ($container) {
    return new CustomExceptionHandler(new ExceptionStatusHttpMapper());
};
$app->get('/post',GetPostController::class);
$app->get('/post/{id}',GetPostDetailController::class);
$app->post('/post',PublishPostController::class);
$app->put('/post/{id}',EditPostController::class);
$app->delete('/post/{id}',DeletePostController::class);
$app->get('/v1/doc', function($request, $response, $args) {
    $swagger = \Swagger\scan(['../src']);
    return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write($swagger);
});
$app->get('/swagger/ui', function($request, $response, $args) {
    $server = $_SERVER['HTTP_HOST'];
    $server = explode(':',$server);
    $text = file_get_contents('../config/index.html');
    $virtualHost = $server[0];
    $port = $server[1];
    $text = str_replace('{VIRTUALHOST}', $virtualHost, $text);
    $text = str_replace('{PORT}', $port, $text);
//    var_dump($text);die;
    return $response->withStatus(200)
        ->withHeader('Content-Type', 'text/html')
        ->write($text);
});


$app->run();


