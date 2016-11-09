<?php
$I = new ApiTester($scenario);
$I->wantTo('create a new article via API to delete it');

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/articles', ['title' => 'to delete title', 'content' => 'to delete content']);
$I->seeResponseCodeIs(201);
$I->seeResponseIsJson();
$I->seeResponseContains('newId');
$I->seeResponseMatchesJsonType(['newId' => 'integer']);

$body = json_decode($I->grabResponse());

$I->sendDELETE('/articles/'.$body->newId);
$I->seeResponseCodeIs(200);
$I->canSeeResponseEquals('');