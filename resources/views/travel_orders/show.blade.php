@extends('layouts.app')

@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
  
@endsection

@section('content')
<!-- Content Header (Page header) -->
@section('content')
<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Request #{{ to_number($travelOrder->to_code, $travelOrder->id) }}</h5>
                        <span class="badge bg-{{ $travelOrder->status == 'approved' ? 'success' : ($travelOrder->status == 'disapproved' ? 'danger' : 'warning') }} fs-6">
                            {{ ucfirst($travelOrder->status) }}
                        </span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Traveler</div>
                        <div class="col-sm-8 fw-bold">{{ $travelOrder->user->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Destination</div>
                        <div class="col-sm-8 fw-bold">{{ $travelOrder->destination }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Estimated Cost</div>
                        <div class="col-sm-8 text-primary fw-bold">PhP {{ number_format($travelOrder->grand_total, 2) }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Purpose</div>
                        <div class="col-sm-8">{{ $travelOrder->purpose }}</div>
                    </div>
                </div>
            </div>

            @if($travelOrder->status == 'pending' && (
                ($travelOrder->current_step == 1 && auth()->id() == $travelOrder->immediate_supervisor_id) ||
                ($travelOrder->current_step == 2 && auth()->id() == $travelOrder->management_id) ||
                ($travelOrder->current_step == 3 && auth()->id() == $travelOrder->budget_officer_id)
            ))
                <div class="card border-primary shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="fw-bold mb-1">Your Action is Required</h6>
                            <p class="small text-muted mb-0">Please review the details and provide your decision.</p>
                        </div>
                        <div class="btn-group">
                           
                            <button type="button" class="btn btn-sm btn-success px-4 me-2" data-bs-toggle="modal" data-bs-target="#approveModal{{ $travelOrder->id }}">
                                Approve
                            </button>
                               
                            <button type="button" class="btn btn-sm btn-danger px-4 me-2" data-bs-toggle="modal" data-bs-target="#disapproveModal{{ $travelOrder->id }}">
                                            Disapprove
                            </button>

                            <a href="{{ route('travel_orders.view_travel_order', $travelOrder->id )}}" class="btn btn-sm btn-primary px-4" target="_blank">
                                            Review
                            </a>
                        </div>
                    </div>
                </div>   

                <div class="modal fade" id="approveModal{{ $travelOrder->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                    <form action="{{ route('travel_orders.approve', $travelOrder->id) }}" method="POST" class="d-inline">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Approve Travel Order No. {{ to_number($travelOrder->to_code, $travelOrder->id) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <p class="fst-italic">Once approved, the Travel Order Application will be treated as FINAL in your end.</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn  btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-sm btn-primary">Approve</button>
                        </div>
                    </div>
                    </form>
                    </div>
                </div>
                
                <div class="modal fade" id="disapproveModal{{ $travelOrder->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <form action="{{ route('travel_orders.disapprove', $travelOrder->id) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Reason for Disapproval</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <textarea name="remarks" class="form-control" rows="3" placeholder="Enter reason here..." required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-danger">Confirm Disapproval</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            {{-- @can('approve', $travelOrder) --}}
                
            {{-- @endcan --}}
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Approval Progress</h6>
                </div>
                <div class="card-body">
                    <div class="vertical-stepper">
                        
                        @include('travel_orders.partials.step', [
                            'title' => 'Immediate Supervisor',
                            'name' => $travelOrder->immediateSupervisor->name,
                            'date' => $travelOrder->immediate_supervisor_approved_at,
                            'active' => ($travelOrder->current_step == 1 && $travelOrder->status == 'pending'),
                            'loop'   => (object)['last' => false]
                        ])

                        @include('travel_orders.partials.step', [
                            'title' => 'Management',
                            'name' => $travelOrder->management->name,
                            'date' => $travelOrder->management_approved_at,
                            'active' => ($travelOrder->current_step == 2 && $travelOrder->status == 'pending'),
                            'loop'   => (object)['last' => false]
                        ])

                        @include('travel_orders.partials.step', [
                            'title' => 'Budget Officer',
                            'name' => $travelOrder->budgetOfficer->name,
                            'date' => $travelOrder->budget_officer_approved_at,
                            'active' => ($travelOrder->current_step == 3 && $travelOrder->status == 'pending'),
                            'loop'   => (object)['last' => true]
                        ])
                    </div>

                    @if($travelOrder->status == 'approved')
                        <a href="{{ route('travel_orders.download', $travelOrder->id) }}" class="btn btn-dark w-100 mt-3">
                            <i class="far fa-file-pdf me-2"></i>Download TO
                        </a>

                        <a href="{{ route('travel_orders.downloadORS', $travelOrder->id) }}" class="btn btn-primary w-100 mt-3">
                            <i class="far fa-file-pdf me-2"></i>Download ORS
                        </a>


                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection




@section('javascripts')
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
<script>
  $(document).ready(function() {
    new DataTable('#listTravelOrderTable');
  });
</script>
@endsection

@section('jsvalidator')

{{!! JsValidator::formRequest('App\Http\Requests\ApprovalStoreRequest'); !!}}
{{-- {!! JsValidator::formRequest('App\Http\Requests\UserStoreRequest', '#edit-form'); !!} --}}

@endsection