<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Find;

use Operator\Common\Application\Query\Query;

class RetrievePostCollectionQuery implements Query
{

    private $limit;
    private $offset;

    public function __construct(int $limit = null, int $offset = null)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }
}