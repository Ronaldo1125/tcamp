<?php

namespace App\Http\Controllers;

use App\Models\TravelOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;

        //dd($notifications[0]['data']->travel_order_id);

        $performanceData = User::whereHas('immediateSupervisorRequests', function($query) {
            $query->whereNotNull('immediate_supervisor_approved_at');
            })
            ->with(['immediateSupervisorRequests'])
            ->get()
            ->map(function ($user) {
                $avgHours = $user->immediateSupervisorRequests->avg(function ($request) {
                    return $request->created_at->diffInHours($request->immediate_supervisor_approved_at);
                });
                
                return [
                    'name' => $user->name,
                    'avg_time' => round($avgHours, 1)
                ];
            });

        $requests = TravelOrder::with(['user', 'immediateSupervisor', 'management', 'budgetOfficer'])->get();
    
        $stats = [
            'approvedCount' => TravelOrder::where('status', 'approved')->count(),
            'pendingCount' => TravelOrder::where('status', 'pending')->count(),
            'disapprovedCount' => TravelOrder::where('status', 'disapproved')->count(),
        ];

        $travelData = TravelOrder::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month');

                //dd($travelData);
        
        //toast('Your Post as been submited!','success');
        return view('home', compact('notifications', 'requests', 'stats', 'travelData', 'performanceData'));

    }

    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
}
