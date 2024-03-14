<?php

namespace App\Http\Controllers;

use App\Models\ExpenditureUnit;
use Illuminate\Http\Request;

class ExpenditureUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Satuan Belanja';
        $expenditureUnits = ExpenditureUnit::all();

        return view('app.expenditure-unit', compact('title', 'expenditureUnits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'expenditure_unit_name.*' => 'required|string|max:255', // Validation for names
            'expenditure_unit_code.*' => 'nullable|string|max:255', // Validation for codes
        ]);

        $names = $request->input('expenditure_unit_name');
        $codes = $request->input('expenditure_unit_code');

        foreach ($names as $index => $name) {
            $code = $codes[$index] ?? null; // Use null if the code is not provided

            // Create a new ExpenditureUnit
            ExpenditureUnit::create([
                'name' => $name,
                'code' => $code,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan satuan belanja.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenditureUnit $expenditureUnit)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Assuming 'name' is a required field
            'code' => 'nullable|string|max:255', // Assuming 'code' is optional
        ]);

        // Update the ExpenditureUnit with validated data
        $expenditureUnit->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('expenditure_unit.index')->with('success', 'Satuan belanja berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenditureUnit $expenditureUnit)
    {
        $expenditureUnit->delete();

        return redirect()->back()->with('success', 'Satuan belanja berhasil dihapus.');
    }
}
