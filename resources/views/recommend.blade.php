@extends('layouts.app')
@section('title', 'Find a Court — LaroHub')
@push('head')
<link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
@endpush
@section('content')

{{-- Page header --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900">Find a Court</h1>
        <p class="text-gray-500 text-sm mt-1">Enter your preferences below to discover and reserve available sports facilities.</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<div class="grid grid-cols-1 xl:grid-cols-12 gap-8">

{{-- ═══════════════════════════════════════════════════
     LEFT PANEL — Search Form (sticky on desktop)
═══════════════════════════════════════════════════ --}}
<aside class="xl:col-span-4">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden xl:sticky xl:top-20">

        {{-- Panel header --}}
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">Search Criteria</p>
                    <p class="text-xs text-gray-400">All fields are optional except sport</p>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('recommend') }}" id="search-form" class="px-6 py-5 space-y-5">

            {{-- Sport type --}}
            <div>
                <label class="label">Sport Type <span class="text-red-400">*</span></label>
                <div class="grid grid-cols-3 gap-2" id="sport-grid">
                    @foreach([
                        ['v'=>'Basketball','path'=>'M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm0 0c2.21 0 4 4.477 4 10s-1.79 10-4 10-4-4.477-4-10 1.79-10 4-10zm-8 9h16'],
                        ['v'=>'Badminton', 'path'=>'M9.5 14.5L3 21M15 3a6 6 0 016 6 6 6 0 01-6 6 6 6 0 01-6-6 6 6 0 016-6z'],
                        ['v'=>'Volleyball','path'=>'M12 2a10 10 0 100 20A10 10 0 0012 2zM2 12h20M12 2c-2.5 4-2.5 16 0 20'],
                        ['v'=>'Tennis',   'path'=>'M12 2a10 10 0 100 20A10 10 0 0012 2zm6.4 4a6 6 0 010 12M5.6 6a6 6 0 000 12'],
                        ['v'=>'Pickleball','path'=>'M12 2a7 7 0 017 7v2a7 7 0 01-14 0V9a7 7 0 017-7zm0 16v4'],
                        ['v'=>'Gym',      'path'=>'M6 5v14M18 5v14M3 8h3M18 8h3M3 16h3M18 16h3M6 12h12'],
                    ] as $sp)
                    <button type="button" data-sport="{{ $sp['v'] }}"
                        class="sport-btn flex flex-col items-center gap-1.5 py-3 px-2 rounded-xl border-2 transition-all duration-150 text-xs font-semibold
                            {{ ($sport ?? '') === $sp['v']
                                ? 'border-blue-600 bg-blue-600 text-white shadow-sm'
                                : 'border-gray-200 bg-white text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $sp['path'] }}"/>
                        </svg>
                        {{ $sp['v'] }}
                    </button>
                    @endforeach
                </div>
                <input type="hidden" name="sport" id="sport-val" value="{{ $sport ?? '' }}">
                <p id="sport-err" class="text-xs text-red-500 mt-1.5 hidden">Please select a sport.</p>
            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Date --}}
            <div>
                <label class="label">Preferred Date</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <input type="date" name="date" value="{{ $date ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="input-field pl-10" required>
                </div>
            </div>

            {{-- Time --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="label">Start Time</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <input type="time" name="start_time" value="{{ $start_time ?? '08:00' }}" class="input-field pl-10" required>
                    </div>
                </div>
                <div>
                    <label class="label">End Time</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <input type="time" name="end_time" value="{{ $end_time ?? '10:00' }}" class="input-field pl-10" required>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Minimum Rating --}}
            <div>
                <label class="label">Minimum Rating</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <select name="min_rating" class="input-field pl-10">
                        <option value="0"   {{ ($min_rating??'0')=='0'  ?'selected':'' }}>Any rating</option>
                        <option value="3.0" {{ ($min_rating??'')=='3.0' ?'selected':'' }}>3.0 stars and above</option>
                        <option value="3.5" {{ ($min_rating??'')=='3.5' ?'selected':'' }}>3.5 stars and above</option>
                        <option value="4.0" {{ ($min_rating??'')=='4.0' ?'selected':'' }}>4.0 stars and above</option>
                        <option value="4.5" {{ ($min_rating??'')=='4.5' ?'selected':'' }}>4.5 stars and above</option>
                    </select>
                </div>
            </div>

            {{-- Max Price --}}
            <div>
                <label class="label">Maximum Price per Hour</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <select name="max_price" class="input-field pl-10">
                        <option value="0"    {{ ($max_price??'0')=='0'   ?'selected':'' }}>No price limit</option>
                        <option value="200"  {{ ($max_price??'')=='200'  ?'selected':'' }}>Up to ₱200 / hr</option>
                        <option value="300"  {{ ($max_price??'')=='300'  ?'selected':'' }}>Up to ₱300 / hr</option>
                        <option value="500"  {{ ($max_price??'')=='500'  ?'selected':'' }}>Up to ₱500 / hr</option>
                        <option value="800"  {{ ($max_price??'')=='800'  ?'selected':'' }}>Up to ₱800 / hr</option>
                        <option value="1200" {{ ($max_price??'')=='1200' ?'selected':'' }}>Up to ₱1,200 / hr</option>
                        <option value="2000" {{ ($max_price??'')=='2000' ?'selected':'' }}>Up to ₱2,000 / hr</option>
                    </select>
                </div>
                <p class="text-xs text-gray-400 mt-1.5">Day sessions: ₱150 – ₱1,200/hr &nbsp;·&nbsp; Night: up to ₱1,900/hr</p>
            </div>

            {{-- Location --}}
            <div>
                <label class="label">Your Location <span class="text-gray-400 font-normal text-xs">(for distance sorting)</span></label>
                <button type="button" id="locate-btn"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 text-sm font-medium text-gray-600 transition-all duration-200 group">
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 shrink-0 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span id="location-label" class="truncate text-left">
                        {{ request('user_lat') ? 'Location detected' : 'Detect my current location' }}
                    </span>
                    @if(request('user_lat'))
                    <svg class="w-4 h-4 text-green-500 shrink-0 ml-auto" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </button>
                <input type="hidden" name="user_lat" id="user-lat" value="{{ request('user_lat') }}">
                <input type="hidden" name="user_lng" id="user-lng" value="{{ request('user_lng') }}">
                <p class="text-xs text-gray-400 mt-1.5">Allows us to sort venues by proximity to you.</p>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-primary w-full !py-3.5 text-sm font-bold mt-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Search Available Courts
            </button>
        </form>
    </div>
</aside>

{{-- ═══════════════════════════════════════════════════
     RIGHT PANEL — Results
═══════════════════════════════════════════════════ --}}
<div class="xl:col-span-8 space-y-6">

@if(!isset($searched) || !$searched)
{{-- ── Empty state before first search ── --}}
<div class="flex flex-col items-center justify-center py-20 text-center">
    <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center mb-5">
        <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>
    <h3 class="text-lg font-bold text-gray-900 mb-2">Select your preferences</h3>
    <p class="text-gray-400 text-sm max-w-xs">Choose a sport type and fill in your schedule on the left to see available courts ranked for you.</p>
</div>

@else
{{-- ── Active search results ── --}}

{{-- Summary bar --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex flex-wrap items-center gap-3">
    <div class="flex items-center gap-2 text-sm font-semibold text-gray-900">
        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Results for <span class="text-blue-600">{{ $sport }}</span>
    </div>
    <div class="flex flex-wrap items-center gap-2 text-xs ml-auto">
        <span class="flex items-center gap-1 text-gray-500">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ \Carbon\Carbon::parse($date)->format('M j, Y') }}
        </span>
        <span class="text-gray-300">|</span>
        <span class="flex items-center gap-1 text-gray-500">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $start_time }} – {{ $end_time }}
        </span>
        @if(!empty($max_price) && $max_price > 0)
        <span class="text-gray-300">|</span>
        <span class="text-gray-500">Max ₱{{ number_format($max_price, 0) }}/hr</span>
        @endif
        <span class="text-gray-300">|</span>
        <span class="font-semibold {{ count($available) > 0 ? 'text-green-600' : 'text-gray-500' }}">
            {{ count($available) }} available
        </span>
    </div>
</div>

@if(count($available) > 0)

{{-- ── Ranked result cards ── --}}
@foreach($available as $item)
@php
    $v         = $item['venue'];
    $f         = $item['facility'];
    $rank      = $item['rank'];
    $total     = $item['price'] * $duration;
    $isNight   = $f->time_slot === 'night' || $f->time_slot === '4pm-10pm';
@endphp
<div class="bg-white rounded-2xl border {{ $rank === 1 ? 'border-blue-200 shadow-md' : 'border-gray-100 shadow-sm' }} overflow-hidden hover:shadow-md transition-shadow duration-200">

    {{-- Colour top bar --}}
    <div class="h-1 bg-gradient-to-r {{ $v->color }}"></div>

    <div class="p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-5">

            {{-- Icon + rank badge --}}
            <div class="relative shrink-0">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $v->color }} flex items-center justify-center shadow-sm">
                    <svg class="w-7 h-7 text-white/70" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                </div>
                <span class="absolute -top-2 -right-2 w-6 h-6 rounded-full text-white text-xs font-bold flex items-center justify-center shadow
                    {{ $rank === 1 ? 'bg-blue-600' : ($rank === 2 ? 'bg-gray-600' : 'bg-gray-400') }}">
                    {{ $rank }}
                </span>
            </div>

            {{-- Info block --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <h3 class="text-base font-bold text-gray-900 truncate">{{ $v->name }}</h3>
                    @if($rank === 1)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold shrink-0">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Top Pick
                    </span>
                    @endif
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-medium shrink-0">Available</span>
                    @if($isNight)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-medium shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        Night
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-xs font-medium shrink-0">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Daytime
                    </span>
                    @endif
                </div>

                <p class="text-sm text-gray-500 mb-3">{{ $f->label }}</p>

                <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-gray-500">
                    {{-- Rating --}}
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="font-semibold text-gray-700">{{ number_format($item['rating'], 1) }}</span> / 5.0
                    </span>
                    {{-- Distance --}}
                    @if($item['distance'] > 0)
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="font-semibold text-gray-700">{{ number_format($item['distance'], 1) }} km</span>
                    </span>
                    @endif
                    {{-- Location --}}
                    <span class="flex items-center gap-1 text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Davao City
                    </span>
                </div>
            </div>

            {{-- Price + Book --}}
            <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-start gap-3 sm:min-w-[130px] pt-4 sm:pt-0 border-t sm:border-t-0 sm:border-l border-gray-100 sm:pl-6">
                <div class="sm:text-right">
                    <p class="text-xl font-bold text-gray-900">₱{{ number_format($item['price'], 0) }}</p>
                    <p class="text-xs text-gray-400 leading-tight">per hour</p>
                    <p class="text-sm font-semibold text-blue-600 mt-1">₱{{ number_format($total, 0) }}</p>
                    <p class="text-xs text-gray-400">total · {{ $duration }}h</p>
                </div>
                <a href="{{ route('book', ['venue_id'=>$v->id,'facility_id'=>$f->id,'date'=>$date,'start_time'=>$start_time,'duration'=>$duration]) }}"
                    class="{{ $rank === 1 ? 'btn-primary' : 'btn-secondary' }} !py-2.5 !px-5 !text-sm whitespace-nowrap shrink-0">
                    Book Now
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>

        </div>
    </div>
</div>
@endforeach

{{-- Map --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            <h3 class="text-sm font-bold text-gray-900">Venue Locations</h3>
        </div>
        <p class="text-xs text-gray-400">Tap a marker to see details</p>
    </div>
    <div id="map" class="h-72 sm:h-80 w-full"></div>
</div>

@else
{{-- No results --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
    <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <h3 class="text-base font-bold text-gray-900 mb-2">No courts found</h3>
    <p class="text-gray-500 text-sm mb-1">No <strong>{{ $sport }}</strong> facilities match your criteria for <strong>{{ \Carbon\Carbon::parse($date)->format('M j, Y') }}</strong>.</p>
    <p class="text-xs text-gray-400 mt-2">Try removing the price limit, lowering the minimum rating, or choosing a different time.</p>
</div>
@endif

{{-- Alternatives --}}
@if(count($alternatives) > 0)
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h3 class="text-sm font-bold text-gray-900">Other {{ $sport }} Venues</h3>
        <p class="text-xs text-gray-400 mt-0.5">These did not meet your filters or have no availability for the selected time.</p>
    </div>
    <div class="divide-y divide-gray-50">
        @foreach($alternatives as $item)
        @php $v = $item['venue']; $f = $item['facility']; @endphp
        <div class="px-5 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $v->color }} flex items-center justify-center shrink-0 opacity-50">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-700 truncate">{{ $v->name }}</p>
                    <p class="text-xs text-gray-400">{{ $f->label }} &nbsp;·&nbsp; ₱{{ number_format($item['price'],0) }}/hr &nbsp;·&nbsp;
                        <svg class="w-3 h-3 text-amber-400 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ number_format($item['rating'],1) }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $item['unavailable_reason'] }}</p>
                </div>
            </div>
            <a href="{{ route('book', ['venue_id'=>$v->id,'facility_id'=>$f->id]) }}" class="btn-secondary !py-1.5 !px-3 !text-xs shrink-0">Book Anyway</a>
        </div>
        @endforeach
    </div>
</div>
@endif

@endif {{-- end $searched --}}

</div>{{-- /.xl:col-span-8 --}}
</div>{{-- /.grid --}}
</div>{{-- /.max-w-6xl --}}

@if(isset($searched) && $searched && count($available) > 0)
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoibGFyb2h1YiIsImEiOiJleGFtcGxlX3Rva2VuIn0.placeholder';
const map = new mapboxgl.Map({ container:'map', style:'mapbox://styles/mapbox/light-v11', center:[125.6128,7.0731], zoom:12 });
map.addControl(new mapboxgl.NavigationControl({showCompass:false}), 'top-right');
const rankColors = ['#2563eb','#1d4ed8','#3b82f6','#60a5fa','#93c5fd'];
const allVenues = @json(array_merge($available, $alternatives));
allVenues.forEach(item => {
    const v = item.venue;
    if (!v.latitude || !v.longitude) return;
    const color = item.available ? (rankColors[(item.rank||1)-1] || '#9ca3af') : '#d1d5db';
    const el = document.createElement('div');
    el.style.cssText = `width:28px;height:28px;border-radius:50%;background:${color};color:white;font-weight:700;font-size:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,.25);cursor:pointer;border:2px solid white`;
    el.textContent = item.available ? (item.rank||'—') : '—';
    new mapboxgl.Marker(el).setLngLat([parseFloat(v.longitude), parseFloat(v.latitude)])
        .setPopup(new mapboxgl.Popup({offset:25}).setHTML(
            `<div style="padding:8px"><strong>${v.name}</strong><br><small style="color:#6b7280">₱${Number(item.price).toLocaleString()}/hr · ${v.rating}★</small></div>`
        )).addTo(map);
});
@if(request('user_lat') && request('user_lng'))
const me = document.createElement('div');
me.style.cssText = 'width:14px;height:14px;border-radius:50%;background:#2563eb;border:3px solid white;box-shadow:0 0 0 4px rgba(37,99,235,.2)';
new mapboxgl.Marker(me).setLngLat([{{ request('user_lng') }}, {{ request('user_lat') }}]).addTo(map);
@endif
</script>
@endif

<script>
// Sport selection grid
const sportBtns = document.querySelectorAll('.sport-btn');
const sportVal  = document.getElementById('sport-val');

function selectSport(val) {
    sportBtns.forEach(b => {
        const active = b.dataset.sport === val;
        b.classList.toggle('border-blue-600', active);
        b.classList.toggle('bg-blue-600',     active);
        b.classList.toggle('text-white',      active);
        b.classList.toggle('shadow-sm',       active);
        b.classList.toggle('border-gray-200', !active);
        b.classList.toggle('bg-white',        !active);
        b.classList.toggle('text-gray-500',   !active);
    });
    sportVal.value = val;
    document.getElementById('sport-err').classList.add('hidden');
}

sportBtns.forEach(b => b.addEventListener('click', () => selectSport(b.dataset.sport)));
if (sportVal.value) selectSport(sportVal.value);

// Prevent submit if no sport
document.getElementById('search-form').addEventListener('submit', e => {
    if (!sportVal.value) {
        e.preventDefault();
        document.getElementById('sport-err').classList.remove('hidden');
        document.getElementById('sport-grid').scrollIntoView({ behavior:'smooth', block:'center' });
    }
});

// Geolocation
document.getElementById('locate-btn').addEventListener('click', () => {
    const label = document.getElementById('location-label');
    const btn   = document.getElementById('locate-btn');
    label.textContent = 'Detecting your location…';
    if (!navigator.geolocation) { label.textContent = 'Location not supported by your browser'; return; }
    navigator.geolocation.getCurrentPosition(
        pos => {
            document.getElementById('user-lat').value = pos.coords.latitude;
            document.getElementById('user-lng').value = pos.coords.longitude;
            label.textContent = 'Location detected successfully';
            btn.classList.remove('border-gray-200','bg-gray-50','text-gray-600');
            btn.classList.add('border-green-300','bg-green-50','text-green-700');
        },
        () => { label.textContent = 'Unable to detect location. Please allow access.'; }
    );
});
</script>
@endsection
