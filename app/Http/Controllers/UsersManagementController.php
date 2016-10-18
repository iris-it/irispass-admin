<?php namespace App\Http\Controllers;


class UsersManagementController extends Controller
{
    /**
     * Show the desktops
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $organization = $this->organization;

        $groups = $this->organization->groups()->get();

        $users = $this->organization->users()->get();

        return view('pages.users_management.index')->with(compact('organization', 'groups', 'users'));

    }


}
