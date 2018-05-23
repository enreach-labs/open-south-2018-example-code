<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Find;

use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\PostNotFoundException;
use Voiceworks\Context\Post\Module\Post\Domain\PostResponse;
use Voiceworks\Context\Post\Module\Post\Domain\ReadPostRepository;

class PostFinder
{
    private $postRepository;

    public function __construct(ReadPostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function search(Uuid $id): PostResponse
    {
        $post = $this->postRepository->find($id);
        $this->guard($post);

        return $post;
    }

    /**
     * @param PostResponse $post
     * @throws PostNotFoundException
     */
    private function guard(PostResponse $post = null): void
    {
        if (!$post instanceof PostResponse) {
            throw new PostNotFoundException();
        }
    }

}