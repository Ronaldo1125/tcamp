<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\DivisionStoreRequest;

class DivisionController extends Controller
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
        //$this->authorize('division-access');

        $divisions = Division::all();

        // $lastActivity = Activity::where('subject_type', 'App\Models\Division')->get();

        // dd($lastActivity);

        // Session::put('division_url', request()->fullUrl());

        // echo Session::get('division_url');

        $title = 'Delete Division!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);

        return view('divisions.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** Authorize with permission only */
        $this->authorize('division-create');

        return view('divisions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DivisionStoreRequest $request)
    {
        /** Authorize with permission only */
        //$this->authorize('division-store');

        Division::create($request->validated());
        
        toast('Division data added successfully!','success');

        return redirect()->route('divisions.index');

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
    public function edit(Division $division)
    {
        //dd($division);
        /** Authorize with permission only */
        $this->authorize('division-edit');


        //echo $division->id;
        return view('divisions.edit', compact('division'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DivisionStoreRequest $request, Division $division)
    {
        /** Authorize with permission only */
        //$this->authorize('division-update');

        $division->update($request->validated());

        toast('Division data updated successfully!','success');

        // if(session('division_url')){
        //     return redirect(session('division_url'));
        // }

        return redirect()->route('divisions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        /** Authorize with permission only */
        $this->authorize('division-delete');

        $division->delete();

        toast('Division deleted successfully!', 'success');

        return redirect()->route('divisions.index');
    }
}
