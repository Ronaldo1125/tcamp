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
          <h1 class="m-0">Travel Order Application</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        {{-- @can('quarter-create') --}}
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('travel.create') }}"><i class="fas fa-plus"></i> Create Travel Order</a>
        </div>
        {{-- @endcan --}}
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Button trigger modal -->


    
<div class="container">
    <table class="table table-bordered" id="listTravelTable">
      <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">REF</th>
            <th class="text-center">Particulars</th>
            <th class="text-center">Amount</th>
            <th class="text-center">Attachment</th>
            <th class="text-center">Document</th>
            <th class="text-center">Status</th>
        </tr>
      </thead>
      <tbody>
	    @foreach ($travel as $trav)
	    <tr>
	        <td class="text-center">{{ $trav->id }}</td>
	        <td>{{ $trav->id }}</td>
	        <td>{{ $trav->purpose }}</td>
	        <td>{{ $trav->grand_total }}</td>
	        <td>{{ $trav->purpose_filename }}</td>
	        <td>{{ $employee->esignature_filename }}</td>

	        
	    </tr>
	    @endforeach
    </tbody>
    </table>
</div>
@endsection

@section('add_modal')

<!-- Modal -->

@endsection

@section('edit_modal')

@endsection

@section('javascripts')
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
<script>
  $(document).ready(function() {
    new DataTable('#listTravelTable');
  });
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\EmployeeStoreRequest', '#add-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\EmployeeUpdateRequest', '#edit-form'); !!}


@endsection