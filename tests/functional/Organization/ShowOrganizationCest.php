<?php
namespace Auth;

use App\User;
use \FunctionalTester;

class ShowOrganizationCest
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
        $I->am('a manager');
        $I->wantTo('See organization info');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('OrganizationController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->canSee('Acme LTD');
        $I->canSee('4 duck street');
        $I->canSee('acme.corp@mail.fr');
        $I->canSee('+33564381765');
        $I->canSee('www.acme.com');

    }
}
