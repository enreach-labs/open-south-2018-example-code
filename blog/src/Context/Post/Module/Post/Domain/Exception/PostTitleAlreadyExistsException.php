<?php

namespace Voiceworks\Context\Post\Module\Post\Domain\Exception;

use Operator\Common\Domain\Exception\InvalidArgumentException;

class PostTitleAlreadyExistsException extends InvalidArgumentException
{
    protected $message = 'Post title already exists';
}