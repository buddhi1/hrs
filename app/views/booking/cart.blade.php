@extends('layouts.main')

@section('content')

<table border = "1">
	<tr>
		<th>Room ID</th>
		<th>Room Name</th>
		<th>No of Rooms</th>
		<th>No of Adults</th>
		<th>No of Kids</th>
		<th>Service ID</th>
		<th>Paid Amount</th>
		<th>Promo Code</th>
		<th>Total Price</th>
		<th>Delete</th>
	</tr>
</table>
<div data-bind="foreach: cartItems">
	<div data-bind="foreach: roomType">
		<div data-bind="text: id"></div>
		<div data-bind="text: name"></div>
	</div>
	<div data-bind="text: noOfRooms"></div>
	<div data-bind="text: noOfAdults"></div>
	<div data-bind="text: noOfKids"></div>
	<div data-bind="text: chosenService"></div>
	<div data-bind="text: paidAmount"></div>
	<div data-bind="text: promoCode"></div>
	<div data-bind="text: totalPrice"></div>
	<div><button data-bind="click: removeItem">Remove Product</button></div>
</div>

{{ HTML::link('booking/booking1', 'Place Another Booking') }}

<button onclick="finishBooking()">Finish Booking</button>
<script type="text/javascript" src="{{url()}}/js/booking.js"></script>
<script type="text/javascript">
	window.onload = function() {
		//load current cart items
		http_url = '{{url()}}';
		var foo;
		var cartArr;
		sendBookingToServerPost('/admin/booking/cart', foo, function(res){
		    if(res) {
		    	cartArr = JSON.parse(res);
		    	for(i in cartArr) {
		    		var booking = new Booking();
		    		booking.id(i);
		    		var room = new RoomTypes();
		    		room.id(cartArr[i].id);
		    		room.name(cartArr[i].name);
		    		booking.roomType.push(room);
		    		booking.noOfRooms(cartArr[i].quantity);
		    		booking.totalPrice(cartArr[i].price);
	    			booking.noOfAdults(cartArr[i].options.no_of_adults);
		    		booking.noOfKids(cartArr[i].options.no_of_kids);
		    		booking.promoCode(cartArr[i].options.promo_code);
		    		booking.chosenService(cartArr[i].options.services);
		    		booking.paidAmount(cartArr[i].options.paid_amount);

		    		bookingIndex.cartItems.push(booking);
		    	}
		    } 
		    // else if(res === 'failure') {
		    //   window.location = http_url+"/admin/booking/booking1";
		    // }
	  	});
	}

  	var bookingIndex= new BookingDisplay();
	ko.applyBindings(bookingIndex);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop