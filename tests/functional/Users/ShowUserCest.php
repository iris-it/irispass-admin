<?php
namespace Users;

use App\User;
use \FunctionalTester;

class ShowUserCest
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
        $I->wantTo('See users');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('UsersManagementController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->canSee('John');
        $I->canSee('Ron');
        $I->canSee('Doe');

    }
}
