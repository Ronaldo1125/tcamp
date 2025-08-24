@extends('layouts.app')

@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card card-danger">
                <div class="card-header"><strong>Advisory</strong></div>

                <div class="card-body">
                   <p>The administrator will review all the data you have submitted. Upon completion and verification, a notification will be sent to your email account, confirming that you are now allowed to use the application. Thank you.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection