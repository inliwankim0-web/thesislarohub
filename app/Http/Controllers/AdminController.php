<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users'        => User::count(),
            'renters'      => User::where('role', 'renter')->count(),
            'staff'        => User::where('role', 'staff')->count(),
            'venues'       => Venue::count(),
            'reservations' => Reservation::count(),
            'pending'      => Reservation::where('status', 'pending')->count(),
            'revenue'      => Reservation::where('status', 'completed')->sum('total_amount'),
        ];

        $recentReservations = Reservation::with(['venue','user'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $venues = Venue::withCount('reservations')->get();

        return view('admin.dashboard', compact('stats', 'recentReservations', 'venues'));
    }

    public function reservations(Request $request)
    {
        $query = Reservation::with(['venue','facility','user'])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('venue_id')) {
            $query->where('venue_id', $request->venue_id);
        }

        $reservations = $query->paginate(20)->withQueryString();
        $venues = Venue::all();

        return view('admin.reservations', compact('reservations', 'venues'));
    }

    public function users()
    {
        $users = User::orderBy('role')->orderBy('last_name')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function toggleVenue(Venue $venue)
    {
        $venue->update(['is_active' => !$venue->is_active]);
        return back()->with('success', $venue->name . ' has been ' . ($venue->is_active ? 'activated' : 'deactivated') . '.');
    }
}
