<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\RestController;

use Slim\Http\Request;
use Slim\Http\Response;
use Voiceworks\Context\Post\Module\Post\Application\Edit\EditPostCommand;
use Symfony\Component\HttpFoundation\Response as SfResponse;
use Voiceworks\Context\Post\Module\Post\Infrastructure\RestController\Payload\EditPost;

class EditPostController extends ApiController
{
    protected $responseStatusCode = SfResponse::HTTP_OK;
    protected $responseContent = 'Post Edited';
    protected $payloadClass = EditPost::class;
    /**
     * @SWG\Put(
     *   path="/post/{id}",
     *   tags={"post"},
     *   summary="edit a post by id given",
     *
     *   @SWG\Parameter(
     *       description="ID of post item to fetch",
     *       in="path",
     *       name="id",
     *       required=true,
     *       type="string"
     *   ),
     *   @SWG\Response(
     *       response=200,
     *       description="Post Edited"
     *   ),
     *   produces={
     *       "application/json",
     *   },
     *   @SWG\Parameter(
     *      name="body",
     *      in="body",
     *      description="Post item object to be created",
     *      required=true,
     *      @SWG\Schema(ref="#/definitions/editPostPayload"),
     *   ),
     * )
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        parent::__invoke($request, $response, $args);
        $command = new EditPostCommand(
            $args['id'],
            $this->payload->title,
            $this->payload->content
        );
        $this->dispatch($command);

        return $this->generateJsonResponse($response);
    }
}