<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // first time create few employees, then may create as many as want

        $this->call([
            PositionsSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
