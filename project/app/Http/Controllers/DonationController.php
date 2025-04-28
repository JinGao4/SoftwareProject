<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class DonationController extends Controller
{
    public function store(Request $request, Campaign $campaign)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1',
        'name' => 'required_if:is_anonymous,false|string|max:255',
        'email' => 'required_if:is_anonymous,false|email',
        'message' => 'nullable|string',
        'is_anonymous' => 'boolean',
    ]);

    if ($validated['is_anonymous']) {
        $validated['name'] = 'Anonymous';
        $validated['email'] = 'anonymous@example.com';
    } else {
        $validated['user_id'] = auth()->id();
    }

    $validated['campaign_id'] = $campaign->id;

    Donation::create($validated);

    // Update campaign current amount
    $campaign->increment('current_amount', $validated['amount']);

    return back()->with('success', 'Thank you for your donation!');

    
    Stripe::setApiKey(config('services.stripe.secret'));

    try {
        $charge = Charge::create([
            'amount' => $validated['amount'] * 100, // in cents
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Donation to ' . $campaign->title,
        ]);

        // Create donation record
        $donation = Donation::create($validated);

        // Update campaign amount
        $campaign->increment('current_amount', $validated['amount']);

        return back()->with('success', 'Thank you for your donation!');

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}
}

