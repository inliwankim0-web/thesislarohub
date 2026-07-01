@extends('layouts.app')
@section('title', 'Booking Confirmed — LaroHub')
@section('content')
<div class="min-h-screen bg-gray-50 py-16 px-4">
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-10 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-1">Booking Received</h1>
                <p class="text-green-100 text-sm">Your reservation is pending confirmation from the venue.</p>
                <div class="mt-5 inline-block bg-white/20 rounded-xl px-6 py-3">
                    <p class="text-green-100 text-xs uppercase tracking-widest mb-1">Reference Code</p>
                    <p class="text-2xl font-bold text-white font-mono tracking-wider">{{ $reservation->reference_code }}</p>
                </div>
            </div>

            <div class="p-7">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    @foreach([
                        ['label'=>'Venue',     'value'=>$reservation->venue->name],
                        ['label'=>'Facility',  'value'=>$reservation->facility->label],
                        ['label'=>'Date',      'value'=>$reservation->date->format('F j, Y')],
                        ['label'=>'Time',      'value'=>$reservation->start_time.' – '.$reservation->end_time],
                        ['label'=>'Duration',  'value'=>$reservation->duration_hours.' hr(s)'],
                        ['label'=>'Amount',    'value'=>'₱'.number_format($reservation->total_amount, 2)],
                        ['label'=>'Payment',   'value'=>strtoupper($reservation->payment_method)],
                        ['label'=>'Status',    'value'=>ucfirst($reservation->status)],
                    ] as $row)
                    <div class="bg-gray-50 rounded-xl p-3.5">
                        <p class="text-xs text-gray-400 mb-0.5">{{ $row['label'] }}</p>
                        <p class="font-semibold text-gray-900 text-sm">{{ $row['value'] }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
                    <p class="text-xs font-semibold text-blue-800 mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        What Happens Next
                    </p>
                    <ul class="space-y-1 text-xs text-blue-700">
                        <li class="flex items-start gap-2"><span class="w-1 h-1 bg-blue-400 rounded-full mt-1.5 shrink-0"></span>The venue will review and confirm your booking</li>
                        <li class="flex items-start gap-2"><span class="w-1 h-1 bg-blue-400 rounded-full mt-1.5 shrink-0"></span>For GCash, send payment to the venue's GCash number and keep your reference</li>
                        <li class="flex items-start gap-2"><span class="w-1 h-1 bg-blue-400 rounded-full mt-1.5 shrink-0"></span>Keep your code: <strong>{{ $reservation->reference_code }}</strong></li>
                    </ul>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('home') }}" class="btn-primary flex-1">Back to Home</a>
                    @auth
                    <a href="{{ route('renter.dashboard') }}" class="btn-secondary flex-1">My Bookings</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
