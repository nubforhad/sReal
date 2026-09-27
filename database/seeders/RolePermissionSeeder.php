<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /* Clear Existing Cache */
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        /* Modules */
        $modules = [
            'dashboard',
            'company',
            'branch',
            'project',
            'client',
            'land',
            'land-share-sale',
            'land-share-payment',
            'land-registration',
            'rajuk',
            'building',
            'floor',
            'flat',
            'construction',
            'boq',
            'procurement',
            'inventory',
            'contractor',
            'construction-cost',
            'service-charge',
            'installment',
            'payment',
            'payment-point',
            'flat-choice',
            'flat-allocation',
            'agreement',
            'handover',
            'complaint',
            'income',
            'expense',
            'finance',
            'employee',
            'payroll',
            'crm',
            'document',
            'notification',
            'report',
        ];
        /*Actions */
        $actions = [
            'view',
            'create',
            'edit',
            'delete',
            'print',
            'approve',
            'payment',
            'export',
        ];
        /* Create Permissions */
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $module . '.' . $action,
                    'guard_name' => 'web',
                ]);
            }
        }
        /*  Roles */
        $roles = [
            'Super Admin',
            'Company Admin',
            'Branch Manager',
            'Project Manager',
            'Sales Manager',
            'Sales Executive',
            'Accountant',
            'Land Officer',
            'Construction Manager',
            'Procurement Officer',
            'Store Manager',
            'HR',
            'Reception',
            'Viewer',
        ];
        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }
    }
}