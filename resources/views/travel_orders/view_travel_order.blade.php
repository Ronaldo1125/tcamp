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
  <link rel="stylesheet" href="{{ url("/plugins/fontawesome-free/css/all.min.css") }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url("/dist/css/bootstrap.min.css") }}">
  <link rel="stylesheet" href="{{ url("/dist/css/adminlte.css") }}">

<style>

body{margin-top:20px;
background:#eee;
/* font-size: 12px; */
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
</style>
 
</head>
<body>
<div class="container">
  <div class="container bootstrap snippets bootdey">
    <div class="panel panel-default">
      <div class="panel-body">
        {{-- <div class="row">
          <div class="col-md-6 col-sm-6 text-left">
            <h4><strong>Client</strong> Details</h4>
            <ul class="list-unstyled">
              <li><strong>First Name:</strong> John</li>
              <li><strong>Last Name:</strong> Doe</li>
              <li><strong>Country:</strong> U.S.A.</li>
              <li><strong>DOB:</strong> YYYY/MM/DD</li>
            </ul>
          </div>
  
          <div class="col-md-6 col-sm-6 text-right">
            <h4><strong>Payment</strong> Details</h4>
            <ul class="list-unstyled">
              <li><strong>Bank Name:</strong> 012345678901</li>
              <li><strong>Account Number:</strong> 012345678901</li>
              <li><strong>SWIFT Code:</strong> SWITCH012345678CODE</li>
              <li><strong>V.A.T Reg #:</strong> VAT5678901CODE</li>
            </ul>
  
          </div>
  
        </div> --}}
        <div class="my-4 text-center">
          <img class="mb-3" src="{{ asset('dist/img/neda_letterhead2.png') }}">
          <p class="text-end mr-5">Local Travel Order No. {{ $travel_order->to_code ."-". sprintf("%02d", $travel_order->id) }}</p>  
        </div>
  
        <div class="table-responsive">
          <table class="">
            {{-- <table class="table table-bordered border-dark"> --}}
            <thead>
              <tr>
                <td scope="col" colspan="4">NAME: <strong class="ml-2">{{ $travel_order->user->name }}</strong></td>
                <td scope="col" colspan="6">POSITION: <strong class="ml-2">{{ $travel_order->user->designation->designation_name }}</strong></td>
              </tr>
              <tr>
                <td scope="col" colspan="4">DESTINATION: <strong class="ml-2">{{ $travel_order->destination }}</strong></td>
                <td scope="col" colspan="6">STATION: <strong class="ml-2">Legazpi City</strong></td>
              </tr>
              <tr>
                <td scope="col" colspan="4">TRAVEL PERIOD: <strong class="ml-2">{{ date("M d, Y", strtotime($travel_order->travel_departure_date)) . " to " . date("M d, Y", strtotime($travel_order->travel_arrival_date)) }}</strong></td>
                <td scope="col" colspan="6">PURPOSE: <strong class="ml-2">{{ $travel_order->purpose }}</strong> </td>
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
              @foreach($travel_itineraries as $travel_itinerary)
              <tr>
                <td>{{ date('M d, Y', strtotime($travel_itinerary->itinerary_date)) }}</td>
                <td>{{ $travel_itinerary->city->name }}</td>
                <td>{{ $travel_itinerary->estimated_time_of_departure }}</td>
                <td>{{ $travel_itinerary->estimated_time_of_arrival }}</td>
                <td>{{ $travel_itinerary->transportation->transportation_name }}</td>
                <td class="text-end pr-2">{{ number_format($travel_itinerary->transportation_price, 2) }}</td>
                <td class="text-end pr-2">{{ ($travel_itinerary->with_lodging) ? number_format($travel_itinerary->region->lodging_cost, 2) : "-" }}</td>
                <td class="text-end pr-2">
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
                <td class="text-end pr-2">{{ ($travel_itinerary->with_incidental_expenses) ? number_format($travel_itinerary->region->incidental_expenses_cost, 2) : "-" }}</td>
                <td class="text-end pr-2">{{ number_format($travel_itinerary->total, 2) }}</td>
              </tr>
              @endforeach
              <tr>
                <td colspan="10" class="text-end pr-2"><strong class="ml-2"><span class="mr-5">TOTAL</span>{{ number_format($travel_order->grand_total, 2)}}</strong></td>
              </tr>
              <tr>
                <td colspan="10" class="text-end">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="10" class="text-end">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4">Requesting for cash advance:
                  <input type="checkbox" class="ml-3" {{ ($travel_itinerary->travel_order->is_travel_related_to_training == 1) ? 'checked' : '' }}>YES <input type="checkbox" class="ml-3" {{ ($travel_itinerary->travel_order->is_travel_related_to_training == 0) ? 'checked' : '' }}>NO
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
                  <span><center><img src="{{ asset('images/' . $travel_order->user->profile->esignature) }}" width="150px;" height="60px;" alt="eSignature Image"></center></span>
                  <span><center><strong>{{ $travel_order->user->name }}</strong></center></span>
                  <span><center>{{ $travel_order->user->designation_name }}</center></span>
                </td>
                <td colspan="6" rowspan="2">REVIEWED/RECOMMENDING APPROVAL:<br><br>
                  <div style="text-indent: 30px;"><small>I certify that: (1) I reviewed the foregoing itinerary, (2) the travel is necessary to the
                    service, (3) the period covered is reasonable, (4) the expenses claimed are proper.</small></div><br><br><br>
                    @if(isset($approver[0][0]->profile->esignature))
                      <span><center><img src="{{ asset('images/' . $approver[0][0]->profile->esignature) }}" width="150px;" height="60px;" alt="eSignature Image"></center></span>
                    @endif
                    @if(isset($approver[0][0]->name))
                    <span><center><strong>{{$approver[0][0]->name}}</strong></center></span>
                    @endif
                    <span><center>Chief Administrative Officer</center></span>
                </td>
              </tr>
              <tr>
                <td colspan="4">DATE PREPARED: <strong class="ml-2">{{ date('F d, Y', strtotime($travel_order->created_at)) }}</strong></td>
              </tr>
              <tr>
                <td colspan="10" class="text-end">
                  <span><center>APPROVED:</center></span><br><br><br>
                  @if(isset($approver[1][0]->profile->esignature))
                      <span><center><img src="{{ asset('images/' . $approver[1][0]->profile->esignature) }}" width="150px;" height="60px;" alt="eSignature Image"></center></span>
                    @endif
                    @if(isset($approver[1][0]->name))
                  <span><center><strong>{{ $approver[1][0]->name }}</strong></center></span>
                  @endif
                  <span><center>Assistant Regional Director</center></span>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
  
        {{-- <hr class="nomargin-top">
        <div class="row">
          <div class="col-sm-6 text-left">
            <h4><strong>Contact</strong> Details</h4>
            <p class="nomargin nopadding">
              <strong>Note:</strong> 
              Lid est laborum dolo rumes fugats.
            </p><br><!-- no P margin for printing - use <br> instead -->
  
            <address>
              PO Box 21132 <br>
              Vivas 2355 Australia<br>
              Phone: 1-800-565-2390 <br>
              Fax: 1-800-565-2390 <br>
              Email:support@yourname.com
            </address>
          </div>
  
          <div class="col-sm-6 text-right">
            <ul class="list-unstyled">
              <li><strong>Sub - Total Amount:</strong> $2162.00</li>
              <li><strong>Discount:</strong> 10.0%</li>
              <li><strong>VAT ($6):</strong> $12.0</li>
              <li><strong>Grand Total:</strong> $1958.0</li>
            </ul>     
            <a class="btn btn-default" href="#">MAKE A PAYMENT</a>
          </div>
        </div> --}}
      </div>
    </div>
  
    <div class="panel panel-default text-right">
      <div class="panel-body mb-3">
        {{-- <a class="btn btn-warning" href="#"><i class="fa fa-pencil-square-o"></i> EDIT</a>
        <a class="btn btn-primary" href="#"><i class="fa fa-check"></i> SAVE</a> --}}
        <a class="btn btn-success btn-xs printbtn" href="javascript:window.print();"><i class="fa fa-print"></i> PRINT TO</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
