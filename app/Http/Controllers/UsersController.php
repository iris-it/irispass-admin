<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Services\KeycloakService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Irisit\IrispassShared\Model\User;
use Irisit\IrispassShared\Model\UserProvider;
use Irisit\IrispassShared\Services\OsjsService;
use Laracasts\Flash\Flash;

class UsersController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @param KeycloakService $keycloakService
     * @param OsjsService $service
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, KeycloakService $keycloakService, OsjsService $service)
    {
        $data = $request->all();

        $user = User::create($data);

        $keycloakService->getToken()
            ->makeUserRepresentation($this->organization, $user)
            ->createUser()
            ->sendResetEmail();

        $user->sub = $keycloakService->getUserId();

        $user->save();

        $provider = UserProvider::create([
            'user_id' => $user->id,
            'provider_user_id' => $user->sub,
            'provider' => 'keycloak',
            'access_token' => ''
        ]);

        $provider->user()->associate($user);

        $provider->save();

        if ($service->createDirectory('user', $user->sub)) {

            $user->organization()->associate($this->organization);
            $user->save();

            Flash::success(Lang::get('users.create-success'));
            return redirect(action('UsersManagementController@index') . '#orgausers');
        } else {
            Flash::error(Lang::get('users.create-failed'));
            return redirect(action('UsersController@create'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('pages.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('pages.users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param  int $id
     * @param KeycloakService $keycloakService
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id, KeycloakService $keycloakService)
    {
        $old_user = User::findOrFail($id);

        $user = User::findOrFail($id);

        $data = $request->all();

        $user->update($data);

        $user->save();

        $keycloakService->getToken()
            ->setUserId($user->sub)
            ->makeUserRepresentation($this->organization, $user)
            ->updateUser();

        if ($old_user->email != $user->email) {
            $keycloakService->sendResetEmail();
        }

        Flash::success(Lang::get('users.update-success'));

        return redirect(action('UsersController@show', ['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param OsjsService $service
     * @param KeycloakService $keycloakService
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, OsjsService $service, KeycloakService $keycloakService)
    {
        $user = User::findOrFail($id);

        if ($user->id == Auth::user()->id) {
            Flash::error(Lang::get('users.destroy-failed'));
            return redirect(action('UsersManagementController@index') . '#orgausers');
        }

        if ($path = $service->deleteDirectory('user', $user->sub)) {

            $keycloakService->getToken()
                ->setUserId($user->sub)
                ->deleteUser();

            $user->delete();

            Flash::success(Lang::get('users.destroy-success'));
        } else {
            Flash::error(Lang::get('users.destroy-failed'));
        }

        return redirect(action('UsersManagementController@index') . '#orgausers');

    }
}
