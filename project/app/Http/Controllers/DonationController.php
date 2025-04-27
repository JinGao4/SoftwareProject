<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        return view('donate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        Donation::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'status' => 'completed',
        ]);

        return redirect()->back()->with('success', 'Thank you for your donation!');
    }

    public function cancel($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->status = 'cancelled';
        $donation->save();

        return redirect()->back()->with('success', 'Donation cancelled.');
    }
}

