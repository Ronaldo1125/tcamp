<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesignationStoreRequest;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['isRegisterVerified', 'isActive']); 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** Authorize with permission only */
        //$this->authorize('designation-access');

        $designations = Designation::all();

        $title = 'Delete Designation!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);
        
        return view('designations.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** Authorize with permission only */
        $this->authorize('designation-create');

        return view('designations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesignationStoreRequest $request)
    {
        /** Authorize with permission only */
        //$this->authorize('designation-store');

        
        Designation::create($request->validated());
        
        toast('Designation data added successfully!','success');

        return redirect()->route('designations.index');

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
         $this->authorize('designation-edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DesignationStoreRequest $request, Designation $designation)
    {
        /** Authorize with permission only */
        //$this->authorize('designation-update');

        $designation->update($request->validated());

        toast('Designation data updated successfully!','success');

        // if(session('division_url')){
        //     return redirect(session('division_url'));
        // }

        return redirect()->route('designations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        /** Authorize with permission only */
        $this->authorize('designation-delete');

        $designation->delete();

        toast('Designation data deleted successfully!', 'success');

        return redirect()->route('designations.index');
    }
}
