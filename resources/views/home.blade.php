@extends('layouts.app')

@section('styles')

<style>
/* The main container for the step */
.step {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  font-family: sans-serif;
}

/* Styling the container that holds the number and text */
.step-container {
  display: flex;
  align-items: center;
  gap: 15px;
}

/* The circle/box for the step number */
.step-no {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: #e0e0e0; /* Gray for incomplete */
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
  color: #666;
  border: 2px solid #ccc;
}

/* Logic for the "DONE" state */
.step.done .step-no {
  background-color: #4CAF50; /* Green background */
  border-color: #45a049;
  color: white;
}

.step.done .step-container {
  color: #2e7d32; /* Darker green text */
}

</style>



@endsection

@section('content')
{{-- <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Dashboard
            </div>

            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if(auth()->user()->id == 1)
                    @forelse($notifications as $notification)
                        <div class="alert alert-success" role="alert">
                            [{{ $notification->created_at }}] User {{ $notification->data['name'] }} ({{ $notification->data['email'] }}) has just registered.
                            <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                                Mark as read
                            </a>
                        </div>

                        @if($loop->last)
                            <a href="#" id="mark-all">
                                Mark all as read
                            </a>
                        @endif
                    @empty
                        There are no new notifications
                    @endforelse
                @else
                    You are logged in!
                @endif
            </div>
        </div>
    </div>
</div> --}}

 {{-- <div class="step-req table-cell s5 valign-top b-l b-light-gray p-n m-n">
            
	<div class="steps m-md p-sm p-t-xs p-b-xs p-r-sm m-r-n bg-white b-l b-light-gray">
		<label id='lvl' class='hide'>48291_23</label>
		<div class="panel-header b-b b-dashed b-light-gray p-t-sm p-b-xs m-b-xs m-l-xs m-r-xs">
		<p class="font-bold">Steps</p>
			
		</div>
		
	<div class='step done '>
		<div class='step-container'>
			<div class='step-no'>1</div>
			<div class='step-title m-b-xxs'>For Certification of Leave Credits and Attachment (Approved)</div>
			<div class='step-desc m-b-xs'><span>responsible person :</span> SOLANO, YANCY RAMON CLAVILLAS (HRIS-Attendance-Approver)
			</div>
			<div class='step-desc  m-b-xs'><span>duration: </span> December 10, 2025 05:19:21 PM - December 10, 2025 05:19:32 PM</div>
			<div class='actions mini radius-small show m-t-sm'>
				   <a class='emerald m-l-n m-r-xs' data-modal='modal_view_task_dtls' href='#modal_view_task_dtls' onclick="modal_view_task_dtls_init('073ef08775e325d5a27c45ff7cc3b33c5078c0751a68bd5af9abd296pJjGgTf5CVJwQM1qoeRD8Q--/f17a1e7d0b80601/d40be4bce1225a7/fbaf35fd891c3a0001c88c2e1ac6349552f64f29fcef8af6450e54d4wwZ8ujsbR4V855iro65umw--40bcbfb4e6c72b5b07a958fc87ca77b532032614ed1064ad7eaf54edCW9g.Bmjv.9joyqfP5furQ--/49ce5ee512f14868a805366c63c941e9be83edc87da76bef4dde45a5ekWC1IULxz2ewBT1bK~kGA--')"><i class='material-icons font-lg grey-text'>assignment</i> View Task Detail </a> <a href='#modal_task_history' onclick="modal_task_history_init('073ef08775e325d5a27c45ff7cc3b33c5078c0751a68bd5af9abd296pJjGgTf5CVJwQM1qoeRD8Q--/f17a1e7d0b80601/d40be4bce1225a7/fbaf35fd891c3a0001c88c2e1ac6349552f64f29fcef8af6450e54d4wwZ8ujsbR4V855iro65umw--40bcbfb4e6c72b5b07a958fc87ca77b532032614ed1064ad7eaf54edCW9g.Bmjv.9joyqfP5furQ--/49ce5ee512f14868a805366c63c941e9be83edc87da76bef4dde45a5ekWC1IULxz2ewBT1bK~kGA--','this','View Task History')" class='light-blue m-l-n m-r-xs'><i class='material-icons font-lg grey-text'>assignment</i> View Task History</a>  
			</div>
			
			
			
		</div>
	</div>
	<div class='step done '>
		<div class='step-container'>
			<div class='step-no'>2</div>
			<div class='step-title m-b-xxs'>For Recommendation of Supervisor (Approved)</div>
			<div class='step-desc m-b-xs'><span>responsible person :</span> BITARE, GWENDOLYN SALUNA 
			</div>
			<div class='step-desc  m-b-xs'><span>duration: </span> December 10, 2025 05:19:31 PM - December 19, 2025 03:05:00 PM</div>
			<div class='actions mini radius-small show m-t-sm'>
				   <a class='emerald m-l-n m-r-xs' data-modal='modal_view_task_dtls' href='#modal_view_task_dtls' onclick="modal_view_task_dtls_init('170a84398568afbfaf57d96b3efd8fcea01eac8d7df3bd7dbf425688EsUS51ahQVHnJNiMYvqu9w--/ebf950e72ffc6fb/67fb6df39905d8b/fbaf35fd891c3a0001c88c2e1ac6349552f64f29fcef8af6450e54d4wwZ8ujsbR4V855iro65umw--40bcbfb4e6c72b5b07a958fc87ca77b532032614ed1064ad7eaf54edCW9g.Bmjv.9joyqfP5furQ--/49ce5ee512f14868a805366c63c941e9be83edc87da76bef4dde45a5ekWC1IULxz2ewBT1bK~kGA--')"><i class='material-icons font-lg grey-text'>assignment</i> View Task Detail </a> <a href='#modal_task_history' onclick="modal_task_history_init('170a84398568afbfaf57d96b3efd8fcea01eac8d7df3bd7dbf425688EsUS51ahQVHnJNiMYvqu9w--/ebf950e72ffc6fb/67fb6df39905d8b/fbaf35fd891c3a0001c88c2e1ac6349552f64f29fcef8af6450e54d4wwZ8ujsbR4V855iro65umw--40bcbfb4e6c72b5b07a958fc87ca77b532032614ed1064ad7eaf54edCW9g.Bmjv.9joyqfP5furQ--/49ce5ee512f14868a805366c63c941e9be83edc87da76bef4dde45a5ekWC1IULxz2ewBT1bK~kGA--','this','View Task History')" class='light-blue m-l-n m-r-xs'><i class='material-icons font-lg grey-text'>assignment</i> View Task History</a>  
			</div>
			
			
			
		</div>
	</div>
	<div class='step done '>
		<div class='step-container'>
			<div class='step-no'>3</div>
			<div class='step-title m-b-xxs'>For Approval of Next Higher (Approved)</div>
			<div class='step-desc m-b-xs'><span>responsible person :</span> ZANTUA, JASMIN CASIN 
			</div>
			<div class='step-desc  m-b-xs'><span>duration: </span> December 19, 2025 03:05:00 PM - December 19, 2025 05:23:58 PM</div>
			<div class='actions mini radius-small show m-t-sm'>
				   <a class='emerald m-l-n m-r-xs' data-modal='modal_view_task_dtls' href='#modal_view_task_dtls' onclick="modal_view_task_dtls_init('33f6b98cd445f2351c7c18cb169f68051ef25606f6cdabebd009672cxCRnYjWsKwOS5dxKMfY7hQ--/13af3925f74f58a/b21e2b85563783e/fbaf35fd891c3a0001c88c2e1ac6349552f64f29fcef8af6450e54d4wwZ8ujsbR4V855iro65umw--40bcbfb4e6c72b5b07a958fc87ca77b532032614ed1064ad7eaf54edCW9g.Bmjv.9joyqfP5furQ--/49ce5ee512f14868a805366c63c941e9be83edc87da76bef4dde45a5ekWC1IULxz2ewBT1bK~kGA--')"><i class='material-icons font-lg grey-text'>assignment</i> View Task Detail </a> <a href='#modal_task_history' onclick="modal_task_history_init('33f6b98cd445f2351c7c18cb169f68051ef25606f6cdabebd009672cxCRnYjWsKwOS5dxKMfY7hQ--/13af3925f74f58a/b21e2b85563783e/fbaf35fd891c3a0001c88c2e1ac6349552f64f29fcef8af6450e54d4wwZ8ujsbR4V855iro65umw--40bcbfb4e6c72b5b07a958fc87ca77b532032614ed1064ad7eaf54edCW9g.Bmjv.9joyqfP5furQ--/49ce5ee512f14868a805366c63c941e9be83edc87da76bef4dde45a5ekWC1IULxz2ewBT1bK~kGA--','this','View Task History')" class='light-blue m-l-n m-r-xs'><i class='material-icons font-lg grey-text'>assignment</i> View Task History</a>  
			</div>
			
			
			
		</div>
	</div>
	</div> --}}


<div class="m-4 text-blue font-weight-bold">
    <h4><i class="fas fa-plane"></i> Welcome, {{ Auth::user()->name }}!</h4>
</div>
<div class="container py-4">
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <h6 class="text-uppercase small">Pending Approval</h6>
                    <h2 class="display-6 fw-bold">{{ $stats['pendingCount'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <h6 class="text-uppercase small">Fully Approved</h6>
                    <h2 class="display-6 fw-bold">{{ $stats['approvedCount'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-dark text-white">
                <div class="card-body">
                    <h6 class="text-uppercase small">Disapproved</h6>
                    <h2 class="display-6 fw-bold">{{ $stats['disapprovedCount'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                {{-- <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Traveler</th>
                            <th>Purpose</th>
                            <th>Destination</th>
                            <th>Current Stage</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $req->user->name }}</div>
                                <div class="small text-muted">{{ $req->travel_departure_date }}</div>
                            </td>
                             <td>{{ $req->purpose }}</td>
                            <td>{{ $req->destination }}</td>
                            <td>
                                @if($req->status == 'pending')
                                    <span class="badge rounded-pill bg-info text-dark">
                                        Step {{ $req->current_step }}/3
                                    </span>
                                @else
                                    <span class="text-muted small">Completed</span>
                                @endif
                            </td>
                            <td>
                                @php 
                                    $color = ['pending' => 'warning', 'approved' => 'success', 'disapproved' => 'danger'];
                                @endphp
                                <span class="badge bg-{{ $color[$req->status] }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewDetailModal{{$req->id}}">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> --}}
                <table class="table table-hover mt-4">
                    <thead class="thead-dark">
                        <tr>
                            <th>Traveler</th>
                            <th>Destination</th>
                            <th>Current Approver</th>
                            <th>Current Stage</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $req)
                        <tr>
                            <td>{{ $req->user->name }}</td>
                            <td>{{ $req->destination }}</td>
                            <td>
                                @if($req->status == 'approved')
                                    <span class="text-success">Fully Approved</span>
                                @elseif($req->status == 'disapproved')
                                    <span class="text-danger">Rejected</span>
                                @else
                                    {{-- Show who needs to sign next --}}
                                    @if($req->current_step == 1) {{ $req->immediateSupervisor->name }} (Immediate Supervisor)
                                    @elseif($req->current_step == 2) {{ $req->management->name }} (Management)
                                    @elseif($req->current_step == 3) {{ $req->budgetOfficer->name }} (Budget Officer)
                                    @endif
                                @endif
                            </td>
                            <td class="text-ce">
                                                @if($req->status == 'pending')
                                                    <span class="badge rounded-pill bg-info text-dark">
                                                        Step {{ $req->current_step }}/3
                                                    </span>
                                                @else
                                                    <span class="text-muted small">Completed</span>
                                                @endif
                                            </td>
                            <td>
                                <div class="progress mt-2" style="height: 10px;">
                                    @php 
                                        $percent = ($req->status == 'approved') ? 100 : ($req->current_step - 1) * 33; 
                                    @endphp
                                    <div class="progress-bar" style="width: {{ $percent }}%"></div>
                                </div>
                            </td>
                            <td>
                                <span class="badge @if($req->status == 'pending') badge-warning @elseif($req->status == 'approved') badge-success @else badge-danger @endif">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-outline-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#viewDetailModal{{$req->id}}">View Details</a>
                                @if($req->status == 'approved')
                                    <a href="{{ route('travel_orders.download', $req->id) }}" class="btn btn-sm btn-outline-secondary me-2">
                                        <i class="fa fa-download"></i> TO
                                    </a>
                                     <a href="{{ route('travel_orders.downloadORS', $req->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fa fa-download"></i> ORS
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- <div class="card">
        <div class="card-header">Travel Requests Overview</div>
            <div class="card-body">
                <canvas id="travelChart"></canvas>
            </div>
    </div> --}}

    {{-- <div class="card">
        <div class="card-header">Travel Requests Overview</div>
            <div class="card-body">
                <canvas id="approvalSpeedChart"></canvas>
            </div>
    </div> --}}

</div>




@foreach($requests as $req)
<div class="modal fade" id="viewDetailModal{{$req->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Approval Timeline</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
                
            </div>
            <div class="card-body">
                <div class="timeline">
                    
                    <div class="d-flex mb-4 position-relative">
                        <div class="step-line"></div> <div class="me-3 z-1">
                            <span class="badge rounded-circle p-2 {{ $req->immediate_supervisor_approved_at ? 'bg-success' : 'bg-secondary' }}">
                                <i class="bi {{ $req->immediate_supervisor_approved_at ? 'bi-check-lg' : 'bi-person' }}"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Immediate Supervisor: {{ $req->immediateSupervisor->name }}</h6>
                            @if($req->immediate_supervisor_approved_at)
                                <small class="text-success">Approved on {{ $req->immediate_supervisor_approved_at }}</small>
                            @else
                                <small class="text-muted">Awaiting Action</small>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex mb-4 position-relative">
                        <div class="me-3 z-1">
                            <span class="badge rounded-circle p-2 {{ $req->management_approved_at ? 'bg-success' : ($req->current_step == 2 ? 'bg-primary' : 'bg-light text-muted') }}">
                                <i class="bi {{ $req->management_approved_at ? 'bi-check-lg' : 'bi-person' }}"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Management: {{ $req->management->name }}</h6>
                            @if($req->management_approved_at)
                                <small class="text-success">Approved on {{ $req->management_approved_at }}</small>
                            @elseif($req->status == 'disapproved')
                                <small class="text-danger">Process Halted</small>
                            @else
                                <small class="text-muted">Pending</small>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex position-relative">
                        <div class="me-3 z-1">
                            <span class="badge rounded-circle p-2 {{ $req->budget_officer_approved_at ? 'bg-success' : ($req->current_step == 3 ? 'bg-primary' : 'bg-light text-muted') }}">
                                <i class="bi {{ $req->budget_officer_approved_at ? 'bi-check-lg' : 'bi-shield-lock' }}"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Budget Officer: {{ $req->budgetOfficer->name }}</h6>
                            @if($req->budget_officer_approved_at)
                                <small class="text-success">Final Sign-off on {{ $req->budget_officer_approved_at }}</small>
                            @else
                                <small class="text-muted">Pending Final Review</small>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
      </div>
    </div>
  </div>
</div>
@endforeach



{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('approvalSpeedChart').getContext('2d');
const performanceData = @json($performanceData);

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: performanceData.map(item => item.name),
        datasets: [{
            label: 'Avg Hours to Approve',
            data: performanceData.map(item => item.avg_time),
            backgroundColor: 'rgba(13, 110, 253, 0.2)',
            borderColor: 'rgb(13, 110, 253)',
            borderWidth: 2,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Hours' } }
        }
    }
});
</script> --}}



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('travelChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], // Dynamic labels
            datasets: [{
                label: 'Requests',
                data: @json($travelData->values()),
                backgroundColor: 'rgba(54, 162, 235, 0.5)'
            }]
        }
    });
</script>

<style>
    /* Simple CSS to draw the line between steps */
    .timeline { position: relative; }
    .step-line {
        position: absolute;
        left: 15px;
        top: 20px;
        bottom: 20px;
        width: 2px;
        background: #e9ecef;
        z-index: 0;
    }
    .z-1 { z-index: 1; }
</style> 

@endsection
{{-- @section('scripts')
@parent
@if(auth()->user()->id == 1)
    <script>
    function sendMarkRequest(id = null) {
        return $.ajax("{{ route('home.markNotification') }}", {
            method: 'POST',
            data: {
                _token,
                id
            }
        });
    }

    $(function() {
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));

            request.done(() => {
                $(this).parents('div.alert').remove();
            });
        });

        $('#mark-all').click(function() {
            let request = sendMarkRequest();

            request.done(() => {
                $('div.alert').remove();
            })
        });
    });
    </script>
@endif
@endsection --}}
