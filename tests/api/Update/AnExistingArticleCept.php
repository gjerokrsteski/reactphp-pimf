<?php
$I = new ApiTester($scenario);
$I->wantTo('update a existing article via API');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/articles', ['title' => 'test title', 'content' => 'test content']);
$I->seeResponseCodeIs(201);
$I->seeResponseIsJson();
$I->seeResponseContains('newId');
$I->seeResponseMatchesJsonType(['newId' => 'integer']);

$body = json_decode($I->grabResponse());

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPUT('/articles/'.$body->newId, ['title' => $newTitle = uniqid('new title '), 'content' => $newContent = uniqid('new content ')]);
$I->seeResponseCodeIs(200);
$I->canSeeResponseEquals('');

$I->sendGET('/articles/'.$body->newId);
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(
    ['id'=>$body->newId, 'title'=>$newTitle, 'content'=>$newContent]
);