<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Admin\RolePermissionRequest;
use App\Http\Requests\Admin\RoleRequest;
use Illuminate\Support\Facades\Lang;
use Irisit\IrispassShared\Model\Permission;
use Irisit\IrispassShared\Model\Role;
use Laracasts\Flash\Flash;

class RoleController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::paginate(10);

        return view('pages.admin.role.index')->with(compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.admin.role.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $data = $request->all();

        if ($role = Role::create($data)) {
            Flash::success(Lang::get('role.create-success'));
            return redirect(action('Admin\RoleController@index'));
        } else {
            Flash::error(Lang::get('role.create-failed'));
            return redirect(action('Admin\RoleController@create'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::orderBy('name')->lists('name', 'id');

        return view('pages.admin.role.show')->with(compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {

        $role = Role::findOrFail($id);

        $permissions = Permission::orderBy('name')->lists('name', 'id');

        return view('pages.admin.role.edit')->with(compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->update($request->all()) && $role->save()) {
            Flash::success(Lang::get('role.update-success'));
        } else {
            Flash::error(Lang::get('role.update-failed'));
        }

        return redirect(action('Admin\RoleController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (!in_array($role->name, ['admin', 'manager', 'user']) && $role->delete()) {
            Flash::success(Lang::get('role.destroy-success'));
        } else {
            Flash::error(Lang::get('role.destroy-failed'));
        }

        return redirect(action('Admin\RoleController@index'));

    }

    public function syncPermissions(RolePermissionRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $data = $request->all();

        if (!$request->has("permissions")) {
            $data["permissions"] = [];
        }

        if ($role->permissions()->sync($data["permissions"])) {
            Flash::success(Lang::get('role.update-success'));
        } else {
            Flash::error(Lang::get('role.update-failed'));
        }

        return redirect(action('Admin\RoleController@index'));

    }
}
