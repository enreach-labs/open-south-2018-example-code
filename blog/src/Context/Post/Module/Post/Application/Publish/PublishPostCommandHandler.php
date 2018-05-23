<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Publish;

use Operator\Common\Domain\Value\UuidGenerator;
use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;
use Voiceworks\Context\Post\Module\Post\Domain\PostTagCollection;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;

final class PublishPostCommandHandler
{
    private $publisher;

    private $uuidGenerator;

    public function __construct(PostPublisher $publisher, UuidGenerator $uuidGenerator)
    {
        $this->publisher = $publisher;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function __invoke(PublishPostCommand $publishPostCommand)
    {
        $id = $this->uuidGenerator->fromString($publishPostCommand->id());
        $title = new PostTitle($publishPostCommand->title());
        $content = new PostContent($publishPostCommand->content());
        $author = new PostAuthor($publishPostCommand->author());
        $tags = new PostTagCollection($publishPostCommand->tags());
        $this->publisher->publish($id, $title, $content, $author, $tags);
    }
}