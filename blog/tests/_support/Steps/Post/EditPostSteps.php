<?php

namespace Steps\Post;

use Behat\Gherkin\Node\TableNode;
use Operator\Common\Domain\Exception\InvalidArgumentException;
use Prooph\ServiceBus\Exception\MessageDispatchException;
use Voiceworks\Context\Post\Module\Post\Application\Edit\EditPostCommand;
use Voiceworks\Context\Post\Module\Post\Application\Edit\EditPostCommandHandler;
use Voiceworks\Context\Post\Module\Post\Application\Edit\PostEditor;
use Voiceworks\Context\Post\Module\Post\Application\Find\PostFinder;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\PostTitleAlreadyExistsException;
use Voiceworks\Context\Post\Module\Post\Domain\PostResponse;

class EditPostSteps extends BasicPostSteps
{
    private $exception;

    /**
     * @Given I want to change the blog post with id :arg1 to contain the following data:
     */
    public function iWantToChangeTheBlogPostWithIdToContainTheFollowingData($arg1, TableNode $tableNode)
    {
        $postData = $tableNode->getRowsHash();
        $this->initializeDataFromRow($postData);
        $this->I->postId = $arg1;
    }

    /**
     * @When I request the blog service to modify the blog post
     */
    public function iRequestTheBlogServiceToModifyTheBlogPost()
    {
        try {
            $this->editPost();
        } catch (InvalidArgumentException $exception) {
            $this->I->exception = $exception;
        } catch (MessageDispatchException $exception) {
            $this->I->exception = $exception->getPrevious();
        }
    }

    /**
     * @Then the blog post with id :arg1 should have changed and containe the following information:
     */
    public function theBlogPostWithIdShouldHaveChangedAndContaineTheFollowingInformation($arg1, TableNode $tableNode)
    {
        /** @var PostResponse $post */
        $post = $this->I->readPostRepository->find($arg1);
        $postData = $tableNode->getRowsHash();
        $this->I->assertEquals($postData['id'], $post->getId());
        $this->I->assertEquals($postData['title'], $post->getTitle());
        $this->I->assertEquals($postData['content'], $post->getContent());
    }

    /**
     * @Then I should be presented with an error explaining that a blog post with the title :arg1 already exists
     */
    public function iShouldBePresentedWithAnErrorExplainingThatABlogPostWithTheTitleAlreadyExists($arg1)
    {
        $this->I->assertInstanceOf(PostTitleAlreadyExistsException::class, $this->I->exception);
    }

    /**
     * @param array $postData
     */
    private function initializeDataFromRow(array $postData): void
    {
        $this->I->postTitle = $postData['title'];
        $this->I->postContent = $postData['content'];
    }

    private function editPost()
    {
        $command = new EditPostCommand(
            $this->I->postId,
            $this->I->postTitle,
            $this->I->postContent
        );
        $postEditor = new PostEditor(
            $this->I->postRepository
        );

        $commandHandler = new EditPostCommandHandler(
            $postEditor,
            $this->I->uuidGenerator
        );

        $commandHandler->__invoke($command);
    }
}