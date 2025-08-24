@extends('layouts.app')

@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-sm-6">
          <h1 class="m-0">Profile</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

 


    
<div class="container">
 <p>
    
      <div class="row mx-5">
        <div class="col-xs-10 col-sm-10 col-md-10">
        
          <h4 class="my-3">Change Password</h4>

          <p>Ensure your account is using a long, random password to stay secure.</p>
          <form action="{{ route('profiles.updatePassword', $user->id) }}" method="POST" id="update-form" enctype="multipart/form-data">
            @csrf
            @method('POST')
          <div class="form-group">
              <div class="input-group">
                <input type="password" name="current_password" id="current-pass" class="form-control" value="" placeholder="Current Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <a href="#" class="text-dark" id="icon-click">
                      <i class="fas fa-eye" id="icon"></i>
                    </a>   
                  </div>
                </div>
              </div>
            
            <div class="input-group mt-3">
              <input type="password" name="password" id="new-pass" class="form-control" value="" placeholder="New Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <a href="#" class="text-dark" id="icon-click-new">
                    <i class="fas fa-eye" id="icon-new"></i>
                  </a>   
                </div>
              </div>
            </div>
               
            <div class="input-group mt-3">
              <input type="password" name="confirm_password" id="confirm-pass" class="form-control" value="" placeholder="Confirm Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <a href="#" class="text-dark" id="icon-click-confirm">
                    <i class="fas fa-eye" id="icon-confirm"></i>
                  </a>   
                </div>
              </div>
            </div>

              <div class="row-3 mt-5">  
                <button type="submit" class="btn-sm btn-primary" id="formSubmit">Update Password</button>
              </div>
          </div>
        </form>
        </div>
      </div>
    </div>
 
  </p>
</div>



@endsection



@section('javascripts')
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#icon-click").click(function(){
      $("#icon").toggleClass('fa-eye-slash');
  
      var input = $("#current-pass");
      if(input.attr("type")==="password") 
      {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    $("#icon-click-new").click(function(){
      $("#icon-new").toggleClass('fa-eye-slash');
  
      var input = $("#new-pass");
      if(input.attr("type")==="password") 
      {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    $("#icon-click-confirm").click(function(){
      $("#icon-confirm").toggleClass('fa-eye-slash');
  
      var input = $("#confirm-pass");
      if(input.attr("type")==="password") 
      {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  });
</script>
@endsection



@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\PasswordUpdateRequest'); !!}
{{-- {!! JsValidator::formRequest('App\Http\Requests\TransportationStoreRequest', '#edit-form'); !!} --}}

@endsection