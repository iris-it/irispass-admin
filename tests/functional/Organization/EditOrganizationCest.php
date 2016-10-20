<?php
namespace Auth;

use App\User;
use \FunctionalTester;

class EditOrganizationCest
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
        $I->wantTo('Edit an organization');

        $I->amLoggedAs(User::find(1));

        $I->amOnAction('HomeController@index');
        $I->canSee('John Doe');
        $I->canSeeAuthentication();

        $I->amOnAction('OrganizationController@edit');
        $I->canSee('Settings');

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
        $I->seeCurrentActionIs('OrganizationController@index');
        $I->canSee('Organization updated');

        //assert
        $I->seeRecord('organizations', [
            'name' => 'Gorilla LTD',
            'address' => '4 street',
            'address_comp' => '2nd office',
            'phone' => '0102030405',
            'email' => 'gorilla@ltd.fr',
            'website' => 'http://gorilla.dev/',
            'status' => 'SAS',
            'siren_number' => '001002004',
            'siret_number' => '00100200400556',
            'ape_number' => '42.42',
            'tva_number' => 'FR00001004040',
            'owner_id' => 1
        ]);

    }
}
