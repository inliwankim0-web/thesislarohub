@extends('layouts.app')
@section('title', 'LaroHub — Sports Facility Booking Davao City')
@section('content')

{{-- Hero --}}
<section class="relative bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700 overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <svg viewBox="0 0 800 600" class="w-full h-full" preserveAspectRatio="xMidYMid slice">
            <defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
    </div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3 blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-white text-sm font-medium mb-6">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                6 Sports Centers in Davao City
            </div>
            <h1 class="text-4xl lg:text-6xl font-bold text-white leading-tight mb-6">
                Reserve Your Court<br><span class="text-yellow-300">in Minutes</span>
            </h1>
            <p class="text-blue-100 text-lg mb-8 leading-relaxed">
                Find and book basketball courts, badminton, volleyball, tennis, pickleball, and gym facilities across Davao City's top sports centers.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('recommend') }}" class="btn-accent">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    Find a Court
                </a>
                <a href="{{ route('venues') }}" class="btn-secondary !bg-white/10 !border-white/20 !text-white hover:!bg-white/20">
                    Explore Venues
                </a>
            </div>
            <div class="mt-10 flex items-center gap-8">
                <div><p class="text-3xl font-bold text-white">6</p><p class="text-blue-200 text-sm mt-0.5">Sports Centers</p></div>
                <div class="w-px h-8 bg-white/20"></div>
                <div><p class="text-3xl font-bold text-white">5+</p><p class="text-blue-200 text-sm mt-0.5">Sports Available</p></div>
                <div class="w-px h-8 bg-white/20"></div>
                <div><p class="text-3xl font-bold text-white">24/7</p><p class="text-blue-200 text-sm mt-0.5">Online Booking</p></div>
            </div>
        </div>
    </div>
</section>

{{-- Venues --}}
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-end justify-between mb-10">
        <div>
            <p class="text-blue-600 text-sm font-semibold uppercase tracking-wider mb-1">Featured</p>
            <h2 class="text-3xl font-bold text-gray-900">Sports Centers</h2>
            <p class="text-gray-500 mt-1.5 text-sm">Premier facilities across Davao City</p>
        </div>
        <a href="{{ route('venues') }}" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
            View all
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
        $venueCards = [
            ['name'=>'Homecourt',         'sports'=>'Basketball · Badminton · Gym',     'from'=>'₱200', 'gradient'=>'from-orange-500 to-red-600',    'sport_key'=>'Basketball'],
            ['name'=>'Playsite',          'sports'=>'Basketball · Volleyball · Badminton','from'=>'₱150','gradient'=>'from-cyan-500 to-blue-600',    'sport_key'=>'Basketball'],
            ['name'=>'Recreation Center', 'sports'=>'Basketball',                         'from'=>'₱600', 'gradient'=>'from-emerald-500 to-green-700','sport_key'=>'Basketball'],
            ['name'=>'Aqua Verde',        'sports'=>'Basketball · Tennis · Volleyball',   'from'=>'₱450', 'gradient'=>'from-teal-500 to-cyan-700',   'sport_key'=>'Tennis'],
            ['name'=>'Southside',         'sports'=>'Pickleball · 8 Courts',              'from'=>'₱350', 'gradient'=>'from-violet-500 to-purple-700','sport_key'=>'Pickleball'],
            ['name'=>'Wheels N More',     'sports'=>'Badminton · 6 Courts',               'from'=>'₱180', 'gradient'=>'from-rose-500 to-pink-700',   'sport_key'=>'Badminton'],
        ];
        @endphp

        @foreach($venueCards as $vc)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 group">
            <div class="h-44 bg-gradient-to-br {{ $vc['gradient'] }} relative flex items-center justify-center overflow-hidden">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors"></div>
                <svg class="w-20 h-20 text-white/20 group-hover:text-white/30 transition-colors" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="absolute top-3 left-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-white/20 text-white text-xs font-medium backdrop-blur-sm">{{ $vc['sports'] }}</span>
                </div>
                <div class="absolute top-3 right-3">
                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-500 text-white text-xs font-semibold">Open</span>
                </div>
            </div>
            <div class="p-5">
                <h3 class="text-base font-bold text-gray-900 mb-1">{{ $vc['name'] }}</h3>
                <div class="flex items-center gap-1.5 text-gray-400 text-xs mb-4">
                    <svg class="w-3.5 h-3.5 text-blue-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    Davao City, Davao del Sur
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400">Starting at</p>
                        <p class="text-blue-600 font-bold text-lg">{{ $vc['from'] }}<span class="text-xs text-gray-400 font-normal">/hr</span></p>
                    </div>
                    <a href="{{ route('venues') }}" class="btn-primary !py-2 !px-4 !text-xs">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- How it works --}}
<section class="bg-gray-900 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-blue-400 text-sm font-semibold uppercase tracking-wider mb-3">Simple Process</p>
            <h2 class="text-3xl font-bold text-white mb-3">How It Works</h2>
            <p class="text-gray-500 text-sm max-w-sm mx-auto">Reserve your court in three easy steps</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'step' => '01', 'title' => 'Find a Court', 'desc' => 'Search by sport, date, and time. Our smart engine ranks venues by rating, price, and proximity.'],
                ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'step' => '02', 'title' => 'Pick a Schedule', 'desc' => 'Choose your preferred date and time slot. Live availability updates so you always book a free court.'],
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'step' => '03', 'title' => 'Confirm & Play', 'desc' => 'Submit your booking and get a reference code. Pay via GCash or cash on site.'],
            ] as $step)
            <div class="text-center group">
                <div class="w-14 h-14 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center mx-auto mb-5 group-hover:bg-blue-600/20 group-hover:border-blue-500/40 transition-all duration-300">
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/></svg>
                </div>
                <p class="text-xs font-bold text-gray-600 tracking-widest mb-2">{{ $step['step'] }}</p>
                <h3 class="text-lg font-bold text-white mb-2">{{ $step['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('register') }}" class="btn-accent">
                Get Started — It's Free
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-white border-b border-gray-100">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-3">Ready to play?</h2>
        <p class="text-gray-500 mb-8">Join hundreds of Dabawenyo athletes who book through LaroHub every week.</p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('register') }}" class="btn-primary">Create Free Account</a>
            <a href="{{ route('venues') }}" class="btn-secondary">Browse Venues</a>
        </div>
    </div>
</section>

@endsection
