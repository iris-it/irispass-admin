<?php

namespace App\Services;

use GuzzleHttp\Client;
use Irisit\IrispassShared\Model\User;

/**
 * Created by PhpStorm.
 * User: alexa
 * Date: 25/06/2016
 * Time: 02:56
 */
class KeycloakService
{

    private $token;

    private $client;

    private $username;

    private $password;

    private $realm;

    public function __construct()
    {
        $this->username = config('irispass.keycloak.username');

        $this->password = config('irispass.keycloak.password');

        $this->realm = env('AUTH_REALM');

        $this->client = new Client([
            'base_uri' => env('AUTH_SERVER'),
            'timeout' => 2.0,
        ]);

    }

    public function getToken()
    {

        $parameters = [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => 'admin-cli',
                'username' => $this->username,
                'password' => $this->password,
            ]
        ];

        $response = $this->client->request('POST', "/auth/realms/master/protocol/openid-connect/token", $parameters);

        $response = json_decode($response->getBody());

        $this->token = $response->access_token;

        return $this;
    }

    public function getUsers()
    {
        $parameters = ['headers' => ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]];

        $response = $this->client->request('GET', '/auth/admin/realms/' . $this->realm . '/users', $parameters);

        return json_decode($response->getBody());
    }

    public function createUser()
    {
        $parameters = ['headers' => ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]];

        $response = $this->client->request('GET', '/auth/admin/realms/' . $this->realm . '/users', $parameters);

        dd(json_decode($response->getBody()));
    }

    public function makeUserRepresentation($organization, User $user, $password)
    {

        $user_representation = [
            'enabled' => true,
            'groups' => 'users'
        ];

        if ($user->preferred_username) {
            $user_representation['username'] = $user->preferred_username;
        }

        if ($user->given_name) {
            $user_representation['firstName'] = $user->given_name;
        }

        if ($user->family_name) {
            $user_representation['lastName'] = $user->family_name;
        }

        if ($user->email) {
            $user_representation['email'] = $user->email;
        }

        if ($user->given_name) {
            $user_representation['firstName'] = $user->given_name;
        }

        if ($organization->id) {
            $user_representation['attributes']['organization'] = $organization->id;
        }

        if ($password) {
            $user_representation['credentials']['type'] = 'password';
            $user_representation['attributes']['value'] = $password;
            $user_representation['requiredActions'] = 'UPDATE_PASSWORD';
        }

        return $user_representation;
    }

}