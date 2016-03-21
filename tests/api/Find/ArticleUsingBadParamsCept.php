<?php 
$I = new ApiTester($scenario);
$I->wantTo('find article via API which using bad param name');
$I->sendGET('/articles', ['title' => 1]);
$I->seeResponseCodeIs(400);