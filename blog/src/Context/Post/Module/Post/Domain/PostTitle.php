<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

use Operator\Common\Domain\Value\StringValueObject;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostTitleException;

class PostTitle extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->guard($value);
        parent::__construct($value);
    }

    private function guard($value)
    {
        if (!$value || $value == "") {
            throw new InvalidPostTitleException();
        }
    }
}