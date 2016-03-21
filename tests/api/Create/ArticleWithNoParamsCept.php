<?php
$I = new ApiTester($scenario);
$I->wantTo('create a article via API without parameters');
$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
$I->sendPOST('/articles', []);
$I->seeResponseCodeIs(400);

