<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RoleStoreRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware(['isRegisterVerified', 'isActive']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Role $role)
    {
        /** Authorize with permission only */
        //$this->authorize('role-access');

        $roles = Role::all();
        $permissions = Permission::all();

        $title = 'Delete User Role!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);
       
        return view('roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** Authorize with permission only */
        $this->authorize('role-create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        $request->validated();

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        toast('Permission data added successfully!','success');
    
        return redirect()->route('roles.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {

        $roles = Role::find($role->id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$role->id)
            ->get();
    
        return view('roles.show',compact('roles','rolePermissions'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->authorize('role-edit');

        $roles = Role::find($role->id);

        //dd($roles);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('roles.edit',compact('roles','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleStoreRequest $request, Role $role)
    {
        //$this->authorize('role-update');

        $request->validated();
    
        $role = Role::find($role->id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));

        toast('Role updated successfully!', 'success');
    
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('role-delete');

        $role->delete();

        toast('User Role deleted successfully!', 'success');

        return redirect()->route('roles.index');
    }
}
