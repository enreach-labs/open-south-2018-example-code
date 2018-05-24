<?php
use App\Tests\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantTo('login as admin to backend');
$I->amOnPage('/');
$I->click('Browse backend');
$I->seeInCurrentUrl('/en/login');
$I->see('Secure Sign in', 'legend');
$I->fillField('Username', 'jane_admin');
$I->fillField('Password', 'kitten');
$I->click('Sign in');
$I->seeInCurrentUrl('admin');
$I->seeLink('Logout');
