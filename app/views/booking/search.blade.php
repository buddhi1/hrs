@extends('layouts.main')

@section('content')

<h2>Search booking</h2>
<div>
	@if(Session::has('message'))
		{{ Session::get('message') }}
	@endif
</div>
<div id="search_booking">
	<input type="text" name="booking_id" data-bind="value: id" />
	<button data-bind="click: searchBookingByID">Search by booking id</button>
</div>	
<div id="search_user">
	<input type="text" name="id" data-bind="value: userID" />
	<button data-bind="click: searchBookingByUserID">Search by identification no</button>
</div>
<div id="search_result">
	Rooom Type ID:<div data-bind="text: chosenRoomType"></div>
	No. of Rooms:<div data-bind="text: noOfRooms"></div>
	No. of Adults:<div data-bind="text: noOfAdults"></div>
	No. of Kids:<div data-bind="text: noOfKids"></div>
	Service:<div data-bind="text: chosenService"></div>
	Total Charge:<div data-bind="text: totalPrice"></div>
	Paid Amount:<div data-bind="text: chosenAmount"></div>

	<button data-bind="style: { visibility: checkIn() === null ? 'visible' : 'hidden' }, click: markCheckin">Mark Checkin</button></br>
	<button data-bind="style: { visibility: checkOut() === null && checkIn() !== null ? 'visible' : 'hidden' }, click: markCheckout">Mark Checkout</button>
</div>
<script type="text/javascript" src="{{url()}}/js/booking.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	var searchBooking = new SearchByID();
	ko.applyBindings(SearchByID, document.getElementById('search_booking'));

	var searchUser = new SearchByUserID();
	ko.applyBindings(SearchByUserID, document.getElementById('search_user'));
	
	var searchResult = new Booking();
	ko.applyBindings(searchResult, document.getElementById('search_result'));
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop