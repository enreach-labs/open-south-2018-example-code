<?php 
$I = new ApiTester($scenario);
$I->wantTo('create a new post');
$I->haveHttpHeader('Content-Type', 'application/json');
$uuid = \Ramsey\Uuid\Uuid::uuid4();

$I->sendPOST(
    '/post',
    "{  \"id\": \"$uuid\",  \"title\": \"awesome title for $uuid\",  \"content\": \"awesome content\",  \"author\": \"awesome-devs@voiceworks.com\",  \"tags\": \"ddd,hexagonal\"}"
);

$I->canSeeResponseIsJson();
$I->canSeeResponseCodeIs(201);

