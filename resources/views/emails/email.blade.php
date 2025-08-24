


<strong>Dear {{ $content->name }},</strong>
<br>
<p>Please be informed that One Travel Order application with the reference number {{ $travel_order->to_code ."-". sprintf("%02d", $travel_order->id) }} had been filed on the TCAMP system, below are the details.</p>

<p style="padding-left: 50px;">Name: {{ Auth::user()->name }}</p>
<p style="padding-left: 50px;">Purpose: {{ $travel_order->purpose }}</p>
<p style="padding-left: 50px;">Destination: {{ $travel_order->destination }}</p>
<p style="padding-left: 50px;">Travel Date: {{ $travel_order->travel_departure_date ." - " . $travel_order->travel_arrival_date }}</p>


<p><a href="http://tcamp2.app.local/travel_orders"><button>Link to TCAMP Application</button></a></p>

<p>Thank you,</p>
TCAMP Admin
<br>
<p style="font-style: italic; font-weight: bold; font-size: 10px;">***NOTE: Please do not reply to this email. This a system generated email.***</p>
