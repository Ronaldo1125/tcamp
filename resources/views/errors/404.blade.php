<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="_token" content="{{csrf_token()}}" />
  <title>View Pre Travel Order Application</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ url("/plugins/fontawesome-free/css/all.min.css") }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url("/dist/css/bootstrap.min.css") }}">
  <link rel="stylesheet" href="{{ url("/dist/css/adminlte.css") }}">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh; margin: 0;">

    <div class="card p-4 shadow-sm border-0 text-center" style="max-width: 400px; width: 100%; margin: auto;">
        <div class="card-body">
            <div class="text-danger mb-3">
                <!-- Small balanced Bootstrap Icon -->
                <i class="bi bi-exclamation-triangle-fill fs-3"></i>
            </div>
            <h1 class="h5 fw-bold text-dark mb-2">404 - Page Not Found</h1>
            <p class="small text-muted mb-4">
                {{ $exception->getMessage() ?: "The page you are looking for could not be found." }}
            </p>
            <a href="/home" class="btn btn-primary btn-sm px-4 rounded">
                Return to Dashboard
            </a>
        </div>
    </div>

</body>
</html>

