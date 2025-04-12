<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'package_id',
        'slot_id',
        'booking_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class, 'slot_id');
    }
        
    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
    
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
    
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}