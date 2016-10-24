<?php
namespace Groups;

use App\User;
use \FunctionalTester;

class CreateGroupCest
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
        $I->wantTo('Create a group');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('HomeController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->amOnAction('GroupsController@create');
        $I->canSee('Create a new group');

        $I->fillField(['name' => 'name'], 'testing_group_2');

        $I->click('submit-groups-create');

        //verify
        $I->seeCurrentActionIs('UsersManagementController@index');
        $I->canSee('This group was successfully created');

        //assert
        $I->seeRecord('groups', [
            'name' => 'testing_group_2'
        ]);

    }
}
