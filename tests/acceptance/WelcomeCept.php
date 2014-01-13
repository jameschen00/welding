<?php
$I = new WebGuy($scenario);
$I->wantTo('Ensure that frontpage works');
$I->amOnPage('/');
$I->see('info@welding.com.ua');