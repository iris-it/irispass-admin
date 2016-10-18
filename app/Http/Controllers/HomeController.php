<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {

        if ($this->organization) {
            $groups = $this->organization->groups()->get();
            $users = $this->organization->users()->get();
        }

        return view('pages.home.index')->with(compact('organization', 'groups', 'users'));
    }
}
