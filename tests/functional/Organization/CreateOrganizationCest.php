<?php
namespace Auth;

use App\User;
use \FunctionalTester;

class CreateOrganizationCest
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
        $I->wantTo('see if the auth works');

        $I->amLoggedAs(User::find(2));

        $I->amOnAction('HomeController@index');
        $I->canSee('Mike Doe');
        $I->canSeeAuthentication();

        $I->amOnAction('OrganizationController@create');
        $I->canSee('New organization');

        $I->fillField(['name' => 'name'], 'Gorilla LTD');
        $I->fillField(['name' => 'address'], '4 street');
        $I->fillField(['name' => 'address_comp'], '2nd office');
        $I->fillField(['name' => 'phone'], '0102030405');
        $I->fillField(['name' => 'email'], 'gorilla@ltd.fr');
        $I->fillField(['name' => 'website'], 'http://gorilla.dev/');
        $I->fillField(['name' => 'status'], 'SAS');
        $I->fillField(['name' => 'siren_number'], '001002004');
        $I->fillField(['name' => 'siret_number'], '00100200400556');
        $I->fillField(['name' => 'ape_number'], '42.42');
        $I->fillField(['name' => 'tva_number'], 'FR00001004040');

        $I->click('submit-organization-create');

        //verify
        $I->seeCurrentActionIs('HomeController@index');

        //assert
        $I->seeRecord('organizations', [
            'name' => 'Gorilla LTD',
            'status' => 'SAS',
            'siret_number' => '00100200400556',
            'owner_id' => 2
        ]);

    }
}
