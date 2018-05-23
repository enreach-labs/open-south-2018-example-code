<?php

namespace Steps\Post;


use Behat\Gherkin\Node\TableNode;
use Operator\Common\Domain\Exception\InvalidArgumentException;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PostPublisher;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PublishPostCommand;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PublishPostCommandHandler;
use Voiceworks\Context\Post\Module\Post\Domain\Post;

class PublishPostSteps extends BasicPostSteps
{

    /**
     * @Given I want to create a blog post containing the following information
     */
    public function iWantToCreateABlogPostContainingTheFollowingInformation(TableNode $tableNode)
    {
        $row = $tableNode->getRowsHash();
        $this->initializeDataFromRow($row);
    }

    /**
     * @When I request the blog service to create the blog post
     */
    public function iRequestTheBlogServiceToCreateTheBlogPost()
    {
        try {
            $this->createPost();
        } catch (InvalidArgumentException $exception) {
            $this->I->exception = $exception;
        }
    }

    /**
     * @Then the post with id :arg1 should be stored
     */
    public function thePostWithIdShouldBeStored($arg1)
    {
        $post = $this->I->postRepository->find($arg1);

        $this->I->assertInstanceOf(Post::class, $post);
    }

    /**
     * @Then I should be presented with an error explaining that blog posts should contain a title
     */
    public function iShouldBePresentedWithAnErrorExplainingThatBlogPostsShouldContainATitle()
    {
        $this->I->assertInstanceOf(InvalidArgumentException::class, $this->I->exception);
    }

    /**
     * @Then I should be presented with an error explaining that blog posts should contain at least one tag
     */
    public function iShouldBePresentedWithAnErrorExplainingThatBlogPostsShouldContainAtLeastOneTag()
    {
        $this->I->assertInstanceOf(InvalidArgumentException::class, $this->I->exception);
    }

    /**
     * @Then I should be presented with an error explaining that blog posts should contain an author
     */
    public function iShouldBePresentedWithAnErrorExplainingThatBlogPostsShouldContainAnAuthor()
    {
        $this->I->assertInstanceOf(InvalidArgumentException::class, $this->I->exception);
    }

    /**
     * @Then I should be presented with an error explaining that blog posts should contain an author in form of an email address
     */
    public function iShouldBePresentedWithAnErrorExplainingThatBlogPostsShouldContainAnAuthorInFormOfAnEmailAddress()
    {
        $this->I->assertInstanceOf(InvalidArgumentException::class, $this->I->exception);
    }

    /**
     * @param array $postData
     */
    private function initializeDataFromRow(array $postData): void
    {
        $this->I->postId = $postData['id'];
        $this->I->postTitle = $postData['title'];
        $this->I->postContent = $postData['content'];
        $this->I->postAuthor = $postData['author'];
        $this->I->postTags = $postData['tags'];
    }

    private function createPost()
    {
        $command = new PublishPostCommand(
            $this->I->postId,
            $this->I->postTitle,
            $this->I->postContent,
            $this->I->postAuthor,
            $this->I->postTags
        );
        $postPublisher = new PostPublisher(
            $this->I->postRepository
        );

        $commandHandler = new PublishPostCommandHandler(
            $postPublisher,
            $this->I->uuidGenerator
        );

        $commandHandler->__invoke($command);
    }
}