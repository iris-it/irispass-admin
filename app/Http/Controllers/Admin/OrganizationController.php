<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrganizationRequest;
use App\Licence;
use App\Organization;
use App\User;
use Illuminate\Support\Facades\Lang;
use Laracasts\Flash\Flash;

class OrganizationController extends Controller
{

    public function index()
    {
        $organizations = Organization::paginate(10);

        return view('pages.admin.organization.index')->with(compact('organizations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $users = User::pluck('preferred_username', 'id');

        $licences = Licence::pluck('name','id');

        return view('pages.admin.organization.create')->with(compact('licences', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrganizationRequest $request
     * @return Response
     */
    public function store(OrganizationRequest $request)
    {

        $data = $request->all();

        $usersToSave = [];

        if ($organization = Organization::create($data)) {

            if ($request->has("users")) {

                foreach ($data["users"] as $userId) {

                    $user = User::findOrFail($userId);
                    $usersToSave[] = $user;
                }
                $organization->users()->saveMany($usersToSave);
            }

            $owner = User::findOrFail($data["owner_id"]);

            $organization->owner()->associate($owner);
            $organization->save();

            $owner->organization()->associate($organization);
            $owner->save();

            Flash::success(Lang::get('organization.create-success'));
            return redirect(action('Admin\OrganizationController@index', $organization->id));
        } else {
            Flash::error(Lang::get('organization.create-failed'));
            return redirect(action('Admin\OrganizationController@create'));
        }

    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        $organization = Organization::findOrFail($id);

        return view('pages.admin.organization.show')->with(compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        
        $organization = Organization::findOrFail($id);

        $licences = Licence::pluck('name','id');

        $users = User::pluck('preferred_username', 'id');


        return view('pages.admin.organization.edit')->with(compact('organization', 'licences', 'users'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param OrganizationRequest $request
     */
    public function update(OrganizationRequest $request, $id)
    {
        $organization = Organization::findOrFail($id);
        $data = $request->all();
        $usersToSave = [];

        if ($organization->update($data) && $organization->save()) {

            foreach ($organization->users as $oldUser) {

                if (!$request->has("users")) {
                    $data["users"] = [];
                }

                if (!in_array($oldUser->id, $data["users"])) {
                    $oldUser->organization()->dissociate();
                    $oldUser->save();
                }
            }

            if ($request->has("users")) {

                foreach ($data["users"] as $userId) {
                    $user = User::findOrFail($userId);
                    $usersToSave[] = $user;
                }

                $organization->users()->saveMany($usersToSave);
            }
            $owner = User::findOrFail($data["owner_id"]);

            $organization->owner()->associate($owner);
            $organization->save();

            $owner->organization()->associate($organization);
            $owner->save();

            Flash::success(Lang::get('organization.update-success'));
        } else {
            Flash::error(Lang::get('organization.update-failed'));
        }

        return redirect(action('Admin\OrganizationController@index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);

        if ($organization->delete()) {
            Flash::success(Lang::get('organization.destroy-success'));
        } else {
            Flash::error(Lang::get('organization.destroy-failed'));
        }

        return redirect(action('Admin\OrganizationController@index'));
    }


}