<?php

use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;

class PostTitleTest extends \Codeception\Test\Unit
{
    public function test__construct()
    {
        $postTitle = new PostTitle('Valid Title');
        $this->assertInstanceOf(PostTitle::class, $postTitle);
    }

    /**
     * @expectedException \Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostTitleException
     */
    public function test__constructExeception()
    {
        $postTitle = new PostTitle('');
        $this->assertInstanceOf(PostTitle::class, $postTitle);
    }
}
