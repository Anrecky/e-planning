<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

class NavigationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->resolving(Navigation::class, function (Navigation $navigation): Navigation {
            return $navigation
                ->add('Dasbor', route('admin.dashboard'))
                ->add('Penerimaan', route('reception.index'))
                ->add(
                    'Perencanaan',
                    url('#'),
                    fn (Section $section) => $section
                        ->add(
                            'Renstra',
                            url('#'),
                            fn (Section $section) => $section
                                ->add('Visi', route('vision.index'))
                                ->add('Misi', route('mission.index'))
                                ->add('Indikator Kinerja Utama', route('iku.index'))
                                ->add('Capaian Kinerja Tahun Sebelumnya', url('#'))
                                ->attributes(['permission' => 'view perencanaan'])
                        )
                        ->add(
                            'RKT',
                            url('#'),
                            fn (Section $section) => $section
                                ->add('Visi', route('vision.index'))
                                ->add('Misi', route('mission.index'))
                                ->add('Indikator Kinerja Utama', url('#'))
                                ->add('Capaian Kinerja Tahun Sebelumnya', url('#'))
                                ->attributes(['permission' => 'view perencanaan'])
                        )
                        ->add(
                            'Perkin',
                            url('#'),
                            fn (Section $section) => $section
                                ->add('Sasaran Program', route('program_target.index'))
                                ->add('Misi', route('performance_indicator.index'))
                                ->attributes(['permission' => 'view perencanaan'])
                        )
                        ->attributes(['permission' => 'view perencanaan'])
                )
                ->add(
                    'Penganggaran',
                    url('#'),
                    fn (Section $section) => $section
                        ->add('Usulan Dipa', route('budget_implementation.index'), fn ($section) => $section->attributes(['permission' => 'view penganggaran']))
                        ->add('Revisi Dipa', url('#'), fn ($section) => $section->attributes(['permission' => 'view penganggaran']))
                        ->add('Rencana Penarikan Dana', route('withdrawal_plan.index'), fn ($section) => $section->attributes(['permission' => 'view penganggaran']))
                        ->add('Rekap Kegiatan dan Upload Data Dukung', route('activity_recap.index'), fn ($section) => $section->attributes(['permission' => 'view penganggaran']))
                        ->attributes(['permission' => 'view penganggaran'])
                )
                ->add(
                    'Pembayaran',
                    url('#'),
                    fn (Section $section) => $section
                        ->add(
                            'Rekam Pembayaran',
                            route('payment-receipt.index'),
                            fn ($section) => $section->attributes(['permission' => 'view pembayaran'])
                        )->add(
                            'Usulan Pembayaran',
                            route('payment-receipt.list'),
                            fn ($section) => $section->attributes(['permission' => 'approval pembayaran'])
                        )
                        ->attributes(['permission' => 'view pembayaran'])
                )
                ->add(
                    'Pelaporan',
                    url('#'),
                    fn (Section $section) => $section
                        ->add(
                            'Cetak Laporan',
                            url('#'),
                            fn (Section $section) => $section
                                ->add('Laporan FA Detail', route('detailed-FA-report.index'), fn ($section) => $section->attributes(['permission' => 'view pelaporan']))
                                ->attributes(['permission' => 'view pelaporan'])
                        )
                        ->attributes(['permission' => 'view pelaporan'])
                )
                ->add(
                    'Administrasi',
                    url('#'),
                    fn (Section $section) => $section
                        ->add('Unit Kerja', route('work_unit.index'))
                        ->add('Pagu Lembaga', route('ins_budget.index'))
                        ->add('Pagu Unit', route('unit_budget.index'))
                        ->add('Satuan Belanja', route('expenditure_unit.index'))
                        ->add(
                            'Kode Akun',
                            url('#'),
                            fn (Section $section) => $section
                                ->add('Penganggaran & Pembayaran', route('account_code.index'))
                                ->add('Penerimaan', route('account_code_reception.index'))
                        )
                        ->add(
                            'PIC Pembayaran',
                            url('#'),
                            fn (Section $section) => $section
                                ->add('Bendahara', url('#'))
                                ->add('PPK', route('ppk.index'))
                                ->add('Verifikator', url('#'))
                        )
                        ->add('SBM dan SBI', route('sbm_sbi.index'), fn ($section) => $section->attributes(['permission' => 'view sbm&sbi']))
                        ->add('Manajemen User', route('user.index'))
                        ->attributes(['permission' => 'view sbm&sbi'])
                );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
