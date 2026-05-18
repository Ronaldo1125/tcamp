<?php

namespace App\Http\Controllers;

use App\Http\Requests\TravelOrderStoreRequest;
use App\Http\Requests\TravelOrderUpdateRequest;
use App\Mail\TestMail;
use App\Models\ApprovalType;
use App\Models\Designation;
use App\Models\Division;
use App\Models\Employee;
use App\Models\FundSource;
use App\Models\Pap;
use App\Models\Region;
use App\Models\Role;
use App\Models\Transportation;
use App\Models\TravelItinerary;
use App\Models\TravelOrder;
use App\Models\TravelOrderUserApproval;
use App\Models\User;
use App\Notifications\ApplicationTravelOrder;
use App\Notifications\TravelOrderNotifyUser;
use App\Notifications\TravelStepNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

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
        $user = Auth::user();

        // 1. Fetch requests created by the user (Traveler View)
        $myRequests = TravelOrder::with(['immediateSupervisor', 'management', 'budgetOfficer'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        // 2. Fetch requests awaiting THIS user's approval (Approver View)
        $pendingApprovals = TravelOrder::with(['user', 'immediateSupervisor', 'management', 'budgetOfficer'])
            ->where(function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('current_step', 1)->where('immediate_supervisor_id', $user->id);
                })->orWhere(function ($q) use ($user) {
                    $q->where('current_step', 2)->where('management_id', $user->id);
                })->orWhere(function ($q) use ($user) {
                    $q->where('current_step', 3)->where('budget_officer_id', $user->id);
                });
            })
            ->where('status', 'pending')
            ->get();


        $title = 'Delete Travel Order!';
        $text = "Are you sure? This will be deleted permanently.";
        confirmDelete($title, $text);

        return view('travel_orders.index', compact('myRequests', 'pendingApprovals'));
        //$travel_orders = TravelOrder::find(1);

        // $role = Auth::user()->roles[0]['name'];

        // $travel_orders = TravelOrder::all();

        // if($role == 'Staff') {
        //     $travel_orders = TravelOrder::where( 'user_id', '=', Auth::user()->id)->get();
        // } 
        
        // if ($role == 'Immediate Supervisor') {
        //     $ids = $this->getUserIdInDivision(Auth::user()->division_id);
        //     $travel_orders = $travel_orders->whereIn('user_id',$ids);
        // }
        
       
      

        //return view('travel_orders.index', compact('travel_orders', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fund_sources = FundSource::pluck('fund_source_acronym','id')->all();
        $paps = Pap::pluck('pap_name','id')->all();
        $transportations = Transportation::pluck('transportation_name','id')->all();
        $users = User::where('id', '!=' , auth()->id())->get(['id', 'name']);
        $regions = Region::pluck('name', 'region_code');

        $times = [];
        $periods = CarbonPeriod::create('00:00', '5 minutes', '23:55');

        foreach ($periods as $period) 
        {
            $times[] = $period->format('H:i');
        }
        return view('travel_orders.create', compact('fund_sources', 'paps', 'transportations', 'regions', 'times', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TravelOrderStoreRequest $request)
    {
        $otherPapName = '';
        $papId = 0;

        $request->validated();

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
        $travelOrder = TravelOrder::create([
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
            'immediate_supervisor_id' => $request->immediate_supervisor_id,
            'management_id' => $request->management_id,
            'budget_officer_id' => $request->budget_officer_id,
            'grand_total' => $request->grand_total,
        ]);

        //Save the travel itineraries to the database
        foreach($request->inputs as $input) {
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

            $travelOrder->travel_itinineraries()->create($itinerary);
            //TravelItinerary::create($itinerary);
        }

        //Notify the Immediate Supervisor
        $travelOrder->immediateSupervisor->notify(new TravelStepNotification($travelOrder, 'new_submission'));

        toast('Travel Order data added successfully!','success');
    
        return redirect()->route('travel_orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TravelOrder $travelOrder)
    {
        //$this->authorize('view', $travelOrder);

        // Automatically mark related notifications as read when the user views the request
            auth()->user()->unreadNotifications
                ->where('data.travel_order_id', $travelOrder->id)
                ->markAsRead();

        // 2. Load relationships for the tracker
        $travelOrder->load(['user', 'immediateSupervisor', 'management', 'budgetOfficer']);

        return view('travel_orders.show', compact('travelOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelOrder $travelOrder)
    {

        if ($travelOrder->user_id !== auth()->id() || $travelOrder->current_step !== 1) {
            
            // toast('Unauthorized action!','error');
            // return redirect()->route('travel_orders.index');
            abort(403, 'Unauthorized action.');
        }

        $fund_sources = FundSource::pluck('fund_source_acronym','id')->all();
        $paps = Pap::pluck('pap_name','id')->all();
        $transportations = Transportation::pluck('transportation_name','id')->all();
        $regions = Region::pluck('name', 'region_code');
        $users = User::where('id', '!=' , auth()->id())->get(['id', 'name']);

        $itineraries = TravelItinerary::where('travel_order_id', $travelOrder->id)->get();

        return view('travel_orders.edit', compact('fund_sources', 'paps', 'transportations', 'regions', 'travelOrder', 'itineraries', 'users'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TravelOrderUpdateRequest $request, TravelOrder $travelOrder)
    {
        $request->validated();

        if ($travelOrder->user_id !== auth()->id() || $travelOrder->status !== 'disapproved') {
            abort(403, 'Unauthorized action.');
        }

        $otherPapName = '';
        $papId = 0;

        if(isset($request->other_pap_name)) {
            $otherPapName = $request->other_pap_name;
        }

        if(isset($request->pap_id)) {
            $papId = $request->pap_id;
        }

        if($request->hasFile('purpose_image_filename')) 
        {
            $oldImage = 'travel_attachment/'. $travelOrder->purpose_image_filename;

            //Remove Old Image 
            if(\File::exists($oldImage)) 
            {
                \File::delete($oldImage);
            }

            $newImageName = time() . '-travel.' . $request->purpose_image_filename->extension();
            $request->purpose_image_filename->move(public_path('travel_attachment'), $newImageName);
        }

        $travelOrder->update([
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
            'immediate_supervisor_id' => $request->immediate_supervisor_id,
            'management_id' => $request->management_id,
            'budget_officer_id' => $request->budget_officer_id,
            'status'       => 'pending',
            'current_step' => 1,
            'remarks'      => null, // Clear the old rejection reason
            'grand_total' => $request->grand_total,
        ]);

        //Delete first the itineraries
        $travelOrder->travel_itinineraries()->delete();

        //Then create new itineraries

        foreach($request->inputs as $input) {
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

            $travelOrder->travel_itinineraries()->create($itinerary);
            //TravelItinerary::create($itinerary);
        }

        // Notify the FIRST person in the chain again
        //$travelOrder->unitHead->notify(new \App\Notifications\TravelApprovalRequest($travelOrder));

        toast('Travel Order data updated successfully!','success');

        return redirect()->route('travel_orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelOrder $travel_order)
    {
        //$this->authorize('travel_order-delete');

       // dd($travel_order);
       // 1. Manually clear notifications related to this specific record
        DB::table('notifications')
            ->where('data', 'like', '%"travel_order_id":' . $travel_order->id . '%')
            ->delete();

        $travel_order->delete();

        toast('Travel Order deleted successfully!', 'success');

        return redirect()->route('travel_orders.index');
    }

    public function sendApproval(Request $request) {

        $this->authorize('travel_order-sendApproval');

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

    public function viewTravelOrder(TravelOrder $travelOrder) {

        $travel_itineraries = TravelItinerary::where('travel_order_id', $travelOrder->id)->get();

        return view('travel_orders.view_travel_order', compact('travelOrder', 'travel_itineraries'));
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

    // public function getApprover($id) {

    //     $approver = [];
    //     $pivotUser = TravelOrderUserApproval::where('travel_order_id', $id)->get();

    //     if(!is_null($pivotUser)) {
    //         $i=0;
    //         foreach($pivotUser as $pivot) {
    //             $approver[$i] = User::where('id', '=', $pivot->user_id)->get();
    //             $i++;
    //         }
            
    //     }
    //     return $approver;
    // }

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

    public function approve(Request $request, TravelOrder $travelOrder) {

        $now = now();
        $user = auth()->user();

        //dd($travelOrder);

        if ($travelOrder->current_step == 1 && $user->id == $travelOrder->immediate_supervisor_id) {
            $travelOrder->immediate_supervisor_approved_at = $now;
            $travelOrder->current_step = 2;

            // Notify the Management
            $travelOrder->management->notify(new TravelStepNotification($travelOrder, 'next_approver'));

        } elseif ($travelOrder->current_step == 2 && $user->id == $travelOrder->management_id) {
            $travelOrder->management_approved_at = $now;
            $travelOrder->current_step = 3;

            //Notify the Budget Officer
            $travelOrder->budgetOfficer->notify(new TravelStepNotification($travelOrder, 'next_approver'));

        } elseif ($travelOrder->current_step == 3 && $user->id == $travelOrder->budget_officer_id) {
            $travelOrder->budget_officer_approved_at = $now;
            $travelOrder->status = 'approved';

            // Notify the Traveler
            $travelOrder->user->notify(new TravelStepNotification($travelOrder, 'final_approved'));

        } else {
            return back()->with('error', 'It is not your turn to approve or you are not authorized.');
        }

        $travelOrder->save();

        toast('Travel Order data added successfully!','success');

        return back()->with('success', 'Step approved at ' . $now->format('M d, Y H:i'));
    }

    public function disapprove(Request $request, TravelOrder $travelOrder) {
        // Only the current assigned approver can disapprove
        
        $user = auth()->user();

        $isCurrentApprover = (
            ($travelOrder->current_step == 1 && $user->id == $travelOrder->immediate_supervisor_id) ||
            ($travelOrder->current_step == 2 && $user->id == $travelOrder->management_id) ||
            ($travelOrder->current_step == 3 && $user->id == $travelOrder->budget_officer_id)
            );

        if (!$isCurrentApprover) {
            return back()->with('error', 'Unauthorized action.');
        }

      
        $travelOrder->update([
            'status' => 'disapproved',
            'remarks' => $request->remarks,
        ]);

        $travelOrder->user->notify(new TravelStepNotification($travelOrder, 'rejected'));

        return back()->with('success', 'Request has been disapproved.');
    }


    

    public function downloadVoucher(TravelOrder $travelOrder)
    {
        // Security check: Only allow if fully approved

        // $travel_order = TravelOrder::with('travel_itinineraries')
        //                 ->where('id', $travelOrder->id)
        //                 ->get();
                    
        
        if ($travelOrder->status !== 'approved') {
            return back()->with('error', 'Voucher is only available for fully approved requests.');
        }

        // Load the relationships to show names on the PDF
        $travelOrder->load(['user', 'immediateSupervisor', 'management', 'budgetOfficer']);

        $pdf = Pdf::loadView('travel_orders.pdf.travel_voucher', compact('travelOrder'));
        
        return $pdf->download('Travel_Voucher_' . $travelOrder->id . '.pdf');
    }

    public function downloadORS(TravelOrder $travelOrder)
    {
        // Security check: Only allow if fully approved

        // $travel_order = TravelOrder::with('travel_itinineraries')
        //                 ->where('id', $travelOrder->id)
        //                 ->get();
                    
        
        if ($travelOrder->status !== 'approved') {
            return back()->with('error', 'Voucher is only available for fully approved requests.');
        }

        // Load the relationships to show names on the PDF
        $travelOrder->load(['user', 'immediateSupervisor', 'management', 'budgetOfficer']);

        $pdf = Pdf::loadView('travel_orders.pdf.travel_voucher_ORS', compact('travelOrder'));
        
        return $pdf->download('Travel_Voucher_ORS' . $travelOrder->id . '.pdf');

    }
}
