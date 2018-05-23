<?php
namespace Steps\Post;

use AcceptanceTester;
use Behat\Gherkin\Node\TableNode;
use Operator\Common\Domain\Value\UuidGenerator as UuidGeneratorInterface;
use Operator\Common\Infrastructure\Value\UuidGenerator;
use Voiceworks\Context\Post\Module\Post\Domain\Post;
use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;
use Voiceworks\Context\Post\Module\Post\Domain\PostContent;
use Voiceworks\Context\Post\Module\Post\Domain\PostPublishedOn;
use Voiceworks\Context\Post\Module\Post\Domain\WritePostRepository;
use Voiceworks\Context\Post\Module\Post\Domain\PostTagCollection;
use Voiceworks\Context\Post\Module\Post\Domain\PostTitle;
use Voiceworks\Context\Post\Module\Post\Infrastructure\Persistence\WritePostRepositoryInMemory;

class BasicPostSteps
{
    protected $I;

    function __construct(AcceptanceTester $I)
    {
        $this->I = $I;
    }

    /**
     * @Given the following blog post exist
     */
    public function theFollowingBlogPostExist(TableNode $tableNode)
    {
        $postData = $tableNode->getRowsHash();
        $this->addPostToRepository($postData);
    }

    /**
     * @Given the following blog posts exist
     */
    public function theFollowingBlogPostsExist(TableNode $tableNode)
    {
        foreach ($tableNode as $row) {
            $this->addPostToRepository($row);
        }
    }

    /**
     * @param $postData
     */
    public function addPostToRepository($postData): void
    {
        $postId = $this->I->uuidGenerator->fromString($postData['id']);
        $postTitle = new PostTitle($postData['title']);
        $postContent = new PostContent($postData['content']);
        $postAuthor = new PostAuthor($postData['author']);
        $postTags = new PostTagCollection($postData['tags']);
        $post = Post::publishWithData($postId, $postTitle, $postContent, $postAuthor, $postTags, new PostPublishedOn());
        $this->I->postRepository->save($post);
    }
}