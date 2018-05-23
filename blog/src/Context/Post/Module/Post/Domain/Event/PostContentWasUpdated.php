<?php

namespace Voiceworks\Context\Post\Module\Post\Domain\Event;


use Operator\Common\Domain\Value\Uuid;
use Prooph\EventSourcing\AggregateChanged;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;

class PostContentWasUpdated extends AggregateChanged
{
    public function getContent(): string
    {
        return $this->payload()['content'];
    }
}