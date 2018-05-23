<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Edit;

final class EditPostCommand
{
    private $id;
    private $title;
    private $content;
    private $tags;

    public function __construct(string $id, string $title, string $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
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

    public function tags(): string
    {
        return $this->tags;
    }
}