<?php

namespace Voiceworks\Context\Post\Module\Post\Domain\Event;

use Operator\Common\Domain\Value\Uuid;
use Prooph\EventSourcing\AggregateChanged;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;

class PostTitleWasUpdated extends AggregateChanged
{
    public function getTitle(): string
    {
        return $this->payload()['title'];
    }
}