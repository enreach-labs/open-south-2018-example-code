<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Find;

use Operator\Common\Application\Query\Query;

class RetrievePostQuery implements Query
{

    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}