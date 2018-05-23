<?php
/**
 * Created by IntelliJ IDEA.
 * User: pedroparraortega
 * Date: 06/03/2018
 * Time: 10:23
 */

namespace Voiceworks\Context\Post\Module\Post\Domain\Service;


use Voiceworks\Context\Post\Module\Post\Domain\PostAuthor;

interface AuthorExistanceChecker
{
    public function check(PostAuthor $author): bool;
}