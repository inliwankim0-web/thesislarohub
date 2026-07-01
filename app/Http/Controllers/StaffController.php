<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Facility;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /** Get the venue owned by the logged-in staff */
    private function staffVenue(): Venue
    {
        return Venue::where('owner_id', auth()->id())->firstOrFail();
    }

    public function dashboard()
    {
        $venue = $this->staffVenue();

        $stats = [
            'pending'   => Reservation::where('venue_id', $venue->id)->where('status', 'pending')->count(),
            'confirmed' => Reservation::where('venue_id', $venue->id)->where('status', 'confirmed')->count(),
            'today'     => Reservation::where('venue_id', $venue->id)->whereDate('date', today())->whereIn('status',['confirmed','pending'])->count(),
            'revenue'   => Reservation::where('venue_id', $venue->id)->where('status','completed')->sum('total_amount'),
        ];

        $reservations = Reservation::with(['facility','user'])
            ->where('venue_id', $venue->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('staff.dashboard', compact('venue', 'stats', 'reservations'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $venue = $this->staffVenue();
        if ($reservation->venue_id !== $venue->id) abort(403);

        $request->validate(['status' => 'required|in:confirmed,rejected,completed,cancelled']);
        $reservation->update(['status' => $request->status]);

        return back()->with('success', 'Reservation #' . $reservation->reference_code . ' marked as ' . $request->status . '.');
    }

    public function verifyPayment(Request $request, Reservation $reservation)
    {
        $venue = $this->staffVenue();
        if ($reservation->venue_id !== $venue->id) abort(403);

        $reservation->update(['payment_status' => 'verified']);
        return back()->with('success', 'Payment for #' . $reservation->reference_code . ' verified.');
    }

    public function walkIn(Request $request)
    {
        $venue = $this->staffVenue();
        return view('staff.walk-in', compact('venue'));
    }

    public function storeWalkIn(Request $request)
    {
        $venue = $this->staffVenue();

        $validated = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|max:200',
            'contact'        => 'required|string|max:20',
            'facility_id'    => 'required|exists:facilities,id',
            'date'           => 'required|date|after_or_equal:today',
            'start_time'     => 'required',
            'duration'       => 'required|integer|min:1|max:6',
            'payment_method' => 'required|in:gcash,cash',
            'notes'          => 'nullable|string|max:500',
        ]);

        $facility = Facility::findOrFail($validated['facility_id']);
        if ($facility->venue_id !== $venue->id) abort(403);

        if (!$facility->isAvailable($validated['date'], $validated['start_time'], (int)$validated['duration'])) {
            return back()->withInput()->withErrors(['facility_id' => 'Time slot is already booked.']);
        }

        $endTime = date('H:i', strtotime($validated['start_time']) + (int)$validated['duration'] * 3600);
        $total   = $facility->price_per_hour * (int)$validated['duration'];

        Reservation::create([
            'reference_code' => Reservation::generateReference(),
            'user_id'        => null,
            'venue_id'       => $venue->id,
            'facility_id'    => $validated['facility_id'],
            'first_name'     => $validated['first_name'],
            'last_name'      => $validated['last_name'],
            'email'          => $validated['email'],
            'contact'        => $validated['contact'],
            'date'           => $validated['date'],
            'start_time'     => $validated['start_time'],
            'end_time'       => $endTime,
            'duration_hours' => $validated['duration'],
            'total_amount'   => $total,
            'notes'          => $validated['notes'],
            'payment_method' => $validated['payment_method'],
            'status'         => 'confirmed',
            'payment_status' => 'paid',
            'is_walk_in'     => true,
        ]);

        return redirect()->route('staff.dashboard')->with('success', 'Walk-in reservation recorded successfully.');
    }
}
