<?php

namespace Voiceworks\Common\Domain;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

abstract class EventSourcedAggregateRoot extends AggregateRoot
{
    protected function apply(AggregateChanged $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);

        if (!method_exists($this, $handler)) {
            throw new \RuntimeException(
                sprintf(
                    'Missing event handler method %s for aggregate root %s',
                    $handler,
                    get_class($this)
                )
            );
        }

        $this->{$handler}($event);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
    }

}