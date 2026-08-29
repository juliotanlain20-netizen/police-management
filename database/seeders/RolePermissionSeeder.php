<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $police=Role::where('name','police')->firstOrFail();
        $admin=Role::where('name','admin')->firstOrFail();
        $policePermissions =Permission::whereIn('slug',[
            'complaint.view_all',
            'complaint.request_more_evidence',
            'complaint.reject',
            'case.create',
            'case.view_all',
            'case.update',
        ])->pluck('id');
        $police->permissions()->syncWithoutDetaching(
            $policePermissions
        );
        $admin->permissions()->syncWithoutDetaching(
            Permission::pluck('id')
        );

    }
}
