<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Find;

use Operator\Common\Domain\Value\Uuid;
use Operator\Common\Domain\Value\UuidGenerator;
use Voiceworks\Context\Post\Module\Post\Domain\PostResponse;
use Voiceworks\Context\Post\Module\Post\Domain\PostResponseConverter;

class RetrievePostQueryHandler
{
    private $postFinder;
    private $uuidGenerator;

    public function __construct(
        PostFinder $postFinder,
        UuidGenerator $uuidGenerator
    ) {
        $this->postFinder = $postFinder;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function handle(RetrievePostQuery $query): PostResponse
    {
        $id = $this->uuidGenerator->fromString($query->getId());
        return $this->postFinder->search($id);
    }
}