@extends('layouts.sidebar')
@section('title', $venue->name . ' — Cashier')
@section('panel_name','Cashier Panel')
@section('page_title', $venue->name)
@section('page_subtitle','Manage reservations, verify payments, record walk-ins')

@section('sidebar_nav')
<p class="sidebar-section">Cashier</p>
<a href="{{ route('staff.dashboard') }}" class="sidebar-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
    @php $p = \App\Models\Reservation::where('venue_id',$venue->id)->where('status','pending')->count(); @endphp
    @if($p > 0)
    <span class="ml-auto inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[10px] font-bold">{{ $p }}</span>
    @endif
</a>

<p class="sidebar-section">Actions</p>
<a href="{{ route('staff.walk-in') }}" class="sidebar-link {{ request()->routeIs('staff.walk-in') ? 'active' : '' }}">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    New Walk-in
</a>

<p class="sidebar-section">My Venue</p>
<div class="mx-1 p-3 rounded-xl bg-slate-800 border border-slate-700">
    <div class="flex items-center gap-2.5 mb-3">
        <div class="w-8 h-8 rounded-xl bg-gradient-to-br {{ $venue->color }} flex items-center justify-center shrink-0 shadow">
            <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
        </div>
        <div>
            <p class="text-slate-200 text-xs font-bold truncate">{{ $venue->name }}</p>
            <p class="text-slate-500 text-[10px]">Your assigned venue</p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-2">
        <div class="bg-slate-700/60 rounded-lg p-2.5 text-center">
            <p class="text-white text-base font-black">{{ $stats['pending'] }}</p>
            <p class="text-slate-400 text-[10px] mt-0.5 font-medium">Pending</p>
        </div>
        <div class="bg-slate-700/60 rounded-lg p-2.5 text-center">
            <p class="text-white text-base font-black">{{ $stats['today'] }}</p>
            <p class="text-slate-400 text-[10px] mt-0.5 font-medium">Today</p>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- Stats row --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['label'=>'Pending',   'value'=>$stats['pending'],   'bg'=>'bg-amber-500',  'light'=>'bg-amber-50',  'text'=>'text-amber-600', 'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Confirmed', 'value'=>$stats['confirmed'], 'bg'=>'bg-emerald-500','light'=>'bg-emerald-50','text'=>'text-emerald-600','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label'=>'Today',     'value'=>$stats['today'],     'bg'=>'bg-blue-500',   'light'=>'bg-blue-50',   'text'=>'text-blue-600',  'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['label'=>'Revenue',   'value'=>'₱'.number_format($stats['revenue'],0), 'bg'=>'bg-violet-500','light'=>'bg-violet-50','text'=>'text-violet-600','icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
    ] as $s)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-start gap-4">
        <div class="w-10 h-10 {{ $s['light'] }} rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 {{ $s['text'] }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
        </div>
        <div>
            <p class="text-2xl font-black text-slate-900 leading-none">{{ $s['value'] }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-1">{{ $s['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Reservations table --}}
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-slate-900">Reservations</h2>
            <p class="text-xs text-slate-400 mt-0.5">All bookings for {{ $venue->name }}</p>
        </div>
        <a href="{{ route('staff.walk-in') }}" class="btn-primary !py-2 !px-4 !text-xs gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            New Walk-in
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <th class="px-5 py-3.5 text-left">Reference</th>
                    <th class="px-5 py-3.5 text-left">Guest</th>
                    <th class="px-5 py-3.5 text-left">Facility</th>
                    <th class="px-5 py-3.5 text-left">Schedule</th>
                    <th class="px-5 py-3.5 text-left">Amount</th>
                    <th class="px-5 py-3.5 text-left">Payment</th>
                    <th class="px-5 py-3.5 text-left">Status</th>
                    <th class="px-5 py-3.5 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($reservations as $r)
                <tr class="hover:bg-slate-50/60 transition-colors group">
                    <td class="px-5 py-4">
                        <p class="font-mono text-xs font-bold text-blue-600">{{ $r->reference_code }}</p>
                        @if($r->is_walk_in)<span class="inline-block mt-1 text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full font-medium">Walk-in</span>@endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-xs font-bold shrink-0">
                                {{ strtoupper(substr($r->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $r->guest_name }}</p>
                                <p class="text-xs text-slate-400">{{ $r->contact }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-slate-600">{{ $r->facility->label }}</td>
                    <td class="px-5 py-4">
                        <p class="text-sm font-medium text-slate-800">{{ $r->date->format('M j, Y') }}</p>
                        <p class="text-xs text-slate-400">{{ $r->start_time }} – {{ $r->end_time }}</p>
                    </td>
                    <td class="px-5 py-4 text-sm font-bold text-slate-900">₱{{ number_format($r->total_amount,0) }}</td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $r->payment_status==='verified' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $r->payment_status==='verified' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                            {{ ucfirst($r->payment_status) }}
                        </span>
                        @if($r->payment_reference)
                        <p class="text-[10px] text-slate-400 font-mono mt-1">{{ $r->payment_reference }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                            @if($r->status==='confirmed')  bg-emerald-100 text-emerald-700
                            @elseif($r->status==='pending') bg-amber-100   text-amber-700
                            @elseif($r->status==='rejected') bg-red-100   text-red-700
                            @elseif($r->status==='completed') bg-blue-100 text-blue-700
                            @else bg-slate-100 text-slate-500 @endif">
                            <span class="w-1.5 h-1.5 rounded-full
                                @if($r->status==='confirmed') bg-emerald-500
                                @elseif($r->status==='pending') bg-amber-500
                                @elseif($r->status==='rejected') bg-red-500
                                @elseif($r->status==='completed') bg-blue-500
                                @else bg-slate-400 @endif"></span>
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex flex-wrap gap-1.5">
                            @if($r->status === 'pending')
                            <form method="POST" action="{{ route('staff.reservation.status', $r) }}" class="inline">
                                @csrf<input type="hidden" name="status" value="confirmed">
                                <button class="px-2.5 py-1 text-xs rounded-lg bg-emerald-100 text-emerald-700 hover:bg-emerald-200 font-semibold transition-colors">Confirm</button>
                            </form>
                            <form method="POST" action="{{ route('staff.reservation.status', $r) }}" class="inline">
                                @csrf<input type="hidden" name="status" value="rejected">
                                <button class="px-2.5 py-1 text-xs rounded-lg bg-red-100 text-red-700 hover:bg-red-200 font-semibold transition-colors">Reject</button>
                            </form>
                            @endif
                            @if($r->status === 'confirmed')
                            <form method="POST" action="{{ route('staff.reservation.status', $r) }}" class="inline">
                                @csrf<input type="hidden" name="status" value="completed">
                                <button class="px-2.5 py-1 text-xs rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold transition-colors">Complete</button>
                            </form>
                            @endif
                            @if($r->payment_status !== 'verified' && in_array($r->status,['confirmed','completed']))
                            <form method="POST" action="{{ route('staff.reservation.verify-payment', $r) }}" class="inline">
                                @csrf
                                <button class="px-2.5 py-1 text-xs rounded-lg bg-violet-100 text-violet-700 hover:bg-violet-200 font-semibold transition-colors">Verify Pay</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-16 text-center">
                        <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-slate-400 text-sm font-medium">No reservations yet</p>
                        <a href="{{ route('staff.walk-in') }}" class="mt-3 btn-primary inline-flex !py-2 !px-4 !text-xs">Record a Walk-in</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-50 bg-slate-50/50">{{ $reservations->links() }}</div>
</div>
@endsection
