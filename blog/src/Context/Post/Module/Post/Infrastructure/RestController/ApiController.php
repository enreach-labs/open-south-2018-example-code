<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\RestController;

use JMS\Serializer\SerializerBuilder;
use Operator\Common\Application\Query\Query;
use Operator\Common\Domain\Exception\InvalidArgumentException;
use Operator\Common\Domain\Response\Response;
use Prooph\ServiceBus\Exception\MessageDispatchException;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response as SlimResponse;
use Symfony\Component\HttpFoundation\Request as SfRequest;
/**
 * @SWG\Swagger(
 *   host="blog.voiceworks.dev:8081",
 *   @SWG\Info(
 *     title="Blog API",
 *     version="1.0.0"
 *   )
 * )
 *
 * Class ApiController
 *
 * @package Voiceworks\Context\Post\Module\Post\Infrastructure\RestController
 */
abstract class ApiController
{
    const DEFAULT_PARAMS_VALUE = '';
    protected $container;
    protected $serializer;
    protected $commandBus;
    protected $responseStatusCode = 200;
    protected $responseContent;
    protected $queryBus;
    protected $entityManager;
    protected $mapper;
    protected $payload;
    protected $payloadClass;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->commandBus = $container->get('commandBus');
        $this->queryBus = $container->get('queryBus');
        $this->mapper = $container->get('mapper');
        $this->serializer = SerializerBuilder::create()->build();
    }

    public function __invoke(Request $request, SlimResponse $response, array $args)
    {
        if (($request->getMethod() === SfRequest::METHOD_POST || $request->getMethod() === SfRequest::METHOD_PUT)
            && $this->payloadClass
        ) {
            try {
                $body = json_decode($request->getBody());
                $this->payload = $this->mapper->map($body, new $this->payloadClass());
            } catch (\InvalidArgumentException $exception) {
                throw new InvalidArgumentException("Bad body request");
            }
        }
    }


    public function dispatch($command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function ask(Query $query): Response
    {
        $response = null;
        /** @var MessageDispatchException $exception */
        $exception = null;
        $this->queryBus->dispatch($query)->then(
            function ($result) use(&$response) {
                $response = $result;
            },
            function ($result) use (&$exception){
                $exception = $result->getPrevious();
            }
        );
        if ($exception) { throw $exception;}
        return $response;
    }

    protected function generateJsonResponse(SlimResponse $response)
    {
        $jsonContent = $this->serializer->serialize($this->responseContent, 'json');

        return $response->withStatus($this->responseStatusCode)
            ->withHeader('Content-Type', 'application/json')
            ->write($jsonContent);
    }
}