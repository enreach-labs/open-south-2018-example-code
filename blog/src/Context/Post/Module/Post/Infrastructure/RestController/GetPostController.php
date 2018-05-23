<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\RestController;

use Slim\Http\Request;
use Slim\Http\Response;
use Voiceworks\Context\Post\Module\Post\Application\Find\RetrievePostCollectionQuery;
use Voiceworks\Context\Post\Module\Post\Domain\PostCollectionResponse;

class GetPostController extends ApiController
{
    /**
     * @SWG\Get(
     *   path="/post",
     *   tags={"post"},
     *   summary="Post list",
     *   @SWG\Response(
     *     response=200,
     *     description="Post list"
     *   ),
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *       name="limit",
     *       in="query",
     *       description="results per page",
     *       default=100,
     *       required=false,
     *       format="int64",
     *       type="integer",
     *   ),
     *   @SWG\Parameter(
     *       name="offset",
     *       in="query",
     *       description="current page",
     *       default=0,
     *       required=false,
     *       format="int64",
     *       type="integer",
     *   ),
     * )
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        parent::__invoke($request, $response, $args);
        $query = new RetrievePostCollectionQuery(
            $request->getParam('limit'),
            $request->getParam('offset')
        );
        $postCollection = $this->ask($query);
        if ($postCollection instanceof PostCollectionResponse) {
            $this->responseContent = $postCollection->getPostCollection();
        }

        return $this->generateJsonResponse($response);
    }
}