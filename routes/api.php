<?php

use App\Http\Controllers\AccountCodeController;
use App\Http\Controllers\AccountCodeReceptionController;
use App\Http\Controllers\ActivityRecapController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetItemController;
use App\Http\Controllers\BudgetImplementationController;
use App\Http\Controllers\BudgetImplementationDetailController;
use App\Http\Controllers\PaymentReceiptController;
use App\Http\Controllers\PPKController;
use App\Http\Controllers\ProgramTargetController;
use App\Http\Controllers\TreasurerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificatorController;
use App\Http\Controllers\WithdrawalPlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/verificators', [VerificatorController::class, 'getVerificators'])->name('verificators.index');
    Route::get('/program-targets', [ProgramTargetController::class, 'getProgramTargets'])->name('program_targets.index');
    Route::get('/ppks', [PPKController::class, 'getPPKs'])->name('ppks.index');
    Route::get('/treasurers', [TreasurerController::class, 'getTreasurers'])->name('treasurers.index');
    Route::get('/withdrawal-plans/{activityId}/{year?}', [WithdrawalPlanController::class, 'getWithdrawalPlans'])->name('withdrawal_plans.activity');
    Route::get('/activity/{activityId}/account-codes', [AccountCodeController::class, 'getAccountCodesByActivity'])->name('account_codes.activity');
    Route::get('/details/{activityId}/{accountCodeId}', [BudgetImplementationDetailController::class, 'getByActivityAccountCode'])->name('budget_implementation_details.activity_account_code');
    Route::get('/detail/{budgetImplementationDetail}', [BudgetImplementationDetailController::class, 'show'])->name('detail.show');
    Route::get('/account-code-receptions', [AccountCodeReceptionController::class, 'getAccountCodes'])->name('account_code_receptions.index');
    Route::get('/selected-account-code-reception/{accountCodeReception}', [AccountCodeReceptionController::class, 'getSelectedAccountCode'])->name('account_code_receptions.selected');
    Route::get('/asset-items/{category?}', [AssetItemController::class, 'getAssetItemBySelectedCategory'])->name('asset_items.selected_category');
    // Get Receipt Total Amount By Budget Implementation Detail ID
    Route::get('/receipt/total-amount/{detail}', [PaymentReceiptController::class, 'totalAmountByBudgetImplementationDetail'])->name('receipts.total_amount');

    Route::get('/search-user', [UserController::class, 'getUsers'])->name('search-user');
});
