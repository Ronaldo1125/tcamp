@extends('layouts.app')

@section('styles')
 
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="col-sm-6">
          <h1 class="m-0">Fund Sources Management</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        @can('fund_source-create')
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('fund_sources.create') }}" data-bs-toggle="modal" data-bs-target="#createFundSourceModal"><i class="fas fa-plus"></i> Create New Fund Source</a>
        </div>
        @endcan
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Button trigger modal -->
{{--   
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDivisionModal">
  Add fund_source
</button> --}}


    
<div class="container">
    <table class="table table-bordered" id="listFundSourceTable">
      <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Fund Source Name</th>
            <th class="text-center">Fund Source Acronym</th>
            <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
	    @foreach ($fund_sources as $fund_source)
	    <tr>
	        <td class="text-center">{{ $fund_source->id }}</td>
	        <td>{{ $fund_source->fund_source_name }}</td>
	        <td>{{ $fund_source->fund_source_acronym }}</td>

	        <td class="text-center">
                <form action="{{ route('fund_sources.destroy', $fund_source->id) }}" method="POST">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('divisions.show',$fund_source->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
                    @can('fund_source-edit')
                    <a class="btn btn-info btn-sm" href="{{ route('fund_sources.edit', $fund_source->id) }}" data-bs-toggle="modal" data-bs-target="#editFundSourceModal{{ $fund_source->id }}"><i class="fas fa-edit"></i></a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('fund_source-delete')
                    <a href="{{ route('fund_sources.destroy', $fund_source->id) }}" class="btn btn-danger btn-sm fw-bold" data-confirm-delete="true"> &#10540; </a>
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
<div class="modal fade" id="createFundSourceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Fund Source</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="container">
          <form action="{{ route('fund_sources.store') }}" method="POST" id="add-form">
              @csrf
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="fund_source_name" class="form-label">Fund Source Name:</label>
                          <input type="text" name="fund_source_name" id="fund_source_name" class="form-control" value="{{ old('fund_source_name') }}" placeholder="Fund Source Name">
                        </div>
                         
                        <div class="mb-3 row">
                          <label for="fund_source_acronym" class="form-label pt-3">Fund Source Acronym:</label>
                          <input type="text" name="fund_source_acronym" id="fund_source_acronym" class="form-control" value="{{ old('fund_source_acronym') }}" placeholder="Fund Source Acronym">
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

@foreach ($fund_sources as $fund_source)  
<!-- Modal -->
<div class="modal fade" id="editFundSourceModal{{ $fund_source->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Fund Source</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="{{ route('fund_sources.update', $fund_source->id) }}" method="POST" id="edit-form">
              @csrf
              @method('PUT')
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="fund_source_name" class="form-label">Fund Source Name:</label>
                          <input type="text" name="fund_source_name" id="fund_source_name" class="form-control" value="{{ $fund_source->fund_source_name }}" placeholder="fund_source Name">
                        </div>

                        <div class="mb-3 row">
                          <label for="fund_source_acronym" class="form-label pt-3">Fund Source Acronym:</label>
                          <input type="text" name="fund_source_acronym" id="fund_source_acronym" class="form-control" value="{{ $fund_source->fund_source_acronym }} {{ old('fund_source_acronym')}}" placeholder="Fund Source Acronym">
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
    new DataTable('#listFundSourceTable');
  });
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\FundSourceStoreRequest'); !!}

@endsection
