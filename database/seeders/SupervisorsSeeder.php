<?php

namespace Database\Seeders;

use App\Models\Employee;
use Faker\Factory;
use Illuminate\Database\Seeder;
use App\Models\Supervisor;

class SupervisorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Factory::create();
        $employees = Employee::all();
        $employeeIds = $employees->pluck('id')->toArray();

        foreach ($employees as $employee) {
            $supervisor = new Supervisor([
                'employee_id' => $employee->id,
                'supervisor_id' => $faker->randomElement($employeeIds),
                'level' => $faker->numberBetween(1, 5)
            ]);
            $supervisor->save();
        }
    }
}
