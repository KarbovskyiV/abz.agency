<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
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
        $query = Employee::query()->with('position')->select(
            'id',
            'photo',
            'name',
            'position_id',
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2, max:256'],
            'date_of_employment' => ['required', 'date_format:d.m.Y'],
            'phone_number' => ['required', 'regex:^(\+38)?\s?0\d{2}\s?\d{3}\s?\d{2}\s?\d{2}$', 'min:12'],
            'email' => ['required', 'email', 'unique:employees', 'max:50'],
            'salary' => ['required', 'decimal:0,500000'],
        ]);
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
