<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['superAdmin', 'doctor', 'patient', 'admin', 'nurse'];

        foreach ($roles as $r) {
            $role = new Role();
            $role->name = $r;
            $role->save();
        }
        // app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // $permissions = collect([
        //     'patient-create',
        //     'patient-update',
        //     'patient-read',
        //     'patient-delete',
        //     'patient-print',
        //     'patient-report',
        //     'patient-import',
        //     'patient-export',
        //     'mr-create',
        //     'mr-update',
        //     'mr-read',
        //     'mr-delete',
        //     'mr-print',
        //     'mr-report',
        //     'mr-import',
        //     'mr-export',
        //     'registration-create',
        //     'registration-update',
        //     'registration-read',
        //     'registration-delete',
        //     'registration-print',
        //     'registration-report',
        //     'registration-import',
        //     'registration-export',
        //     'payment-create',
        //     'payment-update',
        //     'payment-read',
        //     'payment-delete',
        //     'payment-print',
        //     'payment-report',
        //     'payment-import',
        //     'payment-export',
        //     'report-create',
        //     'report-update',
        //     'report-read',
        //     'report-delete',
        //     'report-print',
        //     'report-report',
        //     'report-import',
        //     'report-export',
        //     'setting.general-create',
        //     'setting.general-update',
        //     'setting.general-read',
        //     'setting.general-delete',
        //     'setting.general-print',
        //     'setting.general-report',
        //     'setting.general-import',
        //     'setting.general-export',
        //     'setting.role-create',
        //     'setting.role-update',
        //     'setting.role-read',
        //     'setting.role-delete',
        //     'setting.role-print',
        //     'setting.role-report',
        //     'setting.role-import',
        //     'setting.role-export',
        //     'master.healthworker-create',
        //     'master.healthworker-update',
        //     'master.healthworker-read',
        //     'master.healthworker-delete',
        //     'master.healthworker-print',
        //     'master.healthworker-report',
        //     'master.healthworker-import',
        //     'master.healthworker-export',
        //     'master.drugmeddev-create',
        //     'master.drugmeddev-update',
        //     'master.drugmeddev-read',
        //     'master.drugmeddev-delete',
        //     'master.drugmeddev-print',
        //     'master.drugmeddev-report',
        //     'master.drugmeddev-import',
        //     'master.drugmeddev-export',
        //     'master.action-create',
        //     'master.action-update',
        //     'master.action-read',
        //     'master.action-delete',
        //     'master.action-print',
        //     'master.action-report',
        //     'master.action-import',
        //     'master.action-export',
        // ]);

        // $permissions->each(function ($item) {
        //     Permission::create([
        //         'name' => $item
        //     ]);
        // });

        // Role::create(['name' => 'Admin'])->givePermissionTo($permissions);
    }
}
