<?php

use Voiceworks\Context\Post\Module\Post\Application\Find\PostCollectionFinder;
use Voiceworks\Context\Post\Module\Post\Domain\PostCollectionResponse;
use Voiceworks\Context\Post\Module\Post\Domain\ReadPostRepository;

/**
 * Class PostCollectionFinderTest
 * @group post
 * @group application
 * @coversDefaultClass Voiceworks\Context\Post\Module\Post\Application\Find\PostCollectionFinder
 */
class PostCollectionFinderTest extends \Codeception\Test\Unit
{
    /**
     * @var ReadPostRepository
     */
    private $postRepository;

    /**
     * @var PostCollectionFinder
     */
    private $postCollectionFinder;

    protected function _before()
    {
        $this->postRepository = Mockery::mock(ReadPostRepository::class);
        $this->postCollectionFinder = new PostCollectionFinder($this->postRepository);
    }


    public function testSearch()
    {
        $postCollectionResponseMock = Mockery::mock(PostCollectionResponse::class);
        $this->postRepository
            ->shouldReceive('findAll')
            ->times(1)
            ->andReturns($postCollectionResponseMock);
        $postCollectionResponse = $this->postCollectionFinder->search();
        $this->assertInstanceOf(PostCollectionResponse::class, $postCollectionResponse);
    }
}
