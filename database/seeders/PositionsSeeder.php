<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $positions = Position::all();

        if ($positions->isEmpty()) {
            DB::table('positions')->insert([
                ['name' => 'Manager', 'created_at' => now(), 'updated_at' => now(),],
                ['name' => 'Developer', 'created_at' => now(), 'updated_at' => now(),],
                ['name' => 'Designer', 'created_at' => now(), 'updated_at' => now(),],
                ['name' => 'Marketing Specialist', 'created_at' => now(), 'updated_at' => now(),],
                ['name' => 'Sales Representative', 'created_at' => now(), 'updated_at' => now(),],
                ['name' => 'HR Manager', 'created_at' => now(), 'updated_at' => now(),],
            ]);
        }
    }
}
