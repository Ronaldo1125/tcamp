<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** Authorize with permission only */
        //$this->authorize('employee-access');

        $employees = Employee::all();
        //$users = User::pluck('email', 'id')->all();
        $users = User::where('is_assigned', 0)->pluck('email', 'id')->all();
        //dd($users);
        $divisions = Division::pluck('division_acronym', 'id')->all();
        $designations = Designation::pluck('designation_acronym', 'id')->all();
        
        $title = 'Delete Employee!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);

        return view('employees.index', compact('employees', 'users', 'divisions', 'designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** Authorize with permission only */
        $this->authorize('employee-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeStoreRequest $request)
    {
         /** Authorize with permission only */
        //$this->authorize('employee-store');

        $request->validated();
        
        if($request->hasFile('esignature_filename')) 
        {
            $newImageName = time() . '-' . $request->last_name . '.' . $request->esignature_filename->extension();
            $request->esignature_filename->move(public_path('esignature_image'), $newImageName);
        }

        Employee::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'user_id' => $request->user_id,
            'division_id' => $request->division_id,
            'designation_id' => $request->designation_id,
            'esignature_filename' => $newImageName,
            'created_by_id' => $request->created_by_id,
        ]);

        User::where('id', $request->user_id)->update(['is_assigned' => 1]);

        toast('Employee data added successfully!','success');

        return redirect()->route('employees.index');

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
    public function edit(string $id)
    {
         /** Authorize with permission only */
        $this->authorize('employee-edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, Employee $employee)
    {
         /** Authorize with permission only */
        //$this->authorize('employee-update');

        $request->validated();

        if($request->hasFile('esignature_filename')) 
        {
            $imageDestination = 'esignature_image/'. $employee->esignature_filename;
            if(File::exists($imageDestination))
            {
                File::delete($imageDestination);
            }

            $newImageName = time() . '-' . $request->last_name . '.' . $request->esignature_filename->extension();
            $request->esignature_filename->move(public_path('esignature_image'), $newImageName);
        }
        
        Employee::where('id', $employee->id)
                ->update([
                    'last_name' => $request->last_name,
                    'first_name' => $request->first_name,
                    'middle_name' => $request->middle_name,
                    'user_id' => $employee->user_id,
                    'division_id' => $request->division_id,
                    'designation_id' => $request->designation_id,
                    'esignature_filename' => $newImageName,
                    'created_by_id' => $employee->created_by_id,
                ]);

        // User::where('id', $request->user_id)->update(['is_assigned' => 1]);

        toast('Employee data updated successfully!','success');

        return redirect()->route('employees.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
         /** Authorize with permission only */
        $this->authorize('employee-delete');

        $employee->delete();

        $imageDestination = 'esignature_image/'. $employee->esignature_filename;
        if(File::exists($imageDestination))
        {
            File::delete($imageDestination);
        }

        User::where('id', $employee->user_id)->update(['is_assigned' => 0]);

        toast('Employee deleted successfully!', 'success');

        return redirect()->route('employees.index');
    }
}
