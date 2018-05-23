<?php

use Operator\Common\Domain\Value\UuidGenerator;
use Psr\Container\ContainerInterface;
use Voiceworks\Context\Post\Module\Post\Application\Find\PostCollectionFinder;
use Voiceworks\Context\Post\Module\Post\Application\Find\PostFinder;
use Voiceworks\Context\Post\Module\Post\Domain\ReadPostRepository;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Middleware\QueryHandler\ProophRetrievePostCollectionQueryHandler;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Middleware\QueryHandler\ProophRetrievePostQueryHandler;

/**
 * Created by IntelliJ IDEA.
 * User: pedroparraortega
 * Date: 27/02/2018
 * Time: 14:03
 */

class EventContainer implements ContainerInterface {
    private $keys = array();
    private $postRepository;
    private $postFinder;
    private $postCollectionFinder;
    private $uuidGenerator;

    public function __construct(ReadPostRepository $postRepository, UuidGenerator $uuidGenerator, PostFinder $postFinder, PostCollectionFinder $collectionFinder)
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
}