<?php

use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;

class PostAuthorTest extends \Codeception\Test\Unit
{
    public function testValidEmail()
    {
        $postAuthor = new PostAuthor('test@test.com');
        $this->assertInstanceOf(PostAuthor::class, $postAuthor);
    }

    /**
     * @expectedException \Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostAuthorException
     */
    public function testNotValidEmail()
    {
        $postAuthor = new PostAuthor('testtestcom');
    }
}
