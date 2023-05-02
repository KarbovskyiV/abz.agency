<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\Exceptions\Exception;

class PositionController extends Controller
{
    public function index()
    {
        return view('position.index');
    }

    /**
     * @throws Exception
     */
    public function getEmployees()
    {
        $query = Position::query()->select(
            'id',
            'name',
            'updated_at',
        )->orderBy('updated_at', 'desc');

        return datatables($query)->make(true);
    }

    public function create()
    {
        return view('position.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:256'],
        ]);

        Position::query()->create([
            'name' => $validated['name'],
        ]);

        return redirect('positions');
    }

    public function edit($id)
    {
        $position = Position::query()->findOrFail($id);

        return view('position.edit', compact('position'));
    }

    public function update(Request $request, $id)
    {
        $position = Position::query()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:256'],
        ]);

        $position->update($validated);

        return redirect('positions');
    }

    public function destroy($id)
    {
        $position = Position::query()->find($id);

        if ($position) {
            $position->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Position not found.']);
        }
    }
}
