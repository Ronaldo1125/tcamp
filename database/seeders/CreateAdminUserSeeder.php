<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $user = User::create([
            'name' => 'Ronaldo B. Banas', 
            'email' => 'rbbanas@neda.gov.ph',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => bcrypt('password'),
            'role_id' => 1,
            'division_id' => 1,
            'designation_id' => 11,
            'created_by_id' => 1,
            'is_active' => 1,
        ]);
        
        $role = Role::create(['name' => 'Admin']);
         
        $permissions = Permission::pluck('id','id')->all();
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
    }
}
