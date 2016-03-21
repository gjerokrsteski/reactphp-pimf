<?php
$I = new ApiTester($scenario);
$I->wantTo('create a article via API and find a article via api');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/articles', ['title' => 'test title', 'content' => 'test content']);
$I->seeResponseCodeIs(201);
$I->seeResponseIsJson();
$I->seeResponseContains('newId');
$I->seeResponseMatchesJsonType(['newId' => 'integer']);

$body = json_decode($I->grabResponse());

$I->sendGET('/articles/'.$body->newId);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseMatchesJsonType(
    [
        'id'      => 'integer',
        'title'   => 'string',
        'content' => 'string',
    ]
);
