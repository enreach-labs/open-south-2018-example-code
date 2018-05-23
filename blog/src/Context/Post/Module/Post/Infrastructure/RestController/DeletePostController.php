<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\RestController;

use Slim\Http\Request;
use Slim\Http\Response;
use Voiceworks\Context\Post\Module\Post\Application\Delete\DeletePostCommand;

class DeletePostController extends ApiController
{
    protected $responseContent = 'Post Deleted';

    /**
     * @SWG\Delete(
     *     path="/post/{id}",
     *     tags={"post"},
     *     summary="Delete a post item based on a single ID",
     *     @SWG\Parameter(
     *         description="ID of post item to fetch",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="string"
     *     ),
     *     produces={
     *         "application/json",
     *     },
     *     @SWG\Response(
     *         response=200,
     *         description="post item response",
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Post item not found"
     *     )
     * )
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        $command = new DeletePostCommand($args['id']);
        $this->dispatch($command);

        return $this->generateJsonResponse($response);
    }
}