<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\KeycloakService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KeycloakService $keycloakService)
    {

        $keycloakService->getToken()->getUsers();

        return view('pages.home.index');
    }
}
