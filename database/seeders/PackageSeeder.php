<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'PS4 Lite',
                'description' => 'Basic PlayStation 4 package with standard controllers',
                'price' => 25000,
                'duration' => 1,
                'facilities' => 'PlayStation 4 console, 2 standard controllers, 5 basic games',
                'status' => true,
            ],
            [
                'name' => 'PS4 Regular',
                'description' => 'Standard PlayStation 4 package with additional features',
                'price' => 40000,
                'duration' => 2,
                'facilities' => 'PlayStation 4 console, 2 wireless controllers, 10 popular games, snacks included',
                'status' => true,
            ],
            [
                'name' => 'PS4 VIP',
                'description' => 'Premium PlayStation 4 experience with all accessories',
                'price' => 60000,
                'duration' => 3,
                'facilities' => 'PlayStation 4 Pro console, 4 wireless controllers, 15 premium games, VR headset, snacks and drinks included',
                'status' => true,
            ],
            [
                'name' => 'PS5 VIP',
                'description' => 'Ultimate PlayStation 5 premium experience',
                'price' => 100000,
                'duration' => 3,
                'facilities' => 'PlayStation 5 console, 4 DualSense controllers, 20 latest games, VR headset, snacks and drinks included, priority service',
                'status' => true,
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}