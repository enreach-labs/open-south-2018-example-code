<?php

namespace Voiceworks\Context\Post\Module\Post\Domain\Exception;

use Operator\Common\Domain\Exception\InvalidArgumentException;

class InvalidPostTagsException extends InvalidArgumentException
{
    protected $message = 'Invalid post tags';

}