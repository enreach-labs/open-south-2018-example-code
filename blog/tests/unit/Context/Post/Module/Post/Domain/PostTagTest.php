<?php

use Voiceworks\Context\Post\Module\Post\Domain\PostTag;

class PostTagTest extends \Codeception\Test\Unit
{
    public function test__construct()
    {
        $tag = new PostTag('validtag');
        $this->assertInstanceOf(PostTag::class, $tag);
    }

    /**
     * @expectedException \Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostTagsException
     */
    public function test__constructException()
    {
        $tag = new PostTag('&%$%%@');
    }
}
