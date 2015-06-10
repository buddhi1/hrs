@extends('layouts.main')

@section('content')

<h2>Search booking</h2>

@if( Session::has('message') )
	{{ Session::get('message') }}
@endif
<table border="1">
	<tr>
		<th>Checkin Id</th>
		<th>Booking Id</th>
		<th>Authorizer</th>
		<th>Check in</th>
		<th>Check out</th>
		<th>Advace payment</th>
		<th>Payments</th>
		<th>Add a Payment</th>
	</tr>
</table>
<div data-bind="foreach: checkins">
	<span data-bind="text: id"></span>||
	<span data-bind="text: bookingID"></span>||
	<span data-bind="text: authorizer"></span>||
	<span data-bind="text: checkin"></span>||
	<span data-bind="text: checkout"></span>||
	<span data-bind="text: advancedPay"></span>||
	<span data-bind="text: payment"></span>
	<button data-bind="click: addPayment">Add</button>
	</br>
</div>

<script type="text/javascript" src="{{url()}}/js/checkin.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	window.onload = function() {
		//load only the booking ID

		var foo;
		var checkArr;
		sendRequestToServerPost('/admin/checkin/index', foo, function(res) {
			if(res) {
				var checkArr = JSON.parse(res);
				for(var ind in checkArr) {
					var checkinView = new Checkin();

					checkinView.id(checkArr[ind].id);
					checkinView.bookingID(checkArr[ind].booking_id);
					checkinView.authorizer(checkArr[ind].authorizer);
					checkinView.checkin(checkArr[ind].check_in);
					checkinView.checkout(checkArr[ind].check_out);

					var payArr = JSON.parse(checkArr[ind].payment);

					var advPay = parseFloat(payArr[0])+parseFloat(payArr[1]);
					checkinView.advancedPay(advPay);

					var payTotal = 0;
					for (var i = 0; i < payArr.length; i++) {
						payTotal += parseFloat(payArr[i]);
					};
					checkinView.payment(payTotal);
					checkinInd.checkins.push(checkinView);
				}
			}
		});
	}

	var checkinInd = new CheckinIndex();
	ko.applyBindings(checkinInd);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop