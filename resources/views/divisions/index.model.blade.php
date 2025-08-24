@extends('layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Divisions Management</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        {{-- @can('quarter-create') --}}
        <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('divisions.create') }}"><i class="fas fa-plus"></i> Create New Division</a>
        </div>
        {{-- @endcan --}}
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Add Division
</button>


    {{-- @if ($message = Session::get('success'))
    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="alert alert-success alert-dismissible" role="alert">
          <p class="text-center">{{ $message }}</p>
          <button class="btn-close" aria-label="close" data-bs-dismiss="alert"></button>
        </div>
      </div>
      <div class="col-3"></div>
    </div>
        
    @endif --}}
<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Division Name</th>
            <th>Division Acronym</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($divisions as $division)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $division->division_name }}</td>
	        <td>{{ $division->division_acronym }}</td>
	        <td class="text-center">
                <form action="{{ route('divisions.destroy',$division->id) }}" method="POST">
                    {{-- <a class="btn btn-info btn-sm" href="{{ route('divisions.show',$division->id) }}"> <i class="fas fa-eye"></i> Show</a> --}}
                    {{-- @can('quarter-edit') --}}
                    <a class="btn btn-primary btn-sm" href="{{ route('divisions.edit',$division->id) }}"><i class="fas fa-edit"></i> Edit</a>
                    {{-- @endcan --}}

                    @csrf
                    @method('DELETE')
                    {{-- @can('quarter-delete') --}}
                    <a href="{{ route('divisions.destroy', $division->id) }}" class="btn btn-danger btn-sm" data-confirm-delete="true"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                    {{-- @endcan --}}
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Division</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" style="display:none"></div>

        <div class="container">
          <form action="{{ route('divisions.store') }}" method="POST">
              @csrf
              {{-- <input type="hidden" name="created_by_id" value="{{ Auth::user()->id }}"/> --}}
               <div class="row mx-5">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <div class="form-group">
                        <label for="division_name" class="form-label">Division Name:</label>
                          <input type="text" name="division_name" id="division_name" class="form-control mb-3" value="{{ old('division_name') }}" placeholder="Division Name">
                          <label for="division_acronym" class="form-label">Division Acronym:</label>
                          <input type="text" name="division_acronym" id="division_acronym" class="form-control" value="{{ old('division_acronym') }}" placeholder="Division Acronym">
                      </div>
                  </div>
                  </div>
                 
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="formSubmit"><i class="fas fa-save"></i> Submit</button>
                  </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection