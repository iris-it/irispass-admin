<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Requests\GroupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Irisit\IrispassShared\Model\UserGroup;
use Irisit\IrispassShared\Services\OsjsService;
use Laracasts\Flash\Flash;
use Webpatser\Uuid\Uuid;

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
     * @param OsjsService $service
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request, OsjsService $service)
    {

        $group = UserGroup::create($request->all());

        $name = $this->organization->uuid . "#" . $group->name;

        if ($path = $service->createDirectory('group', $name)) {

            $group->organization_uuid = $this->organization->uuid;
            $group->realname = $name;
            $group->path = $path;
            $group->organization()->associate($this->organization);
            $group->save();

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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = UserGroup::findOrFail($id);

        $users = $this->organization->users()->get();

        return view('pages.groups.show')->with(compact('group', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = UserGroup::findOrFail($id);

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
    public function update(GroupRequest $request, $id, OsjsService $service)
    {
        //get the old version
        $group_old = UserGroup::findOrFail($id);
        $old_name = $this->organization->uuid . "-" . $group_old->name;

        //update
        $group = UserGroup::findOrFail($id);
        $group->update($request->all());
        $group->save();

        //get the new version
        $name = $this->organization->uuid . "#" . $group->name;

        if ($path = $service->renameDirectory('group', $old_name, $name)) {

            $group->organization_uuid = $this->organization->uuid;
            $group->realname = $name;
            $group->path = $path;
            $group->save();

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
    public function destroy($id, OsjsService $service)
    {
        $group = UserGroup::findOrFail($id);

        $name = $this->organization->uuid . "#" . $group->name;

        if ($path = $service->deleteDirectory('group', $name)) {

            $group->delete();

            Flash::success(Lang::get('groups.destroy-success'));
        } else {
            Flash::error(Lang::get('groups.destroy-failed'));
        }

        return redirect(action('UsersManagementController@index') . '#orgagroups');
    }


}
