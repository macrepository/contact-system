<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 25; $i++) {
            DB::table('contacts')->insert([
                'user_id'   => 5,
                'name' => "Jorge_$i",
                'company' => "ABC_$i",
                'phone' => "+{$i}9123456789",
                'email' => "jorge_$i@example.com",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 1; $i <= 25; $i++) {
            DB::table('contacts')->insert([
                'user_id'   => 4,
                'name' => "Ana_$i",
                'company' => "CBA_$i",
                'phone' => "+{$i}9123456789",
                'email' => "ana_$i@example.com",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
