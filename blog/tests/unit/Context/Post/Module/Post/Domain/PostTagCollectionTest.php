<?php

use Voiceworks\Context\Post\Module\Post\Domain\PostTagCollection;

class PostTagCollectionTest extends \Codeception\Test\Unit
{
    public function test__construct()
    {
        $postTagCollectionprotected = new PostTagCollection('valid,strings');
        $this->assertInstanceOf(PostTagCollection::class, $postTagCollectionprotected);
    }

    /**
     * @expectedException \Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostTagsException
     */
    public function test__constructExeception()
    {
        $postTagCollectionprotected = new PostTagCollection('$$,strings');
        $this->assertInstanceOf(PostTagCollection::class, $postTagCollectionprotected);
    }

    public function test__toString()
    {
        $postTagCollectionprotected = new PostTagCollection('valid,strings');
        $result = $postTagCollectionprotected->__toString();
        $this->assertEquals('valid,strings', $result);
    }
}
