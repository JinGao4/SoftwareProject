<!DOCTYPE html>
<html>
<head>
    <title>Donate</title>
</head>
<body>
    <h1>Make a Donation</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('donate.store') }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Amount:</label>
        <input type="number" name="amount" min="1" required><br><br>

        <button type="submit">Donate</button>
    </form>

    <h2>Your Donations</h2>
    @php
        $donations = \App\Models\Donation::all();
    @endphp
    <ul>
        @foreach($donations as $donation)
            <li>
                {{ $donation->name }} - ${{ $donation->amount }} - {{ $donation->status }}
                @if($donation->status == 'completed')
                    <form action="{{ route('donation.cancel', $donation->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Cancel</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
</body>
</html>
