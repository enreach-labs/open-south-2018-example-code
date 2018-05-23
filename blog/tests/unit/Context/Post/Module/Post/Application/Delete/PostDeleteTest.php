<?php

use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Application\Delete\PostDelete;
use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;

class PostDeleteTest extends \Codeception\Test\Unit
{
    /**
     * @var PostDelete
     */
    private $postDelete;

    /**
     * @var \Mockery\MockInterface
     */
    private $postRepository;

    protected function _before()
    {
        $this->postRepository = Mockery::mock(WritePostRepository::class);
        $this->postDelete = new PostDelete($this->postRepository);
    }

    public function testDelete()
    {
        $postMock = Mockery::mock(Post::class);
        $uuidStub = Mockery::mock(Uuid::class);
        $this->postRepository
            ->shouldReceive('find')
            ->times(1)
            ->andReturns($postMock);
        $this->postRepository
            ->shouldReceive('delete')
            ->times(1);
        $this->postRepository
            ->shouldReceive('save')
            ->times(1);

        $this->postDelete->delete($uuidStub);
    }
}
