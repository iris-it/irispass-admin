<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Irisit\IrispassShared\Model\Organization;
use Laracasts\Flash\Flash;
use Webpatser\Uuid\Uuid;

class OrganizationController extends Controller
{

    private $organization;

    public function __construct()
    {

        $this->middleware('auth');

        $this->middleware('hasOrganization', ['except' => ['create', 'store']]);

        $this->organization = Auth::user()->organization()->first();

    }

    /**
     * Show the profile of an user
     *
     * @return Response
     */
    public function index()
    {

        $organization = $this->organization;

        $groups = $this->organization->groups()->get();

        $users = $this->organization->users()->get();

        return view('pages.organization.index')->with(compact('organization', 'groups', 'users'));

    }

    /**
     * Show the form for creating a new organization.
     * @return Response
     * @internal param Event $event
     */
    public function create()
    {
        if ($this->organization != null) {
            Flash::error(Lang::get('organization.fail-exists'));
            return redirect(action('OrganizationController@index'));
        } else {
            return view('pages.organization.create');
        }
    }

    /**
     * Store a newly created carpooling in storage.
     *
     * @param OrganizationRequest $request
     * @return Response
     */
    public function store(OrganizationRequest $request)
    {

        $user = Auth::user();

        if ($this->filterName($request->get('name'))) {
            Flash::error(Lang::get('organization.fail-name'));
            return redirect(action('OrganizationController@create'));
        }

        $this->organization = Organization::create($request->all());

        $this->organization->uuid = Uuid::generate(4)->string;

        $this->organization->owner()->associate($user);

        $this->organization->save();

        $user->organization()->associate($this->organization);

        $user->save();

        Flash::success(Lang::get('organization.create-success'));

        return redirect(action('OrganizationController@index'));
    }

    /**
     * Show the form for editing the profile of the authenticated user
     *
     * @return Response
     */
    public function edit()
    {
        return view('pages.organization.edit')->with('organization', $this->organization);
    }

    /**
     * Update the profile of the authenticated user
     *
     * @param OrganizationRequest|UserProfileRequest $request
     * @return Response
     */
    public function update(OrganizationRequest $request)
    {

        if ($this->filterName($request->get('name'))) {
            Flash::error(Lang::get('organization.fail-name'));
            return redirect(action('OrganizationController@edit'));
        }

        $this->organization = Organization::findOrFail($this->organization->id);

        $this->organization->update($request->all());

        $this->organization->save();

        Flash::success(Lang::get('organization.update-success'));

        return redirect(action('OrganizationController@index'));
    }

    /*
     * ADMIN AREA
     */

    #Get all and update this or this


    private function filterName($name)
    {
        $banned_names = [
            'cms', 'irispass', 'mail', 'desktop',
            'bureau', 'chat', 'www', 'office',
            'iris', 'only', 'admin'
        ];

        return (starts_with($name, ['www']) || in_array($name, $banned_names));
    }


}
