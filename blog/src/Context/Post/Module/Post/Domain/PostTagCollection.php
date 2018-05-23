<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;

use Operator\Common\Domain\Value\Collection;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostTagsException;

class PostTagCollection extends Collection
{
    const DELIMITER = ",";
    const REGEXP = "/[\w\-]+(,[\w\-]+)*/";

    public function __construct(string $items)
    {
        $this->guard($items);
        $items = explode(self::DELIMITER, $items);
        $tags=[];
        foreach ($items as $item) {
            $tags[] = new PostTag($item);
        }
        parent::__construct($tags);
    }

    public function __toString(): string
    {
        return implode(',', $this->items());
    }

    protected function type(): string
    {
        return PostTag::class;
    }

    private function guard(string $items): void
    {
        if (!filter_var($items, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>self::REGEXP)))) {
            throw new InvalidPostTagsException();
        }
    }
}