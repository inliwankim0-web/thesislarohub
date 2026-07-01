@extends('layouts.app')
@section('title', 'All Reservations — LaroHub Admin')
@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-2 text-gray-400 text-sm mb-3">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-600 transition-colors">Dashboard</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-700 font-medium">Reservations</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">All Reservations</h1>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form method="GET" class="flex flex-wrap items-end gap-3 mb-6">
        <div>
            <label class="label">Status</label>
            <select name="status" class="input-field !py-2 !text-sm">
                <option value="">All statuses</option>
                @foreach(['pending','confirmed','completed','rejected','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label">Venue</label>
            <select name="venue_id" class="input-field !py-2 !text-sm">
                <option value="">All venues</option>
                @foreach($venues as $v)
                <option value="{{ $v->id }}" {{ request('venue_id')==$v->id?'selected':'' }}>{{ $v->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn-primary !py-2 !text-sm">Apply</button>
        <a href="{{ route('admin.reservations') }}" class="btn-secondary !py-2 !text-sm">Reset</a>
    </form>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3.5 text-left font-semibold">Reference</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Guest</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Venue · Facility</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Date & Time</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Amount</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Payment</th>
                        <th class="px-4 py-3.5 text-left font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reservations as $r)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3.5 font-mono text-xs text-blue-600 font-semibold">{{ $r->reference_code }}</td>
                        <td class="px-4 py-3.5">
                            <p class="font-medium text-gray-900 text-xs">{{ $r->guest_name }}</p>
                            <p class="text-gray-400 text-xs">{{ $r->email }}</p>
                        </td>
                        <td class="px-4 py-3.5">
                            <p class="font-medium text-gray-900 text-xs">{{ $r->venue->name }}</p>
                            <p class="text-gray-400 text-xs">{{ $r->facility->label }}</p>
                        </td>
                        <td class="px-4 py-3.5">
                            <p class="font-medium text-gray-900 text-xs">{{ $r->date?$r->date->format('M j, Y'):'—' }}</p>
                            <p class="text-gray-400 text-xs">{{ $r->start_time }} – {{ $r->end_time }}</p>
                        </td>
                        <td class="px-4 py-3.5 font-bold text-gray-900 text-xs">₱{{ number_format($r->total_amount,0) }}</td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $r->payment_status==='verified'?'bg-green-100 text-green-700':'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($r->payment_status) }}
                            </span>
                            @if($r->is_walk_in)<span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-500">Walk-in</span>@endif
                        </td>
                        <td class="px-4 py-3.5">
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
                    @empty
                    <tr><td colspan="7" class="px-4 py-12 text-center text-gray-400 text-sm">No reservations found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-50">{{ $reservations->links() }}</div>
    </div>
</div>
@endsection
