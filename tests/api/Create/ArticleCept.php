<?php
$I = new ApiTester($scenario);
$I->wantTo('create a article via API');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/articles', ['title' => 'test title', 'content' => 'test content']);
$I->seeResponseCodeIs(201);
$I->seeResponseIsJson();
$I->seeResponseContains('newId');
$I->seeResponseMatchesJsonType(['newId' => 'integer']);

