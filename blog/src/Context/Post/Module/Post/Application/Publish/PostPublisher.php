<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Publish;

use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;
use Voiceworks\Context\Post\Module\Post\Domain\PostFactory;
use Voiceworks\Context\Post\Module\Post\Domain\PostId;
use Voiceworks\Context\Post\Module\Post\Domain\PostPublishedOn;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;
use Voiceworks\Context\Post\Module\Post\Domain\PostTagCollection;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;

final class PostPublisher
{
    private $repository;

    private $postFactory;

    public function __construct(WritePostRepository $postRepository, PostFactory $postFactory)
    {
        $this->repository = $postRepository;
        $this->postFactory = $postFactory;
    }

    public function publish(
        Uuid $id,
        PostTitle $title,
        PostContent $content,
        PostAuthor $author,
        PostTagCollection $tags
    ) {
        $post = $this->postFactory->create($id, $title, $content, $author, $tags, new PostPublishedOn());

        $this->repository->save($post);
    }
}