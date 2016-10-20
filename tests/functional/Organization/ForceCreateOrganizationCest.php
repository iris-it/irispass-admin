<?php
namespace Auth;

use App\User;
use \FunctionalTester;

class ForceCreateOrganizationCest
{
    public function _before(FunctionalTester $I)
    {
        $I->callArtisan('db:seed');
    }

    public function _after(FunctionalTester $I)
    {

    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->am('a user');
        $I->wantTo('see if i am forced to create an organization');

        $I->amLoggedAs(User::find(2));

        $I->amOnAction('HomeController@index');
        $I->canSee('Mike Doe');
        $I->canSeeAuthentication();

        $I->amOnAction('OrganizationController@index');
        $I->canSeeCurrentActionIs('OrganizationController@create');

        $I->amOnAction('UsersManagementController@index');
        $I->canSeeCurrentActionIs('OrganizationController@create');

        $I->amOnAction('WebsiteController@index');
        $I->canSeeCurrentActionIs('OrganizationController@create');
    }
}
