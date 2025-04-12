<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index(Package $package, Request $request)
    {
        $date = $request->date ?? Carbon::now()->format('Y-m-d');
        
        // Get 7 days for date selection
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $currentDate = Carbon::now()->addDays($i);
            $dates[] = [
                'date' => $currentDate->format('Y-m-d'),
                'display' => $currentDate->format('D, d M Y')
            ];
        }
        
        // Get available slots for the selected date and package
        $slots = Slot::where('package_id', $package->id)
            ->where('date', $date)
            ->orderBy('start_time')
            ->get();
        
        return view('member.slots.index', compact('package', 'slots', 'date', 'dates'));
    }
}