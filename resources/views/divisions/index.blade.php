@extends('layouts.app')

@section('styles')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  {{-- <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}"> --}}
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="col-sm-6">
          <h1 class="m-0">Divisions Management</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        @can('division-create')
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('divisions.create') }}" data-bs-toggle="modal" data-bs-target="#createDivisionModal"><i class="fas fa-plus"></i> Create New Division</a>
        </div>
        @endcan
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Button trigger modal -->
{{--   
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDivisionModal">
  Add Division
</button> --}}


    
<div class="container">
    <table class="table table-bordered" id="listDivisionTable">
      <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Division Name</th>
            <th class="text-center">Division Acronym</th>
            <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
	    @foreach ($divisions as $division)
	    <tr>
	        <td class="text-center">{{ $division->id }}</td>
	        <td>{{ $division->division_name }}</td>
	        <td>{{ $division->division_acronym }}</td>
	        <td class="text-center">
                <form action="{{ route('divisions.destroy', $division->id) }}" method="POST">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('divisions.show',$division->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
                    @can('division-edit')
                    <a class="btn btn-info btn-sm" href="{{ route('divisions.edit', $division->id) }}" data-bs-toggle="modal" data-bs-target="#editDivisionModal{{ $division->id }}"><i class="fas fa-edit"></i></a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('division-delete')
                    <a href="{{ route('divisions.destroy', $division->id) }}" class="btn btn-danger btn-sm fw-bold" data-confirm-delete="true"> &#10540; </a>
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
<div class="modal fade" id="createDivisionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Division</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="container">
          <form action="{{ route('divisions.store') }}" method="POST" id="add-form">
              @csrf
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="division_name" class="form-label">Division Name:</label>
                          <input type="text" name="division_name" id="division_name" class="form-control" value="{{ old('division_name') }}" placeholder="Division Name">
                        </div>
                         
                        <div class="mb-3 row">
                          <label for="division_acronym" class="form-label pt-3">Division Acronym:</label>
                          <input type="text" name="division_acronym" id="division_acronym" class="form-control" value="{{ old('division_acronym') }}" placeholder="Division Acronym">
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

@foreach ($divisions as $division)  
<!-- Modal -->
<div class="modal fade" id="editDivisionModal{{ $division->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Division</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="{{ route('divisions.update', $division->id) }}" method="POST" id="edit-form">
              @csrf
              @method('PUT')
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="division_name" class="form-label">Division Name:</label>
                          <input type="text" name="division_name" id="division_name" class="form-control" value="{{ $division->division_name }}" placeholder="Division Name">
                        </div>


                        <div class="mb-3 row"> 
                          <label for="division_acronym" class="form-label pt-3">Division Acronym:</label>
                          <input type="text" name="division_acronym" id="division_acronym" class="form-control" value="{{ $division->division_acronym }} {{ old('division_acronym')}}" placeholder="Division Acronym">
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
    new DataTable('#listDivisionTable');
  });
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\DivisionStoreRequest'); !!}

@endsection

