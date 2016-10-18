<?php

namespace App\Http\Controllers;

use App\Http\Requests\WebsiteRequest;
use App\Organization;
use App\Services\FlatCmService;
use App\Website;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Lang;
use Laracasts\Flash\Flash;

class WebsiteController extends Controller
{

    /**
     * Show the desktops
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $organization = $this->organization;

        $website = $organization->website()->first();

        return view('pages.website.index')->with(compact('organization', 'website'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.website.create');
    }

    /**
     *
     * Activate CMS INSTANCE
     * @param WebsiteRequest $request
     * @param \App\Http\Controllers\FlatCmService|FlatCmService $service
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     * @internal param FlatCmService $service
     * @internal param WebsiteRepositoryInterface $websiteRepository
     */
    public function store(WebsiteRequest $request, FlatCmService $service)
    {

        $identifier = str_slug($this->organization->name, "-");

        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        if ($service->process($identifier, $username, $email, $password)) {

            $website = Website::create([
                'identifier' => $identifier,
                'username' => $username,
                'email' => $email,
                'is_active' => true,
                'url' => 'http://' . $identifier . '.' . env('CMS_BASE_URL')
            ]);

            $organization = Organization::findOrFail($this->organization->id);
            $website->organization()->associate($organization);
            $website->save();

            Flash::success(Lang::get('website.create-success'));
        } else {
            Flash:error:
            (Lang::get('website.create-failed'));
        }

        return redirect(action('WebsiteController@index'));

    }

    public function destroy(FlatCmService $service)
    {
        $identifier = str_slug($this->organization->name, "-");

        if ($service->destroyCMS($identifier)) {

            $website = $this->organization->website()->get()->first();

            $website->delete();

            Flash::success(Lang::get('website.destroy-success'));
        } else {
            Flash::error(Lang::get('website.destroy-failed'));
        }

        return redirect(action('WebsiteController@index'));

    }

}
