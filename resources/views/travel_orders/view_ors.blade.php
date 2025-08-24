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
/* font-size: 14px; */
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
       
        <div class="my-4 text-center">
          <img src="{{ asset('dist/img/neda_letterhead2.png') }}">
        </div>
  
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <td scope="col" colspan="5">
                    <span><center><strong><h5>OBLIGATION REQUEST AND STATUS</h5></strong></center></span><br><br>
                    <span class="text-decoration-underline"><center><strong><h6>NATIONAL ECONOMIC AND DEVELOPMENT AUTHORITY</strong></h6></center></span>
                    <span><center>Entity Name</center></span>
                </td>
                <td scope="col" colspan="3">
                    <span>Serial No.:</span><br>
                    <span>Date:</span><br>
                    <span>Fund Cluster:</span>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td scope="col" colspan="2" class="text-center">Payee</td>
                <td scope="col" colspan="6"><strong>{{ $travel_order->user->name }}</strong></td>
              </tr>
              <tr>
                <td scope="col" colspan="2" class="text-center">Office</td>
                <td scope="col" colspan="6">NEDA Region 5 </td>
              </tr>
              <tr>
                <td scope="col" colspan="2" class="text-center">Address</td>
                <td scope="col" colspan="6">Legazpi City </td>
              </tr>
              <tr class="text-center fw-bold">
                <td colspan="2">Responsibility Center</td>
                <td colspan="2">Particulars</td>
                <td>MFO/PAP</td>
                <td>UACS Object Code</td>
                <td colspan="2">Amount</td>
              </tr>
              <tr class="">
                <td colspan="2" rowspan="2" class="align-top">{{ $travel_order->fund_source->fund_source_name }}</td>
                <td colspan="2" rowspan="2" class="align-top">Travel allowance for the following:<br>
                    <span>{{ $travel_order->purpose }}</span>
                </td>
                <td rowspan="2" class="align-top">{{ $travel_order->pap->pap_name }}</td>
                <td rowspan="2"></td>
                <td colspan="2" class="text-end">{{ number_format($travel_order->grand_total, 2)}}
                <br><br><br><br><br><br><br><br><br>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="text-end"><strong>{{ number_format($travel_order->grand_total, 2)}}</strong></td>
              </tr>
              <tr>
                <td colspan="4"><strong>A.</strong>
                  <div class="mx-4"><strong>Certified:</strong> Charges to appropriation/allotment are necessary, lawful and under my direct supervision; and supporting documents valid, proper, and legal</div><br><br><br>
                  @if(isset($approver[0][0]->profile->esignature))
                  <span><center><img src="{{ asset('images/' . $approver[0][0]->profile->esignature) }}" width="150px;" height="60px;" alt="eSignature Image"></center></span>
                  @endif
                  @if(isset($approver[0][0]->name))
                  <span><center><strong>{{ $approver[0][0]->name }}</strong></center></span>
                  @endif
                  <span><center>Chief Administrative Officer</center></span>
                  <span><center>Head, Requesting Office/Authorized Representative</center></span>
                  <span>Date:</span>
                </td>
                <td colspan="4"><strong>B.</strong>
                  <div class="mx-4"><strong>Certified:</strong> Allotment available and obligated for the purpose/adjustment necessary as indicated above</div><br><br><br>
                  @if(isset($approver[2][0]->profile->esignature))
                  <span><center><img src="{{ asset('images/' . $approver[2][0]->profile->esignature) }}" width="150px;" height="60px;" alt="eSignature Image"></center></span>
                  @endif
                  @if(isset($approver[2][0]->name))
                  <span><center><strong>{{ $approver[2][0]->name }}</strong></center></span>
                  @endif
                  <span><center>Budget Officer</center></span>
                  <span><center>Head, Budget Division/Authorized Representative</center></span>
                  <span>Date:</span>
                </td>
              </tr>
              <tr>
                <td><strong>C.</strong></td>
                <td colspan="7"><span><center><strong>STATUS OF OBLIGATION</strong></center></span></td>
              </tr>
              <tr>
                <td colspan="3"><strong><center>Reference</center></strong></td>
                <td colspan="5"><span><center><strong>Amount</strong></center></span></td>
              </tr>
              <tr>
                <td rowspan="3"><center>Date</center></td>
                <td rowspan="3"><center>Particulars</center></td>
                <td rowspan="3"><center>ORS/JEV/Check/ADA/TRA No.</center></td>
                <td rowspan="2"><center>Obligation</center></td>
                <td rowspan="2"><center>Payable</center></td>
                <td rowspan="2"><center>Payment</center></td>
                <td colspan="2"><center>Balance</center></td>
              </tr>
              <tr>
                <td><center>Not Yet Due</center></td>
                <td><center>Due and Demandable</center></td>
              </tr>
              <tr>
                <td><center>(a)</center></td>
                <td><center>(b)</center></td>
                <td><center>(c)</center></td>
                <td><center>(a-b)</center></td>
                <td><center>(b-c)</center></td>
              </tr>
              <tr>
                <td></td>
                <td><span>Travel allowance for the following: {{ $travel_order->purpose }}</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              
            </tbody>
          </table>
        </div>
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
