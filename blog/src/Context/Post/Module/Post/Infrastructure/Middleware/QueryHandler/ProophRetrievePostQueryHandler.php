<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Middleware\QueryHandler;

use Operator\Common\Domain\Value\UuidGenerator;
use React\Promise\Deferred;
use Voiceworks\Context\Post\Module\Post\Application\Find\PostFinder;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostCollectionQueryHandler;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostQuery;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostQueryHandler;

class ProophRetrievePostQueryHandler extends RetrievePostQueryHandler
{

    public function __invoke(RetrievePostQuery $query, Deferred $deferred)
    {
        $post = $this->handle($query);
        $deferred->resolve($post);
    }
}