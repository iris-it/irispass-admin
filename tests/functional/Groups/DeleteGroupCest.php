<?php
namespace Groups;

use App\User;
use \FunctionalTester;

class DeleteGroupCest
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

        $I->amOnAction('UsersManagementController@index');
        $I->canSee('group_test');

        $I->click('submit-group-delete');

        //verify
        $I->seeCurrentActionIs('UsersManagementController@index');

        //assert
        $I->dontSeeRecord('groups', [
            'name' => 'group_test'
        ]);

    }
}
