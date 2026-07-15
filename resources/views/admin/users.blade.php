@extends('layouts.sidebar')
@section('title','Users')
@section('panel_name','Admin Panel')
@section('page_title','User Management')
@section('page_subtitle','All registered accounts — renters, cashiers, and admins')

@section('sidebar_nav')
<p class="sidebar-section">Main</p>
<a href="{{ route('admin.dashboard') }}" class="sidebar-link">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>
<p class="sidebar-section">Reservations</p>
<a href="{{ route('admin.reservations') }}" class="sidebar-link">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    All Reservations
</a>
<p class="sidebar-section">Management</p>
<a href="{{ route('admin.users') }}" class="sidebar-link active">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    Users
</a>
<a href="{{ route('venues') }}" target="_blank" class="sidebar-link">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    Venues
</a>
@endsection

@section('content')

{{-- Role summary pills --}}
<div class="flex flex-wrap gap-3 mb-5">
    @php
        $totalUsers   = $users->total();
        $roleColors   = ['admin'=>'red','staff'=>'emerald','renter'=>'blue'];
    @endphp
    @foreach(['admin'=>'Admin','staff'=>'Cashier / Staff','renter'=>'Renter'] as $role => $label)
    <div class="flex items-center gap-2 border border-slate-200/80 bg-white shadow-sm rounded-full px-4 py-2">
        <span class="w-2 h-2 rounded-full bg-{{ $roleColors[$role] }}-500"></span>
        <span class="text-xs font-semibold text-slate-700">{{ $label }}</span>
        <span class="text-xs text-slate-400 font-medium">
            {{ \App\Models\User::where('role',$role)->count() }}
        </span>
    </div>
    @endforeach
</div>

<div class="panel-card overflow-hidden">
    {{-- Table header --}}
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <h2 class="text-sm font-bold text-slate-900">All Users</h2>
        <span class="text-xs text-slate-400">{{ $users->total() }} total accounts</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <th class="px-5 py-3.5 text-left">User</th>
                    <th class="px-5 py-3.5 text-left">Email</th>
                    <th class="px-5 py-3.5 text-left">Contact</th>
                    <th class="px-5 py-3.5 text-left">Role</th>
                    <th class="px-5 py-3.5 text-left">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $u)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold shrink-0 shadow-sm
                                @if($u->role==='admin') bg-red-100 text-red-600
                                @elseif($u->role==='staff') bg-emerald-100 text-emerald-600
                                @else bg-blue-100 text-blue-600 @endif">
                                {{ strtoupper(substr($u->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $u->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-sm text-slate-500">{{ $u->email }}</td>
                    <td class="px-5 py-3.5 text-sm text-slate-500">{{ $u->contact ?? '—' }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                            @if($u->role==='admin')  bg-red-100   text-red-700
                            @elseif($u->role==='staff') bg-emerald-100 text-emerald-700
                            @else bg-blue-100 text-blue-700 @endif">
                            <span class="w-1.5 h-1.5 rounded-full
                                @if($u->role==='admin') bg-red-500
                                @elseif($u->role==='staff') bg-emerald-500
                                @else bg-blue-500 @endif"></span>
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-sm text-slate-400">{{ $u->created_at->format('M j, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-50 bg-slate-50/50">{{ $users->links() }}</div>
</div>
@endsection
