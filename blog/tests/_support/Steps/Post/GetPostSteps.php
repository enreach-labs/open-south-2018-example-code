<?php

namespace Steps\Post;



use Behat\Gherkin\Node\TableNode;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostCollectionQuery;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostCollectionQueryHandler;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostQuery;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostQueryHandler;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\PostNotFoundException;
use Voiceworks\Context\Post\Module\Post\Domain\PostCollectionResponse;
use Voiceworks\Context\Post\Module\Post\Domain\PostResponse;

class GetPostSteps extends BasicPostSteps
{
    /**
     * @var PostResponse
     */
    private $post;
    /**
     * @var PostCollectionResponse
     */
    private $postCollection;

    /**
     * @When I request the blog service to retrieve a single blog with post id :arg1
     */
    public function iRequestTheBlogServiceToRetrieveASingleBlogWithPostId($arg1)
    {
        $query = new RetrievePostQuery($arg1);
        $handler = new RetrievePostQueryHandler($this->I->postFinder, $this->I->uuidGenerator);
        try {
           $this->post = $handler->handle($query);
        } catch (PostNotFoundException $exception) {
            $this->I->exception = $exception;
        }
    }

    /**
     * @Then I shold be presented with the following blog post
     */
    public function iSholdBePresentedWithTheFollowingBlogPost(TableNode $tableNode)
    {
        $postData = $tableNode->getRowsHash();
        $this->I->assertEquals($postData['id'], $this->post->getId());
        $this->I->assertEquals($postData['title'], $this->post->getTitle());
        $this->I->assertEquals($postData['content'], $this->post->getContent());
        $this->I->assertEquals($postData['author'], $this->post->getAuthor());
        $this->I->assertEquals($postData['tags'], $this->post->getTags());
    }

    /**
     * @Then I should be presented with an error explaining that the blog post could not be found
     */
    public function iShouldBePresentedWithAnErrorExplainingThatTheBlogPostCouldNotBeFound()
    {
        $this->I->assertInstanceOf(PostNotFoundException::class, $this->I->exception);
    }

    /**
     * @When I request the blog service to retrieve :num1 blog posts starting from blog post :num1
     * @When I request the blog service to retrieve :num:num2 blog posts starting from blog post :num2
     */
    public function iRequestTheBlogServiceToRetrieveBlogPostsStartingFromBlogPost($num1, $num2)
    {

        $query = new RetrievePostCollectionQuery($num1, $num2-1);
        $handler = new RetrievePostCollectionQueryHandler($this->I->postCollectionFinder);
        $this->postCollection = $handler->handle($query);
    }

    /**
     * @Then I should be presented with the following blog posts
     */
    public function iShouldBePresentedWithTheFollowingBlogPosts(TableNode $tableNode)
    {
        foreach ($tableNode->getRows() as $index => $row) {
            if ($index === 0) {
                continue;
            }
            $this->I->assertEquals($row[0], $this->postCollection->getPostCollection()[$index-1]->getId());
        }
    }
}