<?php

namespace App\Http\Controllers;

use App\Models\BudgetImplementation;
use App\Models\BudgetImplementationDetail;
use App\Models\AccountCode;
use App\Models\ExpenditureUnit;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\BudgetImplementationInputArrayService;


class BudgetImplementationController extends Controller
{
    protected $budgetService;

    public function __construct(BudgetImplementationInputArrayService $budgetService)
    {
        $this->budgetService = $budgetService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "DIPA";

        // Retrieving BudgetImplementations with necessary relations
        $budgetImplementations = BudgetImplementation::query()
            ->with(['activity', 'accountCode', 'details'])
            ->initialBudget()
            ->get();

        // Grouping by activity code, then further grouping each activity's data by account code
        $groupedBI = $budgetImplementations->groupBy('activity.code')->map(function ($activityGroup) {
            return $activityGroup->groupBy('accountCode.code');
        });

        $accountCodes = AccountCode::all();
        $expenditureUnits = ExpenditureUnit::all();

        return view('app.budget-implementation', compact('title', 'groupedBI', 'accountCodes', 'expenditureUnits'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'dipa.*.bi' => 'sometimes|integer',
            'dipa.*.activity.id' => 'sometimes|integer',
            'dipa.*.activity.code' => 'required|string',
            'dipa.*.activity.name' => 'required|string',
            'dipa.*.accounts' => 'nullable|array',
            'dipa.*.accounts.*.account.id' => 'sometimes|string',
            'dipa.*.accounts.*.account.code' => 'required|string',
            'dipa.*.accounts.*.account.name' => 'required|string',
            'dipa.*.accounts.*.expenditures' => 'sometimes|array',
            'dipa.*.accounts.*.expenditures.*.id' => 'sometimes|string',
            'dipa.*.accounts.*.expenditures.*.budget_implementation' => 'sometimes|string',
            'dipa.*.accounts.*.expenditures.*.description' => 'required|string',
            'dipa.*.accounts.*.expenditures.*.volume' => 'required|numeric',
            'dipa.*.accounts.*.expenditures.*.unit' => 'required|string',
            'dipa.*.accounts.*.expenditures.*.unit_price' => 'required|numeric',
            'dipa.*.accounts.*.expenditures.*.total' => 'required|numeric',
        ]);

        return response()->json($this->budgetService->process($validator->validated()['dipa']));

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
        } catch (\Exception $e) {
            Log::error('Error in store function: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(BudgetImplementation $budgetImplementation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetImplementation $budgetImplementation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BudgetImplementation $budgetImplementation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetImplementation $budgetImplementation)
    {
        //
    }
}
