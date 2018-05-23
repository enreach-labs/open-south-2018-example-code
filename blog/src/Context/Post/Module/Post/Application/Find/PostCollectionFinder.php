<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Find;

use Voiceworks\Context\Post\Module\Post\Domain\PostCollectionResponse;
use Voiceworks\Context\Post\Module\Post\Domain\ReadPostRepository;

class PostCollectionFinder
{
    private $postRepository;

    public function __construct(ReadPostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function search(int $limit = null, int $offset = null) : PostCollectionResponse
    {
        $postCollection = $this->postRepository->findAll($limit, $offset);

        return $postCollection;
    }

}