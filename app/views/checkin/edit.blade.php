@extends('layouts.main')

@section('content')

Booking ID: <input type="text" data-bind="value: bookingID" /></br>
Check out: <input type="checkbox" data-bind="checked: checkout" /></br>
Payments so far: <span data-bind="text: paid" ></span></br>
Payment: <input type="text" data-bind="value: payment" /></br>
<button data-bind="click: saveCheckin">Submit</button></br>

{{ HTML::link('admin/checkin/addpayment', 'Add a Payment to an exsisting Check in') }}

@if(Session::has('message'))

	<p class="text-success">{{ Session::get('message') }}</p>

@endif

<script type="text/javascript" src="{{url()}}/js/checkin.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	window.onload = function() {
		//load booking ID and payments so far values

		var foo;
		var checkArr;

		sendRequestToServerPost('/admin/checkin/edit', foo, function(res) {
			if(res) {
				checkArr = JSON.parse(res);
				checkinView.bookingID(checkArr.booking_id);
				checkinView.paid(checkArr.payments);
			}
		});
	}

	var checkinView = new Checkin();
	ko.applyBindings(checkinView);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>

@stop