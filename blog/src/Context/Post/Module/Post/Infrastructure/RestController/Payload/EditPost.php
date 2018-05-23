<?php

namespace Voiceworks\Context\Post\Module\Post\Infrastructure\RestController\Payload;
/**
 * @SWG\Definition(
 *   definition="editPostPayload"
 * )
 */
class EditPost implements Payload
{
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
}