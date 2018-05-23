<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

use Operator\Common\Domain\Value\StringValueObject;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostTagsException;

class PostTag extends StringValueObject
{
    const REGEXP = "/([a-z-\-])\w+/";

    public function __construct(string $value)
    {
        $this->guard($value);
        parent::__construct($value);
    }

    private function guard($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>self::REGEXP)))) {
            throw new InvalidPostTagsException();
        }
    }
}