<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Edit;

use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;

final class PostEditor
{
    private $repository;

    public function __construct(WritePostRepository $postRepository)
    {
        $this->repository = $postRepository;
    }

    public function edit(Uuid $id, PostTitle $title, PostContent $content): void
    {
        $post = $this->repository->find($id);
        $post->updateTitle($title);
        $post->updateContent($content);
        $this->repository->save($post);
    }
}