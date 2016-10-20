<?php
namespace Auth;

use App\User;
use \FunctionalTester;

class HomePageCest
{
    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('db:seed');
    }

    public function _after(FunctionalTester $I)
    {

    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->am('a user');
        $I->wantTo('see if the auth works');

        $I->amLoggedAs(User::find(1));

        $I->amOnPage('/');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();
    }
}
