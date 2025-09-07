<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ url('/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('/dist/css/adminlte.css')}}">
  
</head>
<body class="hold-transition login-page bg-img">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <div class="mb-2"><img src="/dist/img/depdev_logo.png" width="100" height="100"></div>
    <div class="h5 font-weight-bold">DEPDev 5 Travel Expenditure and Cash Advance Management Portal (TCAMP)</div>
    </div>
    <div class="card-body">
      <p class="login-box-msg font-weight-bold">Log In</p>

      <form method="POST" action="{{ route('login') }}">
                        @csrf
        <div class="input-group mb-3">
        <input id="email" type="email" placeholder="Enter Your Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="input-group mb-3">
        <input id="pass" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

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
        <div class="row">
          <div class="col-8">
            &nbsp;
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
        <div class="row">
          <div class="col-12">
            <a href="{{route('password.request')}}" class="text-center">I forgot my password</a>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <a href="{{route('register')}}" class="text-center">Register a new membership</a>
          </div>
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
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
});
</script>
</body>
</html>