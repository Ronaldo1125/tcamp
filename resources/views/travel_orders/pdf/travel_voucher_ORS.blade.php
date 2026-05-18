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
  align-items: center;     /* Vertical centering */
  max-width: 240px;
  margin: 0 auto;
}

.img_signature {
  float: left;
  width: 100px;
  height: 40px;
}

p.signatory {
  font-style: italic; 
  font-size: 0.8em;
}



</style>
 
</head>
<body>

<div class="container">
  <div class="container bootstrap snippets bootdey">
    <div class="panel panel-default">
      <div class="panel-body">
       
        <div class="my-4 text-center">
          <img src="{{ public_path('dist/img/depdev5header2.png') }}">
        </div>
  
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <td scope="col" colspan="5">
                    <span><center><strong><h5>OBLIGATION REQUEST AND STATUS</h5></strong></center></span><br><br>
                    <span class="text-decoration-underline"><center><strong><h4>DEPARTMENT OF ECONOMY, PLANNING AND DEVELOPMENT</strong></h4></center></span>
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
                <td scope="col" colspan="6"><strong>{{ $travelOrder->user->name }}</strong></td>
              </tr>
              <tr>
                <td scope="col" colspan="2" class="text-center">Office</td>
                <td scope="col" colspan="6">DEPDEV Region 5 </td>
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
                <td colspan="2" rowspan="2" class="align-top">{{ $travelOrder->fund_source->fund_source_name }}</td>
                <td colspan="2" rowspan="2" class="align-top">Travel allowance for the following:<br>
                    <span>{{ $travelOrder->purpose }}</span>
                </td>
                <td rowspan="2" class="align-top">{{ $travelOrder->pap->pap_name }}</td>
                <td rowspan="2"></td>
                <td colspan="2" align="right">{{ number_format($travelOrder->grand_total, 2)}}
                <br><br><br><br><br><br><br><br><br>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="text-end" align="right"><strong>{{ number_format($travelOrder->grand_total, 2)}}</strong></td>
              </tr>
              <tr>
                <td colspan="4"><strong>A.</strong>
                  <div class="mx-4"><strong>Certified:</strong> Charges to appropriation/allotment are necessary, lawful and under my direct supervision; and supporting documents valid, proper, and legal</div><br><br><br>
                  @if(isset($travelOrder->immediateSupervisor->profile->esignature))
                  <div class="pos_cen">
                     <img src="{{ public_path('images/' . $travelOrder->immediateSupervisor->profile->esignature ) }}" class="img_signature"/>
                    <p class="signatory">Electronically signed by {{ $travelOrder->immediateSupervisor->name }} Date: {{ date('Y.m.d H:i:s', strtotime($travelOrder->immediate_supervisor_approved_at)) }}</p>
                  </div>
                  @endif
                  @if(isset($travelOrder->immediateSupervisor->name))
                      <p><center><strong>{{ $travelOrder->immediateSupervisor->name }}</strong></center></p>
                  @endif
                  <span><center>Chief Administrative Officer</center></span>
                  <span><center>Head, Requesting Office/Authorized Representative</center></span>
                  <span>Date: {{ date('F d, Y', strtotime($travelOrder->immediate_supervisor_approved_at)) }}</span>
                </td>
                <td colspan="4"><strong>B.</strong>
                  <div class="mx-4"><strong>Certified:</strong> Allotment available and obligated for the purpose/adjustment necessary as indicated above</div><br><br><br>
                  @if(isset($travelOrder->budgetOfficer->profile->esignature))
                  <div class="pos_cen">
                    <img src="{{ public_path('images/' . $travelOrder->budgetOfficer->profile->esignature) }}" class="img_signature"/>
                    <p class="signatory">Electronically signed by {{ $travelOrder->budgetOfficer->name }} Date: {{ date('Y.m.d H:i:s', strtotime($travelOrder->budget_officer_approved_at)) }}</p>
                  </div>
                  @endif
                  @if(isset($travelOrder->budgetOfficer->name))
                  <p><center><strong>{{ $travelOrder->budgetOfficer->name }}</strong></center></p>
                  @endif
                  <span><center>Budget Officer</center></span>
                  <span><center>Head, Budget Division/Authorized Representative</center></span>
                  <span>Date: {{ date('F d, Y', strtotime($travelOrder->budget_officer_approved_at)) }}</span>
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
                <td>{{ date('F d, Y', strtotime($travelOrder->created_at)) }}</td>
                <td><span>Travel allowance for the following: {{ $travelOrder->purpose }}</span></td>
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
  
    {{-- <div class="panel panel-default text-right">
      <div class="panel-body mb-3">
        <a class="btn btn-success btn-xs printbtn" href="javascript:window.print();"><i class="fa fa-print"></i> PRINT TO</a>
      </div>
    </div> --}}
  </div>
</div>
</body>
</html>