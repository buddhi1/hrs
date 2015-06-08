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
</div>
	</tr>
	<tr>	
		
	</tr>
	
</table>

<div>
	@if(Session::has('booking_id'))
		{{ Session::get('room_type_id') }}
		{{ Session::get('no_of_rooms') }}
		{{ Session::get('no_of_adults') }}
		{{ Session::get('no_of_kids') }}
		{{ Session::get('services') }}
		{{ Session::get('total_charges') }}
		{{ Session::get('paid_amount') }}	
		@if( Session::get('check_in' ) == 0 )
			{{ Form::open(array('url'=>'admin/checkin/create', 'method'=>'GET')) }}
				{{ Form::hidden('booking_id', Session::get('booking_id')) }}
				{{ Form::hidden('identification_no', Session::get('identification_no')) }}
				{{ Form::hidden('check_in', Session::get('check_in')) }}
				{{ Form::hidden('check_out', Session::get('check_out')) }}
								
				{{ Form::submit('Mark Checkin') }}	
			{{ Form::close() }}
		@elseif( Session::get('check_out' ) == 0 )
			{{ Form::open(array('url'=>'admin/checkin/edit', 'method'=>'GET')) }}
				{{ Form::hidden('booking_id', Session::get('booking_id')) }}
				{{ Form::hidden('identification_no', Session::get('identification_no')) }}
				{{ Form::hidden('check_in', Session::get('check_in')) }}
				{{ Form::hidden('check_out', Session::get('check_out')) }}
				
							
				{{ Form::submit('Mark Checkout') }}
			{{ Form::close() }}			
			
		@endif
	@endif
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