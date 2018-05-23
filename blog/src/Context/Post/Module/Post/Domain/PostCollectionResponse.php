<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

use Operator\Common\Domain\Response\Response;
use Operator\Common\Domain\Value\Collection;

class PostCollectionResponse extends Collection implements Response
{
    protected function type(): string
    {
        return PostResponse::class;
    }

    public function getPostCollection(): array
    {
        return $this->items();
    }
}