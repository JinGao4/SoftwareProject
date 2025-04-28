<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
{
    $campaigns = Campaign::latest()->paginate(10);
    return view('campaigns.index', compact('campaigns'));
}

public function create()
{
    return view('campaigns.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'target_amount' => 'required|numeric|min:1',
        'end_date' => 'required|date|after:today',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('campaigns', 'public');
        $validated['image'] = $path;
    }

    $validated['user_id'] = auth()->id();
    $validated['current_amount'] = 0;

    Campaign::create($validated);

    return redirect()->route('campaigns.index')->with('success', 'Campaign created successfully!');
}

// Implement other methods (show, edit, update, destroy) similarly
}
