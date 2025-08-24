<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'travel-list',
            'travel-create',
            'travel-edit',
            'travel-delete',
            'division-list',
            'division-create',
            'division-edit',
            'division-delete',
            'designation-list',
            'designation-create',
            'designation-edit',
            'designation-delete',
            'transportation-list',
            'transportation-create',
            'transportation-edit',
            'transportation-delete',
            'pap-list',
            'pap-create',
            'pap-edit',
            'pap-delete',
            'fund_source-list',
            'fund_source-create',
            'fund_source-edit',
            'fund_source-delete',
            'user-approval-update'
        ];
        
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
