<?php
namespace Groups;

use App\User;
use \FunctionalTester;

class EditGroupCest
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
        $I->wantTo('Create an organization');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('HomeController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->amOnAction('GroupsController@edit', ['id' => 1]);
        $I->canSee('Edit a group');
        $I->seeInField(['name' => 'name'], 'group_test');

        $I->fillField(['name' => 'name'], 'testing_group_2');

        $I->click('submit-groups-create');

        //assert
        $I->seeRecord('groups', [
            'name' => 'testing_group_2'
        ]);

    }
}
