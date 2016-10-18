<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Request;
use App\Organization;
use App\Role;
use App\Services\KeycloakService;
use App\Services\OsjsService;
use App\User;
use App\UserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Laracasts\Flash\Flash;

class UserController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('pages.admin.user.index')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        $organizations = Organization::pluck('name', 'id');
        $organizations->prepend(trans('users.no-membership'), 0);
        return view('pages.admin.user.create')->with(compact('roles', 'organizations'));
    }

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

            if ($data["orga_id"] != 0) {
                $organization = Organization::findOrFail($data["orga_id"]);
                $user->organization()->associate($organization);
                $user->save();
            }

            Flash::success(Lang::get('users.create-success'));
            return redirect(action('Admin\UserController@index'));
        } else {
            Flash::error(Lang::get('users.create-failed'));
            return redirect(action('Admin\UserController@create'));
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('pages.admin.user.show')->with(compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {

        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id');
        $organizations = Organization::pluck('name', 'id');
        $organizations->prepend(trans('users.no-membership'), 0);
        return view('pages.admin.user.edit')->with(compact('user', 'roles', 'organizations'));
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

        if ($data["orga_id"] != 0) {
            $organization = Organization::findOrFail($data["orga_id"]);
            $user->organization()->associate($organization);
            $user->save();
        }

        $keycloakService->getToken()
            ->setUserId($user->sub)
            ->makeUserRepresentation($data["orga_id"], $user)
            ->updateUser();

        if ($old_user->email != $user->email) {
            $keycloakService->sendResetEmail();
        }


        Flash::success(Lang::get('users.update-success'));

        return redirect(action('Admin\UserController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param OsjsService $service
     * @param KeycloakService $keycloakService
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request, OsjsService $service, KeycloakService $keycloakService)
    {
        $user = User::findOrFail($id);

        if ($user->id == $request->user()->id) {
            Flash::error(Lang::get('users.destroy-failed'));
            return redirect(action('Admin\UserController@index'));
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

        return redirect(action('Admin\UserController@index'));

    }

    public function switchOrganization($id, Request $request)
    {
        $user = $request->user();

        if ($request->user()->role->name != "admin") {
            Flash::error(Lang::get('users.update-failed'));
            return redirect(action('Admin\OrganizationController@index'));
        }

        $organization = Organization::findOrFail($id);

        $user->organization()->dissociate();
        $user->organization()->associate($organization);
        $user->save();

        if ($user->save()) {
            Flash::success(Lang::get('users.update-success'));
        } else {
            Flash::error(Lang::get('users.update-failed'));
        }

        return redirect(action('Admin\OrganizationController@index'));

    }
}
