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
          <h1 class="m-0">Create Travel Order</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
      <div class="row mb-2">
        {{-- @can('quarter-create') --}}
        {{-- <div class="col-11 text-end">
          <a class="btn btn-success btn-sm" href="{{ route('roles.create') }}" data-bs-toggle="modal" data-bs-target="#createRoleModal"><i class="fas fa-plus"></i> Create New Role</a>
        </div> --}}
        {{-- @endcan --}}
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

    
<div class="row m-2">
    <form action="{{ route('students.store') }}" method="POST" id="add-form" class="check-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="created_by_id" value="{{ Auth::user()->id}}"/>
    <div class="row mx-5">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">

              @if($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                      
                    @endforeach
                  </ul>
                </div>
                @endif

                @if(Session::has('success'))
                <div class="alert alert-success text-center">
                  <p>
                    {{ Session::get('success') }}
                  </p>
                </div>
                @endif

              <table class="table table-bordered" id="table">
                <tr>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
                <tr>
                  <td><input type="text" name="inputs[0][name]" placeholder="Enter your name" class="form-control"></td>
                  <td><button type="button" name="add" id="add" class="btn btn-success">Add More +</button></td>
                </tr>
              </table>
            </div>
        </div>
      </div>
        <div class="mt-4 text-center">  
          <button type="button" class="btn btn-secondary" onclick = "window.location.href='{{ route('home') }}';">Close</button>
          <button type="submit" class="btn btn-primary" id="formSubmit">Submit</button>
        </div>
    </div>
</form>
</div>
@endsection

@section('add_modal')

<!-- Modal -->

@endsection


@section('javascripts')
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">
 

   var i = 0;
   $('#add').click(function(){
      i++;
      $('#table').append(
        `<tr>
          <td>
            <input type="text" name="inputs[`+i+`][name]" placeholder="Enter your name" class="form-control"/>
            </td>
            <td>
              <button type="button" class="btn btn-danger remove-table-row">Remove</button>
              </td>       
          </tr>`);
          
  });

  $(document).on('click','.remove-table-row', function(){
    $(this).parents('tr').remove();
  });

  

    


</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\StudentStoreRequest'); !!}

@endsection


