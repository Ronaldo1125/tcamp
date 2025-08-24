@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Add New Division</h1>
      </div><!-- /.col -->
      
     
    </div><!-- /.row -->
    <div class="row mb-2">
      <div class="col-11 text-end">
      <a class="btn btn-primary btn-sm" href="{{ route('divisions.index') }}"><i class="fas fa-angle-double-left"></i> Back</a>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

@if ($errors->any())
<div class="row">
  <div class="col-3"></div>
  <div class="col-6">
    <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="btn-close te" aria-label="close" data-bs-dismiss="alert"></button>
    </div>
  </div>
  <div class="col-3"></div>
</div>
@endif
<div class="container">
<form action="{{ route('divisions.store') }}" method="POST">
    @csrf
    {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
     <div class="row mx-5">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label for="division_name" class="form-label">Division Name:</label>
                <input type="text" name="division_name" id="division_name" class="form-control mb-3" value="{{ old('division_name') }}" placeholder="Division Name">
                <label for="division_acronym" class="form-label">Division Acronym:</label>
                <input type="text" name="division_acronym" id="division_acronym" class="form-control" value="{{ old('division_acronym') }}" placeholder="Division Acronym">
            </div>
        </div>
       
        <div class="col-xs-12 col-sm-12 col-md-12 text-center py-3">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Submit</button>
        </div>
    </div>
</form>
</div>


@endsection
