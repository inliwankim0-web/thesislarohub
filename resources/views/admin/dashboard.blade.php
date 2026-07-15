@extends('layouts.sidebar')
@section('title','Admin Dashboard')
@section('panel_name','Admin Panel')
@section('page_title','Dashboard')
@section('page_subtitle', 'Welcome back, ' . auth()->user()->first_name . '. Here\'s what\'s happening.')

@section('sidebar_nav')
<p class="sidebar-section">Main</p>
<a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>

<p class="sidebar-section">Reservations</p>
<a href="{{ route('admin.reservations') }}" class="sidebar-link">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    All Reservations
    @php $pending = \App\Models\Reservation::where('status','pending')->count(); @endphp
    @if($pending > 0)
    <span class="ml-auto inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[10px] font-bold">{{ $pending }}</span>
    @endif
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

{{-- ── STAT CARDS ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-7">

    {{-- Users --}}
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-5 text-white shadow-lg shadow-blue-600/20 relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="absolute -right-2 -bottom-6 w-16 h-16 bg-white/5 rounded-full"></div>
        <div class="relative">
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="text-3xl font-black">{{ $stats['users'] }}</p>
            <p class="text-sm font-semibold text-blue-100 mt-0.5">Total Users</p>
            <p class="text-xs text-blue-200 mt-1">{{ $stats['renters'] }} renters · {{ $stats['staff'] }} staff</p>
        </div>
    </div>

    {{-- Venues --}}
    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-5 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full"></div>
        <div class="relative">
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <p class="text-3xl font-black">{{ $stats['venues'] }}</p>
            <p class="text-sm font-semibold text-emerald-100 mt-0.5">Active Venues</p>
            <p class="text-xs text-emerald-200 mt-1">Davao City locations</p>
        </div>
    </div>

    {{-- Reservations --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 relative overflow-hidden">
        <div class="w-9 h-9 bg-violet-100 rounded-xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <p class="text-3xl font-black text-slate-900">{{ $stats['reservations'] }}</p>
        <p class="text-sm font-semibold text-slate-600 mt-0.5">Total Bookings</p>
        @if($stats['pending'] > 0)
        <div class="mt-2 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
            {{ $stats['pending'] }} pending action
        </div>
        @endif
    </div>

    {{-- Revenue --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 relative overflow-hidden">
        <div class="w-9 h-9 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        </div>
        <p class="text-3xl font-black text-slate-900">₱{{ number_format($stats['revenue'],0) }}</p>
        <p class="text-sm font-semibold text-slate-600 mt-0.5">Total Revenue</p>
        <p class="text-xs text-slate-400 mt-1">From completed bookings</p>
    </div>
</div>

{{-- ── MAIN GRID ── --}}
<div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

    {{-- Venues panel --}}
    <div class="xl:col-span-4 panel-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-50">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-900">Venue Status</h2>
                <span class="text-[11px] text-slate-400 font-medium">Click badge to toggle</span>
            </div>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($venues as $venue)
            <div class="flex items-center justify-between px-5 py-3.5 hover:bg-slate-50 transition-colors">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $venue->color }} flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ $venue->name }}</p>
                        <p class="text-xs text-slate-400">{{ $venue->reservations_count }} total bookings</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.venues.toggle', $venue) }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold transition-all
                            {{ $venue->is_active
                                ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200'
                                : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $venue->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                        {{ $venue->is_active ? 'Active' : 'Off' }}
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Recent reservations --}}
    <div class="xl:col-span-8 panel-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-50 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Recent Reservations</h2>
            <a href="{{ route('admin.reservations') }}"
                class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                View all
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="px-5 py-3 text-left">Reference</th>
                        <th class="px-5 py-3 text-left">Guest</th>
                        <th class="px-5 py-3 text-left">Venue</th>
                        <th class="px-5 py-3 text-left">Date</th>
                        <th class="px-5 py-3 text-left">Amount</th>
                        <th class="px-5 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentReservations as $r)
                    <tr class="hover:bg-slate-50/60 transition-colors group">
                        <td class="px-5 py-3.5">
                            <span class="font-mono text-xs font-bold text-blue-600 group-hover:text-blue-700">{{ $r->reference_code }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($r->first_name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-slate-800 truncate max-w-[120px]">{{ $r->guest_name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-slate-600">{{ $r->venue->name }}</td>
                        <td class="px-5 py-3.5 text-sm text-slate-500">{{ $r->date ? $r->date->format('M j, Y') : '—' }}</td>
                        <td class="px-5 py-3.5 text-sm font-bold text-slate-800">₱{{ number_format($r->total_amount, 0) }}</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                @if($r->status==='confirmed')  bg-emerald-100 text-emerald-700
                                @elseif($r->status==='pending') bg-amber-100   text-amber-700
                                @elseif($r->status==='rejected') bg-red-100   text-red-700
                                @elseif($r->status==='completed') bg-blue-100 text-blue-700
                                @else bg-slate-100 text-slate-600 @endif">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5
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
                        <td colspan="6" class="px-5 py-12 text-center">
                            <p class="text-slate-400 text-sm">No reservations yet</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
