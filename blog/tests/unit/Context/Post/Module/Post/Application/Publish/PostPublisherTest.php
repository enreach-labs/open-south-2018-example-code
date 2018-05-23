<?php

use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PostPublisher;
use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;
use Voiceworks\Context\Post\Module\Post\Domain\PostPublishedOn;
use Voiceworks\Context\Post\Module\Post\Domain\PostTagCollection;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;

class PostPublisherTest extends \Codeception\Test\Unit
{
    /**
     * @var PostPublisher
     */
    private $postPublisher;

    private $postRepository;

    protected function _before()
    {
        $this->postRepository = Mockery::mock(WritePostRepository::class);
        $this->postPublisher = new PostPublisher($this->postRepository);
    }


    public function testPublish()
    {
        $uuidStub = Mockery::mock(Uuid::class);
        $uuidStub->shouldReceive('getValue')->andReturn('string');
        $postTitleStub = Mockery::mock(PostTitle::class);
        $postContentStub = Mockery::mock(PostContent::class);
        $postAuthorStub = Mockery::mock(PostAuthor::class);
        $postTagCollectionStub = Mockery::mock(PostTagCollection::class);
        $postPublishedOnStub = Mockery::mock(PostPublishedOn::class);

        $this->postRepository
            ->shouldReceive('save')
            ->times(1);

        $this->postPublisher->publish(
            $uuidStub,
            $postTitleStub,
            $postContentStub,
            $postAuthorStub,
            $postTagCollectionStub,
            $postPublishedOnStub
        );
    }
}
