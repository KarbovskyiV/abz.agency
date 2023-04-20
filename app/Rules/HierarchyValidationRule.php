<?php

namespace App\Rules;

use App\Models\Employee;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HierarchyValidationRule implements ValidationRule
{
    protected $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    public function passes($attribute, $value)
    {
        $supervisor = Employee::query()->find($value);

        if ($supervisor && $supervisor->level >= $this->employee->level) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'The selected head is not a valid supervisor.';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
    }
}
