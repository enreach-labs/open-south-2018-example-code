<?php

use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Voiceworks\Context\Post\Module\Post\Domain\PostCollection;

class PostCollectionTest extends \Codeception\Test\Unit
{
    public function testValidPostCollection()
    {
        $values = [Mockery::mock(Post::class)];
        $postCollection = new PostCollection($values);
        $this->assertInstanceOf(PostCollection::class, $postCollection);
    }

    /**
     * @expectedException \Operator\Common\Domain\Exception\InvalidArgumentException
     */
    public function testNotValidPostCollection()
    {
        $values = [new stdClass];
        $postCollection = new PostCollection($values);
    }
}
