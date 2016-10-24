<?php
namespace Users;

use App\User;
use \FunctionalTester;

class EditUserCest
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
        $I->wantTo('Edit an user');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('HomeController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->amOnAction('UsersController@edit', ['id' => 3]);
        $I->canSee('Edit an user');

        $I->seeInField(['name' => 'preferred_username'], 'ron_doe');
        $I->seeInField(['name' => 'family_name'], 'Doe');
        $I->seeInField(['name' => 'given_name'], 'Ron');
        $I->seeInField(['name' => 'email'], 'ron.doe@mail.com');

        $I->fillField(['name' => 'preferred_username'], 'user_test');
        $I->fillField(['name' => 'family_name'], 'user');
        $I->fillField(['name' => 'given_name'], 'test');
        $I->fillField(['name' => 'email'], 'test@user.com');

        $I->click('submit-users-create');

        //verify
        $I->seeCurrentActionIs('UsersController@show', ['id' => 3]);
        $I->canSee('User successfully updated');

        //assert
        $I->seeRecord('users', [
            'preferred_username' => 'user_test',
            'family_name' => 'user',
            'given_name' => 'test',
            'email' => 'test@user.com',
        ]);

    }
}
