<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Middleware\QueryHandler;

use React\Promise\Deferred;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostCollectionQuery;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostCollectionQueryHandler;

class ProophRetrievePostCollectionQueryHandler extends RetrievePostCollectionQueryHandler
{
    public function __invoke(RetrievePostCollectionQuery $query, Deferred $deferred)
    {
        $post = $this->handle($query);
        $deferred->resolve($post);
    }
}