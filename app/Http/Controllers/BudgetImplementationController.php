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
use Illuminate\Support\Str;


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
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetImplementation $budgetImplementation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:activity,account,detail',
            'id' => 'required|integer',
            'code' => 'sometimes|string',
            'name' => 'required|string|max:255',
            'volume' => 'required|integer',
            'unit' => 'required|string|max:255',
            'unit_price' => 'required|string',
            'total' => 'required|string',
        ]);
        try {
            switch ($validatedData['type']) {
                case 'activity':
                    $budgetImplementation = BudgetImplementation::findOrFail($validatedData['id']);
                    $activity = Activity::updateOrCreate(
                        ['code' => $validatedData['code']],
                        ['name' => $validatedData['name']]
                    );
                    $budgetImplementation->activity()->associate($activity)->save();
                    return back()->with(['success' => 'Berhasil memperbarui data detail']);
                    break;

                case 'account':
                    $budgetImplementation = BudgetImplementation::findOrFail($validatedData['id']);
                    $accountCode = AccountCode::firstWhere('code', $validatedData['code']);
                    $budgetImplementation->accountCode()->associate($accountCode)->save();
                    return back()->with(['success' => 'Berhasil memperbarui data dipa']);
                    break;

                case 'detail':
                    $validatedData['unit_price'] = $this->convertToDecimal($validatedData['unit_price']);
                    $validatedData['total'] = $this->convertToDecimal($validatedData['total']);
                    $expenditureUnit = ExpenditureUnit::firstWhere('code', $validatedData['unit']);
                    $budgetImplementationDetail = BudgetImplementationDetail::findOrFail($validatedData['id']);
                    $budgetImplementationDetail->name = $validatedData['name'];
                    $budgetImplementationDetail->volume = $validatedData['volume'];
                    $budgetImplementationDetail->price = $validatedData['unit_price'];
                    $budgetImplementationDetail->total = $validatedData['total'];
                    $budgetImplementationDetail->expenditureUnit()->associate($expenditureUnit);
                    $budgetImplementationDetail->save();
                    return back()->with(['success' => 'Berhasil memperbarui data detail']);
                    break;

                default:
                    return back();
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return back();
        }
    }
    private function convertToDecimal($value)
    {
        // Remove the currency symbol, non-breaking spaces (\u{A0} or &nbsp;), and any regular spaces
        $number = str_replace(['Rp', ' ', "\xc2\xa0"], '', $value);

        // Replace Indonesian thousand separator (dot) with nothing
        $number = str_replace('.', '', $number);

        // Replace Indonesian decimal separator (comma) with a dot
        $number = str_replace(',', '.', $number);

        // Convert to float and format to two decimal places
        return number_format((float)$number, 2, '.', '');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($type, $id)
    {
        if ($type === 'detail') {
            try {
                BudgetImplementationDetail::find($id)->delete();
                return response()->json(['success' => 'true', 'message' => 'Berhasil menghapus data detail dipa.'], 200);
            } catch (\Throwable $th) {
                Log::error($th);
                return response()->json(['error' => 'true', 'message' => $th]);
            }
        }
        if ($type === 'activity') {
            try {
                // Find the BudgetImplementation record by ID
                $budgetImplementation = BudgetImplementation::find($id);

                // Check if the record exists
                if (!$budgetImplementation) {
                    return response()->json(['error' => 'true', 'message' => 'Budget Implementation not found.'], 404);
                }

                // Get the activity_id from the found record
                $activityId = $budgetImplementation->activity_id;

                // Delete all BudgetImplementation records with the same activity_id
                BudgetImplementation::where('activity_id', $activityId)->delete();

                return response()->json(['success' => 'true', 'message' => 'Berhasil menghapus data dipa.'], 200);
            } catch (\Throwable $th) {
                Log::error($th);
                return response()->json(['error' => 'true', 'message' => $th->getMessage()], 500);
            }
        }

        try {
            BudgetImplementation::find($id)->delete();
            return response()->json(['success' => 'true', 'message' => 'Berhasil menghapus data dipa.'], 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['error' => 'true', 'message' => $th]);
        }
    }
}
