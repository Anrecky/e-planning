<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'PPK',
            'SPI',
            'STAF PPK',
            'SUPER ADMIN PERENCANAAN',
            'ADMIN FAKULTAS/UNIT',
            'KPA (REKTOR)',
            'BENDAHARA',
            'Pelaksana Kegiatan'
        ];

        $models = [
            'AccountCode', 'AccountCodeReception', 'Activity', 'ActivityRecap',
            'Asset', 'AssetItem', 'BudgetImplementation', 'BudgetImplementationDetail',
            'Employee', 'ExpenditureUnit', 'InstitutionalBudget', 'PaymentVerification',
            'PerformanceIndicator', 'ProgramTarget', 'PPK', 'Receipt', 'ReceiptLog',
            'Reception', 'Renstra', 'Role', 'Treasurer', 'UnitBudget',
            'User', 'Verificator', 'WithdrawalPlan', 'WorkUnit'
        ];

        $actions = ['create', 'edit', 'delete'];

        // Generate permissions for all models except 'SBMSBI'
        $permissions = collect($actions)->flatMap(function ($action) use ($models) {
            return collect($models)->map(function ($model) use ($action) {
                return [
                    'name' => $action . ' ' . strtolower(Str::snake($model, ' ')),
                    'guard_name' => 'web',
                ];
            });
        });

        // Add 'upload' permission for 'SBM&SBI' model
        $permissions->push([
            'name' => 'upload SBM&SBI',
            'guard_name' => 'web',
        ]);
        $permissions->push([
            'name' => 'view SBM&SBI',
            'guard_name' => 'web',
        ]);

        Permission::insert($permissions->toArray());

        // Create roles
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
        Role::where('name', 'ADMIN FAKULTAS/UNIT')->first()->givePermissionTo('view SBM&SBI');
    }
}
