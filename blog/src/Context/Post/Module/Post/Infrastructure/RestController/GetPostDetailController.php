<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\RestController;

use Slim\Http\Request;
use Slim\Http\Response;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostQuery;

class GetPostDetailController extends ApiController
{
    /**
     * @SWG\Get(
     *     path="/post/{id}",
     *     tags={"post"},
     *     summary="Returns a post item based on a single ID",
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
     * )`
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        parent::__invoke($request, $response, $args);
        $query = new RetrievePostQuery($args['id']);
        $this->responseContent = $this->ask($query);

        return $this->generateJsonResponse($response);
    }
}