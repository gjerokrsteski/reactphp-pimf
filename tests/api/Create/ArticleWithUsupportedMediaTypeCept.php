<?php
$I = new ApiTester($scenario);
$I->wantTo('create a article via API using unsupported media type');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/articles', ['title' => '', 'content' => ['test'=>'content']]);
$I->seeResponseCodeIs(400);

