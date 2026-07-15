@extends('layouts.app')
@section('title', 'Find a Court — LaroHub')
@push('head')
<link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
@endpush
@section('content')

{{-- ────────────────────────────────────────────────────
     HERO SEARCH BANNER
──────────────────────────────────────────────────── --}}
<div class="bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03]">
        <svg viewBox="0 0 1200 600" class="w-full h-full" preserveAspectRatio="xMidYMid slice">
            <defs><pattern id="dots" width="30" height="30" patternUnits="userSpaceOnUse">
                <circle cx="2" cy="2" r="1.5" fill="white"/>
            </pattern></defs>
            <rect width="100%" height="100%" fill="url(#dots)"/>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-0">
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 bg-blue-500/10 border border-blue-400/20 rounded-full px-4 py-1.5 text-blue-300 text-xs font-semibold uppercase tracking-wider mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                Smart Court Finder
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3 leading-tight">
                Find the <span class="text-blue-400">Best Court</span> Near You
            </h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto">Set your sport, schedule, budget, and location — we rank every available facility for you.</p>
        </div>

        {{-- ── SEARCH FORM CARD ── --}}
        <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-5 sm:p-6 max-w-5xl mx-auto shadow-2xl">
            <form method="GET" action="{{ route('recommend') }}" id="search-form">
                <input type="hidden" name="sport" id="sport-val" value="{{ $sport ?? '' }}">

                {{-- Sport selector row --}}
                <div class="mb-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Select Sport <span class="text-red-400">*</span></p>
                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                        @foreach([
                            ['v'=>'Basketball','path'=>'M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 0c2.21 0 4 4.477 4 10s-1.79 10-4 10-4-4.477-4-10 1.79-10 4-10zm-8 9h16'],
                            ['v'=>'Badminton', 'path'=>'M9.5 14.5L3 21M15 3a6 6 0 016 6 6 6 0 01-6 6 6 6 0 01-6-6 6 6 0 016-6z'],
                            ['v'=>'Volleyball','path'=>'M12 2a10 10 0 100 20A10 10 0 0012 2zM2 12h20M12 2c-2.5 4-2.5 16 0 20M12 2c2.5 4 2.5 16 0 20'],
                            ['v'=>'Tennis',   'path'=>'M12 2a10 10 0 100 20A10 10 0 0012 2zm6.4 4a6 6 0 010 12M5.6 6a6 6 0 000 12'],
                            ['v'=>'Pickleball','path'=>'M12 2a7 7 0 017 7v2a7 7 0 01-14 0V9a7 7 0 017-7zm0 16v4'],
                            ['v'=>'Gym',      'path'=>'M6 5v14M18 5v14M3 8h3M18 8h3M3 16h3M18 16h3M6 12h12'],
                        ] as $sp)
                        <button type="button" data-sport="{{ $sp['v'] }}"
                            class="sport-btn flex flex-col items-center gap-2 py-3.5 px-2 rounded-2xl border transition-all duration-200 text-xs font-semibold
                                {{ ($sport ?? '') === $sp['v']
                                    ? 'border-blue-500 bg-blue-500 text-white shadow-lg shadow-blue-500/30'
                                    : 'border-white/10 bg-white/5 text-slate-300 hover:bg-white/10 hover:border-white/20 hover:text-white' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $sp['path'] }}"/>
                            </svg>
                            <span>{{ $sp['v'] }}</span>
                        </button>
                        @endforeach
                    </div>
                    <p id="sport-err" class="text-xs text-red-400 mt-2 hidden flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        Please select a sport to continue.
                    </p>
                </div>

                {{-- Main inputs grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-4">

                    {{-- Date --}}
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Date</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="date" name="date" value="{{ $date ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}"
                                class="w-full bg-white/10 border border-white/10 text-white placeholder-slate-500 rounded-xl pl-9 pr-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                        </div>
                    </div>

                    {{-- Start Time --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Start Time</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <input type="time" name="start_time" value="{{ $start_time ?? '08:00' }}"
                                class="w-full bg-white/10 border border-white/10 text-white rounded-xl pl-9 pr-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    {{-- End Time --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">End Time</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <input type="time" name="end_time" value="{{ $end_time ?? '10:00' }}"
                                class="w-full bg-white/10 border border-white/10 text-white rounded-xl pl-9 pr-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                        </div>
                    </div>

                    {{-- Max Price --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Max Price / hr</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <select name="max_price"
                                class="w-full bg-white/10 border border-white/10 text-white rounded-xl pl-9 pr-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition appearance-none">
                                <option class="text-gray-900" value="0"    {{ ($max_price??'0')=='0'   ?'selected':'' }}>Any price</option>
                                <option class="text-gray-900" value="200"  {{ ($max_price??'')=='200'  ?'selected':'' }}>Up to ₱200</option>
                                <option class="text-gray-900" value="300"  {{ ($max_price??'')=='300'  ?'selected':'' }}>Up to ₱300</option>
                                <option class="text-gray-900" value="500"  {{ ($max_price??'')=='500'  ?'selected':'' }}>Up to ₱500</option>
                                <option class="text-gray-900" value="800"  {{ ($max_price??'')=='800'  ?'selected':'' }}>Up to ₱800</option>
                                <option class="text-gray-900" value="1200" {{ ($max_price??'')=='1200' ?'selected':'' }}>Up to ₱1,200</option>
                                <option class="text-gray-900" value="2000" {{ ($max_price??'')=='2000' ?'selected':'' }}>Up to ₱2,000</option>
                            </select>
                        </div>
                    </div>

                    {{-- Min Rating --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Min Rating</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <select name="min_rating"
                                class="w-full bg-white/10 border border-white/10 text-white rounded-xl pl-9 pr-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition appearance-none">
                                <option class="text-gray-900" value="0"   {{ ($min_rating??'0')=='0'  ?'selected':'' }}>Any</option>
                                <option class="text-gray-900" value="3.0" {{ ($min_rating??'')=='3.0' ?'selected':'' }}>3.0+</option>
                                <option class="text-gray-900" value="3.5" {{ ($min_rating??'')=='3.5' ?'selected':'' }}>3.5+</option>
                                <option class="text-gray-900" value="4.0" {{ ($min_rating??'')=='4.0' ?'selected':'' }}>4.0+</option>
                                <option class="text-gray-900" value="4.5" {{ ($min_rating??'')=='4.5' ?'selected':'' }}>4.5+</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Location + Submit row --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" id="locate-btn"
                        class="flex-1 flex items-center gap-2.5 px-4 py-3 rounded-xl border transition-all duration-200 text-sm font-medium
                            {{ request('user_lat') ? 'border-green-500/40 bg-green-500/10 text-green-400' : 'border-white/10 bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span id="location-label" class="truncate">
                            {{ request('user_lat') ? 'Location detected — distance will be calculated' : 'Use my current location (for distance ranking)' }}
                        </span>
                        @if(request('user_lat'))
                        <svg class="w-4 h-4 text-green-400 shrink-0 ml-auto" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        @endif
                    </button>
                    <input type="hidden" name="user_lat" id="user-lat" value="{{ request('user_lat') }}">
                    <input type="hidden" name="user_lng" id="user-lng" value="{{ request('user_lng') }}">

                    <button type="submit"
                        class="sm:w-48 flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-500 active:scale-95 text-white font-bold text-sm rounded-xl transition-all duration-200 shadow-lg shadow-blue-600/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Search Courts
                    </button>
                </div>
            </form>
        </div>

        {{-- Bottom wave --}}
        <div class="h-8"></div>
    </div>
</div>

{{-- ────────────────────────────────────────────────────
     RESULTS SECTION
──────────────────────────────────────────────────── --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

@if(!isset($searched) || !$searched)
{{-- Empty state --}}
<div class="max-w-md mx-auto text-center py-20">
    <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center mx-auto mb-5">
        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">Ready to find your court?</h3>
    <p class="text-gray-400 text-sm leading-relaxed">Select a sport above, set your preferred schedule, budget, and location to get personalised recommendations ranked just for you.</p>
</div>

@else

{{-- ── FILTER TABS: Available / All ── --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">
            Results
            <span class="text-blue-600">{{ $sport }}</span>
        </h2>
        <p class="text-sm text-gray-400 mt-0.5">
            {{ \Carbon\Carbon::parse($date)->format('M j, Y') }}
            &nbsp;·&nbsp; {{ $start_time }} – {{ $end_time }}
            &nbsp;·&nbsp; {{ $duration }}h
            @if(!empty($max_price) && $max_price > 0) &nbsp;·&nbsp; Max ₱{{ number_format($max_price,0) }}/hr @endif
            @if(!empty($min_rating) && $min_rating > 0) &nbsp;·&nbsp; {{ $min_rating }}+ stars @endif
        </p>
    </div>

    {{-- Filter tabs --}}
    <div class="flex items-center gap-1 bg-gray-100 p-1 rounded-xl">
        <button id="tab-available" onclick="showTab('available')"
            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-gray-900 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-green-500"></span>
            Available
            <span class="ml-1 bg-green-100 text-green-700 text-xs font-bold px-1.5 py-0.5 rounded-full">{{ count($available) }}</span>
        </button>
        <button id="tab-others" onclick="showTab('others')"
            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-500 hover:text-gray-700">
            <span class="w-2 h-2 rounded-full bg-gray-400"></span>
            Unavailable
            <span class="ml-1 bg-gray-200 text-gray-600 text-xs font-bold px-1.5 py-0.5 rounded-full">{{ count($alternatives) }}</span>
        </button>
    </div>
</div>

{{-- ── AVAILABLE RESULTS ── --}}
<div id="panel-available">
@if(count($available) > 0)
<div class="space-y-4 mb-8">
    @foreach($available as $item)
    @php
        $v      = $item['venue'];
        $f      = $item['facility'];
        $rank   = $item['rank'];
        $total  = $item['price'] * $duration;
        $isNight = $f->time_slot === 'night' || $f->time_slot === '4pm-10pm';
    @endphp
    <div class="bg-white rounded-2xl border {{ $rank === 1 ? 'border-blue-200 ring-2 ring-blue-100' : 'border-gray-100' }} shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 group">
        <div class="flex flex-col lg:flex-row">

            {{-- Left accent strip --}}
            <div class="lg:w-1.5 h-1.5 lg:h-auto bg-gradient-to-b {{ $rank === 1 ? 'from-blue-500 to-indigo-600' : 'from-gray-200 to-gray-300' }} lg:rounded-l-2xl rounded-t-2xl lg:rounded-tr-none shrink-0"></div>

            <div class="flex-1 p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row gap-5">

                    {{-- Venue icon + rank --}}
                    <div class="relative shrink-0 self-start">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $v->color }} flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                            <svg class="w-8 h-8 text-white/80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-black shadow-md
                            {{ $rank === 1 ? 'bg-blue-600 ring-2 ring-blue-200' : ($rank === 2 ? 'bg-slate-600' : 'bg-slate-400') }}">
                            {{ $rank }}
                        </div>
                    </div>

                    {{-- Main info --}}
                    <div class="flex-1 min-w-0">

                        {{-- Name + badges --}}
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <h3 class="text-lg font-bold text-gray-900">{{ $v->name }}</h3>
                            @if($rank === 1)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-blue-600 text-white text-xs font-bold shadow-sm">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Top Pick
                            </span>
                            @endif
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                Available
                            </span>
                            @if($isNight)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-xs font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                                Night
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-xs font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                Daytime
                            </span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-500 mb-3">{{ $f->label }}</p>

                        {{-- Stats row --}}
                        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs">
                            <span class="flex items-center gap-1.5 text-gray-600">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="font-semibold text-gray-800">{{ number_format($item['rating'],1) }}</span> / 5.0 rating
                            </span>
                            @if($item['distance'] > 0)
                            <span class="flex items-center gap-1.5 text-gray-600">
                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="font-semibold text-gray-800">{{ number_format($item['distance'],1) }} km</span> away
                            </span>
                            @else
                            <span class="flex items-center gap-1.5 text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Share location to see distance
                            </span>
                            @endif
                            <span class="flex items-center gap-1.5 text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Davao City
                            </span>
                        </div>
                    </div>

                    {{-- Price + CTA --}}
                    <div class="flex sm:flex-col items-center sm:items-end justify-between gap-4 sm:gap-3 pt-4 sm:pt-0 sm:pl-6 sm:border-l border-gray-100 shrink-0">
                        <div class="sm:text-right">
                            <p class="text-2xl font-black text-gray-900 leading-none">₱{{ number_format($item['price'],0) }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">per hour</p>
                            <div class="mt-2 inline-flex items-center px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                                ₱{{ number_format($total,0) }} total
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">for {{ $duration }} hour{{ $duration>1?'s':'' }}</p>
                        </div>
                        <a href="{{ route('book', ['venue_id'=>$v->id,'facility_id'=>$f->id,'date'=>$date,'start_time'=>$start_time,'duration'=>$duration]) }}"
                            class="{{ $rank===1 ? 'btn-primary' : 'btn-secondary' }} !py-2.5 !px-5 !text-sm whitespace-nowrap">
                            Book Now
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Map --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            <h3 class="text-sm font-bold text-gray-900">Venue Locations — Davao City</h3>
        </div>
        <p class="text-xs text-gray-400">Tap markers for details &nbsp;·&nbsp; Numbers show rank</p>
    </div>
    <div id="map" class="h-80 sm:h-96 w-full"></div>
</div>

@else
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
    <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <h3 class="text-base font-bold text-gray-900 mb-2">No courts available</h3>
    <p class="text-gray-500 text-sm">No <strong>{{ $sport }}</strong> facilities match your filters for <strong>{{ \Carbon\Carbon::parse($date)->format('M j, Y') }}</strong>.</p>
    <p class="text-xs text-gray-400 mt-2">Try removing the price limit, lowering the rating, or picking a different time.</p>
    @if(count($alternatives) > 0)
    <button onclick="showTab('others')" class="mt-5 btn-secondary !py-2 !px-5 !text-sm">
        View {{ count($alternatives) }} other {{ $sport }} venues →
    </button>
    @endif
</div>
@endif
</div>

{{-- ── UNAVAILABLE PANEL ── --}}
<div id="panel-others" class="hidden">
@if(count($alternatives) > 0)
<div class="space-y-3">
    @foreach($alternatives as $item)
    @php $v = $item['venue']; $f = $item['facility']; @endphp
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 opacity-80 hover:opacity-100 transition-opacity">
        <div class="flex items-center gap-4 min-w-0">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $v->color }} flex items-center justify-center shrink-0 opacity-60">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
            </div>
            <div class="min-w-0">
                <p class="font-bold text-gray-800 text-sm">{{ $v->name }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ $f->label }} &nbsp;·&nbsp; ₱{{ number_format($item['price'],0) }}/hr &nbsp;·&nbsp;
                    <svg class="w-3 h-3 text-amber-400 inline-block -mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    {{ number_format($item['rating'],1) }}
                </p>
                <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-full bg-orange-100 text-orange-700 text-xs font-medium">{{ $item['unavailable_reason'] }}</span>
            </div>
        </div>
        <a href="{{ route('book', ['venue_id'=>$v->id,'facility_id'=>$f->id]) }}" class="btn-secondary !py-2 !px-4 !text-xs shrink-0">
            Book a Different Time
        </a>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-16 text-gray-400 text-sm">No other venues to show.</div>
@endif
</div>

@endif {{-- /searched --}}
</div>

@if(isset($searched) && $searched && count($available) > 0)
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoibGFyb2h1YiIsImEiOiJleGFtcGxlX3Rva2VuIn0.placeholder';
const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/light-v11',
    center: [125.6128, 7.0731],
    zoom: 12
});
map.addControl(new mapboxgl.NavigationControl({ showCompass: false }), 'top-right');
const colors = ['#2563eb','#1d4ed8','#3b82f6','#60a5fa','#93c5fd'];
const allVenues = @json(array_merge($available, $alternatives));
allVenues.forEach(item => {
    const v = item.venue;
    if (!v.latitude || !v.longitude) return;
    const color = item.available ? (colors[(item.rank||1)-1] || '#9ca3af') : '#d1d5db';
    const el = document.createElement('div');
    el.style.cssText = `width:30px;height:30px;border-radius:50%;background:${color};color:white;font-weight:800;font-size:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 8px rgba(0,0,0,.3);cursor:pointer;border:2px solid white`;
    el.textContent = item.available ? (item.rank||'—') : '—';
    new mapboxgl.Marker(el).setLngLat([parseFloat(v.longitude), parseFloat(v.latitude)])
        .setPopup(new mapboxgl.Popup({offset:28}).setHTML(
            `<div style="padding:10px;min-width:140px">
                <strong style="font-size:13px;display:block;margin-bottom:2px">${v.name}</strong>
                <span style="font-size:11px;color:#6b7280">₱${Number(item.price).toLocaleString()}/hr &nbsp;·&nbsp; ${v.rating}★</span>
                ${item.distance>0 ? `<br><span style="font-size:11px;color:#6b7280">${item.distance} km away</span>` : ''}
            </div>`
        )).addTo(map);
});
@if(request('user_lat') && request('user_lng'))
const me = document.createElement('div');
me.style.cssText = 'width:14px;height:14px;border-radius:50%;background:#2563eb;border:3px solid white;box-shadow:0 0 0 5px rgba(37,99,235,.2)';
new mapboxgl.Marker(me).setLngLat([{{ request('user_lng') }}, {{ request('user_lat') }}]).addTo(map);
@endif
</script>
@endif

<script>
// Sport buttons
const sportBtns = document.querySelectorAll('.sport-btn');
const sportVal  = document.getElementById('sport-val');

function selectSport(val) {
    sportBtns.forEach(b => {
        const on = b.dataset.sport === val;
        b.className = b.className
            .replace(/border-blue-500|bg-blue-500|text-white|shadow-lg|shadow-blue-500\/30|border-white\/10|bg-white\/5|text-slate-300|hover:bg-white\/10|hover:border-white\/20|hover:text-white/g, '').trim();
        if (on) {
            b.classList.add('border-blue-500','bg-blue-500','text-white','shadow-lg','shadow-blue-500/30');
        } else {
            b.classList.add('border-white/10','bg-white/5','text-slate-300','hover:bg-white/10','hover:border-white/20','hover:text-white');
        }
    });
    sportVal.value = val;
    document.getElementById('sport-err').classList.add('hidden');
}

sportBtns.forEach(b => b.addEventListener('click', () => selectSport(b.dataset.sport)));
if (sportVal.value) selectSport(sportVal.value);

document.getElementById('search-form').addEventListener('submit', e => {
    if (!sportVal.value) {
        e.preventDefault();
        document.getElementById('sport-err').classList.remove('hidden');
        document.querySelector('#sport-err').scrollIntoView({ behavior:'smooth', block:'center' });
    }
});

// Geolocation
document.getElementById('locate-btn').addEventListener('click', () => {
    const lbl = document.getElementById('location-label');
    const btn = document.getElementById('locate-btn');
    lbl.textContent = 'Detecting your location…';
    if (!navigator.geolocation) { lbl.textContent = 'Location not supported by your browser'; return; }
    navigator.geolocation.getCurrentPosition(pos => {
        document.getElementById('user-lat').value = pos.coords.latitude;
        document.getElementById('user-lng').value = pos.coords.longitude;
        lbl.textContent = 'Location detected — distance will be calculated';
        btn.classList.remove('border-white/10','bg-white/5','text-slate-300');
        btn.classList.add('border-green-500/40','bg-green-500/10','text-green-400');
    }, () => { lbl.textContent = 'Unable to detect. Please allow location access.'; });
});

// Filter tabs
function showTab(tab) {
    const panelAvail  = document.getElementById('panel-available');
    const panelOthers = document.getElementById('panel-others');
    const btnAvail    = document.getElementById('tab-available');
    const btnOthers   = document.getElementById('tab-others');

    if (tab === 'available') {
        panelAvail.classList.remove('hidden');
        panelOthers.classList.add('hidden');
        btnAvail.classList.add('bg-white','text-gray-900','shadow-sm');
        btnAvail.classList.remove('text-gray-500');
        btnOthers.classList.remove('bg-white','text-gray-900','shadow-sm');
        btnOthers.classList.add('text-gray-500');
    } else {
        panelOthers.classList.remove('hidden');
        panelAvail.classList.add('hidden');
        btnOthers.classList.add('bg-white','text-gray-900','shadow-sm');
        btnOthers.classList.remove('text-gray-500');
        btnAvail.classList.remove('bg-white','text-gray-900','shadow-sm');
        btnAvail.classList.add('text-gray-500');
    }
}
</script>
@endsection
