<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UsersManagementController extends Controller
{

    private $organization;

    public function __construct()
    {

        $this->middleware('auth');

        $this->middleware('hasOrganization');

        $this->organization = Auth::user()->organization()->first();
    }

    /**
     * Show the desktops
     *
     * @return Response
     */
    public function index()
    {

        $organization = $this->organization;

        $groups = $this->organization->groups()->get();

        $users = $this->organization->users()->get();

        return view('pages.users_management.index')->with(compact('organization', 'groups', 'users'));

    }


}
