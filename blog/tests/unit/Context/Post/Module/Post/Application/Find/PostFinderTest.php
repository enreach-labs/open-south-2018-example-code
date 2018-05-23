<?php

use Mockery\MockInterface;
use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Application\Find\PostFinder;
use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Voiceworks\Context\Post\Module\Post\Domain\PostResponse;
use Voiceworks\Context\Post\Module\Post\Domain\ReadPostRepository;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;

/**
 * Class PostFinderTest
 * @group post
 * @group application
 * @coversDefaultClass Voiceworks\Context\Post\Module\Post\Application\Find\PostFinder
 */
class PostFinderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var PostFinder
     */
    private $postFinder;
    /**
     * @var ReadPostRepository | MockInterface
     */
    private $postRepository;
    
    protected function _before()
    {
        $this->postRepository = Mockery::mock(ReadPostRepository::class);
        $this->postFinder = new PostFinder($this->postRepository);
    }

    protected function _after()
    {
    }

    public function testSearchSuccess()
    {
        $postResponseMock = Mockery::mock(PostResponse::class);
        $uuidStub = Mockery::mock(Uuid::class);
        $this->postRepository
            ->shouldReceive('find')
            ->times(1)
            ->andReturns($postResponseMock);
        $post = $this->postFinder->search($uuidStub);
        $this->assertInstanceOf(PostResponse::class, $post);
    }

    /**
     * @expectedException \Voiceworks\Context\Post\Module\Post\Domain\Exception\PostNotFoundException
     */
    public function testSearchFail()
    {
        $uuidStub = Mockery::mock(Uuid::class);
        $this->postRepository
            ->shouldReceive('find')
            ->times(1)
            ->andReturns(null);
        $post = $this->postFinder->search($uuidStub);
    }
}