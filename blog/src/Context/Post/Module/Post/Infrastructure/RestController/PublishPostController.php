<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\RestController;

use Slim\Http\Request;
use Slim\Http\Response;
use Voiceworks\Context\Post\Module\Post\Application\Publish\PublishPostCommand;
use Symfony\Component\HttpFoundation\Response as SfResponse;
use Voiceworks\Context\Post\Module\Post\Infrastructure\RestController\Payload\PublishPost;

class PublishPostController extends ApiController
{
    protected $responseStatusCode = SfResponse::HTTP_CREATED;
    protected $responseContent = 'Post Created';
    protected $payloadClass = PublishPost::class;

    /**
     * @SWG\Post(
     *   path="/post",
     *   tags={"post"},
     *   summary="create a new post",
     *   @SWG\Response(
     *       response=201,
     *       description="Post Created"
     *   ),
     *   produces={
     *       "application/json",
     *   },
     *   @SWG\Parameter(
     *      name="body",
     *      in="body",
     *      description="Post item object to be created",
     *      required=true,
     *      @SWG\Schema(ref="#/definitions/publishPostPayload"),
     *   ),
     * )
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        parent::__invoke($request, $response, $args);
        $command = new PublishPostCommand(
            $this->payload->id,
            $this->payload->title,
            $this->payload->content,
            $this->payload->author,
            $this->payload->tags
        );
        $this->dispatch($command);

        return $this->generateJsonResponse($response);
    }
}