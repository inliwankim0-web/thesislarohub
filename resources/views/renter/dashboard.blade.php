@extends('layouts.app')
@section('title', 'My Bookings — LaroHub')
@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900">My Bookings</h1>
        <p class="text-gray-500 text-sm mt-1">Welcome back, {{ auth()->user()->first_name }}.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label'=>'Total Bookings', 'value'=>$stats['total'],     'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color'=>'blue'],
            ['label'=>'Pending',        'value'=>$stats['pending'],   'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color'=>'amber'],
            ['label'=>'Confirmed',      'value'=>$stats['confirmed'], 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color'=>'green'],
            ['label'=>'Completed',      'value'=>$stats['completed'], 'icon'=>'M5 13l4 4L19 7', 'color'=>'indigo'],
        ] as $s)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between mb-3">
                <div class="w-9 h-9 rounded-xl bg-{{ $s['color'] }}-50 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-{{ $s['color'] }}-600 w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $s['value'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Header row --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-bold text-gray-900">Reservation History</h2>
        <a href="{{ route('recommend') }}" class="btn-primary !py-2 !px-4 !text-sm">New Booking</a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @forelse($reservations as $r)
        <div class="px-5 py-4 border-b border-gray-50 last:border-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50 transition-colors">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $r->venue->color }} flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="font-semibold text-gray-900 text-sm">{{ $r->venue->name }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            @if($r->status==='confirmed') bg-green-100 text-green-700
                            @elseif($r->status==='pending') bg-amber-100 text-amber-700
                            @elseif($r->status==='cancelled') bg-gray-100 text-gray-600
                            @elseif($r->status==='rejected') bg-red-100 text-red-700
                            @else bg-blue-100 text-blue-700 @endif">
                            {{ ucfirst($r->status) }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $r->facility->label }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $r->date->format('M j, Y') }} · {{ $r->start_time }} – {{ $r->end_time }}</p>
                    <p class="text-xs text-gray-400 font-mono mt-0.5">{{ $r->reference_code }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0 ml-14 sm:ml-0">
                <p class="text-sm font-bold text-gray-900">₱{{ number_format($r->total_amount, 0) }}</p>
                @if(in_array($r->status, ['pending','confirmed']))
                <form method="POST" action="{{ route('renter.reservation.cancel', $r) }}">
                    @csrf
                    <button type="submit" onclick="return confirm('Cancel this reservation?')" class="text-xs text-gray-400 hover:text-red-600 transition-colors px-2 py-1 rounded-lg hover:bg-red-50">Cancel</button>
                </form>
                @endif
                <a href="{{ route('booking.confirmation', $r->reference_code) }}" class="btn-secondary !py-1.5 !px-3 !text-xs">View</a>
            </div>
        </div>
        @empty
        <div class="py-16 text-center">
            <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-gray-500 font-medium text-sm mb-1">No bookings yet</p>
            <p class="text-gray-400 text-xs mb-5">Find a court and make your first reservation.</p>
            <a href="{{ route('recommend') }}" class="btn-primary">Find a Court</a>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $reservations->links() }}</div>
</div>
@endsection
