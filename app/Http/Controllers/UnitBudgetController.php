<?php

namespace App\Http\Controllers;

use App\Models\UnitBudget;
use App\Models\WorkUnit;
use Illuminate\Http\Request;

class UnitBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Pagu Unit';
        $workUnits = WorkUnit::with('unitBudgets')->get();
        $unitBudgets = UnitBudget::with('workUnit')->get();
        return view('app.unit-budget', compact('title', 'workUnits', 'unitBudgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        foreach ($request->all() as $budgetData) {
            UnitBudget::updateOrCreate(
                ['work_unit_id' => $budgetData['work_unit_id']], // Check for existing record based on work_unit_id
                ['pagu' => $budgetData['pagu']] // Values to update or create
            );
        }

        return response()->json(['message' => 'Pagu unit berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitBudget $unitBudget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitBudget $unitBudget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitBudget $unitBudget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitBudget $unitBudget)
    {
        //
    }
}
