@extends('layouts.main')

@section('content')

Booking ID: <input type="text" data-bind="value: bookingID" /></br>
Check in: <input type="checkbox" data-bind="checked: checkin" /></br>
Toal Charges: <span data-bind="text: payment"></span></br>
Already Paid: <span data-bind="text: paid"></span></br>
Advance Payment: <input type="text" data-bind="value: advancedPay" /></br>
<button data-bind="click: saveCheckin">Submit</button></br>

{{ HTML::link('admin/checkin/addpayment', 'Add a Payment to an exsisting Check in') }}

@if(Session::has('message'))
	<p class="text-success">{{ Session::get('message') }}</p>
@endif

<script type="text/javascript" src="{{url()}}/js/checkin.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	window.onload = function() {
		//load only the booking ID

		var foo;
		var checkArr;
		sendRequestToServerPost('/admin/checkin/onload', foo, function(res) {
			if(res) {
				checkArr = JSON.parse(res);
				checkinView.bookingID(checkArr.booking_id);
				checkinView.payment(checkArr.payment);
				var 
				checkinView.paid(checkArr.paid);
			}
		});
	}

	var checkinView = new Checkin();
	ko.applyBindings(checkinView);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop