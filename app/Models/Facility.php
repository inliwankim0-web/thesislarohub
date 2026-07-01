<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'venue_id','sport','label','time_slot','price_per_hour',
        'has_lights','court_count','is_monthly','rate_type','is_active',
    ];

    protected function casts(): array
    {
        return [
            'has_lights' => 'boolean',
            'is_monthly' => 'boolean',
            'is_active'  => 'boolean',
            'price_per_hour' => 'float',
        ];
    }

    public function venue()       { return $this->belongsTo(Venue::class); }
    public function reservations(){ return $this->hasMany(Reservation::class); }

    /**
     * Check if a given date+time+duration overlaps with existing confirmed reservations.
     */
    public function isAvailable(string $date, string $startTime, int $hours): bool
    {
        $end = date('H:i', strtotime($startTime) + $hours * 3600);

        return !$this->reservations()
            ->whereDate('date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startTime, $end) {
                $q->where(function ($q2) use ($startTime, $end) {
                    $q2->where('start_time', '<', $end)
                       ->where('end_time', '>', $startTime);
                });
            })->exists();
    }
}
