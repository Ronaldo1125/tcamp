@extends('layouts.app')

@section('styles')
  
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/select2/select2.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/dropzone.css')}}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h5 class="ml-5 fw-bold">Update Pre-Travel Order Application</h5>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Update Travel Order</h3>
          </div>
           <form action="{{ route('travel_orders.update', $travelOrder->id) }}" method="POST" id="add-form" enctype="multipart/form-data">    	
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
            <div class="card-body bg-light">
              <div class="row mx-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="p-3 bg-white text-dark shadow-sm rounded-3 border-top border-primary border-5">
                    <div class="form-group">
                      <div class="mb-3 row">
                        <div class="col-4">
                          <label for="purpose" class="form-label">Purpose:</label>
                          <textarea name="purpose" id="purpose" class="form-control" placeholder="Specify the purpose of the travel.">{{ $travelOrder->purpose }}</textarea>
                        </div>
                        <div class="col-2">
                          <label for="purpose_image_filename" class="form-label">Purpose Document:</label>
                          <div id="dropzone" class="dropzone-area p-5 text-center mb-4 position-relative">
                            <input type="file" name="purpose_image_filename" id="fileInput" class="form-control" onchange="updateFileName(this)" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">
                            
                            <div class="d-flex flex-column align-items-center gap-3">
                                <div class="upload-icon">
                                    <i class="fa fa-cloud-upload-alt text-muted fs-4"></i>
                                </div>
                                <p class="small fw-medium text-secondary mb-0">
                                    <span class="text-primary text-decoration-underline">Click to browse</span> or drag file here
                                </p>
                                <p class="xsmall text-muted mb-0" style="font-size: 0.75rem;">Maximum file payload size: 5MB</p>
                            </div>

                            <!-- Dynamic File Name Badge -->
                            <div id="fileBadge" class="d-none mt-3">
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 fw-medium text-wrap text-break">
                                    <i class="bi bi-file-earmark-check-fill me-1"></i>
                                    <span id="fileName">document.pdf</span>
                                </span>
                            </div>
                        </div>
                          {{-- <label for="purpose_image_image" class="form-label">Image:</label>
                          <input type="file" name="purpose_image_filename" class="form-control" value="{{ old('purpose_image_filename') }}"> --}}
                        </div>
        
                       <div class="col-2 mb-3">
                          <div class="row-3">
                            <label for="region_code" class="form-label">Region:</label>
                              <select class="form-control" name="region_code" id="region_code">
                                <option value="">-- Select Region --</option>
                                  @foreach ($regions as $key => $region)
                                  <option value="{{ $key }}" {{ ($travelOrder->region_code == $key ? "selected" : "") }}>{{ $region }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="row-3">
                            <label for="province_code" class="form-label mt-2">Province:</label>
                              <select class="form-control" name="province_code" id="province_code">
                                <option value="">-- Select Province --</option>
                            </select>
                          </div>
                          <div class="row-3">
                              <label for="city_code" class="form-label mt-2">City/Municipality:</label>
                              <select class="form-control" name="city_code" id="city_code">
                                <option value="">-- Select City/Municipality --</option>
                              </select>           
                          </div> 
                        </div>
                    
                        <div class="col-2">
                          <label for="travel_departure_date" class="form-label">Departure:</label>
                          <input type="date" name="travel_departure_date" id="travel_departure_date" class="form-control" value="{{ $travelOrder->travel_departure_date }}" oninput="replicateDate(this);">
                        </div>
                        <div class="col-2">
                          <label for="travel_arrival_date" class="form-label">Return:</label>
                          <input type="date" name="travel_arrival_date" value="{{ $travelOrder->travel_arrival_date }}" class="form-control">
                        </div> 
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-3">
                          <label for="flexRadioDefault1" class="form-label">Travel Related to Training?</label>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_travel_related_to_training" value="1" id="flexRadioDefault1" 
                                @if($travelOrder->is_travel_related_to_training == 1)
                                  checked="checked"
                                @endif
                                >
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Yes
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_travel_related_to_training" value="0" id="flexRadioDefault1" 
                                 @if($travelOrder->is_travel_related_to_training == 0)
                                  checked="checked"
                                @endif
                                > 
                                <label class="form-check-label" for="flexRadioDefault2">
                                  No
                                </label>
                              </div>
                        </div>
                        <div class="col-3">
                          <label for="fund_source_id" class="form-label">Fund Source:</label><br>
                                <select class="form-control" name="fund_source_id" id="fund_source_id">
                                  <option value="">-- Select Fund Source --</option>
                                    @foreach ($fund_sources as $key => $fund_source)
                                    <option value="{{ $key }}" {{ ($travelOrder->fund_source_id == $key) ? 'selected' : '' }}>
                                      {{ $fund_source }}
                                    </option>
                                    @endforeach
                                </select>
                        </div>

                        <div class="col-3">
                          <label for="pap_id" class="form-label">MFO/PAPs:</label>
                                <select class="form-control" name="pap_id" id="pap_id">            
                                  <option value="">-- Select MFO/PAPs --</option>
                                </select>
                                <br>
                                <input type="text" name="other_pap_name" class="form-control" id="other_pap_name" placeholder="MFO/PAPs Name"/>
                        </div>
                        
                        <div class="col-3">
                          <label for="flexRadioDefault1" class="form-label">Requesting for Cash Advance?</label>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_cash_advance" value="1" id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Yes
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_cash_advance" value="0" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault2">
                                  No
                                </label>
                              </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="row">
                        <div class="col-3">
                          <label for="immediate_supervisor_id" class="form-label">Immediate Supervisor:</label>
                              <select class="form-control" name="immediate_supervisor_id" id="immediate_supervisor_id">
                             @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ ($user->id == $travelOrder->immediate_supervisor_id) ? "selected" : "" }}>{{ $user->name }}</option>
                              @endforeach
                              </select>
                         
                        </div>
                        <div class="col-3">
                          <label for="management_id" class="form-label">Management:</label>
                                <select class="form-control" name="management_id" id="management_id">
                                  {{-- <option value="">-- Select Management --</option> --}}
                                 @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ ($user->id == $travelOrder->management_id ) ? "selected" : "" }}>{{ $user->name }}</option>
                              @endforeach

                              </select>
                        </div>

                         <div class="col-3">
                          <label for="budget_officer_id" class="form-label">Budget Officer:</label>
                                <select class="form-control" name="budget_officer_id" id="budget_officer_id">
                                   @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ ($user->id == $travelOrder->budget_officer_id ) ? "selected" : "" }}>{{ $user->name }}</option>
                              @endforeach

                              </select>
                        </div>                        
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row my-3 mr-4">
                      <div class="col-12 text-end">
                        <a href="javascript:(0)" class="btn btn-to-add btn-xs addRow shadow">
                           <i class="fa fa-plus"></i> <!-- Font Awesome Add Icon -->
                          <span>ADD</span>
                        </a>
                      </div>
                    </div>
                  </div>

                    <div class="form-group">
                      <div class="itineryMain" id="itinerary-form">
                        @php
                          $i = 0;
                        @endphp
                        @foreach($itineraries as $itinerary)
                        <div class="row mb-3 py-3 itineraryField bg-white text-dark shadow rounded-3 border-top border-secondary border-5">
                          <div class="col-2">
                            <label for="itinerary_date" class="form-label">Date:</label>
                            <input type="date" name="inputs[{{$i}}][itinerary_date]" id="itinerary_date" value="{{ $itinerary->itinerary_date }}" class="form-control">
                          </div>
        
                          <div class="col-2">
                            <div class="row-3">
                              <label for="estimated_time_of_departure" class="form-label">ETD:</label>
                              <input type="time" name="inputs[{{$i}}][estimated_time_of_departure]" value="{{ \Carbon\Carbon::parse($itinerary->estimated_time_of_departure)->format('H:i')}}" class="form-control">
                            </div>
                            <div class="row-3">
                              <label for="estimated_time_of_arrival" class="form-label">ETA:</label>
                              <input type="time" name="inputs[{{$i}}][estimated_time_of_arrival]" value="{{ \Carbon\Carbon::parse($itinerary->estimated_time_of_arrival)->format('H:i')}}" class="form-control">
                            </div>   
                          </div>
                          <div class="col-2">
                            <label for="transportation_id" class="form-label">Transportation:</label>
                            <select class="form-control" name="inputs[{{$i}}][transportation_id]" id="transportation_id">
                              <option value="">-- Transportation --</option>
                                @foreach ($transportations as $key => $transportation)
                                <option value="{{ $key }}" {{ $itinerary->transportation_id == $key ? "selected" : "" }}>{{ $transportation }}</option>
                                @endforeach
                            </select>
                            <label for="fare" class="form-label">Fare:</label>
                            <input type="number" name="inputs[{{$i}}][transportation_price]" id="fare" value="{{ $itinerary->transportation_price }}" class="form-control text-end itinerary-fare-input" placeholder="PhP" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();">
                          </div>
        
                          <div class="col-1 text-center">
                            <label for="with_lodging" class="form-label">Lodging:</label>
                            <div class="form-check">
                              <input type="checkbox" name="inputs[{{$i}}][with_lodging]" value="with_lodging" id="with_lodging" {{ $itinerary->with_lodging ? "checked" : "" }} class="itinerary-checkbox">
                            </div>
                          </div>
        
                          <div class="col-1 text-center">
                            <label for="with_breakfast" class="form-label">Meals:</label>
                            <div class="form-check">
                              <input type="checkbox" name="inputs[{{$i}}][with_breakfast]" value="with_breakfast" id="with_breakfast" {{ $itinerary->with_breakfast ? "checked" : "" }} data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Breakfast" class="itinerary-checkbox">&nbsp;
                              <input type="checkbox" name="inputs[{{$i}}][with_lunch]" value="with_lunch" id="with_lunch" {{ $itinerary->with_lunch ? "checked" : "" }} data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lunch" class="itinerary-checkbox">&nbsp;
                              <input type="checkbox" name="inputs[{{$i}}][with_snack]" value="with_snack" id="with_snack" {{ $itinerary->with_snack ? "checked" : "" }} data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PM Snack" class="itinerary-checkbox">
                            </div>
                          </div>
        
                          <div class="col-1 text-center">
                            <label for="with_incidental_expenses" class="form-label">Inc. Expenses:</label>
                             <div class="form-check">
                                <input type="checkbox" name="inputs[{{$i}}][with_incidental_expenses]" value="with_incidental_expenses" id="with_incidental_expenses" {{ $itinerary->with_incidental_expenses ? "checked" : "" }} class="itinerary-checkbox">
                             </div>
                          </div>
        
                          <div class="col-2">
                            <label for="total" class="form-label">Total:</label>
                            <input type="number" name="inputs[{{$i}}][total]" id="total" value="{{number_format($itinerary->total, 2, '.', '')}}" class="form-control text-end fw-semibold bg-dark-subtle" readonly>
                          </div>
                        </div>
                        @php
                          $i++;
                        @endphp
                        @endforeach
                      </div>
                    </div>
                  
        
                <div class="my-3 row align-items-end">
                  <div class="col-8"></div>
                  <div class="col-2 text-end">
                    <label for="grand_total" class="form-label">Grand Total:</label>
                  </div>
                  <div class="col-2">
                    <input type="number" name="grand_total" id="grand_total" class="form-control text-end bg-yellow fw-bold text-white" readonly value="{{ number_format($travelOrder->grand_total, 2, '.', '') }}">
                  </div>
                </div>
        
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 text-center py-3">
                <button type="submit" class="btn btn-to-submit custom-blue-btn">
                  <span>Update Request</span>
                  <i class="fa fa-paper-plane"></i>
                </button>
              </div>
          </div>   
        </form>
          <input type="hidden" name="sfund_source_id" id="sfund_source_id" value="{{ $travelOrder->fund_source_id }}" />
          <input type="hidden" name="spap_id" id="spap_id" value="{{ $travelOrder->pap_id }}" />
          <input type="hidden" name="sregion_code" id="sregion_code" value="{{ $travelOrder->region_code }}" />
          <input type="hidden" name="sprovince_code" id="sprovince_code" value="{{ $travelOrder->province_code }}" />
          <input type="hidden" name="scity_code" id="scity_code" value="{{ $travelOrder->city_code }}" />

      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

    @endsection

    @section('add_modal')
    @endsection
  
    @section('edit_modal')
    @endsection
  
  
    @section('javascripts')
  <script type="text/javascript" charset="utf8" src="{{ url('/dist/js/datatables/jquery.dataTables.min.js') }}"></script>
  <script type="text/javascript" charset="utf8" src="{{ url('/dist/js/select2/select2.full.min.js') }}"></script>
  <script type="text/javascript" charset="utf8" src="{{ url('/dist/js/easy-number-separator.js') }}"></script>
  <script type="text/javascript" charset="utf8" src="{{ url('/dist/js/dropzone.js') }}"></script>

  <script>
    $(document).ready(function() {
      new DataTable('#listTravelOrderTable');
      $('.select2').select2();

      $('.select2bs4').select2();

      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

      // Fund Source dynamic dropdown
      let pap = $("#pap_id");
      let otherPapName = $("#other_pap_name");
      pap.attr('disabled','disabled');
      otherPapName.hide();

      const sfundSource = $("#sfund_source_id").val();
      const spap = $("#spap_id").val();
      if(sfundSource !== '') {
        $.ajax({
          url: "{{ route('paps.getPaps') }}",
          data: {
            fund_source_id: sfundSource
          },
          success: function (data) {
            if(data.length == 0) {
              otherPapName.show();
              pap.hide();
            } else {
              pap.html('<option value="">-- Select MFO/PAPs --</option>');
              $.each(data, function(id,value){
                pap.append('<option value="' + value.id + '">' + value.pap_name + '</option>');
              })
              pap.removeAttr('disabled');
              pap.show();
              if(spap !== '') {
                pap.val(spap);
              }
            }
            //console.log(data);
          }
        })
      } 

      $(document).on('change', '#fund_source_id', function(){
        let fundSource = $('#fund_source_id').val();

        if(fundSource !== '') {
         $.ajax({
            url: "{{ route('paps.getPaps') }}",
            data: { fund_source_id: fundSource},
            beforeSend: function() {
              pap.html('<option value="">Loading...</option>').attr('disabled','disabled');
            },

            success: function (data) {
              if(data.length == 0) {
                pap.hide().removeAttr('required');
                $('#pap_id-error').hide();
                    
                otherPapName.show().attr('required', 'required');
              } else {
                otherPapName.hide().removeAttr('required').val(''); // Clear old input value
                $('#other_pap_name-error').hide();

                let options = '<option value="">-- Select MFO/PAPs --</option>';
                $.each(data, function(index, value) {
                    options += `<option value="${value.id}">${value.pap_name}</option>`;
                });
                
                pap.html(options).removeAttr('disabled').show().attr('required', 'required');
              }
            },
            error: function() {
                console.error("Failed to fetch PAPs.");
            }
          });
        } else {
         pap.html('<option value="">-- Select MFO/PAPs --</option>')
           .attr('disabled', 'disabled')
           .removeAttr('required')
           .show();
           
        otherPapName.hide().removeAttr('required').val('');
        }
      })

  
  let itineraries = @json($itineraries);

  //console.log(itineraries);
  var i = itineraries.length - 1;
  console.log(i);
  $(".addRow").click(function(){
    i++;
    $("#itinerary-form").append(
      `<div class="row mb-3 py-3 itineraryField bg-white text-dark shadow rounded-3 border-top border-secondary border-5">
              <div class="col-2">
                <label for="itinerary_date" class="form-label">Date:</label>
                <input type="date" name="inputs[${i}][itinerary_date]" id="itinerary_date" class="form-control">
              </div>
              <div class="col-2">
                <div class="row-3">
                  <label for="estimated_time_of_departure" class="form-label">ETD:</label>
                  <input type="time" name="inputs[${i}][estimated_time_of_departure]" class="form-control">
                </div>
                <div class="row-3">
                  <label for="estimated_time_of_arrival" class="form-label">ETA:</label>
                  <input type="time" name="inputs[${i}][estimated_time_of_arrival]" class="form-control">   
                </div>
              </div>
              <div class="col-2">
                <label for="transportation_id" class="form-label">Transportation:</label>
                <select class="form-control" name="inputs[${i}][transportation_id]" id="transportation_id">
                  <option value=''>-- Transportation --</option>
                    @foreach ($transportations as $key => $transportation)
                    <option value='{{ $key }}'>{{ $transportation }}</option>
                    @endforeach
                </select>
                <label for="fare" class="form-label">Fare:</label>
                <input type="number" name='inputs[${i}][transportation_price]' id="fare" class="form-control text-end itinerary-fare-input" placeholder="PhP" onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();">
              </div>

              <div class="col-1 text-center">
                <label for="with_lodging" class="form-label">Lodging:</label>
                <div class="form-check">
                  <input type="checkbox" name="inputs[${i}][with_lodging]" value="with_lodging" id="with_lodging" class="itinerary-checkbox">
                </div>
              </div>

              <div class="col-1 text-center">
                <label for="with_breakfast" class="form-label">Meals:</label>
                <div class="form-check">
                  <input type="checkbox" name="inputs[${i}][with_breakfast]" value="with_breakfast" id="with_breakfast" title="Breakfast" class="itinerary-checkbox">&nbsp;
                  <input type="checkbox" name="inputs[${i}][with_lunch]" value="with_lunch" id="with_lunch" title="Lunch" class="itinerary-checkbox">&nbsp;
                  <input type="checkbox" name="inputs[${i}][with_snack]" value="with_snack" id="with_snack" title="PM Snack" class="itinerary-checkbox">
                </div>
              </div>

              <div class="col-1 text-center">
                <label for="with_incidental_expenses" class="form-label">Inc. Expenses:</label>
                  <div class="form-check">
                    <input type="checkbox" name="inputs[${i}][with_incidental_expenses]" value="with_incidental_expenses" id="with_incidental_expenses" class="itinerary-checkbox">
                  </div>
              </div>

              <div class="col-2">
                <label for="total" class="form-label">Total:</label>
                <input type="number" name="inputs[${i}][total]" id="total" class="form-control text-end fw-semibold bg-dark-subtle" readonly>
              </div>
              <div class="col text-center">
                <a href="javascript:(0)" class="btn btn-danger btn-sm mt-4 deleteRow shadow rounded-3">
                  <i class="fa fa-trash-alt"></i> <!-- Font Awesome Delete Icon -->
                      <span>Delete</span>
                  </a>
              </div>
            </div>`);

            // if(i > 0) {
            //   let withLodging = $("[name='inputs["+i+"][with_lodging]']");
            //   withLodging.attr({disabled:"disabled"});
            //   console.log(i)
              
            // }
    });

    $(document).on('click', '.deleteRow', function(){
      $(this).parents('.itineraryField').remove();
      i--;
      calcTotal();
    });

  });

  
  function replicateDate() {
    let departDate = $("#travel_departure_date").val();
    let  itineraryDate = $("[name='inputs[0][itinerary_date]']");

    itineraryDate.val(departDate);  
  }

  // Logic on the Location On Change
  const region_code   = $("#region_code");
  const province_code = $("#province_code");
  const city_code     = $("#city_code");

  // On Load Disable province and ci
  $(province_code).attr({disabled:"disabled"});
  $(city_code).attr({disabled:"disabled"});

  // On Change of Region
  $(region_code).on('change', function() {
    $(city_code).html('<option value="">-- Select City/Municipality --</option>');
    if(this.value !== '') {
      $(province_code).removeAttr('disabled');
      $(city_code).attr({disabled:"disabled"});
      getProvinces(province_code, this.value, false);
    } else {
      $(province_code).html('<option value="">-- Select Province --</option>');
      $(province_code).attr({disabled:"disabled"});
      $(city_code).attr({disabled:"disabled"});   
    } 
  });

  $(province_code).on('change', function() {
      if(this.value !== '') {  
        $(city_code).removeAttr('disabled');
        getCities(city_code, this.value, false);
      } else {
        $(city_code).html('<option value="">-- Select City/Municipality --</option>');
        $(city_code).attr({disabled:"disabled"});
      } 
  });


  const getProvinces = (province_code, region_code, preselect) => {
    $.ajax({
      url: "{{ route('location.provinces') }}",
      data: {
        region_code: region_code
      },
      beforeSend: function() {
        province_code.html('<option value="">Loading...</option>').attr('disabled','disabled');
      },
      success: function (data) {
        let options = '<option value="">-- Select Province --</option>';

        $.each(data, function (id, value){
          options += '<option value="' + value.province_code + '"';
            if(value.province_code == sprovince_code.val() && preselect == true) {
              options += ' selected="selected"';
            }  
          options += '>' + value.name + '</option>';
        });
        province_code.html(options).removeAttr('disabled');
        // console.log(data);
      },
      error: function() {
        console.error("Failed to fetch provinces.");
      }
    })
  }

  const getCities = (city_code, province_code, preselect) => {
    $.ajax({
      url: "{{ route('location.cities') }}",
      data: {
        province_code: province_code
      },
      beforeSend: function() {
        city_code.html('<option value="">Loading...</option>').attr('disabled','disabled');
      },
      success: function (data) {
        let options = '<option value="">-- Select City/Municipality --</option>';
        
        $.each(data, function (id, value){
          options += '<option value="' + value.city_code + '"';
          if(value.city_code == $(scity_code).val() && preselect == true) {
            options += ' selected="selected"';
          }
          options += '>' + value.name + '</option>';
        });
        city_code.html(options).removeAttr('disabled');
      }, 
      error: function() {
        console.error("Failed to fetch cities.");
      }
    });
  }

  // Preselected on Load
  const sregion_code = $("#sregion_code")
  const sprovince_code = $("#sprovince_code");
  const scity_code = $("#scity_code");
  

  if(sregion_code.val() !== "") {
    $(province_code).removeAttr("disabled");
    getProvinces(province_code, sregion_code.val(), true);
  }

  if(sprovince_code !== "") {
    $(city_code).removeAttr("disabled");
    getCities(city_code, sprovince_code.val(), true)
  }
     

    // Cache global selectors
  const $regionCode = $("#region_code");
  const $grandTotal = $("[name='grand_total']");

  // Centralized state to cache cost data and prevent redundant API calls
  let cachedCosts = null;

  async function getAdditionalCost() {
      if (cachedCosts) return cachedCosts;

      return new Promise(function(resolve, reject) {
          $.ajax({
              url: "{{ route('location.regions') }}",
              data: { region_code: $regionCode.val() },
              success: function (data) {
                  cachedCosts = data; // Cache the response
                  resolve(data);
              },
              error: function (xhr, status, error) {
                  reject(error);
              }
          });
      });
  }

  // Invalidate cache when region changes so the next action fetches fresh data
  // $regionCode.on('change', async function() {
  //     cachedCosts = null;

  //     // Capture all fields first so we can determine their true sequential index
  //     let $fields = $(".itineraryField");

  //     $fields.each(function(index) {
  //         // 'index' is automatically passed by jQuery's each() starting from 0
  //         updateItinerary(index);
  //     });
  // });
  $regionCode.on('change', async function() {
      cachedCosts = null;

      // Loop through every row on the page and force an update
      $(".itineraryField").each(function() {
          let index = $(this).index();
          if (index !== -1) {
              updateItinerary(index);
          }
      });

  });

function getPerItineraryTotal(index, costs) {
    const costData = (costs && costs.length > 0) ? costs[0] : {};
    
    // Helper to get cost if checkbox is checked
    const getCheckedCost = (suffix, costValue) => {
        return $("[name='inputs[" + index + "][with_" + suffix + "]']").is(':checked') ? (costValue || 0) : 0;
    };

    let lodging_price = getCheckedCost('lodging', costData.lodging_cost);
    let breakfast_price = getCheckedCost('breakfast', costData.meals_cost);
    let lunch_price = getCheckedCost('lunch', costData.meals_cost);
    let snack_price = getCheckedCost('snack', costData.meals_cost);
    let incidental_expense_price = getCheckedCost('incidental_expenses', costData.incidental_expenses_cost);
    
    let fare = parseFloat($("[name='inputs[" + index + "][transportation_price]']").val()) || 0;

    let sub_total = fare + lodging_price + breakfast_price + lunch_price + snack_price + incidental_expense_price;
    let total = (Math.round(sub_total * 100) / 100).toFixed(2);
    
    $("[name='inputs[" + index + "][total]']").val(total);
}

function calcTotal() {
    let totals = 0;
    $(".itineraryField").each(function(index) {
        let total = parseFloat($("[name='inputs[" + index + "][total]']").val()) || 0;
        totals += total;
    });
    
    let grand_total = (Math.round(totals * 100) / 100).toFixed(2);
    $grandTotal.val(grand_total);
}

// Unified orchestrator function for all itinerary updates
async function updateItinerary(index) {
  try {
      let costs = await getAdditionalCost();
      getPerItineraryTotal(index, costs);
      calcTotal();
  } catch (error) {
      console.error("Error updating itinerary costs:", error);
  }
}

// Public wrapper for your dropdown/region change event
async function getRegionCost(v) {
    await updateItinerary(v);
}

// Modern jQuery Event Delegation
// Replace your inline HTML attributes (e.g., onclick="addBreakfast(this)") with class names on the inputs
$(document).ready(function() {

  // 1. For text inputs (fare): Listen to 'input' event so it calculates live as you type
    $(document).on('input', '.itinerary-fare-input', function() {
        // Find the index based on closest itinerary container
        let index = $(this).closest('.itineraryField').index();
        if (index !== -1) {
            updateItinerary(index);
        }
    });

    // 2. For checkboxes: Keep listening to 'change' event
    $(document).on('change', '.itinerary-checkbox', function() {
        let index = $(this).closest('.itineraryField').index();
        if (index !== -1) {
            updateItinerary(index);
        }
    });
});


</script>
@endsection

@section('jsvalidator')

{!! JsValidator::formRequest('App\Http\Requests\TravelOrderUpdateRequest'); !!}
{{-- {!! JsValidator::formRequest('App\Http\Requests\UserStoreRequest', '#edit-form'); !!} --}}

@endsection    