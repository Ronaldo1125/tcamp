<?php

namespace App\Http\Controllers;

use App\Models\Pap;
use App\Models\FundSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\FundSourceStoreRequest;

class FundSourceController extends Controller
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
        //$this->authorize('fund_source-access');

        $fund_sources = FundSource::all();

        $title = 'Delete Fund Source!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);

        return view('fund_sources.index', compact('fund_sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** Authorize with permission only */
        $this->authorize('fund_source-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FundSourceStoreRequest $request)
    {
        /** Authorize with permission only */
        //$this->authorize('fund_source-store');

        FundSource::create($request->validated());
        
        toast('Fund Source data added successfully!','success');

        return redirect()->route('fund_sources.index');
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
        $this->authorize('fund_source-edit');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FundSourceStoreRequest $request, FundSource $fund_source)
    {
        /** Authorize with permission only */
        //$this->authorize('fund_source-update');
        
        $fund_source->update($request->validated());

        toast('Fund Source data updated successfully!','success');

        return redirect()->route('fund_sources.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundSource $fund_source)
    {
        /** Authorize with permission only */
        $this->authorize('fund_source-delete');

        $fund_source->delete();

        toast('Fund Source data deleted successfully!', 'success');

        return redirect()->route('fund_sources.index');
    }
}
