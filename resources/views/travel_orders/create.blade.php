@extends('layouts.app')

@section('styles')
  
  <link rel="stylesheet" type="text/css" href=" {{ url('/dist/css/datatables/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/css/select2/select2.min.css')}}">
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
                  <div class="p-3 bg-light">
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
                          <label for="fund_source_id" class="form-label">Fund Source:</label><br>
                                <select class="form-control" name="fund_source_id" id="fund_source_id">
                                  <option value="">-- Select Fund Source --</option>
                                    @foreach ($fund_sources as $key => $fund_source)
                                    <option value="{{ $key }}">{{ $fund_source }}</option>
                                    @endforeach
                                </select>
                        </div>

                        <div class="col-3">
                          <label for="pap_id" class="form-label">MFO/PAPs:</label>
                                <select class="form-control" name="pap_id" id="pap_id">
                                  <option value="">-- Select MFO/PAPs --</option>
                                </select>
                                <br>
                                <input type="text" name="other_pap_name" class="form-control" id="other_pap_name" placeholder="MFO/PAPs Name">
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
                    <div class="form-group">
                      <div class="row my-3 mr-4">
                        <div class="col-12 text-end">
                          <a href="javascript:(0)" class="btn btn-success btn-sm addRow">+ ADD</a>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="itineryMain" id="itinerary-form">
                        <div class="mb-3 pt-2 row itineraryField bg-light" id="itinerary_field">
                          <div class="col-2">
                            <label for="itinerary_date" class="form-label">Date:</label>
                            <input type="date" name="inputs[0][itinerary_date]" id="itinerary_date" value="{{ old('inputs[0][itinerary_date]') }}" class="form-control" readonly>
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
                              <input type="time" name="inputs[0][estimated_time_of_departure]" class="form-control">
                            </div>
                            <div class="row-3">
                              <label for="estimated_time_of_arrival" class="form-label">ETA:</label>
                              <input type="time" name="inputs[0][estimated_time_of_arrival]" class="form-control">
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
                              <input type="checkbox" name="inputs[0][with_breakfast]" value="with_breakfast" id="with_breakfast" onclick="addBreakfast(this);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Breakfast">&nbsp;
                              <input type="checkbox" name="inputs[0][with_lunch]" value="with_lunch" id="with_lunch" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Lunch" onclick="addLunch(this);">&nbsp;
                              <input type="checkbox" name="inputs[0][with_snack]" value="with_snack" id="with_snack" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="PM Snack" onclick="addSnack(this);">
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
                    <input type="numbers" name="grand_total" id="grand_total" class="form-control text-end bg-yellow fw-bold text-white" readonly>
                  </div>
                </div>
        
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 text-center py-3">
                <button type="submit" class="btn-sm btn-primary"><i class="fas fa-save"></i> Submit</button>
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

      $(document).on('change', '#fund_source_id', function(){
        let fundSource = $('#fund_source_id').val();

        //console.log(fundSource);

        if(fundSource == '') {
          pap.attr('disabled','disabled');
          pap.removeAttr('required');
          pap.show();
          otherPapName.hide();
          otherPapName.removeAttr('required');

        } else {

          $.ajax({
            url: "{{ route('paps.getPaps') }}",
            data: {
              fund_source_id: fundSource
            },
            success: function (data) {

              //console.log(data);

              if(data.length == 0) {
                
                otherPapName.show();
                otherPapName.attr('required', true);
                pap.hide();
                pap.removeAttr('required');

              } else {
                pap.html('<option value="">-- Select MFO/PAPs --</option>');
                $.each(data, function(id,value){
                  pap.append('<option value="' + value.id + '">' + value.pap_name + '</option>');
                })
                pap.removeAttr('disabled');
                pap.attr('required', true);
                pap.show();
                otherPapName.hide();
                otherPapName.removeAttr('required');
              }
              //console.log(data);
            }
          }) 
          
        }
      })


  var i = 0;
  $(".addRow").click(function(){
    i++;
    $("#itinerary-form").append(
      `<div class="mb-3 py-2 row itineraryField bg-light" id="itinerary-field">
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
                  <input type="time" name="inputs[`+i+`][estimated_time_of_departure]" class="form-control">
                </div>
                <div class="row-3">
                  <label for="estimated_time_of_arrival" class="form-label">ETA:</label>
                  <input type="time" name="inputs[`+i+`][estimated_time_of_arrival]" class="form-control">   
                </div>
              </div>
              <div class="col-1">
                <label for="transportation_id" class="form-label">Transport:</label>
                <select class="form-control" name="inputs[`+i+`][transportation_id]" id="transportation_id">
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
                  <input type="checkbox" name="inputs[`+i+`][with_lodging]" value="with_lodging" id="with_lodging" onclick="addLodging(this);">
                </div>
              </div>

              <div class="col-1 text-center">
                <label for="with_breakfast" class="form-label">Meals:</label>
                <div class="form-check">
                  <input type="checkbox" name="inputs[`+i+`][with_breakfast]" value="with_breakfast" id="with_breakfast" title="Breakfast" onclick="addBreakfast(this);">&nbsp;
                  <input type="checkbox" name="inputs[`+i+`][with_lunch]" value="with_lunch" id="with_lunch" title="Lunch" onclick="addLunch(this);">&nbsp;
                  <input type="checkbox" name="inputs[`+i+`][with_snack]" value="with_snack" id="with_snack" title="PM Snack" onclick="addSnack(this);">
                </div>
              </div>

              <div class="col-1 text-center">
                <label for="with_incidental_expenses" class="form-label">Inc. Expenses:</label>
                <input type="checkbox" name="inputs[`+i+`][with_incidental_expenses]" value="with_incidental_expenses" id="with_incidental_expenses" onclick="addIncidentalExpenses(this);">
              </div>

              <div class='col'>
                <label for="total" class="form-label">Total:</label>
                <input type="number" name="inputs[`+i+`][total]" id="total" class="form-control text-end fw-semibold bg-dark-subtle" readonly>
              </div>
              <div class="col text-center">
                <a href="javascript:(0)" class="btn btn-danger btn-sm mt-4 deleteRow">- DEL</a>
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
      console.log(index);
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
  @endsection
  
  @section('jsvalidator')
  
  {!! JsValidator::formRequest('App\Http\Requests\TravelOrderStoreRequest'); !!}
  {{-- {!! JsValidator::formRequest('App\Http\Requests\UserStoreRequest', '#edit-form'); !!} --}}
  
  @endsection    