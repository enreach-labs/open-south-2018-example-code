<?php

use Voiceworks\Context\Post\Module\Post\Domain\PostResponse;

class PostResponseTest extends \Codeception\Test\Unit
{
    public function testGetId()
    {
        $postResponse = new PostResponse;
        $reflectionClass = new ReflectionClass('\Voiceworks\Context\Post\Module\Post\Domain\PostResponse');
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($postResponse, 'id');
        $result = $postResponse->getId();
        $this->assertInternalType('string', $result);
    }

    public function testGetTitle()
    {
        $postResponse = new PostResponse;
        $reflectionClass = new ReflectionClass('\Voiceworks\Context\Post\Module\Post\Domain\PostResponse');
        $reflectionProperty = $reflectionClass->getProperty('title');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($postResponse, 'title');
        $result = $postResponse->getTitle();
        $this->assertInternalType('string', $result);
    }

    public function testGetContent()
    {
        $postResponse = new PostResponse;
        $reflectionClass = new ReflectionClass('\Voiceworks\Context\Post\Module\Post\Domain\PostResponse');
        $reflectionProperty = $reflectionClass->getProperty('content');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($postResponse, 'content');
        $result = $postResponse->getContent();
        $this->assertInternalType('string', $result);
    }

    public function testGetAuthor()
    {
        $postResponse = new PostResponse;
        $reflectionClass = new ReflectionClass('\Voiceworks\Context\Post\Module\Post\Domain\PostResponse');
        $reflectionProperty = $reflectionClass->getProperty('author');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($postResponse, 'author');
        $result = $postResponse->getAuthor();
        $this->assertInternalType('string', $result);
    }

    public function testGetTags()
    {
        $postResponse = new PostResponse;
        $reflectionClass = new ReflectionClass('\Voiceworks\Context\Post\Module\Post\Domain\PostResponse');
        $reflectionProperty = $reflectionClass->getProperty('tags');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($postResponse, 'tags');
        $result = $postResponse->getTags();
        $this->assertInternalType('string', $result);
    }
}
