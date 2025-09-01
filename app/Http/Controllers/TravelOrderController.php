<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pap;
use App\Models\Role;
use App\Models\User;
use App\Mail\TestMail;
use App\Models\Region;
use App\Models\Division;
use App\Models\Employee;
use Carbon\CarbonPeriod;
use App\Models\FundSource;
use App\Models\Designation;
use App\Models\TravelOrder;
use App\Models\ApprovalType;
use Illuminate\Http\Request;
use App\Models\Transportation;
use App\Models\TravelItinerary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\TravelOrderUserApproval;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ApplicationTravelOrder;
use App\Http\Requests\TravelOrderStoreRequest;
use App\Notifications\TravelOrderNotifyUser;

class TravelOrderController extends Controller
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
        //$travel_orders = TravelOrder::find(1);

        $role = Auth::user()->roles[0]['name'];

        $travel_orders = TravelOrder::all();

        if($role == 'Staff') {
            $travel_orders = TravelOrder::where( 'user_id', '=', Auth::user()->id)->get();
        } 
        
        if ($role == 'Immediate Supervisor') {
            $ids = $this->getUserIdInDivision(Auth::user()->division_id);
            $travel_orders = $travel_orders->whereIn('user_id',$ids);
        }
        
        $approval_types = ApprovalType::pluck('approval_type_name', 'id')->all();

        //dd($travel_orders->user->employee->division->division_name);

        //dd(Auth::user()->employee->division->id);
        // $division = Auth::user()->employee->division;

        // $supervisor = $this->getSupervisorEmail($division->id, $division->division_acronym);
        // dd($supervisor);

        //$user = User::find(Auth::user()->id);
        
       // dd($travel_orders->approval_type[0]->approval_type_name);

        //$role = Auth::user()->roles->pluck('role_name')[0];
        

        //$role = Role::find(Auth::user()->role_id);

        //dd($role);

       // dd(Auth::user()->roles[0]['name']);
       $title = 'Delete Travel Order!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);

        return view('travel_orders.index', compact('travel_orders', 'approval_types', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        return view('travel_orders.create', compact('fund_sources', 'paps', 'transportations', 'regions', 'times'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TravelOrderStoreRequest $request)
    {
        $otherPapName = '';
        $papId = 0;

        //dd($request->inputs);

        //Save file to folder destination and insert filename to database
        if($request->hasFile('purpose_image_filename')) 
        {
            $newImageName = time() . '-travel.' . $request->purpose_image_filename->extension();
            $request->purpose_image_filename->move(public_path('travel_attachment'), $newImageName);
        }

        if(isset($request->other_pap_name)) {
            $otherPapName = $request->other_pap_name;
        }

        if(isset($request->pap_id)) {
            $papId = $request->pap_id;
        }
        
        //Save the travel data to the database
        $travel = TravelOrder::create([
            'to_code' => Carbon::now()->format('Y-m'),
            'purpose' => $request->purpose,
            'user_id' => $request->user_id,
            'purpose_image_filename' => $newImageName,
            'destination' => $request->destination,
            'travel_departure_date' => $request->travel_departure_date,
            'travel_arrival_date' => $request->travel_arrival_date,
            'fund_source_id' => $request->fund_source_id,
            'pap_id' => $papId,
            'other_pap_name' => $otherPapName,
            'is_travel_related_to_training' => $request->is_travel_related_to_training,
            'is_cash_advance' => $request->is_cash_advance,
            'grand_total' => $request->grand_total,
        ]);

        //Save the travel itineraries to the database
        foreach($request->inputs as $input) {
            $itinerary['travel_order_id'] = $travel->id;
            $itinerary['itinerary_date'] = $input['itinerary_date'];
            $itinerary['region_code'] = $input['region_code'];
            $itinerary['province_code'] = $input['province_code'];
            $itinerary['city_code'] = $input['city_code'];
            $itinerary['estimated_time_of_departure'] = $input['estimated_time_of_departure'];
            $itinerary['estimated_time_of_arrival'] = $input['estimated_time_of_arrival'];
            $itinerary['transportation_id'] = $input['transportation_id'];
            
            if(is_null($input['transportation_price'])) {
                $itinerary['transportation_price'] = 0;
            } else {
                $itinerary['transportation_price'] = $input['transportation_price'];
            }
           
            $itinerary['with_lodging'] = isset($input['with_lodging']) ? 1 : 0;
            $itinerary['with_breakfast'] = isset($input['with_breakfast']) ? 1 : 0;
            $itinerary['with_lunch'] = isset($input['with_lunch']) ? 1 : 0;
            $itinerary['with_snack'] = isset($input['with_snack']) ? 1 : 0;
            $itinerary['with_incidental_expenses'] = isset($input['with_incidental_expenses']) ? 1 : 0;
            $itinerary['total'] = $input['total'];

            TravelItinerary::create($itinerary);
        }

        /**
         * Email To the Immediate Supervisor
         */
        $travel_order = TravelOrder::where('id', $travel->id)->first();
        $cntApprover = count(TravelOrderUserApproval::where('travel_order_id', '=', $travel->id)->get());
        $approverEmail = $this->getApproverEmail($cntApprover);
        $url = URL::to('/travel_orders');

        //dd($supervisor->email);
        //$subject = Auth::user()->name .' Application for Travel';
        //Mail::to($supervisor->email)->send(new TestMail($subject, $supervisor, $travel_order));
        Notification::send($approverEmail, new ApplicationTravelOrder(Auth::user()->name, $approverEmail->name, $travel_order, $url));

        toast('Travel Order data added successfully!','success');
    
        return redirect()->route('travel_orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TravelOrder $travelOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelOrder $travelOrder)
    {

        $fund_sources = FundSource::pluck('fund_source_acronym','id')->all();
        $paps = Pap::pluck('pap_name','id')->all();
        $transportations = Transportation::pluck('transportation_name','id')->all();
        $regions = Region::pluck('name', 'region_code');

        $itineraries = TravelItinerary::where('travel_order_id', $travelOrder->id)->get();


        return view('travel_orders.edit', compact('fund_sources', 'paps', 'transportations', 'regions', 'travelOrder', 'itineraries'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TravelOrder $travelOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelOrder $travelOrder)
    {
        $this->authorize('travel_order-delete');

        $travelOrder->delete();

        toast('Travel Order deleted successfully!', 'success');

        return redirect()->route('travel_orders.index');
    }

    public function sendApproval(Request $request) {

        $this->authorize('travel_order-sendApproval');

        // $cntApproval = count(TravelOrderUserApproval::where('travel_order_id', '=', $request->travel_order_id)->get());
        // $approverEmail = $this->getApproverEmail($cntApproval);
        // dd($approverEmail);

        $travelOrderApproval = TravelOrderUserApproval::create([
            'user_id' => $request->user_id,
            'travel_order_id' => $request->travel_order_id,
            'approval_type_id' => $request->approval_type_id,
            'remarks' => $request->remarks,
        ]);

        //make a email notification for ARD and Budget Officer
        $cntApproval = count(TravelOrderUserApproval::where('travel_order_id', '=', $travelOrderApproval->travel_order_id)->get());
        $travel_order = TravelOrder::where('id', $travelOrderApproval->travel_order_id)->first();
        $url = URL::to("/travel_orders");
        
        
        if($travelOrderApproval->approval_type_id == 1) 
        {  
            if($cntApproval <= 2) 
            { 
                $approverEmail = $this->getApproverEmail($cntApproval);    
                Notification::send($approverEmail, new ApplicationTravelOrder(Auth::user()->name, $approverEmail->name, $travel_order, $url));
            } else {
                // Notify the staff success;
                $line = 'We would like to formally inform you that your application for a travel order has received approval. 
                        You are now authorized to print a copy of your travel order.';
                
                Notification::send($travel_order->user, new TravelOrderNotifyUser($travel_order, $line, $url));
            }
            toast('Travel Order was Approved!','success');            
        } else {
            $line = 'We wish to formally notify you that your application for a travel order has been denied.';
            Notification::send($travel_order->user, new TravelOrderNotifyUser($travel_order, $line, $url));
            
            toast('Travel Order was Disapproved!','warning');
        }
        
        return redirect()->route('travel_orders.index');
    }

    public function viewTravelOrder($id) {

        //Get travel_order with the relation in employee table
        $travel_order = TravelOrder::find($id);

        //dd($travel_order->user->employee->division);

        $approver = $this->getApprover($id);

        //dd($approver[0][0]->profile->esignature);
        
        $travel_itineraries = TravelItinerary::where('travel_order_id', $id)->get();

        return view('travel_orders.view_travel_order', compact('travel_order', 'travel_itineraries', 'approver'));
    }

    public function getApproverEmail($cnt) 
    {
        switch ($cnt) {
            case 0:
                //Get Immediate Supervisor Email
            $division = Auth::user()->division;
            $approverEmailAddress = $this->getSupervisorEmail($division->id, $division->division_acronym);
                break;
            case 1:
               //Get ARD Email;
               $designation = Designation::where('designation_acronym', '=', 'ARD')->first();
               $approverEmailAddress = User::where('designation_id', '=', $designation->id)->first();
                break;
            case 2:
                //Get Budget Officer Email
                $designation = Designation::where('designation_acronym', '=', 'Supervising AO')->first();
                $approverEmailAddress = User::where('designation_id', '=', $designation->id)->first();
                break;
        }

       return $approverEmailAddress;

    }

    public function viewORS($id) {

        $travel_order = TravelOrder::find($id);

        $approver = $this->getApprover($id);

        //dd($approver);

        $travel_itineraries = TravelItinerary::where('travel_order_id', $id)->get();

        return view('travel_orders.view_ors', compact('travel_order', 'travel_itineraries', 'approver'));

    }

    public function getApprover($id) {

        $approver = [];
        $pivotUser = TravelOrderUserApproval::where('travel_order_id', $id)->get();

        if(!is_null($pivotUser)) {
            $i=0;
            foreach($pivotUser as $pivot) {
                $approver[$i] = User::where('id', '=', $pivot->user_id)->get();
                $i++;
            }
            
        }
        return $approver;
    }

    //cao = 8, ard = 2, DC = 5
    public function getSupervisorEmail($division_id, $division_acronym) {

        if($division_acronym == 'FAD') 
        {
            $designation = Designation::where('designation_acronym', 'CAO')->first();
        } else {
            $designation = Designation::where('designation_acronym', 'CEDS')->first();
        }

        $supervisorUserData = User::where([
            ['division_id', '=' ,$division_id],
            ['designation_id', '=', $designation->id]
           ])->first(); 

        return $supervisorUserData;
    }

    public function getUserIdInDivision($division_id) {

        $user_ids = User::where('division_id', '=' , $division_id)->get(['id']);
        $ids = array();

        foreach($user_ids as $user_id) {
            //$ids .= "'" . $user_id->id . "',";
            $ids[] = $user_id->id;
        }

        //$ids = substr($ids,0,-1);
        //$ids = $ids . "]";

        return $ids;

    }
}
