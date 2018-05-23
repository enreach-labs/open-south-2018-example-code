<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Delete;


use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;

class PostDelete
{
    private $postRepository;

    public function __construct(WritePostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function delete(Uuid $id)
    {
        $post = $this->postRepository->find($id);
        $this->postRepository->delete($post);
        $this->postRepository->save($post);
    }
}