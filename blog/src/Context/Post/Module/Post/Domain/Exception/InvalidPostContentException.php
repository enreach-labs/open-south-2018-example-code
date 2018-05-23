<?php
/**
 * Created by IntelliJ IDEA.
 * User: pedroparraortega
 * Date: 22/02/2018
 * Time: 11:22
 */

namespace Voiceworks\Context\Post\Module\Post\Domain\Exception;


use Operator\Common\Domain\Exception\InvalidArgumentException;

class InvalidPostContentException extends InvalidArgumentException
{
    protected $message = 'Invalid post content';

}