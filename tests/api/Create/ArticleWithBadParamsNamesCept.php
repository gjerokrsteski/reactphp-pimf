<?php
$I = new ApiTester($scenario);
$I->wantTo('create a article via API using no expected parameters');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/articles', ['test' => 'test title', 'test2' => 'test content']);
$I->seeResponseCodeIs(400);

