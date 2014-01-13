<?php
$I = new WebGuy($scenario);
$I->wantTo('Ensure that product category works');
$I->amOnPage('/telefsmart/mobile');
$I->see('Samsung SGH-U700 Black');