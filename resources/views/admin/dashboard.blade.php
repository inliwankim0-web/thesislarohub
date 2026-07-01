@extends('layouts.app')
@section('title', 'Admin Dashboard — LaroHub')
@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-500 text-sm mt-1">System overview — LaroHub</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label'=>'Total Users',    'value'=>$stats['users'],        'sub'=>$stats['renters'].' renters', 'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color'=>'blue'],
            ['label'=>'Active Venues',  'value'=>$stats['venues'],       'sub'=>'All locations',              'icon'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'color'=>'green'],
            ['label'=>'Reservations',   'value'=>$stats['reservations'], 'sub'=>$stats['pending'].' pending', 'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color'=>'indigo'],
            ['label'=>'Total Revenue',  'value'=>'₱'.number_format($stats['revenue'],0), 'sub'=>'Completed bookings', 'icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'color'=>'amber'],
        ] as $s)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="w-9 h-9 rounded-xl bg-{{ $s['color'] }}-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-{{ $s['color'] }}-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $s['label'] }}</p>
            <p class="text-xs text-blue-500 mt-0.5">{{ $s['sub'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-gray-900">Venues</h2>
            </div>
            <div class="space-y-2">
                @foreach($venues as $venue)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm px-4 py-3 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $venue->color }} flex items-center justify-center">
                            <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $venue->name }}</p>
                            <p class="text-xs text-gray-400">{{ $venue->reservations_count }} bookings</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.venues.toggle', $venue) }}">
                        @csrf
                        <button class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium transition-colors
                            {{ $venue->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $venue->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-gray-900">Recent Reservations</h2>
                <a href="{{ route('admin.reservations') }}" class="text-xs text-blue-600 hover:underline font-medium">View all →</a>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Reference</th>
                            <th class="px-4 py-3 text-left font-semibold">Guest</th>
                            <th class="px-4 py-3 text-left font-semibold">Venue</th>
                            <th class="px-4 py-3 text-left font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($recentReservations as $r)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 font-mono text-xs text-blue-600 font-semibold">{{ $r->reference_code }}</td>
                            <td class="px-4 py-3 text-xs font-medium text-gray-900">{{ $r->guest_name }}</td>
                            <td class="px-4 py-3 text-xs text-gray-500">{{ $r->venue->name }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($r->status==='confirmed') bg-green-100 text-green-700
                                    @elseif($r->status==='pending') bg-amber-100 text-amber-700
                                    @elseif($r->status==='rejected') bg-red-100 text-red-700
                                    @elseif($r->status==='completed') bg-blue-100 text-blue-700
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-lg font-bold text-white">User Management</p>
            <p class="text-blue-100 text-sm">Manage renters, staff, and admin accounts.</p>
        </div>
        <a href="{{ route('admin.users') }}" class="btn-secondary !bg-white/15 !border-white/25 !text-white hover:!bg-white/25">Manage Users →</a>
    </div>
</div>
@endsection
