@extends('layouts.main')

@section('content')

Booking ID: 
<input type="text" data-bind="value: id" name="id"  required />
</br>

<button data-bind="click: deleteBooking">Delete</button>
<script type="text/javascript" src="{{url()}}/js/booking.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';

	var bookingDel= new Booking();
	ko.applyBindings(bookingDel);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>

@if(Session::has('message'))

	<p class="text-success">{{ Session::get('message') }}</p>

@endif

@stop