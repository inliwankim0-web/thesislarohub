<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class RenterController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $reservations = Reservation::with(['venue','facility'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        $stats = [
            'total'     => Reservation::where('user_id', $user->id)->count(),
            'pending'   => Reservation::where('user_id', $user->id)->where('status', 'pending')->count(),
            'confirmed' => Reservation::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'completed' => Reservation::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];

        return view('renter.dashboard', compact('reservations', 'stats'));
    }

    public function cancelReservation(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }
        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This reservation cannot be cancelled.');
        }
        $reservation->update(['status' => 'cancelled']);
        return back()->with('success', 'Reservation #' . $reservation->reference_code . ' has been cancelled.');
    }
}
