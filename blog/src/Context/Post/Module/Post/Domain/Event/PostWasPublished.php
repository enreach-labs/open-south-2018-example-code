<?php

namespace Voiceworks\Context\Post\Module\Post\Domain\Event;

use Operator\Common\Domain\Value\Uuid;
use Prooph\EventSourcing\AggregateChanged;
use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;
use Voiceworks\Context\Post\Module\Post\Domain\PostPublishedOn;
use Voiceworks\Context\Post\Module\Post\Domain\PostTagCollection;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;

class PostWasPublished extends AggregateChanged
{
    public function getTitle(): string
    {
        return $this->payload()['title'];
    }

    public function getContent(): string
    {
        return $this->payload()['content'];
    }

    public function getAuthor(): string
    {
        return $this->payload()['author'];
    }

    public function getTags(): string
    {
        return $this->payload()['tags'];
    }

    public function getPublishedOn(): string
    {
        return $this->payload()['publishedOn'];
    }
}