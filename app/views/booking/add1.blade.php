@extends('layouts.main')

@section('content')
Identification No: 
<input type="text" data-bind="value: identificationNo" name="id_no"  required />
</br>

Start Date: 
<input type="text" data-bind="value: startDate" name="start_date"  required />
</br>

End Date: 
<input type="text" data-bind="value: endDate" name="end_date"  required />
</br>

No of Adults: 
<input type="text" data-bind="value: noOfAdults" name="no_of_adults"  required />
</br>

No of Kids: 
<input type="text" data-bind="value: noOfKids" name="no_of_kids"  required />
</br>

No of Rooms: 
<input type="text" data-bind="value: noOfRooms" name="no_of_rooms"  required />
</br>

Promo Code: 
<input type="text" data-bind="value: promoCode" name="promo_code"  required />
</br>

<button onclick="checkAvailability()">Check Availability</button>

</br></br>
Room Types: 
<select data-bind="options: roomType, selectedOptions: chosenRoomType, optionsText: function(item) {return item.name }, event: { change: sevicesDrop }" name="room_type" id="room_type" required></select>

Services: 
<select data-bind="options: services, selectedOptions: chosenService, optionsText: function(item) {return item.name }" name="services" id="services" required></select>

Paid Amount: <select type="text" data-bind="options: paidAmount, selectedOptions: chosenAmount, optionsText: function(item) {return item.name }" name="paid_amount"  required></select>
</br>
<button onclick="saveBooking()">Place Booking</button>
@if(Session::has('message'))

	<p class="text-success">{{ Session::get('message') }}</p>

@endif



<script type="text/javascript" src="{{url()}}/js/booking.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	var bookingFirst = new Booking();
	ko.applyBindings(bookingFirst);
	
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop