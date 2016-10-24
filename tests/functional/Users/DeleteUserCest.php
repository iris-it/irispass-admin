<?php
namespace Users;

use App\User;
use \FunctionalTester;

class DeleteUserCest
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
        $I->wantTo('delete an user');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('UsersManagementController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->canSee('Ron');
        $I->canSee('Doe');

        $I->click('submit-users-delete');

        //verify
        $I->seeCurrentActionIs('UsersManagementController@index');

        //assert
        $I->dontSeeRecord('users', [
            'preferred_username' => 'ron_doe'
        ]);

    }
}
