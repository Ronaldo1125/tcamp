<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Designation;

class TravelOrderService 
{

    public function getSupervisorEmailAddress($division_id) 
    {
        $supervisorRoleId = Role::where('role_name', 'Immediate Supervisor')->first();

        $supervisorUserData = User::where(
          ['division_id', $division_id],
          ['role_id', $supervisorRoleId->id]
          )->first(); 

        return $supervisorUserData;
    }
}