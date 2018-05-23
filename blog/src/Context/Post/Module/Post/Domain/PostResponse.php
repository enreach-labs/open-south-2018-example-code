<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

use Operator\Common\Domain\Response\Response;

class PostResponse implements Response
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $tags;
    private $publishedOn;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getTags(): string
    {
        return $this->tags;
    }

    public function getPublishedOn(): string
    {
        return $this->publishedOn;
    }
}