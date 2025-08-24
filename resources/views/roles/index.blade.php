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
          <h1 class="m-0">Roles Management</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        @can('role-create')
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('roles.create') }}" data-bs-toggle="modal" data-bs-target="#createRoleModal"><i class="fas fa-plus"></i> Create New Role</a>
        </div>
        @endcan
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Button trigger modal -->
{{--   
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createuserModal">
  Add user
</button> --}}


    
<div class="container">
    <table class="table table-bordered" id="listRoleTable">
      <thead>
        <tr>
            <th class="text-center">ID No</th>
            <th class="text-center">Name</th>
            <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
	    @foreach ($roles as $role)
	    <tr>
	        <td class="text-center">{{ $role->id }}</td>
	        <td>{{ $role->name }}</td>
            
	        <td class="text-center">
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
                    @can('role-edit')
                    <a class="btn btn-info btn-sm" href="{{ route('roles.edit', $role->id) }}"><i class="fas fa-edit"></i> </a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('role-delete')
                    <a href="{{ route('roles.destroy', $role->id) }}" class="btn btn-danger btn-sm fw-bold" data-confirm-delete="true"> &#10540; </a>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </tbody>
    </table>
</div>
@endsection

@section('add_modal')

<!-- Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Role</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="container">
            <form action="{{ route('roles.store') }}" method="POST" id="add-form">
                @csrf
            <div class="row mx-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <div class="row mb-3">
                      <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Name">
                      </div>
                    <div class="row mb-3">
                        <label for="permission" class="form-label">Permission:</label>
                        <select class="form-control select2" name="permission[]" id="permission" multiple="multiple" style="width:100%">
                            @foreach ($permissions as $key => $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                </div>
              </div>
                <div class="modal-footer">  
                  <button type="button" class="btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn-sm btn-primary" id="formSubmit">Submit</button>
                </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- @section('edit_modal')

@foreach($roles as $role)

<!-- Modal -->
<div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Role</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="container">
            <form action="{{ route('roles.update', $role->id) }}" method="POST" id="edit-form">
                @csrf
            <div class="row mx-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <div class="row mb-3">
                      <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" placeholder="Name">
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
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="formSubmit">Submit</button>
                </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endforeach
@endsection --}}


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
{{-- {!! JsValidator::formRequest('App\Http\Requests\RoleStoreRequest', '#edit-form'); !!} --}}

@endsection

