<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Publish;

final class PublishPostCommand
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $tags;

    public function __construct(string $id, string $title, string $content, string $author, string $tags)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->tags = $tags;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function tags(): string
    {
        return $this->tags;
    }
}