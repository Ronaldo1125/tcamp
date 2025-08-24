<?php

namespace App\Http\Controllers;

use App\Http\Requests\PapStoreRequest;
use App\Models\FundSource;
use App\Models\Pap;
use Illuminate\Http\Request;

class PapController extends Controller
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
        //$this->authorize('pap-access');

        $paps = Pap::all();
        $fund_sources = FundSource::pluck('fund_source_acronym', 'id')->all();

        $title = 'Delete MFO/PAPs!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);

        return view('paps.index', compact('paps', 'fund_sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** Authorize with permission only */
        $this->authorize('pap-create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PapStoreRequest $request)
    {
        /** Authorize with permission only */
        //$this->authorize('pap-store');


        Pap::create($request->validated());
        
        toast('MFO/PAP data added successfully!','success');

        return redirect()->route('paps.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pap $pap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pap $pap)
    {
        /** Authorize with permission only */
        $this->authorize('pap-edit');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PapStoreRequest $request, Pap $pap)
    {
        /** Authorize with permission only */
        //$this->authorize('pap-update');

        $pap->update($request->validated());

        toast('MFO/PAP data updated successfully!','success');

        return redirect()->route('paps.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pap $pap)
    {
        /** Authorize with permission only */
        $this->authorize('pap-delete');

        $pap->delete();

        toast('MFO/PAP data deleted successfully!', 'success');

        return redirect()->route('paps.index');
    }

    public function getPaps(Request $request) {
        
        $fund_source_id = $request->fund_source_id;

        $paps = Pap::where('fund_source_id', $fund_source_id)->get();

        return response()->json($paps);

    }
}
