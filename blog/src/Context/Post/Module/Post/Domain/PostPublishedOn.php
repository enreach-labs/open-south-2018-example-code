<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

class PostPublishedOn
{
    private $dateTime;

    public function __construct()
    {
        $this->dateTime = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    public function __toString(): string
    {
        return $this->dateTime->format(\DateTime::ATOM);
    }
}