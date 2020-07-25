<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Login_credential;

class DashboardController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userLogged = Auth::id();
        $login_credentials = Login_credential::where('user_id', '=', $userLogged)->get();

        return view('dashboard', compact('login_credentials'));
    }

    public function create()
    {
        // code...
    }
}
