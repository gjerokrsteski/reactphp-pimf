<?php
$I = new ApiTester($scenario);
$I->wantTo('create a article via API using bad parameter values');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/articles', ['title' => '', 'content' => ['test'=>'content']]);
$I->seeResponseCodeIs(400);

