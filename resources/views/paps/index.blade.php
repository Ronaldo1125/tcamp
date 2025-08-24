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
          <h1 class="m-0">MFO/PAPs Management</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        @can('pap-create')
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('paps.create') }}" data-bs-toggle="modal" data-bs-target="#createPapModal"><i class="fas fa-plus"></i> Create New MFO/PAP</a>
        </div>
        @endcan
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Button trigger modal -->
{{--   
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDivisionModal">
  Add pap
</button> --}}


    
<div class="container">
    <table class="table table-bordered" id="listPapTable">
      <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">MFO/PAP Name</th>
            <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
	    @foreach ($paps as $pap)
	    <tr>
	        <td class="text-center">{{ $pap->id }}</td>
	        <td>{{ $pap->pap_name }}</td>

	        <td class="text-center">
                <form action="{{ route('paps.destroy', $pap->id) }}" method="POST">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('divisions.show',$pap->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
                    @can('pap-edit')
                    <a class="btn btn-info btn-sm" href="{{ route('paps.edit', $pap->id) }}" data-bs-toggle="modal" data-bs-target="#editPapModal{{ $pap->id }}"><i class="fas fa-edit"></i></a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('pap-delete')
                    <a href="{{ route('paps.destroy', $pap->id) }}" class="btn btn-danger btn-sm fw-bold" data-confirm-delete="true"> &#10540; </a>
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
<div class="modal fade" id="createPapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New MFO/PAP</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="container">
          <form action="{{ route('paps.store') }}" method="POST" id="add-form">
              @csrf
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="pap_name" class="form-label">MFO/PAP Name:</label>
                          <input type="text" name="pap_name" id="pap_name" class="form-control" value="{{ old('pap_name') }}" placeholder="MFO/PAP Name">
                        </div>

                        <div class="mb-3 row">
                          <label for="fund_source_id" class="form-label">User Account:</label>
                          <select class="form-control" name="fund_source_id" id="fund_source_id">
                              <option value="">Select a fund source...</option>
                              @foreach ($fund_sources as $key => $fund_source)
                              <option value="{{ $key }}">{{ $fund_source }}</option>
                              @endforeach
                          </select>
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

@foreach ($paps as $pap)  
<!-- Modal -->
<div class="modal fade" id="editPapModal{{ $pap->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit MFO/PAPs</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="{{ route('paps.update', $pap->id) }}" method="POST" id="edit-form">
              @csrf
              @method('PUT')
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                        <label for="pap_name" class="form-label">MFO/PAP Name:</label>
                          <input type="text" name="pap_name" id="pap_name" class="form-control" value="{{ $pap->pap_name }}" placeholder="pap Name">
                        </div>

                         <div class="mb-3 row">
                          <label for="fund_source_id" class="form-label">User Account:</label>
                          <select class="form-control" name="fund_source_id" id="fund_source_id">
                              <option value="">Select a fund source...</option>
                              @foreach ($fund_sources as $key => $fund_source)
                              <option value="{{ $key }}" {{ ($pap->fund_source_id == $key) ? "selected" : "" }}>{{ $fund_source }}</option>
                              @endforeach
                          </select>
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
    new DataTable('#listPapTable');
  });
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\PapStoreRequest', '#add-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\PapStoreRequest', '#edit-form'); !!}

@endsection
