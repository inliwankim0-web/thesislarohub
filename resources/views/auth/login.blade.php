@extends('layouts.app')
@section('title', 'Sign In — LaroHub')
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
            <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
            <p class="text-gray-500 text-sm mt-1">Sign in to manage your reservations</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
            <div class="p-8">
                @if($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-5 flex items-start gap-3">
                    <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <p class="text-red-700 text-sm">{{ $errors->first() }}</p>
                </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="label">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" class="input-field pl-10 @error('email') ring-2 ring-red-300 @enderror" required autofocus>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="label !mb-0">Password</label>
                            <a href="#" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" name="password" placeholder="••••••••" class="input-field pl-10" required>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600">
                        <label for="remember" class="text-sm text-gray-600">Keep me signed in</label>
                    </div>
                    <button type="submit" class="btn-primary w-full !py-3">
                        Sign In
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-500">Don't have an account?
                        <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700">Sign up free</a>
                    </p>
                </div>
            </div>
        </div>
        <p class="text-center text-xs text-gray-400 mt-5">By signing in you agree to our Terms of Service and Privacy Policy.</p>
    </div>
</div>
@endsection
