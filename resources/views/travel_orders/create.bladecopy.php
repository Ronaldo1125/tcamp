@extends('layouts.app')

@section('styles')
  
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/select2/select2.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/smart_wizard_all.min.css')}}">
@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="m-0">Pre Travel Order Application</h1>
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
            <h3 class="card-title">Create Pre Travel Order</h3>
          </div>
            <form action="{{ route('travel_orders.store') }}" method="POST" id="add-form" enctype="multipart/form-data">    	
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
            <div class="card-body">
              <div class="row mx-5">
                <div class="col-xs-12 col-sm-12 col-md-12">

                  <!-- SmartWizard html -->
                  <div id="smartwizard">
                    <ul class="nav nav-progress">
                        <li class="nav-item">
                          <a class="nav-link" href="#step-1">
                            <div class="num">1</div>
                            Travel Order Details
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#step-2">
                            <span class="num">2</span>
                            Itinerary Details
                          </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                      <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                          <h3>Step 1 Content</h3>
                          <div class="form-group">
                            <div class="mb-3 row">
                              <div class="col-4">
                                <label for="purpose" class="form-label">Purpose:</label>
                                <textarea name="purpose" id="purpose" class="form-control" placeholder="Specify the purpose of the travel."></textarea>
                              </div>
                              <div class="col-2">
                                <label for="purpose_image_image" class="form-label">Image:</label>
                                <input type="file" name="purpose_image_filename" class="form-control" value="{{ old('purpose_image_filename') }}">
                              </div>
                
                              <div class="col-2">
                                <label for="destination" class="form-label">Destination:</label>
                                <input type="text" name="destination" id="destination" class="form-control" value="{{ old('destination') }}">
                              </div>
                          
                              <div class="col-2">
                                <label for="travel_departure_date" class="form-label">Departure:</label>
                                <input type="date" name="travel_departure_date" id="travel_departure_date" class="form-control" value="{{ old('travel_departure_date') }}" oninput="replicateDate(this);">
                              </div>
                              <div class="col-2">
                                <label for="travel_arrival_date" class="form-label">Return:</label>
                                <input type="date" name="travel_arrival_date" value="{{ old('travel_arrival_date') }}" class="form-control">
                              </div> 
                            </div>
                          </div>
                
                          <div class="form-group">
                            <div class="row">
                              <div class="col-3">
                                    <label for="fund_sources" class="form-label">Fund Source:</label>
                                      <select class="form-control select2" name="fund_sources[]" id="fund_sources" multiple>
                                          @foreach ($fund_sources as $key => $fund_source)
                                          <option value="{{ $key }}">{{ $fund_source }}</option>
                                          @endforeach
                                      </select>
                              </div>
                
                              <div class="col-3">
                                <label for="pap_id" class="form-label">MFO/PAPs:</label>
                                      <select class="form-control" name="pap_id" id="pap_id">
                                        <option value="">-- Select MFO/PAPs --</option>
                                          @foreach ($paps as $key => $pap)
                                          <option value="{{ $key }}">{{ $pap }}</option>
                                          @endforeach      
                                      </select>
                              </div>
                              <div class="col-3">
                                <label for="flexRadioDefault1" class="form-label">Travel Related to Training?</label>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="is_travel_related_to_training" value="1" id="flexRadioDefault1" checked>
                                      <label class="form-check-label" for="flexRadioDefault1">
                                        Yes
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="is_travel_related_to_training" value="0" id="flexRadioDefault1">
                                      <label class="form-check-label" for="flexRadioDefault2">
                                        No
                                      </label>
                                    </div>
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
                      </div>
                      <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                        <h3>Step 2 Content</h3>
                            <div class="form-group">
                                      <div class="row my-3 mr-4">
                                        <div class="col-12 text-end">
                                          <a href="javascript:(0)" class="btn btn-success btn-sm addRow">+</a>
                                        </div>
                                      </div>
                                    </div>
                
                                    <div class="form-group">
                                      <div class="itineryMain" id="itinerary-form">
                                        <div class="mb-3 row itineraryField bg-danger-outline" id="itinerary_field">
                                          <div class="col-2">
                                            <label for="itinerary_date" class="form-label">Date:</label>
                                            <input type="date" name="inputs[0][itinerary_date]" id="itinerary_date" value="{{ old('inputs[0][itinerary_date]') }}" class="form-control">
                                          </div>
                                          <div class="col-2 mb-3">
                                              <label for="region_code" class="form-label">Region:</label>
                                              <select class="form-control" name="inputs[0][region_code]" id="region_code" onchange="getProvinces(this); getRegionCost(this);">
                                                <option value="">-- Select Region --</option>
                                                  @foreach ($regions as $key => $region)
                                                  <option value="{{ $key }}" {{ (old("inputs[0][region_code]") == $key ? "selected":"") }}>{{ $region }}</option>
                                                  @endforeach
                                              </select>
                                            <label for="province_code" class="form-label">Province:</label>
                                            <select class="form-control" name="inputs[0][province_code]" id="province_code0" onchange="getCities(this);" disabled>
                                              <option value="">-- Select Province --</option>
                                              
                                            </select>
                                            
                                            <label for="city_code" class="form-label">City/Municipality:</label>
                                            <select class="form-control" name="inputs[0][city_code]" id="city_code0" disabled>
                                              <option value="">-- Select City --</option>
                                              
                                            </select>
                                        
                                          </div>
                        
                                          <div class="col-2">
                                            <div class="row-3">
                                              <label for="estimated_time_of_departure" class="form-label">ETD:</label>
                                              <select name="inputs[0][estimated_time_of_departure]" class="form-control">
                                                <option value="">-- Select ETD --</option>
                                                @foreach($times as $time)
                                                  <option value="{{ $time }}" {{ (old("inputs[0][estimated_time_of_departure]") == $time ? "selected":"") }}>{{ $time }}</option>
                                                @endforeach 
                                              </select>
                                            </div>
                                            <div class="row-3">
                                              <label for="estimated_time_of_arrival" class="form-label">ETA:</label>
                                              <select name="inputs[0][estimated_time_of_arrival]" class="form-control">
                                                <option value="">-- Select ETA --</option>
                                                @foreach($times as $time)
                                                  <option value="{{ $time }}" {{ (old("inputs[0][estimated_time_of_arrival]") == $time ? "selected":"") }}>{{ $time }}</option>
                                                @endforeach 
                                              </select>
                                            </div>   
                                          </div>
                                          <div class="col-1">
                                            <label for="transportation_id" class="form-label">Transport:</label>
                                            <select class="form-control" name="inputs[0][transportation_id]" id="transportation_id">
                                              <option value="">-- Transpo --</option>
                                                @foreach ($transportations as $key => $transportation)
                                                <option value="{{ $key }}" {{ (old("inputs[0][transportation_id]") == $key ? "selected":"") }}>{{ $transportation }}</option>
                                                @endforeach
                                            </select>
                                            <label for="fare" class="form-label">Fare:</label>
                                            <input type="number" name="inputs[0][transportation_price]" id="fare" value="{{ old('inputs[0][transportation_price]') }}" class="form-control text-end" placeholder="PhP" oninput="addTransportPrice(this);">
                                          </div>
                        
                                          <div class="col-1 text-center">
                                            <label for="with_lodging" class="form-label">Lodging:</label>
                                            <div class="form-check">
                                              <input type="checkbox" name="inputs[0][with_lodging]" value="with_lodging" id="with_lodging" onclick="addLodging(this);">
                                            </div>
                                          </div>
                        
                                          <div class="col-1 text-center">
                                            <label for="with_breakfast" class="form-label">Meals:</label>
                                            <div class="form-check">
                                              <input type="checkbox" name="inputs[0][with_breakfast]" value="with_breakfast" id="with_breakfast" onclick="addBreakfast(this);"/>&nbsp;
                                              <input type="checkbox" name="inputs[0][with_lunch]" value="with_lunch" id="with_lunch" onclick="addLunch(this);">&nbsp;
                                              <input type="checkbox" name="inputs[0][with_snack]" value="with_snack" id="with_snack" onclick="addSnack(this);">
                                            </div>
                                          </div>
                        
                                          <div class="col-1 text-center">
                                            <label for="with_incidental_expenses" class="form-label">Inc. Expenses:</label>
                                            <input type="checkbox" name="inputs[0][with_incidental_expenses]" value="with_incidental_expenses" id="with_incidental_expenses" onclick="addIncidentalExpenses(this);">
                                          </div>
                        
                                          <div class="col-1">
                                            <label for="total" class="form-label">Total:</label>
                                            <input type="number" name="inputs[0][total]" id="total" class="form-control text-end fw-semibold bg-dark-subtle" readonly>
                                          </div>
                                        </div>
                                      </div>
                        
                                    </div>
                                </div>
                        
                                <div class="my-3 row align-items-end">
                                  <div class="col-9"></div>
                                  <div class="col-1">
                                    <label for="grand_total" class="form-label">Grand Total:</label>
                                  </div>
                                  <div class="col-2">
                                    <input type="numbers" name="grand_total" id="grand_total" class="form-control text-end bg-gradient-green fw-bold text-white" readonly>
                                  </div>
                                </div>
                        
                              </div>
                              {{-- <div class="col-xs-12 col-sm-12 col-md-12 text-center py-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                              </div> --}}
                   
                
                    {{-- <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> --}}
                </div>



          </div>   
        </form>
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
  <script type="text/javascript" src="{{ url('/dist/js/jquery.smartWizard.min.js') }}" ></script>

  <script>
    $(document).ready(function() {
      new DataTable('#listTravelOrderTable');
      $('.select2').select2();

      $('.select2bs4').select2();

      $(function () {
        $('[data-toggle="tooltip"]').tooltip();
      });

  var i = 0;
  $(".addRow").click(function(){
    i++;
    $("#itinerary-form").append(
      `<div class="mb-3 row itineraryField" id="itinerary-field">
              <div class="col-2">
                <label for="itinerary_date" class="form-label">Date:</label>
                <input type="date" name="inputs[`+i+`][itinerary_date]" id="itinerary_date" class="form-control">
              </div>
              <div class="col-2">
                    <label for="region_code" class="form-label">Region:</label>
                    <select class="form-control" name="inputs[`+i+`][region_code]" id="region_code" onchange="getProvinces(this); getRegionCost(this);">
                      <option value="">-- Select Region --</option>
                        @foreach ($regions as $key => $region)
                        <option value="{{ $key }}">{{ $region }}</option>
                        @endforeach
                    </select>
                    <label for="province_code" class="form-label">Province:</label>
                    <select class="form-control" name="inputs[`+i+`][province_code]" id="province_code`+i+`" onchange="getCities(this);" disabled>
                      <option value="">-- Select Province --</option>
                      
                    </select>
                    <label for="city_code" class="form-label">City/Municipality:</label>
                    <select class="form-control" name="inputs[`+i+`][city_code]" id="city_code`+i+`" disabled>
                      <option value="">-- Select City --</option>
                    </select>
                  </div>
              <div class="col-2">
                <div class="row-3">
                  <label for="estimated_time_of_departure" class="form-label">ETD:</label>
                  <select name="inputs[`+i+`][estimated_time_of_departure]" class="form-control">
                        <option value="">-- Select ETD --</option>
                        @foreach($times as $time)
                          <option @selected(old('inputs[`+i+`][estimated_time_of_departure]') == $time)>{{ $time }}</option>
                        @endforeach 
                  </select>
                </div>
                <div class="row-3">
                <label for="estimated_time_of_arrival" class="form-label">ETA:</label>
                <select name="inputs[`+i+`][estimated_time_of_arrival]" class="form-control">
                        <option value="">-- Select ETA --</option>
                        @foreach($times as $time)
                          <option @selected(old('inputs[`+i+`][estimated_time_of_arrival]') == $time)>{{ $time }}</option>
                        @endforeach 
                      </select>
                </div>
              </div>
              <div class="col-1">
                <label for="transportation_id" class="form-label">Transport:</label>
                <select class="form-control" name='inputs[`+i+`][transportation_id]' id="transportation_id">
                  <option value=''>-- Transpo --</option>
                    @foreach ($transportations as $key => $transportation)
                    <option value='{{ $key }}'>{{ $transportation }}</option>
                    @endforeach
                </select>
                <label for="fare" class="form-label">Fare:</label>
                <input type="number" name='inputs[`+i+`][transportation_price]' id="fare" class="form-control text-end" placeholder="PhP" oninput="addTransportPrice(this);">
              </div>

              <div class="col-1 text-center">
                <label for="with_lodging" class="form-label">Lodging:</label>
                <div class="form-check">
                  <input type="checkbox" name='inputs[`+i+`][with_lodging]' value="with_lodging" id="with_lodging" onclick="addLodging(this);">
                </div>
              </div>

              <div class="col-1 text-center">
                <label for="with_breakfast" class="form-label">Meals:</label>
                <div class="form-check">
                  <input type="checkbox" name='inputs[`+i+`][with_breakfast]' value="with_breakfast" id="with_breakfast" onclick="addBreakfast(this);">&nbsp;
                  <input type="checkbox" name='inputs[`+i+`][with_lunch]' value="with_lunch" id="with_lunch" onclick="addLunch(this);">&nbsp;
                  <input type="checkbox" name='inputs[`+i+`][with_snack]' value="with_snack" id="with_snack" onclick="addSnack(this);">
                </div>
              </div>

              <div class="col-1 text-center">
                <label for="with_incidental_expenses" class="form-label">Inc. Expenses:</label>
                <input type="checkbox" name='inputs[`+i+`][with_incidental_expenses]' value="with_incidental_expenses" id="with_incidental_expenses" onclick="addIncidentalExpenses(this);">
              </div>

              <div class='col'>
                <label for="total" class="form-label">Total:</label>
                <input type="number" name='inputs[`+i+`][total]' id="total" class="form-control text-end fw-semibold bg-dark-subtle" readonly>
              </div>
              <div class="col text-center">
                <a href="javascript:(0)" class="btn btn-danger btn-sm mt-4 deleteRow">-</a>
              </div>
            </div>`);

            // if(i > 0) {
            //   let withLodging = $("[name='inputs["+i+"][with_lodging]']");
            //   withLodging.attr({disabled:"disabled"});
            //   console.log(i)
              
            // }
    });

    $(document).on('click', '.deleteRow', function(){
      $(this).parents('#itinerary-field').remove();
      i--;
      calcTotal();
    });

  });

  function replicateDate() {
      let departDate = $("#travel_departure_date").val();
      let  itineraryDate = $("[name='inputs[0][itinerary_date]']");

      itineraryDate.val(departDate);  
    }

    function getProvinces(v) {
      var index = $(v).parent().parent().index();
      //console.log(index);
      var province_id = $("#province_code" + index);
      var region_code =  $("[name='inputs[" + index + "][region_code]']").val();

      $.ajax({
        url: "{{ route('location.provinces') }}",
        data: {
          region_code: region_code
        },
        success: function (data) {
          province_id.html('<option value="">-- Select Province --</option>');
          $.each(data, function (id, value){
            province_id.append('<option value="' + value.province_code + '">' + value.name + '</option>')
          });
          province_id.removeAttr('disabled');
         // console.log(data);
        }
      })
      // $.getJSON("/location/provinces",{'region_code': region_code, ajax: 'true'}, function(j){

			// 	console.log(j);
			// });		
    }

    function getCities(v) {
      var index = $(v).parent().parent().index();
      var city_id = $("#city_code" + index);
      var province_code =  $("[name='inputs[" + index + "][province_code]']").val();

      $.ajax({
        url: "{{ route('location.cities') }}",
        data: {
          province_code: province_code
        },
        success: function (data) {
          city_id.html('<option value="">-- Select City --</option>');
         
          $.each(data, function (id, value){
            city_id.append('<option value="' + value.city_code + '">' + value.name + '</option>')
          });
          city_id.removeAttr('disabled');
        }
      })
      // $.getJSON("/location/provinces",{'region_code': region_code, ajax: 'true'}, function(j){

			// 	console.log(j);
			// });		
    }


    async function getAdditionalCost(index) {
      return new Promise(function(resolve,reject){
        let region_code =  $("[name='inputs[" + index + "][region_code]']").val();

        $.ajax({
          url: "{{ route('location.regions') }}",
          data: {
            region_code: region_code
          },
          success: function (data) {
            resolve(data);   
          }
        });

      }); 
    }

    function getPerItineraryTotal(index, costs) {

      let lodging_price = 0;
      let breakfast_price = 0;
      let lunch_price = 0;
      let snack_price = 0;
      let incidental_expense_price = 0;
      let sub_total = 0;
      let fare = $("[name='inputs[" + index + "][transportation_price]']").val();

      if($("[name='inputs[" + index + "][with_lodging]']").is(':checked')) {
        if(costs.length != 0) lodging_price = costs[0]["lodging_cost"];
      }

      if($("[name='inputs[" + index + "][with_breakfast]']").is(':checked')) {
        if (costs.length != 0) breakfast_price = costs[0]["meals_cost"];
      }

      if($("[name='inputs[" + index + "][with_lunch]']").is(':checked')) {
        if (costs.length != 0) lunch_price = costs[0]["meals_cost"];
      }

      if($("[name='inputs[" + index + "][with_snack]']").is(':checked')) {
        if (costs.length != 0) snack_price = costs[0]["meals_cost"];
      }

      if($("[name='inputs[" + index + "][with_incidental_expenses]']").is(':checked')) {
        if (costs.length != 0) incidental_expense_price = costs[0]["incidental_expenses_cost"];
      }

      sub_total = +(fare) + +(lodging_price) + +(breakfast_price) + +(lunch_price) + +(snack_price) + +(incidental_expense_price);
      let total = (Math.round(sub_total * 100) / 100).toFixed(2);

      $("[name='inputs[" + index + "][total]']").val(total);

      }

    function getRegionCost(v) {

      let index = $(v).parent().parent().index();

      let additionalCost = getAdditionalCost(index);
      additionalCost.then(function(costs) {

        getPerItineraryTotal(index, costs);
        calcTotal();

      });

    }

    function addLodging(v) 
    {
      let index = $(v).parent().parent().parent().index();
      
      let additionalCost = getAdditionalCost(index);
      additionalCost.then(function(costs){
        
        getPerItineraryTotal(index, costs);
        calcTotal();
      
      });

     }
     
     function addBreakfast(v) {
      var index = $(v).parent().parent().parent().index();
      let additionalCost = getAdditionalCost(index);
      additionalCost.then(function(costs){

        getPerItineraryTotal(index, costs);
        calcTotal();
      
      });

    }

    function addLunch(v) {
      var index = $(v).parent().parent().parent().index();
      let additionalCost = getAdditionalCost(index);
      additionalCost.then(function(costs){

        getPerItineraryTotal(index, costs);
        calcTotal();
      
      });

    }

    function addSnack(v) {
      var index = $(v).parent().parent().parent().index();
      let additionalCost = getAdditionalCost(index);
      additionalCost.then(function(costs){

        getPerItineraryTotal(index, costs);
        calcTotal();
      
      });

    }

    function addIncidentalExpenses(v) {
      var index = $(v).parent().parent().index();
      let additionalCost = getAdditionalCost(index);
      additionalCost.then(function(costs){

        getPerItineraryTotal(index, costs);
        calcTotal();
      
      });
    }
   
    function addTransportPrice(v) {

      var index = $(v).parent().parent().index();
      let additionalCost = getAdditionalCost(index);
      additionalCost.then(function(costs){

        getPerItineraryTotal(index, costs);
        calcTotal();
      
      });
    }

    function calcTotal() {
      var cnt = $("div#itinerary-field");
      var totals = 0;
      var grand_total = 0;
      
      for(let index = 0; index <= cnt.length; index++) {
        var total = $("[name='inputs[" + index + "][total]']").val();
        totals = +(totals) + +(total);
      }

      grand_total = (Math.round(totals * 100) / 100).toFixed(2);

      //console.log(grand_total);
      $("[name='grand_total']").val(grand_total);

    }

 </script>
 <script type="text/javascript">

  // function onFinish(){ alert('Finish Clicked'); }
  // function onCancel(){ $('#smartwizard').smartWizard("reset"); }

  $(function() {
      // Step show event
      $("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
          $("#prev-btn").removeClass('disabled').prop('disabled', false);
          $("#next-btn").removeClass('disabled').prop('disabled', false);
          if(stepPosition === 'first') {
              $("#prev-btn").addClass('disabled').prop('disabled', true);
          } else if(stepPosition === 'last') {
              $("#next-btn").addClass('disabled').prop('disabled', true);
          } else {
              $("#prev-btn").removeClass('disabled').prop('disabled', false);
              $("#next-btn").removeClass('disabled').prop('disabled', false);
          }

          // Get step info from Smart Wizard
          let stepInfo = $('#smartwizard').smartWizard("getStepInfo");
          $("#sw-current-step").text(stepInfo.currentStep + 1);
          $("#sw-total-step").text(stepInfo.totalSteps);
      });

      $("#smartwizard").on("initialized", function(e) {
          console.log("initialized");
      });

      $("#smartwizard").on("loaded", function(e) {
          console.log("loaded");
      });

      // Smart Wizard
      $('#smartwizard').smartWizard({
          selected: 0,
          autoAdjustHeight: true,
          theme: 'arrows', // basic, arrows, square, round, dots
          transition: {
            animation:'slideHorizontal' // none|fade|slideHorizontal|slideVertical|slideSwing|css
          },
          toolbar: {
            showNextButton: true, // show/hide a Next button
            showPreviousButton: true, // show/hide a Previous button
            position: 'top', // none/ top/ both bottom
            extraHtml: `<button class="btn btn-success" onclick="onFinish()">Finish</button>`
          },
          anchor: {
              enableNavigation: true, // Enable/Disable anchor navigation 
              enableNavigationAlways: false, // Activates all anchors clickable always
              enableDoneState: true, // Add done state on visited steps
              markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
              unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
              enableDoneStateNavigation: true // Enable/Disable the done state navigation
          },
          disabledSteps: [], // Array Steps disabled
          errorSteps: [], // Highlight step with errors
          hiddenSteps: [], // Hidden steps
          // getContent: (idx, stepDirection, selStep, callback) => {
          //   console.log('getContent',selStep, idx, stepDirection);
          //   callback('<h1>'+idx+'</h1>');
          // }
      });

      $("#state_selector").on("change", function() {
          $('#smartwizard').smartWizard("setState", [$('#step_to_style').val()], $(this).val(), !$('#is_reset').prop("checked"));
          return true;
      });

      $("#style_selector").on("change", function() {
          $('#smartwizard').smartWizard("setStyle", [$('#step_to_style').val()], $(this).val(), !$('#is_reset').prop("checked"));
          return true;
      });

  });
</script>
  @endsection
  
  @section('jsvalidator')
  
  {!! JsValidator::formRequest('App\Http\Requests\TravelOrderStoreRequest'); !!}
  {{-- {!! JsValidator::formRequest('App\Http\Requests\UserStoreRequest', '#edit-form'); !!} --}}
  
  @endsection    