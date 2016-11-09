<?php
$I = new ApiTester($scenario);
$I->wantTo('delete article with invalid id via API');

$I->sendDELETE('/articles/bad-article-id-here');
$I->seeResponseCodeIs(400);
$I->canSeeResponseEquals('');