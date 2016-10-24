<?php

namespace App\Http\Controllers;


use App\Http\Requests\GroupRequest;
use App\Services\OsjsService;
use App\Group;
use Illuminate\Support\Facades\Lang;
use Laracasts\Flash\Flash;

class GroupsController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GroupRequest $request
     * @return \Illuminate\Http\Response
     * @internal param OsjsService $service
     */
    public function store(GroupRequest $request)
    {

        $group = Group::create($request->all());

        $group->organization_uuid = $this->organization->uuid;

        $group->realname = $this->organization->uuid . "#" . $group->name;

        $group->organization()->associate($this->organization);

        if ($group->save()) {
            Flash::success(Lang::get('groups.create-success'));
            return redirect(action('UsersManagementController@index') . '#orgagroups');
        } else {
            Flash::error(Lang::get('groups.create-failed'));
            return redirect(action('GroupsController@create'));
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
        $group = Group::findOrFail($id);

        $users = $this->organization->users()->get();

        return view('pages.groups.show')->with(compact('group', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);

        return view('pages.groups.edit')->with('group', $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GroupRequest $request
     * @param  int $id
     * @param OsjsService $service
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, $id)
    {


        $group = Group::findOrFail($id);

        $group->update($request->all());

        $group->organization_uuid = $this->organization->uuid;

        $group->realname = $this->organization->uuid . "#" . $group->name;

        if ($group->save()) {
            Flash::success(Lang::get('groups.update-success'));
        } else {
            Flash::error(Lang::get('groups.update-failed'));
        }

        return redirect(action('GroupsController@show', ['id' => $id]) . '#orgagroups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param OsjsService $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);

        if ($group->delete()) {
            Flash::success(Lang::get('groups.destroy-success'));
        } else {
            Flash::error(Lang::get('groups.destroy-failed'));
        }

        return redirect(action('UsersManagementController@index') . '#orgagroups');
    }

    /**
     * Add an user to a specified group
     * @param $userId
     * @param $groupId
     * @return \Illuminate\Http\Response
     */
    public function addUserToGroup($groupId, $userId)
    {

        $group = Group::find($groupId);

        $group->users()->attach($userId);

        Flash::success(Lang::get('users_groups.update-success'));

        return redirect(action('UsersManagementController@index') . '#orgagroupsaccess');

    }

    /**
     * Remove user from a specified group
     *
     * @param $userId
     * @param $groupId
     * @return \Illuminate\Http\Response
     */
    public function removeUserFromGroup($groupId, $userId)
    {
        $group = Group::find($groupId);

        $group->users()->detach($userId);

        Flash::success(Lang::get('users_groups.update-success'));

        return redirect(action('UsersManagementController@index') . '#orgagroupsaccess');

    }

}
