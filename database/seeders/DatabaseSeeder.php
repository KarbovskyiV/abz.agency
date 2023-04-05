<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // use once, or it duplicates positions table, it was worked but not good...

        $this->call([
            PositionsSeeder::class,
            EmployeeSeeder::class,
            SupervisorsSeeder::class,
        ]);
    }
}
