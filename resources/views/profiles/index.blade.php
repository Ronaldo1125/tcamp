@extends('layouts.app')

@section('styles')
  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-3">
        <div class="col-sm-6">
          <h1 class="m-0">User Profile</h1>
        </div><!-- /.col -->
        
       
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

<div class="container">
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <section style="background-color: #eee;">
                    <div class="container py-2">
                        <div class="row">
                            <div class="col">
                                <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <img src="{{asset('/images')}}/{{$userprofile->picture}}" alt="avatar" class="rounded-circle bg-dark img-fluid" style="width: 150px;">

                                        <div class="row justify-content-center p-2">
                                            <a href="javascript:void(0)" id="upload_pic" class="text-lg text-bold" data-bs-toggle="modal" data-bs-target="#ProfilePicModal">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        </div>

                                        <h5 class="my-3 font-weight-bold">{{$userinfo->name}}</h5>
                                        <p class="text-sm mb-1">{{$userinfo->email}}</p>
                                        <div class="d-flex justify-content-center mb-2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        @if(is_null($userprofile->esignature))
                                        <div class="pb-3 text-danger small fst-italic fw-bold"><i class='fas fa-exclamation-triangle' style='font-size:1em;color:red'></i>
                                            <span class="pl-1">In order to proceed, it is necessary for you to upload your electronic signature image into the designated input box.</span>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Mobile Number</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{$userprofile->mobile_no}}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Address</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="text-muted mb-0">{{$userprofile->address}}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">eSignature</p>
                                            </div>
                                            <div class="col-sm-9">
                                                @if(!is_null($userprofile->esignature))
                                                <p class="text-muted mb-0"><img src="{{asset('/images')}}/{{$userprofile->esignature}}" alt="avatar" class="img-fluid" style="width: 150px;"></p>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#proInfoModal"><i class="fa fa-edit"></i> Edit Profile Info</a>
                                            </div>
                                            <div class="col-sm-9"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div> 

        <div class="col-md-10">
            <p class="small p-2 bg-light shadow-lg font-weight-bold font-italic rounded-3 text-justify">NEDA PRIVACY NOTICE: "All the personal information contained in this system shall be used solely for documentation and processing purposes within the NEDA and shall not be shared with any outside parties, unless with your written consent. Personal information shall be retained and stored by NEDA within a time period in accordance with the National Archives of the Philippines' General Disposition Schedule."</p>
        </div>
    </div>
</div>
@endsection 

@section('add_modal')

<!--Update Profile Pic Modal -->
<div class="modal fade" id="ProfilePicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-dark">
            <div class="modal-header bg-light">
                <h2 class="card-title">Update Profile Picture</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <img src="{{asset('/images')}}/{{$userprofile->picture}}" alt="avatar" class="rounded-circle bg-dark img-fluid" style="width: 150px;">
                        </div>
                        <div class="col-md-6">
                            <form id="avatar-form" enctype="multipart/form-data" action="{{route('profiles.updatePic')}}" method="POST">
                                @csrf
                                <div class="card-body text-center">
                                    <input type="hidden" name="user_id" value="{{ $userprofile->user_id }}">
                                    <div class="row pt-3 justify-content-center">
                                        <input id="avatar" type="file" name="avatar" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn-sm btn-primary">Save Picture</button>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('edit_modal')
<!--Update Profile Info Modal -->
<div class="modal fade" id="proInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-dark">
            <div class="modal-header bg-light">
                <h2 class="card-title">Update Profile Info</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="edit-form" enctype="multipart/form-data" action="{{route('profiles.updateInfo')}}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $userprofile->user_id }}">
                        <div class="row ">
                            <div class="col-sm-4 ">
                                <p class="mb-0">Mobile Number</p>
                            </div>
                            <div class="col-sm-8 pull-right">
                                <input type="text" class="form-control"  name="mobile_no" id="mobile_no" value="{{$userprofile->mobile_no}}">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">Address</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="address" id="address" value="{{$userprofile->address}}">
                            </div>
                        </div>
                        <hr>
                        
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0">eSignature</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="esignature" id="esignature">
                            </div>
                        </div>
                        
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="modal-footer text-end">
                                    <button type="button" class="btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn-sm btn-primary">Update Profile Info</button>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascripts')
<script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
<script>
</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\ProfileUpdateRequest', "#edit-form"); !!}
{{-- {!! JsValidator::formRequest('App\Http\Requests\TransportationStoreRequest', '#edit-form'); !!} --}}

@endsection