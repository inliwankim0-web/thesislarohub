<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'contact', 'password', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isStaff(): bool    { return $this->role === 'staff'; }
    public function isRenter(): bool   { return $this->role === 'renter'; }

    public function reservations() { return $this->hasMany(Reservation::class); }
    public function venues()        { return $this->hasMany(Venue::class, 'owner_id'); }
}
