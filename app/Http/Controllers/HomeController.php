<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        // Require authentication for all actions in this controller
        $this->middleware('auth');
    }

    public function index()
    {
        // At this point, user is authenticated (because of middleware)
        return view('dashboard');
    }
}
