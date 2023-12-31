<?php

use App\Http\Controllers\AccountCodeController;
use App\Http\Controllers\ActivityRecapController;
use App\Http\Controllers\BudgetImplementationController;
use App\Http\Controllers\PerformanceIndicatorController;
use App\Http\Controllers\ProgramTargetController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\WorkUnitController;
use App\Http\Controllers\ExpenditureUnitController;
use App\Http\Controllers\InstitutionalBudgetController;
use App\Http\Controllers\SBMSBIController;
use App\Http\Controllers\UnitBudgetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalPlanController;
use App\Http\Controllers\RuhPaymentController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('dasbor', function () {
        return view('app.dashboard', ['title' => 'Dasbor']);
    })->name('admin.dashboard');

    Route::get('/api/program-targets', [ProgramTargetController::class, 'getProgramTargets'])->name('program_targets.index');
    Route::get('/api/withdrawal-plans/{activityId}', [WithdrawalPlanController::class, 'getWithdrawalPlans'])->name('withdrawal_plans.activity');


    Route::prefix('renstra')->group(function () {
        Route::get('visi', [RenstraController::class, 'vision'])->name('vision.index');
        Route::patch('edit-visi', [RenstraController::class, 'updateVision'])->name('vision.update');
        Route::get('misi', [RenstraController::class, 'mission'])->name('mission.index');
        Route::post('tambah-misi', [RenstraController::class, 'storeMission'])->name('mission.store');
        Route::post('hapus-misi', [RenstraController::class, 'deleteMission'])->name('mission.delete');
        Route::get('iku', [RenstraController::class, 'iku'])->name('iku.index');
        Route::post('tambah-iku', [RenstraController::class, 'storeIku'])->name('iku.store');
        Route::post('hapus-iku', [RenstraController::class, 'deleteIku'])->name('iku.delete');
    });
    Route::prefix('perkin')->group(function () {
        Route::get('sasaran-program', [ProgramTargetController::class, 'index'])->name('program_target.index');
        Route::post('sasaran-program', [ProgramTargetController::class, 'store'])->name('program_target.store');
        Route::delete('sasaran-program/{programTarget}/hapus', [ProgramTargetController::class, 'destroy'])->name('program_target.delete');
        Route::patch('sasaran-program/{programTarget}/update', [ProgramTargetController::class, 'update'])->name('program_target.update');
        Route::get('indikator-kinerja', [PerformanceIndicatorController::class, 'index'])->name('performance_indicator.index');
        Route::post('indikator-kinerja', [PerformanceIndicatorController::class, 'store'])->name('performance_indicator.store');
        Route::delete('indikator-kinerja/{performanceIndicator}/hapus', [PerformanceIndicatorController::class, 'destroy'])->name('performance_indicator.delete');
        Route::patch('indikator-kinerja/{performanceIndicator}/update', [PerformanceIndicatorController::class, 'update'])->name('performance_indicator.update');
    });
    Route::prefix('pengaturan')->group(function () {
        Route::get('unit-kerja', [WorkUnitController::class, 'index'])->name('work_unit.index');
        Route::post('unit-kerja', [WorkUnitController::class, 'store'])->name('work_unit.store');
        Route::patch('unit-kerja/{workUnit}/update', [WorkUnitController::class, 'update'])->name('work_unit.update');
        Route::delete('unit-kerja/{workUnit}/hapus', [WorkUnitController::class, 'destroy'])->name('work_unit.delete');
        Route::get('satuan-belanja', [ExpenditureUnitController::class, 'index'])->name('expenditure_unit.index');
        Route::post('satuan-belanja', [ExpenditureUnitController::class, 'store'])->name('expenditure_unit.store');
        Route::patch('satuan-belanja/{expenditureUnit}/update', [ExpenditureUnitController::class, 'update'])->name('expenditure_unit.update');
        Route::delete('satuan-belanja/{expenditureUnit}/hapus', [ExpenditureUnitController::class, 'destroy'])->name('expenditure_unit.delete');
        Route::get('kode-akun', [AccountCodeController::class, 'index'])->name('account_code.index');
        Route::post('kode-akun', [AccountCodeController::class, 'store'])->name('account_code.store');
        Route::patch('kode-akun/{accountCode}/update', [AccountCodeController::class, 'update'])->name('account_code.update');
        Route::delete('kode-akun/{accountCode}/hapus', [AccountCodeController::class, 'destroy'])->name('account_code.delete');
        Route::get('sbm-sbi', [SBMSBIController::class, 'index'])->name('sbm_sbi.index');
        Route::post('sbm-sbi', [SBMSBIController::class, 'store'])->name('sbm_sbi.store');
        Route::get('pagu-lembaga', [InstitutionalBudgetController::class, 'index'])->name('ins_budget.index');
        Route::post('pagu-lembaga', [InstitutionalBudgetController::class, 'store'])->name('ins_budget.store');
        Route::get('pagu-unit', [UnitBudgetController::class, 'index'])->name('unit_budget.index');
        Route::post('pagu-unit', [UnitBudgetController::class, 'store'])->name('unit_budget.store');
        Route::get('kelola-user', [UserController::class, 'index'])->name('user.index');
        Route::post('user', [UserController::class, 'store'])->name('user.store');
        Route::patch('user/{user}/update', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/{user}/hapus', [UserController::class, 'destroy'])->name('user.delete');
    });
    Route::prefix('penganggaran')->group(function () {
        Route::get('dipa', [BudgetImplementationController::class, 'index'])->name('budget_implementation.index');
        Route::post('dipa', [BudgetImplementationController::class, 'store'])->name('budget_implementation.store');
        Route::patch('edit-dipa', [BudgetImplementationController::class, 'update'])->name('budget_implementation.update');
        Route::delete('hapus-dipa/{type}/{id}', [BudgetImplementationController::class, 'destroy'])->name('budget_implementation.delete');
        Route::get('rekap-kegiatan-dan-upload-data-dukung', [ActivityRecapController::class, 'index'])->name('activity_recap.index');
        Route::post('rekap-kegiatan-dan-upload-data-dukung', [ActivityRecapController::class, 'store'])->name('activity_recap.store');
        Route::get('rekap-kegiatan/bukti-dukung/{activityRecap}', [ActivityRecapController::class, 'showFile'])
            ->name('activity-recap.show-file');
        Route::post('rekap-kegiatan-dan-upload-data-dukung/update-status', [ActivityRecapController::class, 'updateStatus'])->name('activity_recap.update_status');
        Route::get('rencana-penarikan-dana', [WithdrawalPlanController::class, 'index'])->name('withdrawal_plan.index');
        Route::post('rencana-penarikan-dana', [WithdrawalPlanController::class, 'store'])->name('withdrawal_plan.store');
    });
    Route::prefix('pembayaran')->group(function () {
        Route::get('ruh-pembayaran', [RuhPaymentController::class, 'index'])->name('ruh_payment.index');
    });
});
