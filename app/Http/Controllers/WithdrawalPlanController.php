<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\WithdrawalPlan;
use App\Enums\Month;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WithdrawalPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Rencana Penarikan Dana';
        $activities = Activity::with('withdrawalPlans')->sortedByCode()->get();
        $months = Month::cases(); // Assuming you have a Month Enum with cases for each month

        return view('app.withdrawal-plan', compact('title', 'activities', 'months'));
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
        try {
            $validatedData = $request->validate([
                'activityId' => 'required|integer|exists:activities,id',
                'withdrawalPlans' => 'required|array',
                'withdrawalPlans.*.month' => 'required|integer|min:1|max:12',
                'withdrawalPlans.*.amount_withdrawn' => 'required|numeric|min:0',
                'year' => 'required|integer|digits:4'
            ]);

            foreach ($validatedData['withdrawalPlans'] as $planData) {
                $monthEnum = Month::from($planData['month']);

                WithdrawalPlan::updateOrCreate(
                    [
                        'activity_id' => $validatedData['activityId'],
                        'month' => $monthEnum,
                        'year' => $validatedData['year'] ?? date('Y'),
                    ],
                    [
                        'amount_withdrawn' => $planData['amount_withdrawn'],
                    ]
                );
            }

            return response()->json(['message' => 'Data penarikan dana berhasil disimpan']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WithdrawalPlan $withdrawalPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WithdrawalPlan $withdrawalPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WithdrawalPlan $withdrawalPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WithdrawalPlan $withdrawalPlan)
    {
        //
    }

    /**
     * Get withdrawal plans for a specific activity.
     *
     * @param int $activityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithdrawalPlans($activityId, $year = null)
    {
        // If $year is not provided, set it to the current year
        $year = $year ?? date('Y');

        $withdrawalPlans = WithdrawalPlan::where('activity_id', $activityId)
            ->where('year', $year)
            ->get();

        return response()->json($withdrawalPlans);
    }
}
