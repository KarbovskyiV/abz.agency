<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Yajra\DataTables\Exceptions\Exception;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
    }

    /**
     * @throws Exception
     */
    public function getEmployees()
    {
        $query = Employee::query()->select(
            'photo',
            'name',
            'position',
            'date_of_employment',
            'phone_number',
            'email',
            'salary'
        );
        return datatables($query)->make(true);
    }
}
