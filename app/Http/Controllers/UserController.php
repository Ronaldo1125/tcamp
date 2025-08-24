<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Jobs\RegisterApprovalJob;
use App\Mail\UserRegisterApproved;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Notifications\RegistrationApproved;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\UserApproveRegistrationRequest;
use App\Notifications\UserRegistrationApproved;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['isRegisterVerified','isActive']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** Authorize with permission only */
        //$this->authorize('user-access');
//dd(Auth::user()->getRoleNames(Auth::user()->role_id));


        //$role_id = Auth::user()->role_id;
        //$user_id = Auth::user()->id;
        //$role = Role::where('id', $role_id)->first();
        $users = User::all();

        // if($role->name != 'Admin') {
        //     echo "Im here";
        //     $users = User::where('id', $user_id)->get();
        // }
        
        $roles = Role::pluck('name', 'id')->all();
        $divisions = Division::pluck('division_acronym', 'id')->all();
        $designations = Designation::pluck('designation_acronym', 'id')->all();
        //dd($roles);

        $title = 'Delete User!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);
  
        return view('users.index',compact('users', 'roles', 'divisions', 'designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** Authorize with permission only */
        $this->authorize('user-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'division_id' => $request->division_id,
            'designation_id' => $request->designation_id,
            'role_id' => $request->role_id,
            'created_by_id' => $request->created_by_id,
            'is_active' => $request->has('is_active'),
        ]);

        $user->assignRole($request->input('role_id'));
        
        toast('User data added successfully!','success');

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        $this->authorize('user-edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        //dd($user);

        $request->validated();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'division_id' => $request->division_id,
            'designation_id' => $request->designation_id,
            'role_id' => $request->role_id,
            'created_by_id' => $request->created_by_id,
            'is_active' => $request->has('is_active'),
        ]);

        DB::table('model_has_roles')->where('model_id',$request->id)->delete();

        $user->syncRoles($request->role_id);
        //$user->assignRole($request->role_id);
    
        toast('User updated successfully!','success');

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('user-delete');

        $user->delete();
        toast('User deleted successfully!', 'success');
        return redirect()->route('users.index');
    }

    public function viewUnapproveUsers()
    {
        $this->authorize('user-approval-update');

        $users = User::where('is_active', '=' , 0)->get();

        $roles = Role::pluck('name', 'id')->all();
        $divisions = Division::pluck('division_acronym', 'id')->all();
        $designations = Designation::pluck('designation_acronym', 'id')->all();

        return view('users.view_unapprove_users', compact('users', 'roles', 'divisions', 'designations'));
    }

    public function approveRegistration(UserApproveRegistrationRequest $request) {

        $this->authorize('user-approval-update');

        $request->validated();
        $user = User::find($request->id);

        if($request->has('is_active')){
            $user->update([
                'division_id' => $request->division_id,
                'designation_id' => $request->designation_id,
                'role_id' => $request->role_id,
                'is_active' => $request->has('is_active'),
            ]);

            $user->syncRoles($request->role_id);

            //Mail::to($user->email)->send(new UserRegisterApproved($user));
            //Mail::to($user->email)->send(new UserRegisterApproved($user));
            //dispatch(new RegisterApprovalJob($user->email,$user));
            //Notification::send($user, new RegistrationApproved());
            Notification::send($user, new UserRegistrationApproved());
            //request()->user()->notify(new UserRegistrationApproved());

            toast('User registration approved successfully!', 'success');
        } else {
            toast('User registration is disapproved!', 'error');
        }

        return redirect()->route('users.view_unapprove_users');
    }
}
