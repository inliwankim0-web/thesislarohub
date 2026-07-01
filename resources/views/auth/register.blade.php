@extends('layouts.app')
@section('title', 'Create Account — LaroHub')
@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-gradient-to-br from-gray-50 to-blue-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mb-6">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                </div>
                <span class="text-xl font-bold text-gray-900">Laro<span class="text-blue-600">Hub</span></span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Create your account</h1>
            <p class="text-gray-500 text-sm mt-1">Start booking sports facilities today</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-1 bg-gradient-to-r from-orange-400 to-blue-500"></div>
            <div class="p-8">
                @if($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-5">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                        <li class="flex items-center gap-2 text-red-700 text-sm">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">First Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Juan" class="input-field pl-10 @error('first_name') ring-2 ring-red-300 @enderror" required>
                            </div>
                        </div>
                        <div>
                            <label class="label">Last Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Dela Cruz" class="input-field pl-10 @error('last_name') ring-2 ring-red-300 @enderror" required>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="label">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="juan@email.com" class="input-field pl-10 @error('email') ring-2 ring-red-300 @enderror" required>
                        </div>
                    </div>
                    <div>
                        <label class="label">Contact Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="tel" name="contact" value="{{ old('contact') }}" placeholder="09XX XXX XXXX" class="input-field pl-10 @error('contact') ring-2 ring-red-300 @enderror" required>
                        </div>
                    </div>
                    <div>
                        <label class="label">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password" placeholder="Min. 8 characters" class="input-field pl-10 @error('password') ring-2 ring-red-300 @enderror" required>
                        </div>
                    </div>
                    <div>
                        <label class="label">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password_confirmation" placeholder="Repeat your password" class="input-field pl-10" required>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <input type="checkbox" id="terms" name="terms" class="w-4 h-4 mt-0.5 rounded border-gray-300 text-blue-600" required>
                        <label for="terms" class="text-sm text-gray-600 leading-relaxed">I agree to the <a href="#" class="text-blue-600 font-medium hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 font-medium hover:underline">Privacy Policy</a></label>
                    </div>
                    <button type="submit" class="btn-primary w-full !py-3 mt-2">
                        Create Account
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-500">Already have an account?
                        <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
