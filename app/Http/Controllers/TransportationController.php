<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransportationStoreRequest;
use Illuminate\Http\Request;
use App\Models\Transportation;

class TransportationController extends Controller
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
        //$this->authorize('transportation-access');

        $transportations = Transportation::all();

        // Session::put('division_url', request()->fullUrl());

        // echo Session::get('division_url');

        $title = 'Delete Transportation!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);

        return view('transportations.index', compact('transportations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('transportation-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransportationStoreRequest $request)
    {
        //$this->authorize('transportation-store');

        Transportation::create($request->validated());
        
        toast('Transportation data added successfully!','success');

        return redirect()->route('transportations.index');
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
        $this->authorize('transportation-edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransportationStoreRequest $request, Transportation $transportation)
    {
        //$this->authorize('transportation-update');

        $transportation->update($request->validated());

        toast('Transportation data updated successfully!','success');

        return redirect()->route('transportations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transportation $transportation)
    {
        $this->authorize('transportation-delete');

        $transportation->delete();

        toast('Transportation data deleted successfully!', 'success');

        return redirect()->route('transportations.index');
    }
}
