@extends('layouts.app')
@section('title', 'Staff Dashboard — LaroHub')
@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $venue->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">Staff Dashboard — Manage reservations and walk-ins</p>
        </div>
        <a href="{{ route('staff.walk-in') }}" class="btn-primary !py-2 !px-4 !text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Walk-in Reservation
        </a>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label'=>'Pending',  'value'=>$stats['pending'],   'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',          'color'=>'amber'],
            ['label'=>'Confirmed','value'=>$stats['confirmed'], 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',         'color'=>'green'],
            ['label'=>'Today',    'value'=>$stats['today'],     'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color'=>'blue'],
            ['label'=>'Revenue',  'value'=>'₱'.number_format($stats['revenue'],0), 'icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'color'=>'indigo'],
        ] as $s)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="w-9 h-9 rounded-xl bg-{{ $s['color'] }}-50 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-{{ $s['color'] }}-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
            </div>
            <p class="text-xl font-bold text-gray-900">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-gray-900 text-sm">All Reservations</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Reference</th>
                        <th class="px-4 py-3 text-left font-semibold">Guest</th>
                        <th class="px-4 py-3 text-left font-semibold">Facility</th>
                        <th class="px-4 py-3 text-left font-semibold">Date & Time</th>
                        <th class="px-4 py-3 text-left font-semibold">Amount</th>
                        <th class="px-4 py-3 text-left font-semibold">Payment</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reservations as $r)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 font-mono text-xs text-blue-600 font-semibold">{{ $r->reference_code }}</td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-900 text-xs">{{ $r->guest_name }}</p>
                            <p class="text-gray-400 text-xs">{{ $r->contact }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $r->facility->label }}</td>
                        <td class="px-4 py-3">
                            <p class="text-gray-900 text-xs font-medium">{{ $r->date->format('M j, Y') }}</p>
                            <p class="text-gray-400 text-xs">{{ $r->start_time }} – {{ $r->end_time }}</p>
                        </td>
                        <td class="px-4 py-3 font-bold text-gray-900 text-xs">₱{{ number_format($r->total_amount, 0) }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $r->payment_status==='verified' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($r->payment_status) }}
                            </span>
                            @if($r->payment_reference)<p class="text-xs text-gray-400 mt-0.5 font-mono">{{ $r->payment_reference }}</p>@endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                @if($r->status==='confirmed') bg-green-100 text-green-700
                                @elseif($r->status==='pending') bg-amber-100 text-amber-700
                                @elseif($r->status==='rejected') bg-red-100 text-red-700
                                @elseif($r->status==='completed') bg-blue-100 text-blue-700
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ ucfirst($r->status) }}
                            </span>
                            @if($r->is_walk_in)<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-500 ml-1">Walk-in</span>@endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @if($r->status === 'pending')
                                <form method="POST" action="{{ route('staff.reservation.status', $r) }}" class="inline">
                                    @csrf<input type="hidden" name="status" value="confirmed">
                                    <button class="px-2 py-1 text-xs rounded-lg bg-green-100 text-green-700 hover:bg-green-200 font-medium transition-colors">Confirm</button>
                                </form>
                                <form method="POST" action="{{ route('staff.reservation.status', $r) }}" class="inline">
                                    @csrf<input type="hidden" name="status" value="rejected">
                                    <button class="px-2 py-1 text-xs rounded-lg bg-red-100 text-red-700 hover:bg-red-200 font-medium transition-colors">Reject</button>
                                </form>
                                @endif
                                @if($r->status === 'confirmed')
                                <form method="POST" action="{{ route('staff.reservation.status', $r) }}" class="inline">
                                    @csrf<input type="hidden" name="status" value="completed">
                                    <button class="px-2 py-1 text-xs rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 font-medium transition-colors">Complete</button>
                                </form>
                                @endif
                                @if($r->payment_status !== 'verified' && in_array($r->status,['confirmed','completed']))
                                <form method="POST" action="{{ route('staff.reservation.verify-payment', $r) }}" class="inline">
                                    @csrf
                                    <button class="px-2 py-1 text-xs rounded-lg bg-violet-100 text-violet-700 hover:bg-violet-200 font-medium transition-colors">Verify Pay</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-4 py-12 text-center text-gray-400 text-sm">No reservations yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-50">{{ $reservations->links() }}</div>
    </div>
</div>
@endsection
