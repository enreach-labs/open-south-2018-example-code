<?php

namespace Steps\Post;

use Voiceworks\Context\Post\Module\Post\Application\Delete\DeletePostCommand;
use Voiceworks\Context\Post\Module\Post\Application\Delete\DeletePostCommandHandler;
use Voiceworks\Context\Post\Module\Post\Application\Delete\PostDelete;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\PostNotFoundException;

class DeletePostSteps extends BasicPostSteps
{

    /**
     * @Given the blog post with post id :arg1 does not exist
     */
    public function theBlogPostWithPostIdDoesNotExist($arg1)
    {
    }

    /**
     * @When I request the blog service to remove the blog post with post id :arg1
     */
    public function iRequestTheBlogServiceToRemoveTheBlogPostWithPostId($arg1)
    {

        try {
            $deleteCommand = new DeletePostCommand($arg1);
            $deleteCommandHandler = new DeletePostCommandHandler(
                $this->I->uuidGenerator,
                new PostDelete($this->I->postRepository)
            );
            $deleteCommandHandler->__invoke($deleteCommand);
        } catch (PostNotFoundException $exception) {
            $this->I->exception = $exception;
        }
    }

    /**
     * @Then the blog post with id :arg1 should have been removed
     */
    public function theBlogPostWithIdShouldHaveBeenRemoved($arg1)
    {
        $this->I->assertNull($this->I->readPostRepository->find($arg1));
    }

    /**
     * @Then I should be presented with an error explaining that blog post with post id :arg1 does not exist
     */
    public function iShouldBePresentedWithAnErrorExplainingThatBlogPostWithPostIdDoesNotExist($arg1)
    {
        $this->I->assertInstanceOf(PostNotFoundException::class, $this->I->exception);
    }
}