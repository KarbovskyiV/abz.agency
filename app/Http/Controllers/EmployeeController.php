<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
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
            'id',
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

    public function create()
    {
        $positions = Position::query()->select('name')->get();

        return view('employee.create', compact('positions'));
    }

    public function store()
    {
        dump('success');
    }

    public function destroy($id)
    {
        $employee = Employee::query()->find($id);

        if ($employee) {
            $employee->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Employee not found.']);
        }
    }
}
