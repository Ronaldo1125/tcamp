@extends('layouts.app')

@section('styles')
 
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
  
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-5">
        <div class="col-sm-6">
          <h1 class="m-0">Employees Management</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        @can('employee-create')
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('employees.create') }}" data-bs-toggle="modal" data-bs-target="#createEmployeeModal"><i class="fas fa-plus"></i> Create New Employee</a>
        </div>
        @endcan
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Button trigger modal -->


    
<div class="container">
    <table class="table table-bordered" id="listEmployeeTable">
      <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Last Name</th>
            <th class="text-center">First Name</th>
            <th class="text-center">Middle Name</th>
            <th class="text-center">eSignature</th>
            <th class="text-center">eSignature Filename</th>
            <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
	    @foreach ($employees as $employee)
	    <tr>
	        <td class="text-center">{{ $employee->id }}</td>
	        <td>{{ $employee->last_name }}</td>
	        <td>{{ $employee->first_name }}</td>
	        <td>{{ $employee->middle_name }}</td>
	        <td class="text-center"><img src="{{ asset('esignature_image/' . $employee->esignature_filename) }}" width="60px;" height="60px;" alt="eSignature Image"></td>
	        <td>{{ $employee->esignature_filename }}</td>

	        <td class="text-center">
                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('divisions.show',$fund_source->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
                    @can('employee-edit')
                    <a class="btn btn-info btn-sm" href="{{ route('employees.edit', $employee->id) }}" data-bs-toggle="modal" data-bs-target="#editEmployeeModal{{ $employee->id }}"><i class="fas fa-edit"></i> Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('employee-delete')
                    <a href="{{ route('employees.destroy', $employee->id) }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
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
<div class="modal fade" id="createEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="container">
          <form action="{{ route('employees.store') }}" method="POST" id="add-form" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/>
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <div class="mb-3 row">
                          <label for="last_name" class="form-label">Last Name:</label>
                          <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Last Name">
                        </div>
                         
                        <div class="mb-3 row">
                          <label for="first_name" class="form-label">First Name:</label>
                          <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="First Name">
                        </div>

                        <div class="mb-3 row">
                          <label for="middle_name" class="form-label">Middle Name:</label>
                          <input type="text" name="middle_name" id="middle_name" class="form-control" value="{{ old('middle_name') }}" placeholder="Middle Name">
                        </div>

                        <div class="mb-3 row">
                          <label for="user_id" class="form-label">User Account:</label>
                          <select class="form-control" name="user_id" id="user_id">
                              <option value="">Select a user account...</option>
                              @foreach ($users as $key => $user)
                              <option value="{{ $key }}">{{ $user }}</option>
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

                        <div class="mb-3 row">
                          <label for="esignature_image" class="form-label">eSignature Image:</label>
                          <input type="file" name="esignature_filename" id="esignature_filename">
                        </div>
                      </div>
                  </div>
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="formSubmit">Submit</button>
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

@foreach ($employees as $employee)  
<!-- Modal -->
<div class="modal fade" id="editEmployeeModal{{ $employee->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="{{ route('employees.update', $employee->id) }}" method="POST" id="edit-form" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="hidden" name="created_by_id" value="{{ $employee->created_by_id }}"/>
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                      <div class="mb-3 row">
                      <label for="last_name" class="form-label">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $employee->last_name }}" placeholder="Last Name">
                      </div>
                       
                      <div class="mb-3 row">
                        <label for="first_name" class="form-label pt-3">First Name:</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $employee->first_name }}" placeholder="First Name">
                      </div>

                      <div class="mb-3 row">
                        <label for="middle_name" class="form-label pt-3">Middle Name:</label>
                        <input type="text" name="middle_name" id="middle_name" class="form-control" value="{{ $employee->middle_name }}" placeholder="Middle Name">
                      </div>

                     

                      <div class="mb-3 row">
                        <label for="division_id" class="form-label">Division:</label>
                        <select class="form-control" name="division_id" id="division_id">
                            <option value="">Select a division...</option>
                            @foreach ($divisions as $key => $division)
                            <option value="{{ $key }}" {{ ($employee->division_id == $key) ? "selected" : "" }}>{{ $division }}</option>
                            @endforeach
                        </select>
                      </div>

                      <div class="mb-3 row">
                        <label for="designation_id" class="form-label">Designation:</label>
                        <select class="form-control" name="designation_id" id="designation_id">
                            <option value="">Select a designation...</option>
                            @foreach ($designations as $key => $designation)
                            <option value="{{ $key }}" {{ ($employee->designation_id == $key) ? "selected" : "" }}>{{ $designation }}</option>
                            @endforeach
                        </select>
                      </div>

                      <div class="mb-3 row">
                        <label for="esignature_filename" class="form-label">eSignature Image:</label>
                        <input type="file" name="esignature_filename" id="esignature_filename">
                        <img src="{{ asset('esignature_image/' . $employee->esignature_filename) }}" width="50px;" height="100px;" alt="eSignature Image">
                      </div>

                    </div>
                    </div>
                  </div>
                 
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="formSubmit">Submit</button>
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
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
<script>
  $(document).ready(function() {
    new DataTable('#listEmployeeTable');
  });
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\EmployeeStoreRequest', '#add-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\EmployeeUpdateRequest', '#edit-form'); !!}


@endsection