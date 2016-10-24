<?php
namespace Groups;

use App\Group;
use App\User;
use \FunctionalTester;

class RemoveUserToGroupCest
{
    public function _before(FunctionalTester $I)
    {
        $group = Group::find(1);
        $group->users()->attach(User::find(1));
    }

    public function _after(FunctionalTester $I)
    {
        $group = Group::find(1);
        $group->users()->detach(User::find(1));
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->am('a manager');
        $I->wantTo('Remove an user from a group');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('UsersManagementController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->click('submit-usergroup-disable');

        $I->canSee('The authorizations are successfully saved');

    }
}
