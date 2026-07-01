<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'owner_id','name','slug','address','latitude','longitude',
        'contact','description','rating','is_active','color','emoji',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'rating' => 'float'];
    }

    public function owner()       { return $this->belongsTo(User::class, 'owner_id'); }
    public function facilities()  { return $this->hasMany(Facility::class); }
    public function reservations(){ return $this->hasMany(Reservation::class); }

    /** Sports offered (unique list) */
    public function sports(): array
    {
        return $this->facilities()->where('is_active', true)->distinct()->pluck('sport')->toArray();
    }

    /** Lowest hourly rate across all hourly facilities */
    public function lowestRate(): float
    {
        return (float) $this->facilities()
            ->where('rate_type', 'hourly')
            ->where('is_active', true)
            ->min('price_per_hour') ?? 0;
    }
}
