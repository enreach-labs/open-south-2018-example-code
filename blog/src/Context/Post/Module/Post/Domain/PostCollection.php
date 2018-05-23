<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

use Operator\Common\Domain\Value\Collection;

class PostCollection extends Collection
{
    protected function type(): string
    {
        return Post::class;
    }
}