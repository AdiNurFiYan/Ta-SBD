<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'package_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
    
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }
    
    public function isBooked()
    {
        return $this->status === 'booked';
    }
    
    public function isMaintenance()
    {
        return $this->status === 'maintenance';
    }
    
    public function isAvailable()
    {
        return $this->status === 'available';
    }
}