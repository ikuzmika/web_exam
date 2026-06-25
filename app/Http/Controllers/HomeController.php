<?php

namespace App\Http\Controllers;

use App\Models\Competition;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingCompetitions = Competition::with(['organizer', 'photo'])
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->take(3)
            ->get();

        return view('welcome', compact('upcomingCompetitions'));
    }
}
