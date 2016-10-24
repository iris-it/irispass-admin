<?php
namespace Groups;

use App\User;
use \FunctionalTester;

class AddUserToGroupCest
{
    public function _before(FunctionalTester $I)
    {

    }

    public function _after(FunctionalTester $I)
    {
        //The authorizations are successfully saved
        //enable
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->am('a manager');
        $I->wantTo('Add an user from a group');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('UsersManagementController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->click('submit-usergroup-enable');

        $I->seeCurrentActionIs('UsersManagementController@index');

        $I->canSee('The authorizations are successfully saved');

    }
}
