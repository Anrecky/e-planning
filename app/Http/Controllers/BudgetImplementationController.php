<?php

namespace App\Http\Controllers;

use App\Models\BudgetImplementation;
use App\Models\AccountCode;
use App\Models\ExpenditureUnit;
use App\Models\Activity;
use App\Models\ExpenditureDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


class BudgetImplementationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "DIPA";
        $budgetImplementations = BudgetImplementation::with('accountCode', 'expenditureDetail', 'expenditureDetail.expenditureUnit')
            ->where('revisi', 0)
            ->get()
            ->groupBy('activity_code');
        $accountCodes = AccountCode::all();
        $expenditureUnits = ExpenditureUnit::all();
        return view('app.budget-implementation', compact('title', 'accountCodes', 'expenditureUnits', 'budgetImplementations'));
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
        // Decode the JSON data from the request
        $reqData = $request->input('dipa');

        try {
            foreach ($reqData as $dipa) {
                $activityCode = Str::of($dipa['activity']['code'])->upper();
                $activityName = $dipa['activity']['name'];

                // Find or create a BudgetImplementation with revisi 0
                $budgetImplementation = BudgetImplementation::where([
                    ['activity_code', $activityCode],
                    ['revisi', 0]
                ])->first() ?: new BudgetImplementation;
                $budgetImplementation->activity_name = $activityName;
                $budgetImplementation->activity_code = $activityCode;
                $budgetImplementation->save();

                foreach ($dipa['accounts'] as $accountData) {
                    $accountCode = AccountCode::where('code', $accountData['account']['code'])->first();
                    if ($budgetImplementation->account_code_id === null) {
                        $budgetImplementation->accountCode()->associate($accountCode)->save();
                    } else {
                        $budgetImplementation = new BudgetImplementation;
                        $budgetImplementation->activity_name = $activityName;
                        $budgetImplementation->activity_code = $activityCode;
                        $budgetImplementation->save();
                        $budgetImplementation->accountCode()->associate($accountCode)->save();
                    }

                    foreach ($accountData['expenditures'] as $expenditureData) {
                        $expenditureDetail = new ExpenditureDetail;
                        $expenditureDetail->name = $expenditureData['description'];
                        $expenditureDetail->volume = $expenditureData['volume'];
                        $expenditureDetail->price = $expenditureData['unit_price'];
                        $expenditureDetail->total = $expenditureData['total'];
                        $expenditureDetail->expenditure_unit_id = $this->findExpenditureUnitId($expenditureData['unit']);
                        $expenditureDetail->save();

                        if ($budgetImplementation->expenditure_detail_id === null) {
                            $budgetImplementation->expenditureDetail()->associate($expenditureDetail)->save();
                        } else {
                            $budgetImplementation = new BudgetImplementation;
                            $budgetImplementation->activity_name = $activityName;
                            $budgetImplementation->activity_code = $activityCode;
                            $budgetImplementation->save();
                            $budgetImplementation->accountCode()->associate($accountCode)->save();
                            $budgetImplementation->expenditureDetail()->associate($expenditureDetail)->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in store function: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(["message" => "success"]);
    }



    /**
     * Find the ID of the Expenditure Unit based on the unit name.
     * This is a placeholder function and should be implemented according to your application logic.
     *
     * @param string $unitName
     * @return int
     */
    private function findExpenditureUnitId($code)
    {
        // Implement the logic to find the Expenditure Unit ID based on the unit name.
        // This could involve querying the ExpenditureUnit model.
        $expenditureUnit = ExpenditureUnit::where('code', $code)->first();
        return $expenditureUnit ? $expenditureUnit->id : null;
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
