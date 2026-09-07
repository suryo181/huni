<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'description',
        'address',
        'latitude',
        'longitude',
        'price_per_month',
        'total_rooms',
        'available_rooms',
        'is_verified',
    ];

    // Relasi ke User (Pemilik Kos)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kamar (Rooms)
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // Relasi ke Foto Properti (PropertyPhoto)
    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class);
    }

    // Relasi ke Ulasan (Reviews)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function subscriptions()
    {
    return $this->hasMany(Subscription::class);
    }

    // Cek apakah langganan kos ini masih aktif
    public function isSubscribed()
    {
    return $this->subscriptions()
        ->where('status', 'paid')
        ->where('ends_at', '>=', now())
        ->exists();
    }
}