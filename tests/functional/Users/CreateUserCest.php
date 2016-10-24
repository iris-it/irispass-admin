<?php
namespace Users;

use App\User;
use \FunctionalTester;

class CreateUserCest
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
        $I->wantTo('Create an user');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('HomeController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->amOnAction('UsersController@create');
        $I->canSee('Create a new user');

        $I->fillField(['name' => 'preferred_username'], 'user_test');
        $I->fillField(['name' => 'family_name'], 'user');
        $I->fillField(['name' => 'given_name'], 'test');
        $I->fillField(['name' => 'email'], 'test@user.com');


        $I->click('submit-users-create');

        //verify
        $I->seeCurrentActionIs('UsersManagementController@index');

        //assert
        $I->seeRecord('users', [
            'preferred_username' => 'user_test',
            'family_name' => 'user',
            'given_name' => 'test',
            'email' => 'test@user.com',
        ]);

    }
}
