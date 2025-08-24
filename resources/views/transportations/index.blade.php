@extends('layouts.app')

@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="col-sm-6">
          <h1 class="m-0">Transportations Management</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        @can('transportation-create')
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('transportations.create') }}" data-bs-toggle="modal" data-bs-target="#createTransportationModal"><i class="fas fa-plus"></i> Create New transportation</a>
        </div>
        @endcan
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Button trigger modal -->
{{--   
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createdesignationModal">
  Add transportation
</button> --}}


    
<div class="container">
    <table class="table table-bordered" id="listTransportationTable">
      <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Transportation Name</th>
            <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
	    @foreach ($transportations as $transportation)
	    <tr>
	        <td class="text-center">{{ $transportation->id }}</td>
	        <td>{{ $transportation->transportation_name }}</td>
	        <td class="text-center">
                <form action="{{ route('transportations.update', $transportation->id) }}" method="POST">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('transportations.show',$transportation->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
                    @can('transportation-edit')
                    <a class="btn btn-info btn-sm" href="{{ route('transportations.edit', $transportation->id) }}" data-bs-toggle="modal" data-bs-target="#editTransportationModal{{ $transportation->id }}"><i class="fas fa-edit"></i></a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('transportation-delete')
                    <a href="{{ route('transportations.destroy', $transportation->id) }}" class="btn btn-danger btn-sm fw-bold" data-confirm-delete="true"> &#10540; </a>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </tbody>
    </table>
</div>
@endsection

@section('add_modal')

<!-- Modal -->
<div class="modal fade" id="createTransportationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Transportation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="container">
          <form action="{{ route('transportations.store') }}" method="POST" id="add-form">
              @csrf
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="transportation_name" class="form-label">Transportation Name:</label>
                          <input type="text" name="transportation_name" id="transportation_name" class="form-control" value="{{ old('transportation_name') }}" placeholder="Transportation Name">
                        </div>
                      </div>
                  </div>
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn-sm btn-primary" id="formSubmit">Submit</button>
                  </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('edit_modal')

@foreach ($transportations as $transportation)  
<!-- Modal -->
<div class="modal fade" id="editTransportationModal{{ $transportation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Transportation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="{{ route('transportations.update', $transportation->id) }}" method="POST" id="edit-form">
              @csrf
              @method('PUT')
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="transportation_name" class="form-label">Transportation Name:</label>
                          <input type="text" name="transportation_name" id="transportation_name" class="form-control" value="{{ $transportation->transportation_name }}" placeholder="Transportation Name">
                        </div>
                      </div>
                    </div>
                  </div>
                 
                  <div class="modal-footer">
                    <button type="button" class="btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn-sm btn-primary" id="formSubmit">Submit</button>
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


@section('javascripts')
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
<script>
  $(document).ready(function() {
    new DataTable('#listTransportationTable');
  });
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\TransportationStoreRequest'); !!}
{{-- {!! JsValidator::formRequest('App\Http\Requests\TransportationStoreRequest', '#edit-form'); !!} --}}

@endsection