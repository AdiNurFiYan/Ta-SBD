<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Member;
use App\Models\Package;
use App\Models\Slot;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'members' => Member::count(),
            'packages' => Package::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'slots_available' => Slot::where('status', 'available')->count(),
        ];
        
        $recentBookings = Booking::with(['member', 'package', 'slot'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}