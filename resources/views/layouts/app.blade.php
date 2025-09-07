<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="_token" content="{{csrf_token()}}" />
  <title>NEDA 5 - Travel Expenditure and Cash Advance Management Portal</title>
 
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ url("/plugins/fontawesome-free/css/all.min.css") }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url("/dist/css/bootstrap.min.css") }}">
  <link rel="stylesheet" href="{{ url("/dist/css/adminlte.css") }}">
 
  @yield('styles')
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-blue navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
      @if (Route::has('login'))
                    @auth
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ url('/home') }}" class="nav-link">Home</a>
                    </li>
                    @else

                    <li class="nav-item d-none d-sm-inline-block">
                      <a href="{{ url('') }}" class="nav-link">Home</a>
                    </li>
                    
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ route('login') }}" class="nav-link" target="_blank">Log in</a>
                    </li>

                        @if (Route::has('register'))
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="{{ route('register') }}" class="nav-link" target="_blank">Register</a>
                        </li>
                        @endif
                    @endauth
            @endif

            

    </ul>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav me-auto">

      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ms-auto">
          <!-- Authentication Links -->
          @guest
              @if (Route::has('login'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
              @endif

              @if (Route::has('register'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
              @endif
          @else
          <!-- Notifications Dropdown Menu -->
              {{-- <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                  <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-item dropdown-header">15 Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
              </li> --}}
              {{-- <li><a class="nav-link" href="{{ route('travel.index') }}">Create Travel Order</a></li> --}}
              <li><a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                 {{ __('Logout') }}
             </a>

             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                 @csrf
             </form></li>
          @endguest
      </ul>
  </div>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
 {{-- @yield('sidebar') --}}
 @include('layouts.sidebar')
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   @yield('content')
</div>
<!-- /.content-wrapper -->
@yield('add_modal')
@yield('edit_modal')

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
  <strong>Copyright &copy; 2025 <a href="{{ url('') }}">DEPDev 5 - Travel Expenditure and Cash Advance Management Portal</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0
  </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ url('/plugins/jquery/jquery.min.js') }}"></script>

<!-- validatation js -->
<script src="{{ url('/dist/js/validate/jquery.validate.js') }}"></script>
<script src="{{ url('/dist/js/validate/additional-methods.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ url('/dist/js/bootstrap.bundle.min.js') }}"></script>
@yield('javascripts')
<!-- AdminLTE -->
<script src="/dist/js/adminlte.js"></script>
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script> --}}

<!-- OPTIONAL SCRIPTS -->
{{-- <script src="{{ url('/plugins/chart.js/Chart.min.js') }}"></script> --}}
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ url('/dist/js/demo.js') }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ url('/dist/js/pages/dashboard3.js') }}"></script> --}}
@include('sweetalert::alert')

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@yield('jsvalidator')
@yield('scripts')
</body>
</html>