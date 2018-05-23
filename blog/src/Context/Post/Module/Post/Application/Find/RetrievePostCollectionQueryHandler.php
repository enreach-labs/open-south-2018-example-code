<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Find;

use Voiceworks\Context\Post\Module\Post\Domain\PostCollectionResponse;

class RetrievePostCollectionQueryHandler
{
    private $postCollectionFinder;

    public function __construct(PostCollectionFinder $postCollectionFinder) {
        $this->postCollectionFinder = $postCollectionFinder;
    }

    public function handle(RetrievePostCollectionQuery $query): PostCollectionResponse
    {
        return $this->postCollectionFinder->search($query->getLimit(), $query->getOffset());
    }
}