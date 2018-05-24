<?php

namespace App\Tests;

use App\Entity\Comment;
use Codeception\Util\HttpCode;

class CommentCest
{
    public function createComment(FunctionalTester $I)
    {
        $I->amOnLocalizedPage('/login');
        $I->submitForm('#main form', ['_username' => 'john_user', '_password' => 'kitten']);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentRouteIs('blog_index');
        $I->click('article.post > h2 a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeCurrentRouteIs('blog_post');
        $I->dontSee('Hi, Symfony!');
        $I->fillField('comment[content]', 'Hi, Symfony!');
        $I->submitForm('#post-add-comment > form', []);
        $I->seeCurrentRouteIs('blog_post');
        $I->see('Hi, Symfony!');
        $I->seeInRepository(Comment::class, ['content' => 'Hi, Symfony!']);
    }

}