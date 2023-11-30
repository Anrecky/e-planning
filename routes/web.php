<?php

use App\Http\Controllers\AccountCodeController;
use App\Http\Controllers\PerformanceIndicatorController;
use App\Http\Controllers\ProgramTargetController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\WorkUnitController;
use App\Http\Controllers\ExpenditureUnitController;
use App\Http\Controllers\SBMSBIController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('dasbor', function () {
        return view('app.dashboard', ['title' => 'Dasbor']);
    })->name('admin.dashboard');

    Route::get('/api/program-targets', [ProgramTargetController::class, 'getProgramTargets'])->name('program-targets.index');

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
    });
});
