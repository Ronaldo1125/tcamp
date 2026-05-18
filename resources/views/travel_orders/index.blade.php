@extends('layouts.app')

@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
  
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="container py-4">
    
    {{-- Section 1: Approvals Queue --}}
    @if($pendingApprovals->count() > 0)
        <div class="card border-primary mb-5 shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-person-check-fill me-2"></i> Action Required: Pending Your Approval
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Traveler</th>
                            <th>Destination</th>
                            <th>Estimated Cost</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingApprovals as $approval)
                            <tr>
                                <td>{{ $approval->user->name }}</td>
                                <td>{{ $approval->destination }}</td>
                                <td class="fw-bold">PhP {{ number_format($approval->grand_total, 2) }}</td>
                                <td>
                                    <a href="{{ route('travel_orders.show', $approval->id) }}" class="btn btn-sm btn-primary">Review & Decide</a>
                                    {{-- {{-- @if($approval->status == 'pending')
                                        @php
                                            $isApprover = (
                                                ($approval->current_step == 1 && auth()->id() == $approval->immediate_supervisor_id) ||
                                                ($approval->current_step == 2 && auth()->id() == $approval->management_id) ||
                                                ($approval->current_step == 3 && auth()->id() == $approval->budget_officer_id)
                                            );
                                        @endphp

                                        @if($isApprover)
                                        <button type="button" class="btn btn-success btn-sm px-4" data-bs-toggle="modal" data-bs-target="#approveModal{{ $approval->id }}" title="Approve">Approve</button>
                                         
                                        <div class="modal fade" id="approveModal{{ $approval->id }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog">
                                            <form action="{{ route('travel_orders.approve', $approval->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title">Approve Travel Order No. {{ $approval->to_code . "-" . sprintf("%03d", $approval->id)}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <p>Modal body text goes here.</p>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="Submit" class="btn btn-primary">Approve</button>
                                                </div>
                                            </div>
                                            </form>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-danger btn-sm px-4" data-bs-toggle="modal" data-bs-target="#disapproveModal{{ $approval->id }}" title="Disapprove">
                                            Disapprove
                                        </button>


                                        <div class="modal fade" id="disapproveModal{{ $approval->id }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <form action="{{ route('travel_orders.disapprove', $approval->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Reason for Disapproval</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <textarea name="remarks" class="form-control" rows="3" placeholder="Enter reason here..." required></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Confirm Disapproval</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @else
                                            <span class="text-muted small">Awaiting next level</span>
                                        @endif
                                    @endif --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Section 2: My Own Requests --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">My Travel Requests</h5>
        <a href="{{ route('travel_orders.create') }}" class="btn btn-sm btn-success">
            <i class="bi bi-plus-lg"></i> New Request
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Destination</th>
                        <th>Travel Date</th>
                        <th>Current Step</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myRequests as $request)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $request->destination }}</div>
                                <small class="text-muted">PhP {{ number_format($request->grand_total, 2) }}</small>
                            </td>
                            <td>{{ $request->travel_departure_date }}</td>
                            <td>
                                @if($request->status == 'pending')
                                    <span class="badge rounded-pill bg-info text-dark">Step {{ $request->current_step }}/3</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $request->status == 'approved' ? 'success' : ($request->status == 'disapproved' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('travel_orders.show', $request->id) }}" class="btn btn-sm btn-outline-secondary me-2">View Tracker</a>
                                    @if($request->status == 'disapproved')
                                        <a href="{{ route('travel_orders.edit', $request->id) }}" class="btn btn-sm btn-outline-danger">Resubmit</a>
                                    @endif
                                    
                                    @if($request->status == 'pending' && $request->current_step == 1)
                                        <a href="{{ route('travel_orders.edit', $request->id) }}" class="btn btn-sm btn-outline-danger me-2">Edit</a>
                                        <form action="{{ route('travel_orders.destroy', $request->id )}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('travel_orders.destroy', $request->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">Delete</a>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No travel requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0">
            {{ $myRequests->links() }}
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