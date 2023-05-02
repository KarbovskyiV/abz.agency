<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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
                'after_or_equal:2000-01-01',
                'before_or_equal:today'
            ],
            'phone_number' => ['required', 'regex:/^\+380\s?\(\d{2}\)\s?\d{3}\s?\d{2}\s?\d{2}$/', 'unique:employees'],
            'email' => ['required', 'email', 'unique:employees', 'max:50'],
            'salary' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'between:0,500000'],
            'head' => [
                'nullable',
                // TODO зробить перевірку на ієрархію
                Rule::exists('employees', 'name')->when($request->input('head'), function ($query) use ($request) {
                    $selectedHead = DB::table('employees')
                        ->select('level')
                        ->where('name', $request->input('head'))
                        ->first();

                    if ($selectedHead?->level > 1) {
                        return ['required', 'exists:employees,name'];
                    } else {
                        return null;
                    }
                }),
            ],
            'position' => ['required', 'exists:positions,name'],
        ]);


        $position = Position::query()->where('name', $validated['position'])->first();

        $headName = $validated['head'];
        $head = Employee::query()->where('name', $headName)->first();

        $photo = $request->file('photo');
        // Generate a unique filename
        $filename = time() . '_' . $photo->getClientOriginalName();
        // Save the file to storage
        $photo->storeAs('public/photos', $filename);

        $query = Employee::query()->create([
            'position_id' => $position->id,
            'supervisor_id' => $head?->id,
            'name' => $validated['name'],
            'date_of_employment' => $validated['date_of_employment'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'password' => null,
            'salary' => $validated['salary'],
            'photo' => $filename,
            'level' => 1,
        ]);

        dd($query);
    }

    public function edit($id)
    {
        $employee = Employee::query()->findOrFail($id);
        $heads_name = Employee::query()->pluck('name')->toArray();
        $positions = Position::all();

        return view('employee.edit', compact('employee', 'positions', 'heads_name'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::query()->findOrFail($id);

        $validated = $request->validate([
            'photo' => ['file', 'max:5000', 'mimes:jpg,png', 'dimensions:min_width=300,min_height=300'],
            'name' => ['required', 'string', 'min:2, max:256'],
            'phone_number' => [
                'required',
                'regex:/^\+380\s?\(\d{2}\)\s?\d{3}\s?\d{2}\s?\d{2}$/',
                Rule::unique('employees')->ignore($employee->id),
            ],
            'email' => ['required', 'email', 'max:50', Rule::unique('employees')->ignore($employee->id)],
            'position' => ['required', 'exists:positions,name'],
            'salary' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'between:0,500000'],
            'head' => [
                'nullable',
                // TODO зробить перевірку на ієрархію
                Rule::exists('employees', 'name')->when($request->input('head'), function ($query) use ($request) {
                    $selectedHead = DB::table('employees')
                        ->select('level')
                        ->where('name', $request->input('head'))
                        ->first();

                    if ($selectedHead?->level > 1) {
                        return ['required', 'exists:employees,name'];
                    } else {
                        return null;
                    }
                }),
            ],
            'date_of_employment' => [
                'required',
                'after_or_equal:2000-01-01',
                'before_or_equal:today'
            ],
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = $photo->getClientOriginalName();
            $storedFileName = $photo->storeAs('public/photos', $filename);
            $validated['photo'] = basename($storedFileName);
        }

        dd($employee->update($validated));
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
