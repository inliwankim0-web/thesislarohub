<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Facility;
use App\Models\Reservation;
use App\Services\SAWService;
use Illuminate\Http\Request;

class SportController extends Controller
{
    public function home()
    {
        // Backend disabled for UI-only deployment.
        // $venues = Venue::with('facilities')->where('is_active', true)->get();
        // return view('home', compact('venues'));

        return view('home', ['venues' => []]);
    }

    public function venues(Request $request)
    {
        // Backend disabled for UI-only deployment.
        // $venues = Venue::with('facilities')->where('is_active', true)->get();
        // $sport  = $request->query('sport');
        // return view('venues', compact('venues', 'sport'));

        $sport = $request->query('sport');
        return view('venues', ['venues' => [], 'sport' => $sport]);
    }

    /** SAW-powered recommendation + booking search */
    public function recommend(Request $request)
    {
        // If no search yet, just show the form
        if (!$request->filled('sport')) {
            return view('recommend');
        }

        $validated = $request->validate([
            'sport'      => 'required|string',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time'   => 'required',
            'min_rating' => 'nullable|numeric|min:0|max:5',
            'max_price'  => 'nullable|numeric|min:0',
            'user_lat'   => 'nullable|numeric',
            'user_lng'   => 'nullable|numeric',
        ]);

        $start = strtotime($validated['start_time']);
        $end   = strtotime($validated['end_time']);
        $hours = max(1, (int) round(($end - $start) / 3600));

        $saw = app(\App\Services\SAWService::class);

        $results = $saw->recommend(
            sport:     $validated['sport'],
            date:      $validated['date'],
            startTime: $validated['start_time'],
            endTime:   $validated['end_time'],
            hours:     $hours,
            minRating: (float) ($validated['min_rating'] ?? 0),
            maxPrice:  (float) ($validated['max_price']  ?? 0),
            userLat:   isset($validated['user_lat']) ? (float) $validated['user_lat'] : null,
            userLng:   isset($validated['user_lng']) ? (float) $validated['user_lng'] : null,
        );

        return view('recommend', array_merge($validated, $results, [
            'duration' => $hours,
            'searched' => true,
        ]));
    }

    public function book(Request $request)
    {
        // Backend disabled for UI-only deployment.
        // $venues   = Venue::with(['facilities' => function($q) {
        //     $q->where('is_active', true)->where('rate_type', 'hourly');
        // }])->where('is_active', true)->get();
        //
        // // Build a clean JS-safe map: venue_id => [facilities => [...]]
        // $venueMap = [];
        // foreach ($venues as $v) {
        //     $venueMap[$v->id] = [
        //         'facilities' => $v->facilities->map(fn($f) => [
        //             'id'    => $f->id,
        //             'label' => $f->label,
        //             'price' => $f->price_per_hour,
        //             'sport' => $f->sport,
        //         ])->values()->toArray(),
        //     ];
        // }
        //
        // $venue    = $request->query('venue_id');
        // $facility = $request->query('facility_id');
        //
        // return view('book', compact('venues', 'venueMap', 'venue', 'facility'));

        $venue    = $request->query('venue_id');
        $facility = $request->query('facility_id');

        return view('book', ['venues' => [], 'venueMap' => [], 'venue' => $venue, 'facility' => $facility]);
    }

    public function submitBooking(Request $request)
    {
        // Backend disabled for UI-only deployment.
        // $validated = $request->validate([
        //     'first_name'        => 'required|string|max:100',
        //     'last_name'         => 'required|string|max:100',
        //     'email'             => 'required|email|max:200',
        //     'contact'           => 'required|string|max:20',
        //     'venue_id'          => 'required|exists:venues,id',
        //     'facility_id'       => 'required|exists:facilities,id',
        //     'date'              => 'required|date|after_or_equal:today',
        //     'start_time'        => 'required',
        //     'duration'          => 'required|integer|min:1|max:6',
        //     'payment_method'    => 'required|in:gcash,cash',
        //     'payment_reference' => 'nullable|string|max:100',
        //     'notes'             => 'nullable|string|max:500',
        // ]);
        //
        // $facility = Facility::findOrFail($validated['facility_id']);
        //
        // // Check availability
        // if (!$facility->isAvailable($validated['date'], $validated['start_time'], (int) $validated['duration'])) {
        //     return back()->withInput()->withErrors([
        //         'facility_id' => 'This facility is already booked for the selected time slot. Please choose another time.'
        //     ]);
        // }
        //
        // $endTime = date('H:i', strtotime($validated['start_time']) + (int)$validated['duration'] * 3600);
        // $total   = $facility->price_per_hour * (int)$validated['duration'];
        //
        // $reservation = Reservation::create([
        //     'reference_code'    => Reservation::generateReference(),
        //     'user_id'           => auth()->id(),
        //     'venue_id'          => $validated['venue_id'],
        //     'facility_id'       => $validated['facility_id'],
        //     'first_name'        => $validated['first_name'],
        //     'last_name'         => $validated['last_name'],
        //     'email'             => $validated['email'],
        //     'contact'           => $validated['contact'],
        //     'date'              => $validated['date'],
        //     'start_time'        => $validated['start_time'],
        //     'end_time'          => $endTime,
        //     'duration_hours'    => $validated['duration'],
        //     'total_amount'      => $total,
        //     'notes'             => $validated['notes'] ?? null,
        //     'payment_method'    => $validated['payment_method'],
        //     'payment_reference' => $validated['payment_reference'] ?? null,
        //     'status'            => 'pending',
        //     'payment_status'    => 'unpaid',
        //     'is_walk_in'        => false,
        // ]);
        //
        // return redirect()->route('booking.confirmation', $reservation->reference_code)
        //     ->with('success', 'Reservation submitted! Reference: ' . $reservation->reference_code);

        return redirect()->route('book')->with('info', 'Booking is temporarily disabled for UI-only deployment.');
    }

    public function confirmation(string $ref)
    {
        // Backend disabled for UI-only deployment.
        // $reservation = Reservation::with(['venue', 'facility'])
        //     ->where('reference_code', $ref)
        //     ->firstOrFail();
        // return view('booking-confirmation', compact('reservation'));

        return view('booking-confirmation', ['reservation' => null]);
    }
}
