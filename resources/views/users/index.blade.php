@extends('layouts.app')

@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="col-sm-6">  
          <h5 class="ml-5 fw-bold">User Management</h5>
        </div><!-- /.col --> 
      </div><!-- /.row -->
      <div class="row mb-2">
        @can('user-create')
        <div class="col-11 text-end">
          <a class="btn btn-sm btn-primary" href="{{ route('users.create') }}" data-bs-toggle="modal" data-bs-target="#createUserModal"><i class="fas fa-plus"></i> Create New User</a>
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
    <table class="table table-bordered" id="listUserTable">
      <thead>
        <tr>
            <th class="text-center">ID No</th>
            <th class="text-center">Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">Role</th>
            <th class="text-center">Active</th>
            <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
	    @foreach ($users as $user)
	    <tr>
	        <td class="text-center">{{ $user->id }}</td>
	        <td>{{ $user->name }}</td>
	        <td>{{ $user->email }}</td>
            <td class="text-center">@if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                   <label class="badge badge-success">{{ $v }}</label>
                @endforeach
              @endif</td>
              <td class="text-center">
                <label class="badge badge-primary">{{ ($user->is_active) ? 'Yes' : 'No' }}</label>
              </td>

            
	        <td class="text-center">
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
                    @can('user-edit')
                    <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user->id) }}" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}"><i class="fas fa-edit"></i></a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('user-delete')
                    <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm fw-bold" data-confirm-delete="true"> &#10540; </a>
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
<div class="modal fade add-modal" id="createUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="container">
            <form action="{{ route('users.store') }}" method="POST" id="add-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="created_by_id" value="{{ Auth::user()->id}}"/>
            <div class="row mx-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <div class="mb-3 row">
                      <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Name">
                      </div>

                      <div class="mb-3 row">
                        <label for="email" class="form-label">Email Account:</label>
                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                      </div>

                      <div class="mb-3 row">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" placeholder="Password">
                      </div>

                      <div class="mb-3 row">
                        <label for="confirm-password" class="form-label">Confirm Password:</label>
                        <input type="password" name="confirm-password" id="confirm-password" class="form-control" value="{{ old('confirm-password') }}" placeholder="Confirm Password">
                      </div>

                      <div class="mb-3 row">
                        <label for="role_id" class="form-label">Role:</label>
                        
                        <select class="form-control" name="role_id" id="role_id">
                          <option value="">Select a role...</option> 
                            @foreach ($roles as $key => $role)
                            <option value="{{ $key }}">{{ $role }}</option>
                            @endforeach
                            
                        </select>
                      </div>

                      <div class="mb-3 row">
                        <label for="division_id" class="form-label">Division:</label>
                        <select class="form-control" name="division_id" id="division_id">
                            <option value="">Select a division...</option>
                            @foreach ($divisions as $key => $division)
                            <option value="{{ $key }}">{{ $division }}</option>
                            @endforeach
                        </select>
                      </div>

                      <div class="mb-3 row">
                        <label for="designation_id" class="form-label">Designation:</label>
                        <select class="form-control" name="designation_id" id="designation_id">
                            <option value="">Select a designation...</option>
                            @foreach ($designations as $key => $designation)
                            <option value="{{ $key }}">{{ $designation }}</option>
                            @endforeach
                        </select>
                      </div>

                      <div class="row">
                        <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" value="{{ old('is_active') }}">
                        <label for="" class="form-label">Active</label>
                        </div>
                      </div>

                    </div>
                </div>
              </div>
                <div class="modal-footer">  
                  <button type="button" class="btn-sm btn-secondary btn-cancel" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn-sm btn-primary" id="formSubmit">Submit</button>
                </div>
            </div>
        </form>
        
          
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('edit_modal')

@foreach ($users as $user)  
<!-- Modal -->
<div class="modal fade edit-modal" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit user</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="{{ route('users.update', $user->id) }}" method="POST" id="edit-form" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/>
              <div class="row mx-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <div class="mb-3 row">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" data-original="{{ $user->name }}" placeholder="Name">
                      </div>
                      
                        
                        <div class="mb-3 row">
                          <label for="email" class="form-label pt-3">Email Account:</label>
                          <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}" data-original="{{ $user->email }}" placeholder="Email">
                        </div>
                       

                        <div class="mb-3 row">
                          <label for="password" class="form-label pt-3">Password:</label>
                          <input type="password" name="password" id="password" class="form-control" value="" placeholder="Password">
                        </div>
                           
                        <div class="mb-3 row">
                          <label for="confirm-password" class="form-label pt-3">Confirm Password:</label>
                          <input type="password" name="confirm-password" id="confirm-password" class="form-control" value="" placeholder="Confirm Password">
                        </div>
                     
                        <div class="mb-3 row">
                          <label for="role_id" class="form-label pt-3">Role:</label>
                          <select class="form-control" name="role_id" id="role_id" data-original="{{ $user->role_id }}">
                            <option value="">Select a role...</option>
                              @foreach ($roles as $key => $role)
                              <option value="{{ $key }}" {{ ($user->role_id == $key) ? "selected='selected'" : "" }}>{{ $role }}</option>
                              @endforeach
                          </select>
                        </div>
                        
                        <div class="mb-3 row">
                          <label for="division_id" class="form-label">Division:</label>
                          <select class="form-control" name="division_id" id="division_id" data-original="{{ $user->division_id }}">
                              <option value="">Select a division...</option>
                              @foreach ($divisions as $key => $division)
                              <option value="{{ $key }}" {{ ($user->division_id == $key) ? "selected" : "" }}>{{ $division }}</option>
                              @endforeach
                          </select>
                        </div>
  
                        <div class="mb-3 row">
                          <label for="designation_id" class="form-label">Designation:</label>
                          <select class="form-control" name="designation_id" id="designation_id" data-original="{{ $user->designation_id }}">
                              <option value="">Select a designation...</option>
                              @foreach ($designations as $key => $designation)
                              <option value="{{ $key }}" {{ ($user->designation_id == $key) ? "selected" : "" }}>{{ $designation }}</option>
                              @endforeach
                          </select>
                        </div>
  
                        <div class="form-check">
                          <input type="checkbox" name="is_active" id="is_active" value="{{ $user->is_active }}" {{ ($user->is_active) ? 'checked' : '' }} data-original="{{ $user->is_active }}">
                          <label for="is_active" class="form-label pt-3">Active</label>
                          </div>
  
                    </div>
                </div>
              </div>
                <div class="modal-footer">  
                  <button type="button" class="btn-sm btn-secondary btn-cancel" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn-sm btn-primary" id="formSubmit">Submit</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection

@section('javascripts')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    new DataTable('#listUserTable');

      $('.btn-cancel, .btn-close').on('click', function () {
          let $modal = $(this).closest('.edit-modal, .add-modal');
          let $nameInput = $modal.find('#name');
          let $emailInput = $modal.find('#email');
          let $passwordInput = $modal.find('#password');
          let $confirmPasswordInput = $modal.find('#confirm-password');
          let $roleInput = $modal.find('#role_id');
          let $divisionInput = $modal.find('#division_id');
          let $designationInput = $modal.find('#designation_id');
          let $isActiveInput = $modal.find('#is_active');

          if($modal.hasClass('edit-modal')) {
              $nameInput.val($nameInput.data('original')); // Reset to original value for edit modal
              $emailInput.val($emailInput.data('original')); // Reset to original value for edit modal
              $passwordInput.val(''); // Clear the password input for edit modal
              $confirmPasswordInput.val(''); // Clear the confirm password input for edit modal
              $roleInput.val($roleInput.data('original')); // Reset to original value for edit modal
              $divisionInput.val($divisionInput.data('original')); // Reset to original value for edit modal
              $designationInput.val($designationInput.data('original')); // Reset to original value for edit modal
              $isActiveInput.prop('checked', ($isActiveInput.data('original') == 1)); // Reset to original value for edit modal
          } else {
              $nameInput.val(''); // Clear the input for add modal
              $emailInput.val(''); // Clear the input for add modal
              $passwordInput.val(''); // Clear the password input for add modal
              $confirmPasswordInput.val(''); // Clear the confirm password input for add modal
              $roleInput.val(''); // Clear the select for add modal
              $divisionInput.val(''); // Clear the select for add modal
              $designationInput.val(''); // Clear the select for add modal
              $isActiveInput.prop('checked', false); // Uncheck the checkbox for add modal
          }
      });
  });
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\UserStoreRequest'); !!}
{{-- {!! JsValidator::formRequest('App\Http\Requests\UserStoreRequest', '#edit-form'); !!} --}}

@endsection

