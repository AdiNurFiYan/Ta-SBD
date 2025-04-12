<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = Package::all();
        
        // Generate slots for next 7 days
        for ($day = 0; $day < 7; $day++) {
            $date = Carbon::now()->addDays($day);
            
            foreach ($packages as $package) {
                // Time slots (9:00 to 21:00, with package duration intervals)
                $startTime = Carbon::createFromTime(9, 0);
                $endTime = Carbon::createFromTime(21, 0);
                
                while ($startTime->lt($endTime)) {
                    Slot::create([
                        'package_id' => $package->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $startTime->format('H:i:s'),
                        'end_time' => $startTime->copy()->addHours($package->duration)->format('H:i:s'),
                        'status' => 'available',
                    ]);
                    
                    $startTime->addHours($package->duration);
                }
            }
        }
    }
}