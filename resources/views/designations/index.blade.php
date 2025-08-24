@extends('layouts.app')

@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }} ">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="col-sm-6">
          <h1 class="m-0">Designations Management</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        @can('designation-create')
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('designations.create') }}" data-bs-toggle="modal" data-bs-target="#createDesignationModal"><i class="fas fa-plus"></i> Create New Designation</a>
        </div>
        @endcan
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Button trigger modal -->
{{--   
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createdesignationModal">
  Add designation
</button> --}}


    
<div class="container">
    <table class="table table-bordered" id="listDesignationTable">
      <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Designation Name</th>
            <th class="text-center">Designation Acronym</th>
            <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
	    @foreach ($designations as $designation)
	    <tr>
	        <td class="text-center">{{ $designation->id }}</td>
	        <td>{{ $designation->designation_name }}</td>
	        <td>{{ $designation->designation_acronym }}</td>
	        <td class="text-center">
                {{-- <form action="{{ route('designations.update', $designation->id) }}" method="POST"> --}}
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('designations.show',$designation->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
                    @can('designation-edit')
                    <a class="btn btn-info btn-sm" href="{{ route('designations.edit', $designation->id) }}" data-bs-toggle="modal" data-bs-target="#editDesignationModal{{ $designation->id }}"><i class="fas fa-edit"></i></a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('designation-delete')
                    <a href="{{ route('designations.destroy', $designation->id) }}" class="btn btn-danger btn-sm fw-bold" data-confirm-delete="true"> &#10540; </a>
                    @endcan
                {{-- </form> --}}
	        </td>
	    </tr>
	    @endforeach
    </tbody>
    </table>
</div>
@endsection

@section('add_modal')

<!-- Modal -->
<div class="modal fade" id="createDesignationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Designation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="container">
          <form action="{{ route('designations.store') }}" method="POST" id="add-form">
              @csrf
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="designation_name" class="form-label">Designation Name:</label>
                          <input type="text" name="designation_name" id="designation_name" class="form-control" value="{{ old('designation_name') }}" placeholder="Designation Name">
                        </div>
                        <div class="mb-3 row">
                          <label for="designation_acronym" class="form-label">Designation Acronym:</label>
                          <input type="text" name="designation_acronym" id="designation_acronym" class="form-control" value="{{ old('designation_acronym') }}" placeholder="Designation Acronym">
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

@foreach ($designations as $designation)  
<!-- Modal -->
<div class="modal fade" id="editDesignationModal{{ $designation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Designation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="{{ route('designations.update', $designation->id) }}" method="POST" id="edit-form">
              @csrf
              @method('PUT')
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="designation_name" class="form-label">Designation Name:</label>
                          <input type="text" name="designation_name" id="designation_name" class="form-control" value="{{ $designation->designation_name }}" placeholder="Designation Name">
                        </div>
                          <div class="mb-3 row">
                          <label for="designation_acronym" class="form-label pt-3">Designation Acronym:</label>
                          <input type="text" name="designation_acronym" id="designation_acronym" class="form-control" value="{{ $designation->designation_acronym }} {{ old('designation_acronym')}}" placeholder="Designation Acronym">
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
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    new DataTable('#listDesignationTable');
  });
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\DesignationStoreRequest'); !!}

@endsection