<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LaroHub') — Sports Facility Booking Davao City</title>
    <meta name="description" content="Book basketball, badminton, volleyball, tennis, pickleball and gym facilities in Davao City.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-gray-50 antialiased">

{{-- Navigation --}}
<nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                </div>
                <span class="text-lg font-bold text-gray-900 tracking-tight">Laro<span class="text-blue-600">Hub</span></span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">Home</a>
                <a href="{{ route('venues') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('venues') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">Venues</a>
                <a href="{{ route('recommend') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('recommend') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    Find a Court
                </a>
                <a href="{{ route('book') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('book') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">Book Now</a>
            </div>

            {{-- Auth --}}
            <div class="hidden md:flex items-center gap-2">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">Admin Panel</a>
                    @elseif(auth()->user()->isStaff())
                        <a href="{{ route('staff.dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">Staff Panel</a>
                    @else
                        <a href="{{ route('renter.dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">My Bookings</a>
                    @endif
                    <div class="flex items-center gap-2 pl-2 border-l border-gray-100">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ auth()->user()->first_name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-xs text-gray-400 hover:text-red-500 transition-colors px-1">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition-colors">Sign in</a>
                    <a href="{{ route('register') }}" class="btn-primary !py-2 !px-4 !text-sm">Get Started</a>
                @endauth
            </div>

            {{-- Mobile toggle --}}
            <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Home</a>
            <a href="{{ route('venues') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Venues</a>
            <a href="{{ route('recommend') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Find a Court</a>
            <a href="{{ route('book') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Book Now</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Admin Panel</a>
                @elseif(auth()->user()->isStaff())
                    <a href="{{ route('staff.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Staff Panel</a>
                @else
                    <a href="{{ route('renter.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">My Bookings</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="pt-1">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50">Sign out</button>
                </form>
            @else
                <div class="pt-2 flex gap-2">
                    <a href="{{ route('login') }}" class="flex-1 btn-secondary !py-2 !text-sm text-center">Sign in</a>
                    <a href="{{ route('register') }}" class="flex-1 btn-primary !py-2 !text-sm text-center">Get Started</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
<div class="bg-green-50 border-b border-green-100">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-3 text-sm text-green-800">
        <svg class="w-4 h-4 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
</div>
@endif
@if(session('error'))
<div class="bg-red-50 border-b border-red-100">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-3 text-sm text-red-800">
        <svg class="w-4 h-4 text-red-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        {{ session('error') }}
    </div>
</div>
@endif

<main class="flex-1">@yield('content')</main>

{{-- Footer --}}
<footer class="bg-gray-900 text-gray-400 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                    </div>
                    <span class="text-lg font-bold text-white">Laro<span class="text-blue-400">Hub</span></span>
                </div>
                <p class="text-sm leading-relaxed max-w-xs text-gray-500">Sports facility booking platform for Davao City. Find and reserve courts in seconds.</p>
            </div>
            <div>
                <p class="text-white text-sm font-semibold mb-3">Platform</p>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('venues') }}" class="hover:text-white transition-colors">All Venues</a></li>
                    <li><a href="{{ route('recommend') }}" class="hover:text-white transition-colors">Find a Court</a></li>
                    <li><a href="{{ route('book') }}" class="hover:text-white transition-colors">Book Now</a></li>
                </ul>
            </div>
            <div>
                <p class="text-white text-sm font-semibold mb-3">Sports</p>
                <ul class="space-y-2 text-sm">
                    <li>Basketball</li><li>Badminton</li><li>Volleyball</li>
                    <li>Tennis</li><li>Pickleball</li><li>Gym</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-600">
            <p>&copy; {{ date('Y') }} LaroHub. All rights reserved.</p>
            <p>Davao City, Philippines</p>
        </div>
    </div>
</footer>

<script>
document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>
</body>
</html>
