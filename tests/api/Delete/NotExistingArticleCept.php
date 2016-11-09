<?php
$I = new ApiTester($scenario);
$I->wantTo('delete a not existing article via API');

$I->sendDELETE('/articles/'.mt_rand(9999, 99999));
$I->seeResponseCodeIs(404);
$I->canSeeResponseEquals('');