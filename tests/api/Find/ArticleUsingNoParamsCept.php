<?php 
$I = new ApiTester($scenario);
$I->wantTo('find article via API which using no params');
$I->sendGET('/articles');
$I->seeResponseCodeIs(400);