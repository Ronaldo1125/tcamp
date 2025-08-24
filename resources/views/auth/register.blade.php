<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ url('/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url("/dist/css/bootstrap.min.css") }}">
  <link rel="stylesheet" href="{{ url("/dist/css/adminlte.css") }}">
</head>
<body class="hold-transition register-page bg-img">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <div class="h5 font-weight-bold">NEDA 5 Travel Expenditure and Cash Advance Management Portal (TCAMP)</div>
    </div>
    <div class="card-body">
      <p class="login-box-msg font-weight-bold">Register a New Membership</p>
      <p class="small p-2 bg-light shadow-lg font-weight-bold font-italic rounded-3 text-justify">NEDA PRIVACY NOTICE: "All the personal information contained in this system shall be used solely for documentation and processing purposes within the NEDA and shall not be shared with any outside parties, unless with your written consent. Personal information shall be retained and stored by NEDA within a time period in accordance with the National Archives of the Philippines' General Disposition Schedule."</p>
    </p>

      <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
        <input type="hidden" name="created_by_id" value="1"/>
        <input type="hidden" name="role_id" value="5"/>
        <div class="input-group">
          <input type="text" name="name" tabindex="1" class="form-control" placeholder="Full name" value="{{ old('name') }}" autofocus>
@error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mt-3">
        <input id="email" type="email" tabindex="2"  placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email"
         value="{{ old('email') }}" required  autofocus>

{{-- @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror --}}
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
<div class="input-group mt-3">
<input id="pass" type="password" tabindex="3" class="form-control @error('password') is-invalid @enderror" name="password" required
autocomplete="new-password"  placeholder="Password">

@error('password')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
<div class="input-group-append">
<div class="input-group-text">
  <a href="#" class="text-dark" id="icon-click">
    <i class="fas fa-eye" id="icon"></i>
  </a>
</div>
</div>
</div>


<div class="input-group mt-3">
<input id="confirm-pass" type="password" tabindex="4"  placeholder="Confirm Password" class="form-control" name="confirm-password" required autocomplete="new-password">


@error('password')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
<div class="input-group-append">
<div class="input-group-text">
  <a href="#" class="text-dark" id="icon-click-confirm">
    <i class="fas fa-eye" id="icon-confirm"></i>
  </a>
</div>
</div>
</div>





    
        <div class="row mt-4">
          <div class="col-8">
            <a href="{{route('login')}}" class="text-center">I already have a membership</a>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      {{-- <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div> --}}

      
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ url('/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ url('/dist/js/adminlte.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#icon-click").click(function(){
      $("#icon").toggleClass('fa-eye-slash');
  
      var input = $("#pass");
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

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

{!! JsValidator::formRequest('App\Http\Requests\RegistrationStoreRequest') !!}
</body>
</html>