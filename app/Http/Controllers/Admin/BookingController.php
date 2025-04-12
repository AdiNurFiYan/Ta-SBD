<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['member', 'package', 'slot']);
        
        // Search by member name
        if ($request->has('search')) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        $bookings = $query->latest()->paginate(10);
        
        return view('admin.bookings.index', compact('bookings'));
    }
    
    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }
    
    public function confirm(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking confirmed successfully.');
    }
    
    public function complete(Booking $booking)
    {
        $booking->update(['status' => 'completed']);
        
        // Make the slot available again if it's a completed booking
        $booking->slot->update(['status' => 'available']);
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking marked as completed.');
    }
    
    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        
        // Make the slot available again
        $booking->slot->update(['status' => 'available']);
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
    
    // Soft delete
    public function destroy(Booking $booking)
    {
        $booking->delete();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking removed from active list.');
    }
    
// Show booking history (including soft deleted)
public function history(Request $request)
{
    $query = Booking::with(['member', 'package', 'slot'])
        ->withTrashed();
    
    // Search by member name
    if ($request->has('search')) {
        $query->whereHas('member', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }
    
    $bookings = $query->latest()->paginate(10);
    
    return view('admin.bookings.history', compact('bookings'));
}

// Hard delete
public function forceDelete($id)
{
    $booking = Booking::withTrashed()->findOrFail($id);
    $booking->forceDelete();
    
    return redirect()->route('admin.bookings.history')
        ->with('success', 'Booking permanently deleted.');
}

// Restore soft deleted booking
public function restore($id)
{
    $booking = Booking::withTrashed()->findOrFail($id);
    $booking->restore();
    
    return redirect()->route('admin.bookings.history')
        ->with('success', 'Booking restored successfully.');
}
}