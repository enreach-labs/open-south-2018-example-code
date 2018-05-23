<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Event;


class UserWasCreated
{
    private $email;

    /**
     * UserWasCreated constructor.
     *
     * @param $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }
}