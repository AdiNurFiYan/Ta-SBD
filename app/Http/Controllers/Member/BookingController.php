<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show booking form
    public function create(Request $request, Package $package, Slot $slot)
    {
        if ($slot->status !== 'available') {
            return redirect()->route('member.slots.index', $package)
                ->with('error', 'This slot is no longer available.');
        }
        
        return view('member.bookings.create', compact('package', 'slot'));
    }
    
    // Store booking
    public function store(Request $request, Package $package, Slot $slot)
    {
        // Validate request
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Check if slot is still available
        if ($slot->status !== 'available') {
            return redirect()->route('member.slots.index', $package)
                ->with('error', 'This slot is no longer available.');
        }
        
        // Create booking
        $booking = Booking::create([
            'member_id' => Auth::guard('member')->id(),
            'package_id' => $package->id,
            'slot_id' => $slot->id,
            'booking_date' => $slot->date,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);
        
        // Update slot status
        $slot->update(['status' => 'booked']);
        
        return redirect()->route('member.bookings.history')
            ->with('success', 'Booking successfully created and waiting for confirmation.');
    }
    
    // Show booking history
    public function history()
    {
        $member_id = Auth::guard('member')->id();
        $bookings = Booking::where('member_id', $member_id)
            ->with(['package', 'slot'])
            ->latest()
            ->paginate(10);
        
        return view('member.bookings.history', compact('bookings'));
    }
    
    // Cancel booking
    public function cancel(Booking $booking)
    {
        if ($booking->member_id !== Auth::guard('member')->id()) {
            abort(403);
        }
        
        if (in_array($booking->status, ['pending', 'confirmed'])) {
            $booking->update(['status' => 'cancelled']);
            
            // Make the slot available again
            $booking->slot->update(['status' => 'available']);
            
            return redirect()->route('member.bookings.history')
                ->with('success', 'Booking has been cancelled successfully.');
        }
        
        return redirect()->route('member.bookings.history')
            ->with('error', 'This booking cannot be cancelled.');
    }
    
    // Show booking detail with payment info after confirmation
    public function show(Booking $booking)
    {
        if ($booking->member_id !== Auth::guard('member')->id()) {
            abort(403);
        }
        
        return view('member.bookings.show', compact('booking'));
    }
}