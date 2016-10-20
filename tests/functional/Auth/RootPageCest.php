<?php
namespace Auth;

use \FunctionalTester;

class RootPageCest
{
    public function _before(FunctionalTester $I)
    {

    }

    public function _after(FunctionalTester $I)
    {

    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->am('a user');
        $I->wantTo('see if the application works');

        $I->amOnAction('HomeController@index');
        $I->seeCurrentActionIs('AuthController@login');

        $I->cantSeeAuthentication();

        $I->canSee('Iris');
    }
}
