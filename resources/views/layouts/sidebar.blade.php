<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — LaroHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 antialiased text-slate-800">
<div class="flex h-screen overflow-hidden">

{{-- ═══════════════════════════════════════
     SIDEBAR — dark, premium
═══════════════════════════════════════ --}}
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col border-r border-white/10 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950
           -translate-x-full lg:translate-x-0 lg:static
           transition-transform duration-300 ease-in-out shrink-0 shadow-2xl shadow-slate-950/30">

    {{-- Logo --}}
    <div class="flex items-center gap-3 h-16 px-5 border-b border-white/10 shrink-0">
        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/20 shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
            </svg>
        </div>
        <div>
            <p class="text-white font-semibold text-sm">Laro<span class="text-blue-300">Hub</span></p>
            <p class="text-slate-400 text-[10px] font-semibold uppercase tracking-[0.28em]">@yield('panel_name','Admin')</p>
        </div>
    </div>

    <div class="mx-3 mt-4 rounded-2xl border border-white/10 bg-white/5 p-3">
        <div class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-400">
            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
            Operations Hub
        </div>
        <p class="mt-2 text-sm font-semibold text-white">Manage bookings professionally</p>
        <p class="mt-1 text-xs text-slate-400">Everything from reservations to user oversight in one place.</p>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        @yield('sidebar_nav')
    </nav>

    {{-- User footer --}}
    <div class="border-t border-white/10 p-3 shrink-0">
        <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-2.5">
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-sm font-bold text-white shadow">
                {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="truncate text-sm font-semibold text-slate-100">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                <p class="text-xs capitalize text-slate-400">{{ auth()->user()->role }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                @csrf
                <button title="Sign out" type="submit"
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition-all hover:bg-red-500/10 hover:text-red-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Mobile overlay --}}
<div id="sb-overlay" onclick="closeSb()" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm hidden lg:hidden"></div>

{{-- ═══════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════ --}}
<div class="flex-1 flex flex-col min-w-0 overflow-hidden">

    {{-- Topbar --}}
    <header class="h-16 border-b border-slate-200/80 bg-white/95 backdrop-blur flex items-center justify-between px-4 sm:px-6 shrink-0 shadow-sm">
        <div class="flex items-center gap-3">
            <button onclick="openSb()" class="lg:hidden w-9 h-9 rounded-xl flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div>
                <h1 class="text-base font-bold text-slate-900 leading-tight">@yield('page_title','Dashboard')</h1>
                @hasSection('page_subtitle')
                <p class="text-xs text-slate-400 leading-tight mt-0.5">@yield('page_subtitle')</p>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 hover:text-blue-600 transition-colors px-3 py-2 rounded-lg hover:bg-blue-50">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Site
            </a>
            <div class="h-6 w-px bg-slate-100"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                </div>
                <div class="hidden sm:block">
                    <p class="text-sm font-semibold text-slate-800 leading-tight">{{ auth()->user()->first_name }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </header>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="mx-4 sm:mx-6 mt-4">
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm shadow-sm">
            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="mx-4 sm:mx-6 mt-4">
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm shadow-sm">
            <svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <main class="flex-1 overflow-y-auto bg-slate-50 p-4 sm:p-6">
        @yield('content')
    </main>
</div>
</div>

<script>
const sb = document.getElementById('sidebar');
const ov = document.getElementById('sb-overlay');
function openSb()  { sb.classList.remove('-translate-x-full'); ov.classList.remove('hidden'); }
function closeSb() { sb.classList.add('-translate-x-full');    ov.classList.add('hidden'); }
</script>
</body>
</html>
