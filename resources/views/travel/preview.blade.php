@extends('layouts.app')

@section('styles')
 
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/select2/select2.min.css')}}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="col-sm-6">
          <h1 class="m-0">Pre Travel Order and Itinerary of Travel</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        {{-- @can('quarter-create') --}}
        {{-- <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('roles.create') }}" data-bs-toggle="modal" data-bs-target="#createRoleModal"><i class="fas fa-plus"></i> Create New Role</a>
        </div> --}}
        {{-- @endcan --}}
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

    
<div class="row m-2">
    <form action="{{ route('travel.preview') }}" method="POST" id="add-form" class="check-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="created_by_id" value="{{ Auth::user()->id}}"/>
      <div class="row mx-5">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="mt-4 text-center">
              <h4>NATIONAL ECONOMIC AND DEVELOPMENT AUTHORITY</h4>
              <h5>Arimbay, Legazpi City</h5>
              <p class="text-end mr-5">Local Travel Order No.__________________</p>  
            </div>

            <table class="table table-bordered border-dark">
              <thead>
                <tr>
                  <td scope="col" colspan="4">NAME: </td>
                  <td scope="col" colspan="6">POSITION: </td>
                </tr>
                <tr>
                  <td scope="col" colspan="4">DESTINATION: </td>
                  <td scope="col" colspan="6">STATION: Legazpi City</td>
                </tr>
                <tr>
                  <td scope="col" colspan="4">TRAVEL PERIOD: </td>
                  <td scope="col" colspan="6">PURPOSE: </td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="10">Per approved Itinerary of Travel, actual expenses for meals, gasoline, toll fees, per diems and miscellaneous expenses are hereby authorized chargeable against the allocation for travel expenditures, subject to availability of funds and the usual accounting and auditing rules and regulations.</td>
                </tr>
                <tr>
                  <th scope="row" colspan="10" class="text-center">ITINERARY OF TRAVEL</th>
                </tr>
                <tr class="text-center">
                  <th scope="row" rowspan="2" class="align-middle">DATE</th>
                  <th scope="row" rowspan="2" class="align-middle">PLACE</th>
                  <th scope="row" colspan="2">TIME</th>
                  <th scope="row" rowspan="2" class="align-middle">Transportation Means</th>
                  <th scope="row" colspan="5">TRAVEL EXPENSES</th>
                 </tr>
                <tr class="text-center">
                  <th scope="row">ETD</th>
                  <th scope="row">ETA</th>
                  <th scope="row">Transportation</th>
                  <th scope="row">Lodging</th>
                  <th scope="row">Meals</th>
                  <th scope="row">Incidental Expenses</th>
                  <th scope="row">Total</th>
                </tr>
              </tbody>
            </table>
          </div>

      </div>
      
        <div class="mt-4 text-end">
          <div class="col pr-5">
            <button type="submit" class="btn btn-danger mr-4" value="disapproved" id="formSubmit">Disapprove</button>  
            <button type="submit" class="btn btn-primary" value="approved" id="formSubmit">Approve</button>
          </div>
        </div>
    </div>
</form>
</div>
@endsection

@section('add_modal')


@endsection


@section('javascripts')
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/select2/select2.full.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/easy-number-separator.js') }}"></script>

@endsection

@section('jsvalidator')

{{-- {!! JsValidator::formRequest('App\Http\Requests\TravelStoreRequest'); !!}  --}}

@endsection


