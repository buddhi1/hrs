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
<table data-bind="foreach: cartItems">
	<tr>
		<td data-bind="text: chosenRoomType"></td>
		<td data-bind="text: chosenRoomType"></td>
		<td data-bind="text: noOfRooms"></td>
		<td data-bind="text: noOfAdults"></td>
		<td data-bind="text: noOfKids"></td>
		<td data-bind="text: chosenService"></td>
		<td data-bind="text: chosenAmount"></td>
		<td data-bind="text: promoCode"></td>
		<td data-bind="text: totalPrice"></td>
		<td><button data-bind="click: removeItem">Remove Product</button></td>
	</tr>
</table>

{{ HTML::link('booking/booking1', 'Place Another Booking') }}

<button onclick="finishBooking()">Finish Booking</button>

@stop