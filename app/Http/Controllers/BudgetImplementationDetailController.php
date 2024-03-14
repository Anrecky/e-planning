<?php

namespace App\Http\Controllers;

use App\Models\BudgetImplementationDetail;
use Illuminate\Http\Request;

class BudgetImplementationDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BudgetImplementationDetail $budgetImplementationDetail)
    {
        return response()->json(
            $budgetImplementationDetail->load([
                'budgetImplementation.activity:id,name',
                'budgetImplementation.accountCode:id,name',
            ])
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetImplementationDetail $budgetImplementationDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BudgetImplementationDetail $budgetImplementationDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetImplementationDetail $budgetImplementationDetail)
    {
        //
    }

    // Get Account Code By Activity
    public function getByActivityAccountCode(Request $request, $activityId, $accountCodeId)
    {
        try {
            $details = BudgetImplementationDetail::whereHas('budgetImplementation', function ($query) use ($activityId, $accountCodeId) {
                $query->where('activity_id', $activityId)->where('account_code_id', $accountCodeId);
            })->get();

            return response()->json($details);
        } catch (\Exception $e) {
            \Log::error($e);

            return back()->with('error', $e->getMessage());
        }
    }
}
