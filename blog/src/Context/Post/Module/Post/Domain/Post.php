<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Common\Domain\EventSourcedAggregateRoot;
use Voiceworks\Context\Post\Module\Post\Domain\Event\PostContentWasUpdated;
use Voiceworks\Context\Post\Module\Post\Domain\Event\PostTitleWasUpdated;
use Voiceworks\Context\Post\Module\Post\Domain\Event\PostWasDeleted;
use Voiceworks\Context\Post\Module\Post\Domain\Event\PostWasPublished;

class Post extends EventSourcedAggregateRoot
{
    private $id;
    private $title;
    private $content;
    private $author;
    private $tags;
    private $publishedOn;
    private $deleted = false;

    static public function publishWithData(
        Uuid $id,
        PostTitle $title,
        PostContent $content,
        PostAuthor $author,
        PostTagCollection $tags,
        PostPublishedOn $publishedOn
    ): Post {
        $post = new self;
        $post->recordThat(PostWasPublished::occur($id->getValue(), [
            'title' => $title->__toString(),
            'content' => $content->__toString(),
            'author' => $author->__toString(),
            'tags' => $tags->__toString(),
            'publishedOn' => $publishedOn->__toString()
        ]));
        return $post;
    }

    public function updateTitle(PostTitle $postTitle): void
    {
        if (!$this->validateSameTitle($postTitle)) {
            $this->recordThat(PostTitleWasUpdated::occur($this->aggregateId(), [
                'title' => $postTitle->__toString()
            ]));
        }
    }

    public function updateContent(PostContent $postContent): void
    {
        if (!$this->validateSameContent($postContent)) {
            $this->recordThat(PostContentWasUpdated::occur($this->aggregateId(), [
                'content' => $postContent->__toString()
            ]));
        }
    }

    public function delete(): void
    {
        $this->recordThat(PostWasDeleted::occur($this->aggregateId(), []));
    }

    protected function whenPostTitleWasUpdated(PostTitleWasUpdated $event): void
    {
        $this->title = $event->getTitle();
    }

    protected function whenPostContentWasUpdated(PostContentWasUpdated $event): void
    {
        $this->content = $event->getContent();
    }

    protected function whenPostWasPublished(PostWasPublished $event)
    {
        $this->id = $event->aggregateId();
        $this->title = $event->getTitle();
        $this->content = $event->getContent();
        $this->author = $event->getAuthor();
        $this->tags = $event->getTags();
        $this->publishedOn = $event->getPublishedOn();
    }

    protected function whenPostWasDeleted(PostWasDeleted $event)
    {
        $this->deleted = true;
    }

    protected function aggregateId(): string
    {
        return $this->id;
    }

    private function validateSameTitle(PostTitle $postTitle): bool
    {
        return strcmp($this->title, $postTitle) === 0;
    }

    private function validateSameContent(PostContent $postContent): bool
    {
        return strcmp($this->content, $postContent) === 0;
    }
}