@extends('layouts.app')
@section('title', 'Users — LaroHub Admin')
@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-2 text-gray-400 text-sm mb-3">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-600 transition-colors">Dashboard</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-700 font-medium">Users</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">All Users</h1>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5 text-left font-semibold">Name</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Email</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Contact</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Role</th>
                        <th class="px-5 py-3.5 text-left font-semibold">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $u)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($u->first_name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-900 text-sm">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $u->email }}</td>
                        <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $u->contact ?? '—' }}</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                @if($u->role==='admin') bg-red-100 text-red-700
                                @elseif($u->role==='staff') bg-green-100 text-green-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $u->created_at->format('M j, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-50">{{ $users->links() }}</div>
    </div>
</div>
@endsection
