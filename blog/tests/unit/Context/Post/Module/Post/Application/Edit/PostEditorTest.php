<?php

use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Application\Edit\PostEditor;
use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;

class PostEditorTest extends \Codeception\Test\Unit
{

    /**
     * @var PostEditor
     */
    private $postEditor;

    /**
     * @var \Mockery\MockInterface
     */
    private $postRepository;

    protected function _before()
    {
        $this->postRepository = Mockery::mock(WritePostRepository::class);
        $this->postEditor = new PostEditor($this->postRepository);
    }

    public function testEdit()
    {
        $postMock = Mockery::mock(Post::class);
        $uuidStub = Mockery::mock(Uuid::class);
        $uuidStub->shouldReceive('getValue')->andReturn('string');
        $postTitleStub = Mockery::mock(PostTitle::class);
        $postContentStub = Mockery::mock(PostContent::class);

        $this->postRepository
            ->shouldReceive('find')
            ->times(1)
            ->andReturns($postMock);

        $this->postRepository
            ->shouldReceive('save')
            ->times(1);

        $postMock->shouldReceive('updateTitle')->times(1);
        $postMock->shouldReceive('updateContent')->times(1);

        $this->postEditor->edit($uuidStub, $postTitleStub, $postContentStub);
    }
}
