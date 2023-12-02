<?php

namespace App\Http\Controllers;

use App\Models\InstitutionalBudget;
use Illuminate\Http\Request;

class InstitutionalBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Pagu Lembaga";
        $institutionalBudget = InstitutionalBudget::first();
        return view('app.institutional-budget', compact('title', 'institutionalBudget'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Preprocess 'pagu' input: remove 'Rp' and commas, then convert to integer
        $paguInput = $request->input('pagu');
        $cleanedPagu = intval(str_replace(['Rp', ','], '', $paguInput));

        // Validate the request
        $validatedData = $request->validate([
            'ins_budget_id' => 'nullable|exists:institutional_budgets,id'
        ]);

        // Find or create the InstitutionalBudget record
        $institutionalBudget = InstitutionalBudget::findOrNew($validatedData['ins_budget_id'] ?? null);

        // Update or set the 'pagu' field with the cleaned value
        $institutionalBudget->pagu = $cleanedPagu;
        $institutionalBudget->save();

        // Add a response for successful creation or update
        $message = $institutionalBudget->wasRecentlyCreated ?
            'Berhasil menambahkan pagu lembaga.' :
            'Berhasil mengupdate pagu lembaga.';

        return redirect()->back()->with('success', $message);
    }





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InstitutionalBudget $institutionalBudget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstitutionalBudget $institutionalBudget)
    {
        //
    }
}
