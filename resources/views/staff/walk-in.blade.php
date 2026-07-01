@extends('layouts.app')
@section('title', 'Walk-in Reservation — LaroHub')
@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-2 text-gray-400 text-sm mb-3">
            <a href="{{ route('staff.dashboard') }}" class="hover:text-gray-600 transition-colors">Dashboard</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-700 font-medium">Walk-in Reservation</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Record Walk-in</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $venue->name }}</p>
    </div>
</div>

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-8 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
                <p class="font-bold text-gray-900 text-sm">Walk-in Booking</p>
                <p class="text-xs text-gray-400">Booking will be automatically confirmed</p>
            </div>
        </div>

        <form action="{{ route('staff.walk-in.store') }}" method="POST" class="divide-y divide-gray-50">
            @csrf
            <div class="px-8 py-6">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Guest Information</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="label">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="input-field @error('first_name') ring-2 ring-red-300 @enderror" placeholder="Juan" required>
                        @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="input-field" placeholder="Dela Cruz" required>
                    </div>
                    <div>
                        <label class="label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input-field @error('email') ring-2 ring-red-300 @enderror" placeholder="juan@email.com" required>
                    </div>
                    <div>
                        <label class="label">Contact Number</label>
                        <input type="tel" name="contact" value="{{ old('contact') }}" class="input-field" placeholder="09XX XXX XXXX" required>
                    </div>
                </div>
            </div>

            <div class="px-8 py-6">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Booking Details</p>
                <div class="space-y-4">
                    <div>
                        <label class="label">Facility</label>
                        <select name="facility_id" class="input-field @error('facility_id') ring-2 ring-red-300 @enderror" required>
                            <option value="">Select a facility</option>
                            @foreach($venue->facilities->where('is_active', true)->where('rate_type','hourly') as $f)
                            <option value="{{ $f->id }}" {{ old('facility_id') == $f->id ? 'selected' : '' }}>
                                {{ $f->label }} — ₱{{ number_format($f->price_per_hour, 0) }}/hr
                            </option>
                            @endforeach
                        </select>
                        @error('facility_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="label">Date</label>
                            <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" class="input-field" required>
                        </div>
                        <div>
                            <label class="label">Start Time</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" class="input-field" required>
                        </div>
                        <div>
                            <label class="label">Duration</label>
                            <select name="duration" class="input-field" required>
                                @foreach([1,2,3,4,5,6] as $h)
                                <option value="{{ $h }}" {{ old('duration') == $h ? 'selected' : '' }}>{{ $h }}hr</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="label">Payment Method</label>
                        <select name="payment_method" class="input-field" required>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Notes <span class="text-gray-400 font-normal text-xs">(optional)</span></label>
                        <textarea name="notes" rows="2" class="input-field resize-none" placeholder="Any notes...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="px-8 py-5 bg-gray-50 flex gap-3">
                <button type="submit" class="btn-primary flex-1">Save Walk-in</button>
                <a href="{{ route('staff.dashboard') }}" class="btn-secondary flex-1 text-center">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
