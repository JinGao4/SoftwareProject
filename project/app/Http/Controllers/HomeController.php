<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;

class HomeController extends Controller
{
    public function index()
{
    $featuredCampaigns = Campaign::where('end_date', '>', now())
        ->orderBy('current_amount', 'desc')
        ->take(3)
        ->get();

    $recentCampaigns = Campaign::where('end_date', '>', now())
        ->latest()
        ->take(6)
        ->get();

    return view('home', compact('featuredCampaigns', 'recentCampaigns'));

    dd(
        app('view.finder')->find('home'), // Should return full path to home.blade.php
        View::getFinder()->getPaths() // Shows all view paths Laravel checks
    );
}


}
