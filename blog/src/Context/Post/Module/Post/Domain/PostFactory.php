<?php

namespace Voiceworks\Context\Post\Module\Post\Domain;


use Operator\Common\Domain\Value\Uuid;
use Voiceworks\Context\Post\Module\Post\Domain\Author\AuthorNotFoundException;
use Voiceworks\Context\Post\Module\Post\Domain\Service\AuthorExistanceChecker;

class PostFactory
{
    /**
     * @var AuthorExistanceChecker
     */
    private $authorValidator;

    /**
     * PostFactory constructor.
     *
     * @param AuthorExistanceChecker $authorValidator
     */
    public function __construct(AuthorExistanceChecker $authorValidator)
    {
        $this->authorValidator = $authorValidator;
    }

    public function create(
        Uuid $id,
        PostTitle $title,
        PostContent $content,
        PostAuthor $author,
        PostTagCollection $tags,
        PostPublishedOn $publishedOn
    ): Post {
        if(!$this->authorValidator->check($author)){
            throw new AuthorNotFoundException();
        }

        return Post::publishWithData($id, $title, $content, $author, $tags, $publishedOn);
    }

}