<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\RestController\Payload;
/**
 * @SWG\Definition(
 *   definition="publishPostPayload"
 * )
 */
class PublishPost implements Payload
{
    /**
     * @var string
     * @required
     *
     * @SWG\Property(
     *   property="id",
     *   type="string",
     *   description="post id",
     *   format="uuid",
     *   example="31d374f2-5e7d-4101-8563-b2fada27293d"
     * )
     */
    public $id;

    /**
     * @var string
     * @required
     * @SWG\Property(
     *   property="title",
     *   type="string",
     *   description="The post title",
     *   example="awesome title"
     * )
     */
    public $title;

    /**
     * @var string
     * @required
     * @SWG\Property(
     *   property="content",
     *   type="string",
     *   description="The post content",
     *   example="awesome content"
     * )
     */
    public $content;

    /**
     * @var string
     * @required
     * @SWG\Property(
     *   property="author",
     *   type="string",
     *   description="The post author",
     *   format="email",
     *   example="awesome-devs@voiceworks.com"
     * )
     */
    public $author;

    /**
     * @var string
     * @required
     * @SWG\Property(
     *   property="tags",
     *   type="string",
     *   description="The post tags",
     *   example="ddd,hexagonal"
     * )
     */
    public $tags;
}