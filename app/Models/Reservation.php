<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'reference_code','user_id','venue_id','facility_id',
        'first_name','last_name','email','contact',
        'date','start_time','duration_hours','end_time','total_amount',
        'notes','status','payment_method','payment_reference','payment_status','is_walk_in',
    ];

    protected function casts(): array
    {
        return [
            'date'       => 'date',
            'is_walk_in' => 'boolean',
            'total_amount' => 'float',
        ];
    }

    public function user()     { return $this->belongsTo(User::class); }
    public function venue()    { return $this->belongsTo(Venue::class); }
    public function facility() { return $this->belongsTo(Facility::class); }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'confirmed'  => 'green',
            'pending'    => 'yellow',
            'rejected'   => 'red',
            'cancelled'  => 'gray',
            'completed'  => 'blue',
            default      => 'gray',
        };
    }

    public function getGuestNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /** Generate a unique reference code */
    public static function generateReference(): string
    {
        do {
            $code = 'LH-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (static::where('reference_code', $code)->exists());
        return $code;
    }
}
