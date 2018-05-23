<?php

namespace Voiceworks\Context\Post\Module\Post\Domain\Event;

use Operator\Common\Domain\Value\Uuid;
use Prooph\EventSourcing\AggregateChanged;

class PostWasDeleted extends AggregateChanged
{

}