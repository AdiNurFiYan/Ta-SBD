<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();
        $member_id = $member->id;
        
        $pendingBookings = Booking::where('member_id', $member_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['package', 'slot'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('member.dashboard', compact('member', 'pendingBookings'));
    }
}