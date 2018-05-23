<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

use Operator\Common\Domain\Value\EmailValueObject;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostAuthorException;

class PostAuthor extends EmailValueObject
{

    protected function guard($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidPostAuthorException();
        }
    }
}