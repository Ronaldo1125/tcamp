<?php

namespace App\Http\Controllers;

use App\Models\Pap;
use App\Models\Region;
use App\Models\Travel;
use App\Models\Employee;
use Carbon\CarbonPeriod;
use App\Models\FundSource;
use Illuminate\Http\Request;
use App\Models\Transportation;
use App\Http\Requests\TravelStoreRequest;
use Illuminate\Support\Facades\Auth;

class TravelController extends Controller
{

    public function index(){

        $travel = Travel::all();

        return view('travel.index', compact('travel'));
    }


    public function create(){

        $fund_sources = FundSource::pluck('fund_source_acronym','id')->all();
        $paps = Pap::pluck('pap_name','id')->all();
        $transportations = Transportation::pluck('transportation_name','id')->all();
        $regions = Region::pluck('name', 'region_code');

        $times = [];
        $periods = CarbonPeriod::create('00:00', '5 minutes', '23:55');

        foreach ($periods as $period) 
        {
            $times[] = $period->format('H:i');
        }

        return view('travel.create', compact('fund_sources', 'paps', 'transportations', 'regions', 'times'));
        
    }
    

    public function store(TravelStoreRequest $request) 
    {

        $request->validated();

        // if($request->hasFile('purpose_image_filename')) 
        // {
        //     $newImageName = time() . '-travel.' . $request->purpose_image_filename->extension();
        //     $request->purpose_image_filename->move(public_path('travel_attachment'), $newImageName);
        // }
        
        dd($request);

        $employee = Employee::where('user_id', Auth::user()->id)->first();

        $travel = Travel::create([
            'purpose' => $request->purpose,
            'employee_id' => $employee->id,
            //'purpose_image_filename' => $newImageName,
            'destination' => $request->destination,
            'travel_departure_date' => $request->travel_departure_date,
            'travel_arrival_date' => $request->travel_arrival_date,
            'pap_id' => $request->pap_id,
            'is_travel_related_to_training' => $request->is_travel_related_to_training,
            'is_cash_advance' => $request->is_cash_advance,
            'grand_total' => $request->grand_total,
        ]);

        
        toast('Pre Travel Order created successfully!','success');

        return redirect()->route('travel.index');
    
    }
    
    // public function preview(Request $request) {

    //     $this->validate($request, [
    //         'inputs.*.estimated_time_of_departure' => 'required|date_format:H:i',
    //         'inputs.*.estimated_time_of_arrival' => 'required|date_format:H:i|after:inputs.*.estimated_time_of_departure'
    //     ]);
        
    //     $travel_informations = $request->all();



    //     return view('travel.preview', compact('travel_informations'));
    // }
}
