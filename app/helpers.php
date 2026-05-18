<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;


if(!function_exists('default_immediate_supervisor_id')) {
    function default_immediate_supervisor_id(){

        if(Auth::check()) {

            $user = auth()->user();

            $immediate_supervisor = User::where('division_id', $user->division_id) // Where condition on the 'users' table
                ->whereHas('role', function ($query) {
                    $query->where('name', 'Immediate Supervisor'); // Where condition on the related 'posts' table
                })
                ->first();

            // $management = User::whereHas('designation', function($query){
            //         $query->where('designation_name', 'Assistant Regional Director');
            // })->firstOrFail();

            if(!empty($immediate_supervisor)) {
                return $immediate_supervisor->id;
            }
        }
        return null;
    }
}

if(!function_exists('default_management_id')) {
    function default_management_id(){

        if(Auth::check()) {

            $management = User::whereHas('designation', function($query){
                    $query->where('designation_name', 'Assistant Regional Director');
            })->first();

            if(!empty($management)) {
                return $management->id;
            }      
        }
        return null;
    }
}

if(!function_exists('default_budget_officer_id')) {
    function default_budget_officer_id(){

        if(Auth::check()) {

            $budget_officer = User::whereHas('role', function($query){
                    $query->where('name', 'Budget Officer');
            })->first();
//dd($budget_officer);

            if(!empty($budget_officer)) {
                return $budget_officer->id;
            }  
                
        }
        return null;
    }
}

if(!function_exists('to_number')) {
    function to_number($toDate, $id) {
        return $toDate . "-" . sprintf("%03d", $id);
    }
}