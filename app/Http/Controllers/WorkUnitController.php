<?php

namespace App\Http\Controllers;

use App\Models\WorkUnit;
use Illuminate\Http\Request;

class WorkUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Unit Kerja';
        $workUnits = WorkUnit::all();

        return view('app.work-unit', compact('title', 'workUnits'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'work_unit_name.*' => 'required|string|max:255', // Validation for names
            'work_unit_code.*' => 'nullable|string|max:255', // Validation for codes
        ]);

        $names = $request->input('work_unit_name');
        $codes = $request->input('work_unit_code');

        foreach ($names as $index => $name) {
            $code = $codes[$index] ?? null; // Use null if the code is not provided

            // Create a new WorkUnit
            WorkUnit::create([
                'name' => $name,
                'code' => $code,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan unit kerja.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkUnit $workUnit)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Assuming 'name' is a required field
            'code' => 'nullable|string|max:255', // Assuming 'code' is optional
        ]);

        // Update the WorkUnit with validated data
        $workUnit->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('work_unit.index')->with('success', 'Unit Kerja berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkUnit $workUnit)
    {
        $workUnit->delete();

        return redirect()->back()->with('success', 'Unit kerja berhasil dihapus.');
    }
}
