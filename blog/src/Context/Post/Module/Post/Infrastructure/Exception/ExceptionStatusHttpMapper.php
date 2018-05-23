<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Exception;

use Operator\Common\Domain\Exception\InvalidArgumentException;
use Prooph\EventStore\Exception\StreamExistsAlready;
use Symfony\Component\HttpFoundation\Response;
use Voiceworks\Context\Post\Module\Post\Domain\Author\AuthorNotFoundException;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostAuthorException;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostContentException;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostTagsException;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\InvalidPostTitleException;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\PostNotFoundException;
use Voiceworks\Context\Post\Module\Post\Domain\Exception\PostTitleAlreadyExistsException;

final class ExceptionStatusHttpMapper
{
    private $exceptions = [

        InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
        InvalidPostTitleException::class => Response::HTTP_BAD_REQUEST,
        InvalidPostAuthorException::class => Response::HTTP_BAD_REQUEST,
        InvalidPostContentException::class => Response::HTTP_BAD_REQUEST,
        InvalidPostTagsException::class => Response::HTTP_BAD_REQUEST,
        PostNotFoundException::class => Response::HTTP_NOT_FOUND,
        StreamExistsAlready::class => Response::HTTP_BAD_REQUEST,
        PostTitleAlreadyExistsException::class => Response::HTTP_BAD_REQUEST,
        AuthorNotFoundException::class => Response::HTTP_BAD_REQUEST
    ];

    public function getStatusCode(string $exceptionClass): int
    {
        return $this->exceptions[$exceptionClass];
    }
}