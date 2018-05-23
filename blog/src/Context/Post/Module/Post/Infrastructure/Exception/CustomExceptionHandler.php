<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\Exception;

use Prooph\ServiceBus\Exception\CommandDispatchException;
use Prooph\ServiceBus\Exception\MessageDispatchException;
use Slim\Http\Request;
use Slim\Http\Response;

class CustomExceptionHandler
{
    private $exceptionStatusHttpMapper;

    public function __construct(ExceptionStatusHttpMapper $exceptionStatusHttpMapper)
    {
        $this->exceptionStatusHttpMapper = $exceptionStatusHttpMapper;
    }

    public function __invoke(Request $request, Response $response, \Exception $exception) {

        if ($exception instanceof CommandDispatchException) {
            $exception = $exception->getPrevious();
            if ($exception instanceof MessageDispatchException) {
                $exception = $exception->getPrevious();
            }
        }

        return $response
            ->withStatus($this->exceptionStatusHttpMapper->getStatusCode(get_class($exception)))
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode(['error' => $exception->getMessage()]));
    }
}