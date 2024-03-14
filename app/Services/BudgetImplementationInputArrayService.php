<?php

namespace App\Services;

use App\Models\AccountCode;
use App\Models\Activity;
use App\Models\BudgetImplementation;
use App\Models\BudgetImplementationDetail;
use App\Models\ExpenditureUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BudgetImplementationInputArrayService
{
    public function process($inputArray)
    {
        foreach ($inputArray as $inputData) {
            DB::transaction(function () use ($inputData) {
                $this->processInputData($inputData);
            });
        }
    }

    private function processInputData($inputData)
    {
        $activity = $this->updateOrCreateActivity($inputData['activity']);

        if (isset($inputData['bi'])) {
            $this->handleExistingBudgetImplementation($inputData['bi'], $inputData['accounts']);
        } elseif (! empty($inputData['accounts'])) {
            $this->processAccounts($inputData['accounts'], $activity);
        } else {
            $this->createBudgetImplementationWithUniqueCheck($activity, null);
        }
    }

    private function handleExistingBudgetImplementation($biId, $accounts)
    {
        $oldBudgetImplementation = BudgetImplementation::find($biId);
        if (! $oldBudgetImplementation) {
            Log::error("Budget implementation not found with ID: $biId");

            return;
        }

        // Use the same activity_id from the old budget implementation
        $activity = $oldBudgetImplementation->activity;

        // Process accounts with the same activity but potentially different account codes
        foreach ($accounts as $accountData) {
            $this->createBudgetImplementationWithUniqueCheck($activity, $accountData, $oldBudgetImplementation->revision + 1);
        }
    }

    private function createBudgetImplementationWithUniqueCheck(Activity $activity, $accountData, $revision = 0)
    {
        $accountCodeId = null;
        if ($accountData) {
            $accountCode = AccountCode::where('code', $accountData['account']['code'])->firstOrFail();
            $accountCodeId = $accountCode->id;
        }

        // Retrieve or create a BudgetImplementation
        $budgetImplementation = BudgetImplementation::firstOrCreate(
            [
                'activity_id' => $activity->id,
                'account_code_id' => $accountCodeId,
                'revision' => 0,
            ],
            [
                'activity_id' => $activity->id,
                'account_code_id' => $accountCodeId,
                'revision' => 0,
            ]
        );

        // Always create new budget implementation details
        $this->createBudgetImplementationDetails($budgetImplementation, $accountData);
    }

    private function updateOrCreateActivity($activityData)
    {
        return Activity::updateOrCreate(
            ['code' => $activityData['code']],
            ['name' => $activityData['name']]
        );
    }

    private function processAccounts($accounts, Activity $activity)
    {
        foreach ($accounts as $accountData) {
            $this->createBudgetImplementationWithUniqueCheck($activity, $accountData);
        }
    }

    private function createBudgetImplementationDetails($budgetImplementation, $accountData)
    {
        if (isset($accountData['expenditures']) && ! empty($accountData['expenditures'])) {
            foreach ($accountData['expenditures'] as $detail) {
                // Check if $detail['id'] is set to determine if it's for creating a new detail

                if (! isset($detail['id']) && empty($detail['id'])) {
                    BudgetImplementationDetail::create([
                        'budget_implementation_id' => $budgetImplementation->id,
                        'expenditure_unit_id' => ExpenditureUnit::where('code', $detail['unit'])->first()->id,
                        'name' => $detail['description'],
                        'volume' => $detail['volume'],
                        'price' => $detail['unit_price'],
                        'total' => $detail['total'],
                    ]);
                }
                // Else, handle existing detail (e.g., update or skip)
                else {
                    // Log::info(BudgetImplementationDetail::find($detail['id']));
                }
            }
        }
    }
}
