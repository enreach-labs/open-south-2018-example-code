<?php

namespace Voiceworks\Context\Post\Module\Post\Application\Edit;

use Operator\Common\Domain\Value\UuidGenerator;
use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;

final class EditPostCommandHandler
{
    private $publisher;

    private $uuidGenerator;

    public function __construct(PostEditor $editor, UuidGenerator $uuidGenerator)
    {
        $this->editor = $editor;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function __invoke(EditPostCommand $editPostCommand)
    {
        $id = $this->uuidGenerator->fromString($editPostCommand->id());
        $title = new PostTitle($editPostCommand->title());
        $content = new PostContent($editPostCommand->content());
        $this->editor->edit($id, $title, $content);
    }
}