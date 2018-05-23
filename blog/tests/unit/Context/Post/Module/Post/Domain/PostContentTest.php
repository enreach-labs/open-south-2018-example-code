<?php

use Voiceworks\Context\Post\Module\Post\Domain\PostContent;

class PostContentTest extends \Codeception\Test\Unit
{

    public function test__constructValid()
    {
        $postContent = new PostContent('content');
        $this->assertInstanceOf(PostContent::class, $postContent);
    }

    /**
     * @expectedException \Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostContentException
     */
    public function test__constructNotValid()
    {
        $postContent = new PostContent('');
    }
}
