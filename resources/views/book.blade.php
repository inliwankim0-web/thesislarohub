@extends('layouts.app')
@section('title', 'Book a Facility — LaroHub')
@section('content')

<section class="bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="flex items-center gap-2 text-slate-300 text-sm mb-4">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white font-medium">Book a Facility</span>
        </div>
        <div class="max-w-2xl">
            <h1 class="text-3xl sm:text-4xl font-black text-white mb-3">Book your next session in minutes</h1>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">Reserve a court, select the right facility, and confirm your booking with a clean, professional flow designed for fast action.</p>
        </div>
    </div>
</section>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if(session('booking_success'))
    <div class="bg-green-50 border border-green-200 rounded-2xl p-5 mb-8 flex items-start gap-4">
        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <p class="font-semibold text-green-900">Booking Submitted</p>
            <p class="text-green-700 text-sm mt-0.5">Your reservation has been received. We'll confirm it shortly.</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-[28px] border border-slate-200 shadow-[0_20px_60px_-20px_rgba(15,23,42,0.25)] overflow-hidden">
        {{-- Form header --}}
        <div class="px-6 sm:px-8 py-6 border-b border-slate-100 bg-slate-50/70 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="font-bold text-gray-900">Facility Booking Form</p>
                    <p class="text-xs text-gray-500">All fields marked with * are required</p>
                </div>
            </div>
            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Fast confirmation
            </div>
        </div>

        <form action="{{ route('book.submit') }}" method="POST" class="divide-y divide-gray-50">
            @csrf

            {{-- Step 1: Personal Info --}}
            <div class="px-6 sm:px-8 py-7">
                <div class="flex items-center gap-2.5 mb-6">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">1</div>
                    <h2 class="font-bold text-gray-900">Your Information</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="label">First Name <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="first_name" value="{{ old('first_name', auth()->user()?->first_name) }}" placeholder="Juan" class="input-field pl-10 @error('first_name') ring-2 ring-red-300 @enderror" required>
                        </div>
                        @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Last Name <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="last_name" value="{{ old('last_name', auth()->user()?->last_name) }}" placeholder="Dela Cruz" class="input-field pl-10 @error('last_name') ring-2 ring-red-300 @enderror" required>
                        </div>
                        @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Email Address <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" placeholder="juan@email.com" class="input-field pl-10 @error('email') ring-2 ring-red-300 @enderror" required>
                        </div>
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Contact Number <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="tel" name="contact" value="{{ old('contact', auth()->user()?->contact) }}" placeholder="09XX XXX XXXX" class="input-field pl-10 @error('contact') ring-2 ring-red-300 @enderror" required>
                        </div>
                        @error('contact')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Step 2: Venue & Facility --}}
            <div class="px-6 sm:px-8 py-7">
                <div class="flex items-center gap-2.5 mb-6">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">2</div>
                    <h2 class="font-bold text-gray-900">Select Venue & Facility</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="label">Sports Center <span class="text-red-400">*</span></label>
                        <select id="venue-select" name="venue_id" class="input-field @error('venue_id') ring-2 ring-red-300 @enderror" required>
                            <option value="">Select a venue</option>
                            @foreach($venues as $v)
                            <option value="{{ $v->id }}" {{ (old('venue_id', request('venue_id')) == $v->id) ? 'selected' : '' }}>{{ $v->name }}</option>
                            @endforeach
                        </select>
                        @error('venue_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Facility <span class="text-red-400">*</span></label>
                        <select id="facility-select" name="facility_id" class="input-field @error('facility_id') ring-2 ring-red-300 @enderror" required>
                            <option value="">Select a venue first</option>
                        </select>
                        @error('facility_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Pricing preview --}}
                <div id="pricing-card" class="hidden mt-4 rounded-2xl border border-blue-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-5 py-4 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-sm">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Facility rate</p>
                                <p id="pricing-info" class="text-base font-bold text-slate-900"></p>
                            </div>
                        </div>
                        <a href="{{ route('venues') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800 transition-colors">View full pricing →</a>
                    </div>
                </div>
                <div id="pricing-hint" class="mt-4 flex items-center gap-2 text-sm text-slate-500">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Choose a venue and facility to preview the hourly rate.
                </div>
            </div>

            {{-- DB-driven facility data --}}
            <script>
            const venueMap = {!! json_encode($venueMap) !!};
            const preVenueId    = "{{ old('venue_id', request('venue_id')) }}";
            const preFacilityId = "{{ old('facility_id', request('facility_id')) }}";
            const vs = document.getElementById('venue-select');
            const fs = document.getElementById('facility-select');
            const pc = document.getElementById('pricing-card');
            const pi = document.getElementById('pricing-info');
            const ph = document.getElementById('pricing-hint');
            const sp = {'Basketball':'Basketball','Badminton':'Badminton','Volleyball':'Volleyball','Tennis':'Tennis','Pickleball':'Pickleball','Gym':'Gym'};
            function loadFacilities(vid) {
                fs.innerHTML = '<option value="">Select a facility</option>';
                pc.classList.add('hidden'); ph.classList.remove('hidden');
                if (!vid || !venueMap[vid]) { fs.innerHTML='<option value="">Select a venue first</option>'; return; }
                venueMap[vid].facilities.forEach(f => {
                    const o = document.createElement('option');
                    o.value = f.id; o.textContent = f.label; o.dataset.price = f.price;
                    if (String(f.id) === String(preFacilityId)) o.selected = true;
                    fs.appendChild(o);
                });
                if (preFacilityId) showPrice();
            }
            function showPrice() {
                const o = fs.options[fs.selectedIndex];
                if (!o || !o.dataset.price) { pc.classList.add('hidden'); ph.classList.remove('hidden'); return; }
                pi.textContent = '₱' + Number(o.dataset.price).toLocaleString() + ' / hour';
                ph.classList.add('hidden'); pc.classList.remove('hidden');
            }
            vs.addEventListener('change', () => loadFacilities(vs.value));
            fs.addEventListener('change', showPrice);
            if (preVenueId) loadFacilities(preVenueId);
            </script>

            {{-- Step 3: Schedule --}}
            <div class="px-6 sm:px-8 py-7">
                <div class="flex items-center gap-2.5 mb-6">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">3</div>
                    <h2 class="font-bold text-gray-900">Schedule</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="label">Date <span class="text-red-400">*</span></label>
                        <input type="date" name="date" value="{{ old('date', request('date') ?? date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" class="input-field @error('date') ring-2 ring-red-300 @enderror" required>
                        @error('date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Start Time <span class="text-red-400">*</span></label>
                        <input type="time" name="start_time" value="{{ old('start_time', request('start_time')) }}" class="input-field @error('start_time') ring-2 ring-red-300 @enderror" required>
                        @error('start_time')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Duration <span class="text-red-400">*</span></label>
                        <select name="duration" class="input-field @error('duration') ring-2 ring-red-300 @enderror" required>
                            <option value="">Select</option>
                            @foreach([1,2,3,4,5,6] as $h)
                            <option value="{{ $h }}" {{ (old('duration', request('duration')) == $h) ? 'selected' : '' }}>{{ $h }} hour{{ $h > 1 ? 's' : '' }}</option>
                            @endforeach
                        </select>
                        @error('duration')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Step 4: Payment --}}
            <div class="px-6 sm:px-8 py-7">
                <div class="flex items-center gap-2.5 mb-6">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">4</div>
                    <h2 class="font-bold text-gray-900">Payment</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="label">Payment Method <span class="text-red-400">*</span></label>
                        <select name="payment_method" class="input-field" required>
                            <option value="gcash" {{ old('payment_method')=='gcash'?'selected':'' }}>GCash</option>
                            <option value="cash"  {{ old('payment_method')=='cash'?'selected':'' }}>Cash on Site</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">GCash Reference <span class="text-gray-400 font-normal text-xs">(optional)</span></label>
                        <input type="text" name="payment_reference" value="{{ old('payment_reference') }}" placeholder="e.g. 1234567890" class="input-field">
                    </div>
                </div>
                <div class="mt-4 bg-amber-50 border border-amber-100 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <p class="text-xs text-amber-700">For GCash payments, send to the venue's GCash number and enter your reference number above.</p>
                </div>
                <div class="mt-4">
                    <label class="label">Additional Notes <span class="text-gray-400 font-normal text-xs">(optional)</span></label>
                    <textarea name="notes" rows="3" placeholder="Any special requests for the venue..." class="input-field resize-none">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- Submit --}}
            <div class="px-6 sm:px-8 py-5 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500">By submitting, you agree to the booking terms and conditions.</p>
                <button type="submit" class="btn-primary w-full sm:w-auto rounded-2xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Confirm Reservation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
