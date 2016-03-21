<?php
$I = new ApiTester($scenario);
$I->wantTo('delete a not existing article via API');

$I->sendDELETE('/article/'.uniqid());
$I->seeResponseCodeIs(404);
$I->canSeeResponseEquals('');