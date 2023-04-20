<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Rules\HierarchyValidationRule;
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
            'photo' => ['file', 'max:5000', 'mimes:jpg,png', 'dimensions:min_width=300,min_height=300'],
            'name' => ['required', 'string', 'min:2, max:256'],
            'date_of_employment' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:2000-01-01',
                'before_or_equal:today'
            ],
            'phone_number' => ['required', 'regex:/^(\+38)?\s?0\d{2}\s?\d{3}\s?\d{2}\s?\d{2}$/i'],
            'email' => ['required', 'email', 'unique:employees', 'max:50'],
            'salary' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'between:0,500000'],
            'head' => [
                'nullable',
                new HierarchyValidationRule($request->employee),
                'exists:employees,name',
            ],
            'position' => ['required', 'exists:positions,name'],
        ]);

        $employees = Employee::query()->create([
//            'position_id' => Position::query()->value('id'),
            'supervisor_id' => Employee::query()->value('id'),
            'name' => $validated['name'],
            'date_of_employment' => $validated['date_of_employment'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'password' => null,
            'salary' => $validated['salary'],
            'photo' => null,
            'level' => 1,
        ]);

        dd($employees);
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
