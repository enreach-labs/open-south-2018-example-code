<?php
/**
 * Created by IntelliJ IDEA.
 * User: pedroparraortega
 * Date: 06/03/2018
 * Time: 10:30
 */

namespace Voiceworks\Context\Post\Module\Post\Domain\Author;


use Operator\Common\Domain\Exception\InvalidArgumentException;

class AuthorNotFoundException extends InvalidArgumentException
{
    protected $message = "Author not found";
}