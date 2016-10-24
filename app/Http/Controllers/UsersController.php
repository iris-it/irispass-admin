<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
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
     * @param UserService $userService
     * @return \Illuminate\Http\Response
     * @internal param KeycloakService $keycloakService
     * @internal param OsjsService $service
     */
    public function store(UserRequest $request, UserService $userService)
    {

        if ($userService->createUser($request, $this->organization)) {
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @param UserService $userService
     * @return \Illuminate\Http\Response
     * @internal param KeycloakService $keycloakService
     */
    public function update(UserRequest $request, $id, UserService $userService)
    {

        $userService->updateUser($id, $request, $this->organization);

        Flash::success(Lang::get('users.update-success'));

        return redirect(action('UsersController@show', ['id' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param Request $request
     * @param UserService $userService
     * @return \Illuminate\Http\Response
     * @internal param OsjsService $service
     * @internal param KeycloakService $keycloakService
     */
    public function destroy($id, Request $request, UserService $userService)
    {

        if ($userService->deleteUser($id, $request)) {
            Flash::success(Lang::get('users.destroy-success'));
        } else {
            Flash::error(Lang::get('users.destroy-failed'));
        }

        return redirect(action('UsersManagementController@index') . '#orgausers');

    }
}
