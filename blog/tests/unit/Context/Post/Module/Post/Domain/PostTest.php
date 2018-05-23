<?php

use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;
use Voiceworks\Context\Post\Module\Post\Domain\PostPublishedOn;
use Voiceworks\Context\Post\Module\Post\Domain\PostTagCollection;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;

class PostTest extends \Codeception\Test\Unit
{
    /**
     * @var Post
     */
    private $post;

    protected function _before()
    {
        $uuidStub = Mockery::mock(Uuid::class);
        $uuidStub->shouldReceive('getValue')->andReturn('string');
        $postTitleStub = Mockery::mock(PostTitle::class);
        $postTitleStub->shouldReceive('__toString')->andReturn('title1');
        $postContentStub = Mockery::mock(PostContent::class);
        $postContentStub->shouldReceive('__toString')->andReturn('content1');
        $postAuthorStub = Mockery::mock(PostAuthor::class);
        $postTagCollectionStub = Mockery::mock(PostTagCollection::class);
        $postOnPublishedStub = Mockery::mock(PostPublishedOn::class);


        $this->post = Post::publishWithData(
            $uuidStub,
            $postTitleStub,
            $postContentStub,
            $postAuthorStub,
            $postTagCollectionStub,
            $postOnPublishedStub
        );
    }

    public function testPublishWithData()
    {
        $this->assertInstanceOf(Post::class,$this->post);
    }

    public function testUpdateTitle()
    {
        $postTitleStub = Mockery::mock(PostTitle::class);
        $postTitleStub->shouldReceive('__toString')->andReturn('title2');
        $this->post->updateTitle($postTitleStub);
    }

    public function testUpdateContent()
    {
        $postContentStub = Mockery::mock(PostContent::class);
        $postContentStub->shouldReceive('__toString')->andReturn('content2');
        $this->post->updateContent($postContentStub);
    }

    public function testDelete()
    {
        $this->post->delete();
    }
}
