@extends('layouts.main')

@section('content')

<h2>Search booking</h2>

@if( Session::has('message') )
	{{ Session::get('message') }}
@endif

Checkin ID: <span data-bind="text: id"></span></br>
Booking ID: <span data-bind="text: bookingID"></span></br>
Toal Charges: <span data-bind="text: payment"></span></br>
Already Paid: <span data-bind="text: paid"></span></br>
Payment: <input type="text" data-bind="value: advancedPay" /></br>
<button data-bind="click: saveCheckin">Submit</button></br>

<script type="text/javascript" src="{{url()}}/js/checkin.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	window.onload = function() {
		//load only the booking ID

		var foo;
		var checkArr;
		sendRequestToServerPost('/admin/checkin/addpayment', foo, function(res) {
			if(res) {
				checkArr = JSON.parse(res);
				checkinView.id(checkArr.checkin_id);
				checkinView.bookingID(checkArr.booking_id);
				checkinView.payment(checkArr.payment);

				var payArr = JSON.parse(checkArr.paid);
				var payTotal = 0;
				for (var i = 0; i < payArr.length; i++) {
					payTotal += parseFloat(payArr[i]);
				};
				
				checkinView.paid(payTotal);
			}
		});
	}

	var checkinView = new Checkin();
	ko.applyBindings(checkinView);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>

@stop