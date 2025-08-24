@extends('layouts.app')

@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
  
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Travel Order Application</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('travel_orders.create') }}"><i class="fas fa-plus"></i> Create Travel Order</a>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <div class="container">
    <table class="table table-bordered" id="listTravelOrderTable">
      <thead>
        <tr>
            <th class="text-center">TO Number</th>
            <th class="text-center">Particulars</th>
            <th class="text-center">Posted By</th>
            <th class="text-center">Amount</th>
            <th class="text-center">Attachment</th>
            {{-- <th class="text-center">Document</th> --}}
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
            <th class="text-center">File View</th>
            {{--<th class="text-center">Immediate Supervisor</th>
            <th class="text-center">Management</th> --}}
        </tr>
      </thead>
      <tbody>
	    @foreach ($travel_orders as $travel_order)
	    <tr>
	        <td class="text-center">{{ $travel_order->to_code . '-' . sprintf("%02d", $travel_order->id) }}</td>
	        <td>{{ $travel_order->purpose }}</td>
	        <td>{{ $travel_order->user->name }}</td>
	        <td class="text-end">{{ number_format($travel_order->grand_total, 2) }}</td>
	        <td class=" text-center align-middle"><a href="/travel_attachment/{{ $travel_order->purpose_image_filename }}" class="btn btn-info btn-xs" target="_blank"><i class="fas fa-download"></i> Download</a></td>
          {{-- <td class=" text-center align-middle"><a href="#" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a></td> --}}
          <td class=" text-center align-middle">
            @if(count($travel_order->approval_type) == 0)
              <label class="badge badge-danger">For review and approval by the Immediate Supervisor</label>
            @endif
            @if(count($travel_order->approval_type) == 1)
                @if($travel_order->approval_type[0]->approval_type_name == 'Approved')
                  <label class="badge badge-success">Approved by the Immediate Supervisor </label><br>
                  <label class="badge badge-danger">For review and approval by ARD</label>  
                @else
                    <label class="badge badge-danger">Disapproved by the Immediate Supervisor</label>
                @endif
            @endif
            @if(count($travel_order->approval_type) == 2)
              @if($travel_order->approval_type[1]->approval_type_name == 'Approved')
              <label class="badge badge-success">Approved by ARD </label><br>
                <label class="badge badge-danger">For review and approval by the Budget Officer</label>
              @else
                  <label class="badge badge-danger">Disapproved by ARD</label>
              @endif
            @endif
            @if(count($travel_order->approval_type) == 3)
              @if($travel_order->approval_type[2]->approval_type_name == 'Approved')
                <label class="badge badge-success">Approved</label><br>
              @else
                  <label class="badge badge-danger">Disapproved</label>
              @endif
            @endif
          </td>
	       
          <td class=" text-center align-middle">
            @can('travel_order-sendApproval')
          
            @if($role == 'Immediate Supervisor' && (count($travel_order->approval_type) == 0))
              <a class="btn btn-warning btn-xs" 
                href="{{ route('travel_orders.sendApproval', $travel_order->id) }}" 
                data-bs-toggle="modal" 
                data-bs-target="#addTravelOrderApprovalModal{{ $travel_order->id }}" 
                title="Approve/Disapprove Travel Order"><i class="fas fa-thumbs-up"></i>
              </a>          
            @endif
            @if($role == 'Management' && (count($travel_order->approval_type) == 1) && ($travel_order->approval_type[0]->approval_type_name == 'Approved'))
              <a class="btn btn-warning btn-xs" 
                href="{{ route('travel_orders.sendApproval', $travel_order->id) }}" 
                data-bs-toggle="modal" 
                data-bs-target="#addTravelOrderApprovalModal{{ $travel_order->id }}" 
                title="Approve/Disapprove Travel Order"><i class="fas fa-thumbs-up"></i>
              </a>          
            @endif
            @if($role == 'Budget Officer' && (count($travel_order->approval_type) == 2) && ($travel_order->approval_type[1]->approval_type_name == 'Approved'))
            <a class="btn btn-warning btn-xs" 
              href="{{ route('travel_orders.sendApproval', $travel_order->id) }}" 
              data-bs-toggle="modal" 
              data-bs-target="#addTravelOrderApprovalModal{{ $travel_order->id }}" 
              title="Approve/Disapprove Travel Order"><i class="fas fa-thumbs-up"></i>
            </a>          
            @endif
            @endcan

            {{-- @can('travel_order-edit')
            <a class="btn btn-info btn-xs" href="{{ route('travel_orders.edit', $travel_order->id) }}"><i class="fas fa-edit"></i> </a>
            @endcan --}}

            @can('travel_order-delete')
              <a href="{{ route('travel_orders.destroy', $travel_order->id) }}" class="btn btn-danger btn-xs fw-bold" data-confirm-delete="true"> &#10540;</a>
              @endcan
           

            <form action="{{ route('travel_orders.destroy', $travel_order->id) }}" method="POST">
              {{-- <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
             
              @csrf
              @method('DELETE')
          </form>

          </td>
          <td class="text-center align-middle">
            @if(count($travel_order->approval_type) >= 2)
                <a class="btn btn-dark btn-xs" href="{{ route('travel_orders.view_travel_order', $travel_order->id) }}" 
                  title="View Travel Order" target="_blank"><i class="fas fa-plane"></i>
                  </a>
            @endif
            @if(count($travel_order->approval_type) >= 3)
                <a class="btn btn-danger btn-xs" href="{{ route('travel_orders.view_ors', $travel_order->id) }}" 
                  title="View ORS" target="_blank"><i class="fas fa-eye"></i>
                </a>
            @endif         
          </td>
	    </tr>
	    @endforeach
    </tbody>
    </table>
</div>
  @endsection

  @section('add_modal')
  @foreach ($travel_orders as $travel_order)  
<!-- Modal -->

<div class="modal fade" id="addTravelOrderApprovalModal{{ $travel_order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Approval</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
       
          <h5 class="mb-3">Purpose: {{ $travel_order->purpose }}</h5>
          <form action="{{ route('travel_orders.sendApproval', $travel_order->id) }}" method="POST" id="edit-form">
              @csrf
              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
              <input type="hidden" name="travel_order_id" value="{{ $travel_order->id }}"/>
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                          <label for="approval_type_id" class="form-label">Approval Type:</label>
                          <select class="form-control" name="approval_type_id" id="approval_type_id">
                            <option value="">-- Select Approval Type --</option>
                              @foreach ($approval_types as $key => $approval_type)
                              <option value="{{ $key }}">{{ $approval_type }}</option>
                              @endforeach
                          </select>
                        <div class="mb-3 row">
                          <label for="Remarks" class="form-label">Remarks:</label>
                            <textarea name="remarks" id="transportation_name" class="form-control" placeholder="Type approval remarks."></textarea>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="fw-bold pb-1">Status:</div>
                  @if(count($travel_order->travel_order_user_approvals) != 0)
                    @php
                    $approvals = $travel_order->travel_order_user_approvals->sortByDesc('id');
                    @endphp
                    @foreach ($approvals as $approval)
                     
                      <div class="row p-2 fw-bold border border-secondary" style="font-size: 13px;">
                        <div class="col-1">
                          <span class="btn btn-primary fw-bold" style="border-radius: 50%; font-size: 12px;">
                            @php
                            $arrName = explode(" ", $approval->user->name);
                            $initialName = '';
                            $cnt = count($arrName);
                            if($cnt > 1) {
                               $initialName = substr(ucfirst($arrName[0]), 0, 1) . substr(ucfirst($arrName[$cnt - 1]), 0, 1);
                            } elseif($cnt == 1) {
                              $initialName = substr(ucfirst($arrName[0]), 0, 1);
                            }
                            @endphp

                            {{ $initialName }}
                          </span>
                        </div>
                        <div class="col-3">
                          Approved by</br>
                          {{ $approval->user->name }}
                          
                        </div>
                        <div class="col-5">&nbsp;</div>
                        <div class="col-3">
                          {{ $approval->created_at }}
                        </div>
                      </div>
                      <hr>
                    @endforeach
                  @endif
                  <div class="row p-2 fw-bold border border-secondary" style="font-size: 13px;">
                    <div class="col-1">
                      <span class="btn btn-danger fw-bold" style="border-radius: 50%; font-size: 12px;">
                        @php
                            $arrName = explode(" ", $travel_order->user->name);
                            $initialName = '';
                            $cnt = count($arrName);
                            if($cnt > 1) {
                               $initialName = substr(ucfirst($arrName[0]), 0, 1) . substr(ucfirst($arrName[$cnt - 1]), 0, 1);
                            } elseif($cnt == 1) {
                              $initialName = substr(ucfirst($arrName[0]), 0, 1);
                            }
                            @endphp
                            {{ $initialName }}
                        </span>
                    </div>
                    <div class="col-3">
                      Requested by</br>
                      {{ $travel_order->user->name }}
                      
                    </div>
                    <div class="col-5">&nbsp;</div>
                    <div class="col-3">
                      {{ $travel_order->created_at }}
                    </div>
                  </div>
                 
                  <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="formSubmit">Submit</button>
                  </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
  @endsection

  @section('edit_modal')
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