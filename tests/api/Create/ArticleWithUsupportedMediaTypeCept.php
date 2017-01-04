<?php
$I = new ApiTester($scenario);
$I->wantTo('create a article via API using unsupported media type');
$I->haveHttpHeader('Content-Type', 'application/NOT-JSON');
$I->sendPOST('/articles', ['title' => 'test', 'content' => ['test'=>'content']]);
$I->seeResponseCodeIs(415);

