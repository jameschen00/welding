<?php
$I = new TestGuy($scenario);
$I->wantTo('perform actions and see result');
$I->amOnPage('/');
$I->see('info@welding.com.ua');