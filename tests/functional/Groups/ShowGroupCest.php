<?php
namespace Groups;

use App\User;
use \FunctionalTester;

class ShowGroupCest
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
        $I->wantTo('See groups');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('UsersManagementController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->canSee('group_test');

    }
}
