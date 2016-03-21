<?php 
$I = new ApiTester($scenario);
$I->wantTo('find article via API which is not at the system');
$I->sendGET('/articles/9999999');
$I->seeResponseCodeIs(404);
