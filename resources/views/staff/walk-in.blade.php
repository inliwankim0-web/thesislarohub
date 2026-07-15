@extends('layouts.sidebar')
@section('title','Walk-in Reservation')
@section('panel_name','Cashier Panel')
@section('page_title','New Walk-in Reservation')
@section('page_subtitle', $venue->name . ' — Booking will be auto-confirmed and marked as paid')

@section('sidebar_nav')
<p class="sidebar-section">Cashier</p>
<a href="{{ route('staff.dashboard') }}" class="sidebar-link">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>
<p class="sidebar-section">Actions</p>
<a href="{{ route('staff.walk-in') }}" class="sidebar-link active">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    New Walk-in
</a>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        {{-- Card header --}}
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5 flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
                <p class="text-white font-bold text-sm">Walk-in Booking</p>
                <p class="text-emerald-100 text-xs mt-0.5">Auto-confirmed · Marked as paid</p>
            </div>
        </div>

        <form action="{{ route('staff.walk-in.store') }}" method="POST">
            @csrf

            {{-- Guest info --}}
            <div class="px-6 pt-6 pb-5">
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-4">Guest Information</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="label">First Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Juan"
                                class="input-field pl-10 @error('first_name') ring-2 ring-red-300 @enderror" required>
                        </div>
                        @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Last Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Dela Cruz" class="input-field pl-10" required>
                        </div>
                    </div>
                    <div>
                        <label class="label">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="juan@email.com" class="input-field pl-10" required>
                        </div>
                    </div>
                    <div>
                        <label class="label">Contact Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="tel" name="contact" value="{{ old('contact') }}" placeholder="09XX XXX XXXX" class="input-field pl-10" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 mx-6"></div>

            {{-- Booking details --}}
            <div class="px-6 pt-5 pb-5">
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-4">Booking Details</p>
                <div class="space-y-4">
                    <div>
                        <label class="label">Facility</label>
                        <select name="facility_id" class="input-field @error('facility_id') ring-2 ring-red-300 @enderror" required>
                            <option value="">Select a facility</option>
                            @foreach($venue->facilities->where('is_active',true)->where('rate_type','hourly') as $f)
                            <option value="{{ $f->id }}" {{ old('facility_id')==$f->id?'selected':'' }}>
                                {{ $f->label }} — ₱{{ number_format($f->price_per_hour,0) }}/hr
                            </option>
                            @endforeach
                        </select>
                        @error('facility_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="label">Date</label>
                            <input type="date" name="date" value="{{ old('date',date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" class="input-field" required>
                        </div>
                        <div>
                            <label class="label">Start Time</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" class="input-field" required>
                        </div>
                        <div>
                            <label class="label">Duration</label>
                            <select name="duration" class="input-field" required>
                                @foreach([1,2,3,4,5,6] as $h)
                                <option value="{{ $h }}" {{ old('duration')==$h?'selected':'' }}>{{ $h }}h</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="label">Payment Method</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach(['cash'=>'Cash on Site','gcash'=>'GCash'] as $val=>$lbl)
                            <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 cursor-pointer transition-all
                                {{ old('payment_method')==$val ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-slate-300' }}">
                                <input type="radio" name="payment_method" value="{{ $val }}" class="text-blue-600"
                                    {{ old('payment_method',$val=='cash'?'cash':'') ==$val?'checked':'' }}>
                                <span class="text-sm font-semibold text-slate-700">{{ $lbl }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="label">Notes <span class="text-slate-400 font-normal text-xs">(optional)</span></label>
                        <textarea name="notes" rows="2" placeholder="Any special notes..." class="input-field resize-none">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 pb-6 flex gap-3">
                <button type="submit" class="btn-primary flex-1 !py-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Save Walk-in Reservation
                </button>
                <a href="{{ route('staff.dashboard') }}" class="btn-secondary !py-3">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
