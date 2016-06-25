<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class HomeController extends Controller
{
    private $organization;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('hasOrganization');

        //$this->organization = Auth::user()->organization()->first();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$organization = $this->organization;

        //$groups = $this->organization->groups()->get();

        //$users = $this->organization->users()->get();

        return view('pages.home.index');
    }
}
