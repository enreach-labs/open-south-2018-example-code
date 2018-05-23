<?php
/**
 * Created by PhpStorm.
 * User: antonioa
 * Date: 27/02/18
 * Time: 17:03
 */

use Voiceworks\Context\Post\Module\Post\Domain\PostCollectionResponse;
use Voiceworks\Context\Post\Module\Post\Domain\PostResponse;

class PostCollectionResponseTest extends \Codeception\Test\Unit
{
    /**
     * @var PostCollectionResponse
     */
    private $postCollection;

    protected function _before()
    {
        $values = [Mockery::mock(PostResponse::class)];
        $this->postCollection = new PostCollectionResponse($values);
    }

    public function testValidPostCollectionResponse()
    {
        $this->assertInstanceOf(PostCollectionResponse::class, $this->postCollection);
    }

    /**
     * @expectedException \Operator\Common\Domain\Exception\InvalidArgumentException
     */
    public function testNotValidPostCollectionResponse()
    {
        $values = [new stdClass];
        $postCollection = new PostCollectionResponse($values);
    }

    public function testGetPostCollectionResponse()
    {
        $this->assertInternalType('array', $this->postCollection->getPostCollection());
    }
}
