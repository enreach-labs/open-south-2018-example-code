<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Delete;

use Operator\Common\Domain\Value\UuidGenerator;

class DeletePostCommandHandler
{
    private $uuidGenerator;
    private $postDelete;

    public function __construct(UuidGenerator $uuidGenerator, PostDelete $postDelete)
    {
        $this->uuidGenerator = $uuidGenerator;
        $this->postDelete = $postDelete;
    }

    public function __invoke(DeletePostCommand $deletePostCommand)
    {
        $id = $this->uuidGenerator->fromString($deletePostCommand->getId());
        $this->postDelete->delete($id);
    }


}