<?php

namespace Voiceworks\Context\Post\Module\Post\Domain\Exception;


class PostNotFoundException extends \Exception
{
    protected $message = "Requested post doesn't exists";
}