<?php

namespace App\Services;

use App\User;
use App\UserProvider;
use Illuminate\Support\Facades\DB;

class UserService
{

    private $keycloakService;

    public function __construct(KeycloakService $keycloakService)
    {
        $this->keycloakService = $keycloakService;

        if (env('APP_ENV') !== 'testing') {
            DB::beginTransaction();
        }
    }

    public function createUser($request, $organization)
    {

        $data = $request->all();

        $user = User::create($data);

        if (env('APP_ENV') !== 'testing') {
            $this->createUserKeycloak($user, $organization);
        }

        $user->organization()->associate($organization);

        if ($user->save()) {
            if (env('APP_ENV') !== 'testing') {
                DB::commit();
            }
            return true;
        } else {
            return false;
        }
    }

    private function createUserKeycloak($user, $organization)
    {
        $this->keycloakService->getToken()
            ->makeUserRepresentation($organization->id, $user)
            ->createUser()
            ->sendResetEmail();

        $user->sub = $this->keycloakService->getUserId();
        $user->save();

        $provider = UserProvider::create([
            'user_id' => $user->id,
            'provider_user_id' => $user->sub,
            'provider' => 'keycloak',
            'access_token' => ''
        ]);

        $provider->user()->associate($user);
        $provider->save();
    }

    public function updateUser($id, $request, $organization)
    {
        $old_user = User::findOrFail($id);

        $user = User::findOrFail($id);

        $data = $request->all();

        $user->update($data);

        $user->save();

        if (env('APP_ENV') !== 'testing') {
            $this->updateUserKeycloak($old_user, $user, $organization);
        }

        if (env('APP_ENV') !== 'testing') {
            DB::commit();
        }

    }

    private function updateUserKeycloak($old_user, $user, $organization)
    {
        $this->keycloakService->getToken()
            ->setUserId($user->sub)
            ->makeUserRepresentation($organization->id, $user)
            ->updateUser();

        if ($old_user->email != $user->email) {
            $this->keycloakService->sendResetEmail();
        }
    }

    public function deleteUser($id, $request)
    {
        $user = User::findOrFail($id);

        if ($user->id == $request->user()->id) {
            return false;
        }

        if (env('APP_ENV') !== 'testing') {
            $this->deleteUserKeycloak($user);
        }

        $user->delete();

        if (env('APP_ENV') !== 'testing') {
            DB::commit();
        }

        return true;
    }

    private function deleteUserKeycloak($user)
    {
        $this->keycloakService->getToken()
            ->setUserId($user->sub)
            ->deleteUser();

        $user->delete();
    }

}