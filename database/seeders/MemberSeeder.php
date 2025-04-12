<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks
        Schema::disableForeignKeyConstraints();
        
        // Truncate the table
        DB::table('members')->truncate();
        
        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        Member::create([
            'name' => 'Member',
            'email' => 'member@test.com',
            'password' => Hash::make('Password@123'),
        ]);
    }
}