@extends('layouts.sidebar')
@section('title','Reservations')
@section('panel_name','Admin Panel')
@section('page_title','All Reservations')
@section('page_subtitle','View, filter, and manage every booking across all venues')

@section('sidebar_nav')
<p class="sidebar-section">Main</p>
<a href="{{ route('admin.dashboard') }}" class="sidebar-link">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>
<p class="sidebar-section">Reservations</p>
<a href="{{ route('admin.reservations') }}" class="sidebar-link active">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    All Reservations
</a>
<p class="sidebar-section">Management</p>
<a href="{{ route('admin.users') }}" class="sidebar-link">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    Users
</a>
<a href="{{ route('venues') }}" target="_blank" class="sidebar-link">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    Venues
</a>
@endsection

@section('content')
{{-- Filter bar --}}
<div class="panel-card p-4 mb-5">
    <form method="GET" class="flex flex-wrap items-end gap-3">
        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Status</label>
            <select name="status" class="input-field !py-2 !text-sm">
                <option value="">All statuses</option>
                @foreach(['pending','confirmed','completed','rejected','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Venue</label>
            <select name="venue_id" class="input-field !py-2 !text-sm">
                <option value="">All venues</option>
                @foreach($venues as $v)
                <option value="{{ $v->id }}" {{ request('venue_id')==$v->id?'selected':'' }}>{{ $v->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn-primary !py-2 !text-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zm2 5a1 1 0 000 2h10a1 1 0 000-2H5zm2 5a1 1 0 000 2h6a1 1 0 000-2H7z"/></svg>
            Apply Filter
        </button>
        <a href="{{ route('admin.reservations') }}" class="btn-secondary !py-2 !text-sm">Clear</a>
        <div class="ml-auto flex items-end">
            <span class="text-sm font-bold text-slate-700">{{ $reservations->total() }}</span>
            <span class="text-xs text-slate-400 ml-1 mb-0.5">records</span>
        </div>
    </form>
</div>

<div class="panel-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <th class="px-5 py-3.5 text-left">Reference</th>
                    <th class="px-5 py-3.5 text-left">Guest</th>
                    <th class="px-5 py-3.5 text-left">Venue / Facility</th>
                    <th class="px-5 py-3.5 text-left">Schedule</th>
                    <th class="px-5 py-3.5 text-left">Amount</th>
                    <th class="px-5 py-3.5 text-left">Payment</th>
                    <th class="px-5 py-3.5 text-left">Status</th>
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
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-200 to-slate-300 flex items-center justify-center text-slate-600 text-xs font-bold shrink-0">
                                {{ strtoupper(substr($r->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $r->guest_name }}</p>
                                <p class="text-xs text-slate-400">{{ $r->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-sm font-semibold text-slate-800">{{ $r->venue->name }}</p>
                        <p class="text-xs text-slate-400">{{ $r->facility->label }}</p>
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-sm font-medium text-slate-800">{{ $r->date?$r->date->format('M j, Y'):'—' }}</p>
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
                            @else bg-slate-100 text-slate-600 @endif">
                            <span class="w-1.5 h-1.5 rounded-full
                                @if($r->status==='confirmed') bg-emerald-500
                                @elseif($r->status==='pending') bg-amber-500
                                @elseif($r->status==='rejected') bg-red-500
                                @elseif($r->status==='completed') bg-blue-500
                                @else bg-slate-400 @endif"></span>
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-slate-400 text-sm font-medium">No reservations found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-50 bg-slate-50/50">{{ $reservations->links() }}</div>
</div>
@endsection
