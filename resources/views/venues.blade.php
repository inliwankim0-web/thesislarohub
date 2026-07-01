@extends('layouts.app')
@section('title', 'Venues — LaroHub')
@section('content')

<section class="bg-gradient-to-r from-blue-700 to-indigo-700 py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-blue-200 text-sm mb-3">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white">Venues</span>
        </div>
        <h1 class="text-4xl font-bold text-white mb-3">All Sports Venues</h1>
        <p class="text-blue-100 text-lg max-w-2xl">Explore all 6 sports centers in Davao City with detailed pricing, facilities, and availability.</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

{{-- Venue Tabs --}}
<div class="flex gap-2 overflow-x-auto pb-2 mb-8 scrollbar-hide">
    @foreach([
        ['id'=>'homecourt','label'=>'Homecourt','svg'=>'<circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/>'],
        ['id'=>'playsite','label'=>'Playsite','svg'=>'<circle cx="12" cy="12" r="10"/><path d="M12 2C6.5 2 2 6.5 2 12M12 22c5.5 0 10-4.5 10-10M7 3.6C5 6 4 9 4 12M17 20.4c2-2.4 3-5.4 3-8.4"/>'],
        ['id'=>'recreation','label'=>'Recreation Center','svg'=>'<circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/>'],
        ['id'=>'aquaverde','label'=>'Aqua Verde','svg'=>'<circle cx="12" cy="12" r="10"/><path d="M18.4 6a6 6 0 010 12M5.6 6a6 6 0 000 12"/>'],
        ['id'=>'southside','label'=>'Southside','svg'=>'<ellipse cx="12" cy="9" rx="7" ry="8"/><path stroke-linecap="round" stroke-width="2" d="M12 17v5"/>'],
        ['id'=>'wheelsnmore','label'=>'Wheels N More','svg'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l-6 6M15 3a6 6 0 016 6 6 6 0 01-6 6 6 6 0 01-6-6 6 6 0 016-6z"/>'],
    ] as $v)
    <button data-tab="{{ $v['id'] }}"
        class="flex-shrink-0 flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold border-2 border-transparent text-gray-500 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $v['svg'] !!}</svg>
        {{ $v['label'] }}
    </button>
    @endforeach
</div>

{{-- HOMECOURT --}}
<div data-tab-content="homecourt" id="homecourt">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="h-3 bg-gradient-to-r from-orange-400 to-red-500"></div>
        <div class="p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-start gap-6 mb-8">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/></svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Homecourt</h2>
                            <div class="flex items-center gap-2 text-gray-500 text-sm mt-1">
                                <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Davao City, Davao del Sur
                            </div>
                        </div>
                        <a href="{{ route('book', ['venue' => 'Homecourt']) }}" class="btn-primary">Book This Venue</a>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="badge bg-orange-100 text-orange-700">Basketball</span>
                        <span class="badge bg-yellow-100 text-yellow-700">Badminton</span>
                        <span class="badge bg-red-100 text-red-700">Gym</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-orange-50 rounded-xl p-5 border border-orange-100">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/></svg>
                        <h3 class="font-bold text-gray-900">Basketball Court</h3>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center py-2 border-b border-orange-100"><span class="text-sm text-gray-600">Daytime rate</span><span class="font-bold text-gray-900">₱1,200/hr</span></div>
                        <div class="flex justify-between items-center py-2"><span class="text-sm text-gray-600">5PM–12AM (with lights)</span><span class="font-bold text-gray-900">₱1,900/hr</span></div>
                    </div>
                    <a href="{{ route('book', ['venue'=>'Homecourt','facility'=>'Basketball']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
                <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l-6 6M15 3a6 6 0 016 6 6 6 0 01-6 6 6 6 0 01-6-6 6 6 0 016-6z"/></svg>
                        <h3 class="font-bold text-gray-900">Badminton Court</h3>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center py-2 border-b border-yellow-100"><span class="text-sm text-gray-600">Daytime</span><span class="font-bold text-gray-900">₱200/hr</span></div>
                        <div class="flex justify-between items-center py-2"><span class="text-sm text-gray-600">Night time</span><span class="font-bold text-gray-900">₱250/hr</span></div>
                    </div>
                    <a href="{{ route('book', ['venue'=>'Homecourt','facility'=>'Badminton']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
                <div class="bg-red-50 rounded-xl p-5 border border-red-100">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5v14M18 5v14M3 8h3M18 8h3M3 16h3M18 16h3M6 12h12"/></svg>
                        <h3 class="font-bold text-gray-900">Gym Membership</h3>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center py-2 border-b border-red-100"><span class="text-sm text-gray-600">Regular monthly</span><span class="font-bold text-gray-900">₱1,500/mo</span></div>
                        <div class="flex justify-between items-center py-2 border-b border-red-100"><span class="text-sm text-gray-600">Student rate</span><span class="font-bold text-gray-900">₱1,200/mo</span></div>
                        <div class="flex justify-between items-center py-2 border-b border-red-100"><span class="text-sm text-gray-600">Group (5 pax)</span><span class="font-bold text-gray-900">₱1,200/mo</span></div>
                        <div class="flex justify-between items-center py-2"><span class="text-sm text-gray-600">w/ Group Class</span><span class="font-bold text-gray-900">₱2,200/mo</span></div>
                    </div>
                    <a href="{{ route('book', ['venue'=>'Homecourt','facility'=>'Gym']) }}" class="btn-primary w-full mt-4 !py-2 !text-sm">Get Membership</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- PLAYSITE --}}
<div data-tab-content="playsite" id="playsite" class="hidden">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="h-3 bg-gradient-to-r from-blue-400 to-cyan-500"></div>
        <div class="p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-start gap-6 mb-8">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2C6.5 2 2 6.5 2 12M12 22c5.5 0 10-4.5 10-10M7 3.6C5 6 4 9 4 12M17 20.4c2-2.4 3-5.4 3-8.4"/></svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Playsite</h2>
                            <div class="flex items-center gap-2 text-gray-500 text-sm mt-1">
                                <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Davao City, Davao del Sur
                            </div>
                        </div>
                        <a href="{{ route('book', ['venue' => 'Playsite']) }}" class="btn-primary">Book This Venue</a>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="badge bg-orange-100 text-orange-700">Basketball</span>
                        <span class="badge bg-blue-100 text-blue-700">Volleyball</span>
                        <span class="badge bg-yellow-100 text-yellow-700">Badminton</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-orange-50 rounded-xl p-5 border border-orange-100">
                    <div class="flex items-center gap-2 mb-4"><svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/></svg><h3 class="font-bold text-gray-900">Basketball</h3></div>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center py-2 border-b border-orange-100"><span class="text-sm text-gray-600">With lights</span><span class="font-bold text-gray-900">₱1,200/hr</span></div>
                        <div class="flex justify-between items-center py-2"><span class="text-sm text-gray-600">Without lights</span><span class="font-bold text-gray-900">₱800/hr</span></div>
                    </div>
                    <a href="{{ route('book', ['venue'=>'Playsite','facility'=>'Basketball']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
                <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                    <div class="flex items-center gap-2 mb-4"><svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2C6.5 2 2 6.5 2 12M12 22c5.5 0 10-4.5 10-10M7 3.6C5 6 4 9 4 12M17 20.4c2-2.4 3-5.4 3-8.4"/></svg><h3 class="font-bold text-gray-900">Volleyball</h3></div>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center py-2 border-b border-blue-100"><span class="text-sm text-gray-600">With lights</span><span class="font-bold text-gray-900">₱500/hr</span></div>
                        <div class="flex justify-between items-center py-2"><span class="text-sm text-gray-600">Without lights</span><span class="font-bold text-gray-900">₱450/hr</span></div>
                    </div>
                    <a href="{{ route('book', ['venue'=>'Playsite','facility'=>'Volleyball']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
                <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100">
                    <div class="flex items-center gap-2 mb-4"><svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l-6 6M15 3a6 6 0 016 6 6 6 0 01-6 6 6 6 0 01-6-6 6 6 0 016-6z"/></svg><h3 class="font-bold text-gray-900">Badminton</h3></div>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center py-2 border-b border-yellow-100"><span class="text-sm text-gray-600">With lights</span><span class="font-bold text-gray-900">₱200/hr</span></div>
                        <div class="flex justify-between items-center py-2"><span class="text-sm text-gray-600">Without lights</span><span class="font-bold text-gray-900">₱150/hr</span></div>
                    </div>
                    <a href="{{ route('book', ['venue'=>'Playsite','facility'=>'Badminton']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- RECREATION CENTER --}}
<div data-tab-content="recreation" id="recreation" class="hidden">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="h-3 bg-gradient-to-r from-green-500 to-emerald-600"></div>
        <div class="p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-start gap-6 mb-8">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/></svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Recreation Center</h2>
                            <div class="flex items-center gap-2 text-gray-500 text-sm mt-1">
                                <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Davao City, Davao del Sur
                            </div>
                        </div>
                        <a href="{{ route('book', ['venue' => 'Recreation Center']) }}" class="btn-primary">Book This Venue</a>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4"><span class="badge bg-orange-100 text-orange-700">Basketball</span></div>
                </div>
            </div>
            <div class="max-w-sm">
                <div class="bg-green-50 rounded-xl p-5 border border-green-100">
                    <div class="flex items-center gap-2 mb-4"><svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/></svg><h3 class="font-bold text-gray-900">Basketball Court</h3></div>
                    <div class="flex justify-between items-center py-2 border-b border-green-100"><span class="text-sm text-gray-600">Per hour</span><span class="font-bold text-gray-900">₱600/hr</span></div>
                    <a href="{{ route('book', ['venue'=>'Recreation Center','facility'=>'Basketball']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- AQUA VERDE --}}
<div data-tab-content="aquaverde" id="aquaverde" class="hidden">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="h-3 bg-gradient-to-r from-teal-400 to-cyan-600"></div>
        <div class="p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-start gap-6 mb-8">
                <div class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M18.4 6a6 6 0 010 12M5.6 6a6 6 0 000 12"/></svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Aqua Verde</h2>
                            <div class="flex items-center gap-2 text-gray-500 text-sm mt-1">
                                <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Davao City, Davao del Sur
                            </div>
                        </div>
                        <a href="{{ route('book', ['venue' => 'Aqua Verde']) }}" class="btn-primary">Book This Venue</a>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="badge bg-orange-100 text-orange-700">Basketball</span>
                        <span class="badge bg-green-100 text-green-700">Tennis</span>
                        <span class="badge bg-blue-100 text-blue-700">Volleyball</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-orange-50 rounded-xl p-5 border border-orange-100">
                    <div class="flex items-center gap-2 mb-4"><svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/></svg><h3 class="font-bold text-gray-900">Basketball</h3></div>
                    <div class="flex justify-between items-center py-2 border-b border-orange-100"><span class="text-sm text-gray-600">Per hour</span><span class="font-bold text-gray-900">₱750/hr</span></div>
                    <a href="{{ route('book', ['venue'=>'Aqua Verde','facility'=>'Basketball']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
                <div class="bg-green-50 rounded-xl p-5 border border-green-100">
                    <div class="flex items-center gap-2 mb-4"><svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M18.4 6a6 6 0 010 12M5.6 6a6 6 0 000 12"/></svg><h3 class="font-bold text-gray-900">Tennis</h3></div>
                    <div class="flex justify-between items-center py-2 border-b border-green-100"><span class="text-sm text-gray-600">Per hour</span><span class="font-bold text-gray-900">₱450/hr</span></div>
                    <a href="{{ route('book', ['venue'=>'Aqua Verde','facility'=>'Tennis']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
                <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                    <div class="flex items-center gap-2 mb-4"><svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2C6.5 2 2 6.5 2 12M12 22c5.5 0 10-4.5 10-10M7 3.6C5 6 4 9 4 12M17 20.4c2-2.4 3-5.4 3-8.4"/></svg><h3 class="font-bold text-gray-900">Volleyball</h3></div>
                    <div class="flex justify-between items-center py-2 border-b border-blue-100"><span class="text-sm text-gray-600">Per hour</span><span class="font-bold text-gray-900">₱500/hr</span></div>
                    <a href="{{ route('book', ['venue'=>'Aqua Verde','facility'=>'Volleyball']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SOUTHSIDE --}}
<div data-tab-content="southside" id="southside" class="hidden">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="h-3 bg-gradient-to-r from-purple-500 to-violet-600"></div>
        <div class="p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-start gap-6 mb-8">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><ellipse cx="12" cy="9" rx="7" ry="8"/><path stroke-linecap="round" stroke-width="2" d="M12 17v5"/></svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Southside</h2>
                            <div class="flex items-center gap-2 text-gray-500 text-sm mt-1">
                                <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Davao City, Davao del Sur
                            </div>
                        </div>
                        <a href="{{ route('book', ['venue' => 'Southside']) }}" class="btn-primary">Book This Venue</a>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="badge bg-purple-100 text-purple-700">Pickleball</span>
                        <span class="badge bg-indigo-100 text-indigo-700">8 Courts Available</span>
                    </div>
                </div>
            </div>
            <div class="max-w-sm">
                <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
                    <div class="flex items-center gap-2 mb-4"><svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><ellipse cx="12" cy="9" rx="7" ry="8"/><path stroke-linecap="round" stroke-width="2" d="M12 17v5"/></svg><h3 class="font-bold text-gray-900">Pickleball Courts</h3></div>
                    <p class="text-sm text-gray-500 mb-4">8 courts available for reservation</p>
                    <div class="flex justify-between items-center py-2 border-b border-purple-100"><span class="text-sm text-gray-600">Per hour (any time)</span><span class="font-bold text-gray-900">₱350/hr</span></div>
                    <a href="{{ route('book', ['venue'=>'Southside','facility'=>'Pickleball']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- WHEELS N MORE --}}
<div data-tab-content="wheelsnmore" id="wheelsnmore" class="hidden">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="h-3 bg-gradient-to-r from-pink-400 to-rose-500"></div>
        <div class="p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row lg:items-start gap-6 mb-8">
                <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l-6 6M15 3a6 6 0 016 6 6 6 0 01-6 6 6 6 0 01-6-6 6 6 0 016-6z"/></svg>
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Wheels N More</h2>
                            <div class="flex items-center gap-2 text-gray-500 text-sm mt-1">
                                <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Davao City, Davao del Sur
                            </div>
                        </div>
                        <a href="{{ route('book', ['venue' => 'Wheels N More']) }}" class="btn-primary">Book This Venue</a>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="badge bg-pink-100 text-pink-700">Badminton</span>
                        <span class="badge bg-rose-100 text-rose-700">6 Courts Available</span>
                    </div>
                </div>
            </div>
            <div class="max-w-sm">
                <div class="bg-pink-50 rounded-xl p-5 border border-pink-100">
                    <div class="flex items-center gap-2 mb-4"><svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l-6 6M15 3a6 6 0 016 6 6 6 0 01-6 6 6 6 0 01-6-6 6 6 0 016-6z"/></svg><h3 class="font-bold text-gray-900">Badminton Courts</h3></div>
                    <p class="text-sm text-gray-500 mb-4">6 courts available for reservation</p>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center py-2 border-b border-pink-100"><span class="text-sm text-gray-600">7AM – 4PM</span><span class="font-bold text-gray-900">₱180/hr</span></div>
                        <div class="flex justify-between items-center py-2"><span class="text-sm text-gray-600">4PM – 10PM</span><span class="font-bold text-gray-900">₱250/hr</span></div>
                    </div>
                    <a href="{{ route('book', ['venue'=>'Wheels N More','facility'=>'Badminton']) }}" class="btn-accent w-full mt-4 !py-2 !text-sm">Reserve Court</a>
                </div>
            </div>
        </div>
    </div>
</div>

</div>{{-- end max-w-7xl --}}
@endsection
