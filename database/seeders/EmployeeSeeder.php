<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Factory::create();

        $positions = Position::all();

        for ($i = 1; $i <= 500; $i++) {
            DB::table('employees')->insert([
                'position_id' => $positions->random()->id,  // Assign a random position
                'name' => $faker->name,
                'position' => $faker->jobTitle,
                'date_of_employment' => $faker->date,
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->unique()->email,
                'salary' => $faker->numberBetween(20000, 100000),
                'photo' => $faker->imageUrl(400, 400, 'people'),
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => 1,
                'admin_updated_id' => 1,
            ]);
        }
    }
}
