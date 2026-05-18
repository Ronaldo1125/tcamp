<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="_token" content="{{csrf_token()}}" />
  <title>View Pre Travel Order Application</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  {{-- <link rel="stylesheet" href="{{ url("/plugins/fontawesome-free/css/all.min.css") }}"> --}}
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  {{-- <link rel="stylesheet" href="{{ url("/dist/css/bootstrap.min.css") }}">
  <link rel="stylesheet" href="{{ url("/dist/css/adminlte.css") }}"> --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{margin-top:20px;
background:#fff;
font-size: 0.7em;
font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

table, thead, th, tr, td {
  border: 1px solid black;
  border-collapse: collapse;
}

/**    17. Panel
 *************************************************** **/
/* pannel */
.panel {
	position:relative;

	background:transparent;

	-webkit-border-radius: 0;
	   -moz-border-radius: 0;
			border-radius: 0;

	-webkit-box-shadow: none;
	   -moz-box-shadow: none;
			box-shadow: none;
}
.panel.fullscreen .accordion .panel-body,
.panel.fullscreen .panel-group .panel-body {
	position:relative !important;
	top:auto !important;
	left:auto !important;
	right:auto !important;
	bottom:auto !important;
}
	
.panel.fullscreen .panel-footer {
	position:absolute;
	bottom:0;
	left:0;
	right:0;
}


.panel>.panel-heading {
	text-transform: uppercase;

	-webkit-border-radius: 0;
	   -moz-border-radius: 0;
			border-radius: 0;
}
.panel>.panel-heading small {
	text-transform:none;
}
.panel>.panel-heading strong {
	font-family:Arial,Helvetica,Sans-Serif;
}
.panel>.panel-heading .buttons {
	display:inline-block;
	margin-top:-3px;
	margin-right:-8px;
}
.panel-default>.panel-heading {
	padding: 15px 15px;
	background:#fff;
}
.panel-default>.panel-heading small {
	color:#9E9E9E;
	font-size:12px;
	font-weight:300;
}
.panel-clean {
	border: 1px solid #ddd;
	border-bottom: 3px solid #ddd;

	-webkit-border-radius: 0;
	   -moz-border-radius: 0;
			border-radius: 0;
}
.panel-clean>.panel-heading {
	padding: 11px 15px;
	background:#fff !important;
	color:#000;	
	border-bottom: #eee 1px solid;
}
.panel>.panel-heading .btn {
	margin-bottom: 0 !important;
}

.panel>.panel-heading .progress {
	background-color:#ddd;
}

.panel>.panel-heading .pagination {
	margin:-5px;
}

.panel-default {
	border:0;
}

.panel-light {
	border:rgba(0,0,0,0.1) 1px solid;
}
.panel-light>.panel-heading {
	padding: 11px 15px;
	background:transaprent;
	border-bottom:rgba(0,0,0,0.1) 1px solid;
}

.panel-heading a.opt>.fa {
    display: inline-block;
    font-size: 14px;
    font-style: normal;
    font-weight: normal;
    margin-right: 2px;
    padding: 5px;
    position: relative;
    text-align: right;
    top: -1px;
}

.panel-heading>label>.form-control {
	display:inline-block;
	margin-top:-8px;
	margin-right:0;
	height:30px;
	padding:0 15px;
}
.panel-heading ul.options>li>a {
	color:#999;
}
.panel-heading ul.options>li>a:hover {
	color:#333;
}
.panel-title a {
	text-decoration:none;
	display:block;
	color:#333;
}

.panel-body {
	background-color:#fff;
	padding: 15px;

	-webkit-border-radius: 0;
	   -moz-border-radius: 0;
			border-radius: 0;
}
.panel-body.panel-row {
	padding:8px;
}

.panel-footer {
	font-size:12px;
	border-top:rgba(0,0,0,0.02) 1px solid;
	background-color:rgba(0255,255,255,1);

	-webkit-border-radius: 0;
	   -moz-border-radius: 0;
			border-radius: 0;
}

@media print {
    .printbtn {
        display :  none;
    }
}

div.pos_cen {
  position: relative;
  display: flex;
  align-items: center;     /* Centers vertically */
  flex-direction: row;      /* Side-by-side; use 'column' to stack */
  max-width: 240px;
  margin: 0 auto;
 
}

.img_signature {
  float: left;
  width: 100px;
  height: 40px;
  margin-right: 2px;
}

p.signatory {
  font-style: italic; 
  font-size: 0.7em;
}

</style>
 
</head>
<body>
<div class="container">
  <div class="container bootstrap snippets bootdey">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="my-4 text-center">
          <center><img class="mb-3" src="{{ public_path('dist/img/depdev5header2.png') }}"></center>
            <p align="right" class="text-end mr-5">Local Travel Order No. {{ to_number($travelOrder->to_code, $travelOrder->id) }}</p>  
        </div>
  
        <div class="table-responsive">
          <table class="">
            <table class="table table-bordered border-dark">
            <thead>
              <tr>
                <td scope="col" colspan="4">NAME: <strong class="ml-2">{{ $travelOrder->user->name }}</strong></td>
                <td scope="col" colspan="6">POSITION: <strong class="ml-2">{{ $travelOrder->user->designation->designation_name }}</strong></td>
              </tr>
              <tr>
                <td scope="col" colspan="4">DESTINATION: <strong class="ml-2">{{ $travelOrder->destination }}</strong></td>
                <td scope="col" colspan="6">STATION: <strong class="ml-2">Legazpi City</strong></td>
              </tr>
              <tr>
                <td scope="col" colspan="4">TRAVEL PERIOD: <strong class="ml-2">{{ date("M d, Y", strtotime($travelOrder->travel_departure_date)) . " to " . date("M d, Y", strtotime($travelOrder->travel_arrival_date)) }}</strong></td>
                <td scope="col" colspan="6">PURPOSE: <strong class="ml-2">{{ $travelOrder->purpose }}</strong> </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="10">Per approved Itinerary of Travel, actual expenses for meals, gasoline, toll fees, per diems and miscellaneous expenses are hereby authorized chargeable against the allocation for travel expenditures, subject to availability of funds and the usual accounting and auditing rules and regulations.</td>
              </tr>
              <tr>
                <th scope="row" colspan="10" class="text-center">ITINERARY OF TRAVEL</th>
              </tr>
             
              <tr class="text-center">
                <th scope="row" rowspan="2" class="align-middle">DATE</th>
                <th scope="row" rowspan="2" class="align-middle">PLACE</th>
                <th scope="row" colspan="2">TIME</th>
                <th scope="row" rowspan="2" class="align-middle">Transportation Means</th>
                <th scope="row" colspan="5">TRAVEL EXPENSES</th>
               </tr>
              <tr class="text-center">
                <th scope="row">ETD</th>
                <th scope="row">ETA</th>
                <th scope="row">Transportation</th>
                <th scope="row">Lodging</th>
                <th scope="row">Meals</th>
                <th scope="row">Incidental Expenses</th>
                <th scope="row">Total</th>
              </tr>
              @foreach($travelOrder->travel_itinineraries as $travel_itinerary)
              <tr>
                <td>{{ date('M d, Y', strtotime($travel_itinerary->itinerary_date)) }}</td>
                <td>{{ $travel_itinerary->city->name }}</td>
                <td>{{ $travel_itinerary->estimated_time_of_departure }}</td>
                <td>{{ $travel_itinerary->estimated_time_of_arrival }}</td>
                <td>{{ $travel_itinerary->transportation->transportation_name }}</td>
                <td align="right" style="padding-right: 2px;">{{ number_format($travel_itinerary->transportation_price, 2) }}</td>
                <td align="right">{{ ($travel_itinerary->with_lodging) ? number_format($travel_itinerary->region->lodging_cost, 2) : "-" }}</td>
                <td align="right">
                  @php
                  $meals = 0;
                  if($travel_itinerary->with_breakfast == 1)
                   $meals += $travel_itinerary->region->meals_cost;
                  
                  if($travel_itinerary->with_lunch == 1)
                   $meals += $travel_itinerary->region->meals_cost;
                  
                  if($travel_itinerary->with_snack == 1)
                   $meals += $travel_itinerary->region->meals_cost;
                  
                  @endphp
                  
                  {{ number_format($meals, 2) }}
                </td>
                <td align="right">{{ ($travel_itinerary->with_incidental_expenses) ? number_format($travel_itinerary->region->incidental_expenses_cost, 2) : "-" }}</td>
                <td align="right">{{ number_format($travel_itinerary->total, 2) }}</td>
              </tr>
              @endforeach
              <tr>
                <td colspan="10" class="text-end pr-2" align="right"><strong class="ml-2"><span class="mr-5" style="margin-right: 5px;">TOTAL</span>{{ number_format($travelOrder->grand_total, 2)}}</strong></td>
              </tr>
              <tr style="font-size: 0.7em;">
                <td colspan="4">Requesting for cash advance:
                  <input type="checkbox" style="vertical-align: -2px;" {{ ($travelOrder->is_travel_related_to_training == 1) ? 'checked' : '' }}> YES <input type="checkbox"  style="vertical-align: -2px;" {{ ($travelOrder->is_travel_related_to_training == 0) ? 'checked' : '' }}> NO
                </td>
                <td colspan="6">ORS/BURS No.</td>
              </tr>
              <tr>
                <td colspan="10">Upon completion of travel, the usual certificate of appearance and certificate of travel completed shall be submitted to FAD and report thereon shall be submitted
                  within fifteen (15) days from completion of said travel, otherwise, the amount corresponding to said cash advances shall be deducted from the next succeeding
                  payday.</td>
              </tr>
              <tr>
                <td colspan="4">PREPARED BY:<br><br>
                 
                      <div class="pos_cen">
                      <img src="{{ public_path('images/' . $travelOrder->user->profile->esignature) }}" class="img_signature">
                      <p class="signatory">Electronically signed by {{ $travelOrder->user->name }} Date: {{ date('Y.m.d H:i:s', strtotime($travelOrder->created_at)) }}</p>
                    </div>
                    <p><center><strong>{{ $travelOrder->user->name }}</strong></center></p>
                    <span><center>{{ $travelOrder->user->designation->designation_name }}</center></span>
                  
                </td>
                <td colspan="6" rowspan="2">REVIEWED/RECOMMENDING APPROVAL:<br><br>
                  <div style="text-indent: 30px;"><small>I certify that: (1) I reviewed the foregoing itinerary, (2) the travel is necessary to the
                    service, (3) the period covered is reasonable, (4) the expenses claimed are proper.</small></div><br><br><br>
                    @if(isset($travelOrder->immediateSupervisor->profile->esignature))
                    <div class="pos_cen">
                      <img src="{{ public_path('images/' . $travelOrder->immediateSupervisor->profile->esignature) }}" class="img_signature">
                      <p class="signatory">Electronically signed by {{ $travelOrder->immediateSupervisor->name }} Date: {{ date('Y.m.d H:i:s', strtotime($travelOrder->immediate_supervisor_approved_at)) }}</p>
                    </div>
                    @endif
                    @if(isset($travelOrder->immediateSupervisor->name))
                    <p><center><strong>{{$travelOrder->immediateSupervisor->name}}</strong></center></p>
                    @endif
                    <span><center>Chief Administrative Officer</center></span>
                </td>
              </tr>
              <tr>
                <td colspan="4">DATE PREPARED: <strong class="ml-2">{{ date('F d, Y', strtotime($travelOrder->created_at)) }}</strong></td>
              </tr>
              <tr>
                <td colspan="10" class="text-end">
                  <span><center>APPROVED:</center></span><br><br><br>
                  @if(isset($travelOrder->management->profile->esignature))
                  <div class="pos_cen">
                      <img src="{{ public_path('images/' . $travelOrder->management->profile->esignature) }}" class="img_signature">
                      <p class="signatory">Electronically signed by {{ $travelOrder->management->name }} Date: {{ date('Y.m.d H:i:s', strtotime($travelOrder->management_approved_at)) }}</p>
                  </div>
                      
                    @endif
                    @if(isset($travelOrder->management->name))
                  <p><center><strong>{{ $travelOrder->management->name }}</strong></center></p>
                  @endif
                  <span><center>Assistant Regional Director</center></span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Styled Table</title>
    <style>
        /* Table container styling */
        table {
            width: 100%;
            border-collapse: collapse; /* Merges cell borders into one */
            font-family: Arial, sans-serif;
            margin: 25px 0;
            font-size: 0.7em;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        /* Header styling */
        thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }

        /* Cell padding and borders */
        th, td {
            padding: 12px 15px;
            border: 1px solid #dddddd; /* Basic border for visibility */
        }

        /* Zebra striping for better readability */
        tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        /* Highlight the last row */
        tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
    </style>
</head>
<body>

    <h2>Product Inventory</h2>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Laptop</td>
                <td>Electronics</td>
                <td>$999</td>
            </tr>
            <tr>
                <td>Desk Chair</td>
                <td>Furniture</td>
                <td>$150</td>
            </tr>
            <tr>
                <td>Monitor</td>
                <td>Electronics</td>
                <td>$200</td>
            </tr>
        </tbody>
    </table>

</body>
</html> --}}
