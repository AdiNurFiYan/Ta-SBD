<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::all();
        $selectedPackage = $request->package_id ? Package::findOrFail($request->package_id) : null;
        $date = $request->date ?? Carbon::now()->format('Y-m-d');
        
        $query = Slot::query();
        
        if ($selectedPackage) {
            $query->where('package_id', $selectedPackage->id);
        }
        
        $query->where('date', $date);
        $slots = $query->orderBy('start_time')->get();
        
        // Get 7 days for date selection
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $currentDate = Carbon::now()->addDays($i);
            $dates[] = [
                'date' => $currentDate->format('Y-m-d'),
                'display' => $currentDate->format('D, d M Y')
            ];
        }
        
        return view('admin.slots.index', compact('packages', 'selectedPackage', 'slots', 'date', 'dates'));
    }
    
    public function create()
    {
        $packages = Package::all();
        return view('admin.slots.create', compact('packages'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'status' => 'required|in:available,booked,maintenance',
        ]);
        
        // Calculate end time based on package duration
        $package = Package::findOrFail($request->package_id);
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addHours($package->duration);
        
        Slot::create([
            'package_id' => $validated['package_id'],
            'date' => $validated['date'],
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'status' => $validated['status'],
        ]);
        
        return redirect()->route('admin.slots.index', ['package_id' => $request->package_id, 'date' => $request->date])
            ->with('success', 'Slot created successfully.');
    }
    
    public function edit(Slot $slot)
    {
        $packages = Package::all();
        return view('admin.slots.edit', compact('slot', 'packages'));
    }
    
    public function update(Request $request, Slot $slot)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,booked,maintenance',
        ]);
        
        $slot->update($validated);
        
        return redirect()->route('admin.slots.index', ['package_id' => $slot->package_id, 'date' => $slot->date])
            ->with('success', 'Slot updated successfully.');
    }
    
    // Soft delete
    public function destroy(Slot $slot)
    {
        $slot->delete();
        
        return redirect()->route('admin.slots.index', ['package_id' => $slot->package_id, 'date' => $slot->date])
            ->with('success', 'Slot removed successfully.');
    }
    
    // Hard delete
    public function forceDelete($id)
    {
        $slot = Slot::withTrashed()->findOrFail($id);
        $packageId = $slot->package_id;
        $date = $slot->date;
        $slot->forceDelete();
        
        return redirect()->route('admin.slots.index', ['package_id' => $packageId, 'date' => $date])
            ->with('success', 'Slot permanently deleted.');
    }
    
    // Generate slots for a package
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'date' => 'required|date|after_or_equal:today',
            'start_hour' => 'required|integer|min:0|max:23',
            'end_hour' => 'required|integer|min:0|max:23|gt:start_hour',
        ]);
        
        $package = Package::findOrFail($request->package_id);
        $date = $request->date;
        $startHour = $request->start_hour;
        $endHour = $request->end_hour;
        
        // Generate slots based on package duration
        $startTime = Carbon::createFromTime($startHour, 0);
        $endTime = Carbon::createFromTime($endHour, 0);
        
        while ($startTime->lt($endTime)) {
            Slot::create([
                'package_id' => $package->id,
                'date' => $date,
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $startTime->copy()->addHours($package->duration)->format('H:i:s'),
                'status' => 'available',
            ]);
            
            $startTime->addHours($package->duration);
        }
        
        return redirect()->route('admin.slots.index', ['package_id' => $package->id, 'date' => $date])
            ->with('success', 'Slots generated successfully.');
    }
}