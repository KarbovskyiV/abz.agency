<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Supervisor;
use Faker\Provider\uk_UA\PhoneNumber;
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

        $employees = Employee::all();
        $positions = Position::all();

        for ($i = 1; $i <= 5; $i++) {
            $supervisor = $employees->isNotEmpty() ? $employees->random()->id : null;
            DB::table('employees')->insert([
                'position_id' => $positions->random()->id,
                'supervisor_id' => $supervisor,
                'name' => $faker->name,
                'date_of_employment' => $faker->date('d.m.Y'),
                'phone_number' => PhoneNumber::numerify('+380 (##) ### ## ##'),
                'email' => $faker->unique()->email,
                'password' => $faker->password(),
                'salary' => $faker->numberBetween(0, 500000),
                'photo' => $faker->imageUrl(400, 400, 'people'),
                // TODO: when level 5 supervisor_id = null
                'level' => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
                'admin_created_id' => 1,
                'admin_updated_id' => 1,
            ]);
        }
    }
}
