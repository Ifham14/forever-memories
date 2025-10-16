<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journey;

class DashboardController extends Controller
{
   public function index()
    {
        $journeys = Journey::where('user_id', auth()->id())->latest()->with('images')->paginate(6);
        return view('dashboard', compact('journeys'));
    }
}
