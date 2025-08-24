@extends('layouts.app')

@section('styles')
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/select2/select2.min.css')}}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Role</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        @can('role-edit')
        <div class="col text-end mr-5">
        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div>
        @endcan
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <div class="container">
    <form action="{{ route('roles.update', $roles->id) }}" method="POST" id="edit-form">
        @csrf
        @method('PATCH')
    <div class="row mx-5">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <div class="row mb-3">
              <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $roles->name }}" placeholder="Name">
              </div>
            <div class="row mb-3">
                <label for="permission" class="form-label">Permission:</label>
                <select class="form-control select2bs4" name="permission[]" id="permission" multiple="multiple" style="width:100%">
                    @foreach ($permissions as $key => $permission)
                    <option value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions) ? "selected" : "" }}>{{ $permission->name }}</option>
                    @endforeach
                </select>
              </div>
            </div>
        </div>
      </div>
        <div class="modal-footer">
          <button type="submit" class="btn-sm btn-primary" id="formSubmit">Submit</button>
        </div>
</form>
</div>

@endsection

@section('javascripts')
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/select2/select2.full.min.js') }}"></script>

<script>
  $(document).ready(function() {
    new DataTable('#listRoleTable');
    $('.select2').select2()

    $('.select2bs4').select2()

  });
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\RoleStoreRequest'); !!}
@endsection
