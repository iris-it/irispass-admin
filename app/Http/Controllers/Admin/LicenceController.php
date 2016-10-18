<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LicenceRequest;
use App\Licence;
use App\Organization;
use Illuminate\Support\Facades\Lang;
use Laracasts\Flash\Flash;

class LicenceController extends Controller
{


    public function index()
    {

        $licences = Licence::paginate(10);
        return view('pages.admin.licence.index')->with(compact('licences'));

    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $organizations = Organization::orderBy('name')->pluck('name', 'id');

        return view('pages.admin.licence.create')->with(compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LicenceRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LicenceRequest $request)
    {

        $data = $request->all();
        $orgasToSave = [];

        if ($licence = Licence::create($data)) {

            if ($request->has("organizations")) {

                foreach ($data["organizations"] as $id) {
                    $organization = Organization::findOrFail($id);
                    $orgasToSave[] = $organization;
                }
                $licence->organizations()->saveMany($orgasToSave);
            }

            Flash::success(Lang::get('licence.create-success'));
            return redirect(action('Admin\LicenceController@index'));
        } else {
            Flash::error(Lang::get('licence.create-failed'));
            return redirect(action('Admin\LicenceController@create'));
        }

    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        $licence = Licence::findOrFail($id);
        $organizations = Organization::orderBy('name')->pluck('name', 'id');

        // Outlets

        return view('pages.admin.licence.show')->with(compact('licence', 'organizations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        $licence = Licence::findOrFail($id);
        $organizations = Organization::orderBy('name')->pluck('name', 'id');

        return view('pages.admin.licence.edit')->with(compact('licence', 'organizations'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param LicenceRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LicenceRequest $request, $id)
    {
        $licence = Licence::findOrFail($id);
        $data = $request->all();
        $orgasToSave = [];

        if ($licence->update($data) && $licence->save()) {

            foreach ($licence->organizations as $oldOrga) {

                if (!$request->has("organizations")) {
                    $data["organizations"] = [];
                }

                if (!in_array($oldOrga->id, $data["organizations"])) {
                    $oldOrga->licence()->dissociate();
                    $oldOrga->save();
                }
            }

            if ($request->has("organizations")) {

                foreach ($data["organizations"] as $orgaId) {
                    $organization = Organization::findOrFail($orgaId);
                    $orgasToSave[] = $organization;
                }

                $licence->organizations()->saveMany($orgasToSave);
            }
            Flash::success(Lang::get('licence.update-success'));
        } else {
            Flash::error(Lang::get('licence.update-failed'));
        }

        return redirect(action('Admin\LicenceController@index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $licence = Licence::findOrFail($id);

        if ($licence->delete()) {
            Flash::success(Lang::get('licence.destroy-success'));
        } else {
            Flash::error(Lang::get('licence.destroy-failed'));
        }

        return redirect(action('Admin\LicenceController@index'));
    }


}