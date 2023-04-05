<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $positions = [
            ['name' => 'Manager'],
            ['name' => 'Developer'],
            ['name' => 'Designer'],
            ['name' => 'Marketing Specialist'],
            ['name' => 'Sales Representative'],
            ['name' => 'HR Manager'],
        ];

        foreach ($positions as $position) {
            $p = new Position($position);
            $p->save();
        }
    }
}
