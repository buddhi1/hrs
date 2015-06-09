@extends('layouts.main')

@section('content')

<h2>Room price calendar</h2>
		
@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif
		
	
	
<div id="room-types">
	<label>Room type</label>
	<select data-bind="options: roomTypeArray, selectedOptions: selected, optionsText: function(item) {return item.name }"></select>
</div>

<div id="services">
	<label>Service</label>
	<select data-bind="options: serviceArray, selectedOptions: selected, optionsText: function(item) {return item.name }"></select>
</div>		
	
<div id="calendar-rec">
	<div>
		<label>Start Date</label>
	
		<input data-bind="value: from" id="from" /> 
		<label>End date</label>
 		<input data-bind="value: to" id="to" />
	</div>
	<div>
		<label>Room price</label>
		<input data-bind="value: price" id="price" /> 
	</div>
	<div>
		<label>Discount Rate</label>
		<input data-bind="value: discount" id="discount" /> 
	</div>
	<div><button data-bind="click: addCalendareRec">Add to Calendar</button></div>
</div>


<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
 <script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>
 <script type="text/javascript" src="{{url()}}/js/calendar.js"></script>
 <script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
 <script type="text/javascript">
 	http_url = '{{url()}}';
 	roomTypes = {{$roomTypes}};
 	services = {{$services}};

	window.onload = function(){
 		loadRoomTypes();
 		loadServices();
	}

 	var allRoomTypes = new RoomTypeArray();
 	var allServices = new ServiceArray();
 	var calendarRec = new CalendarRec();

 	ko.applyBindings(calendarRec, document.getElementById('calendar-rec'));
 	ko.applyBindings(allServices, document.getElementById('services'));
 	ko.applyBindings(allRoomTypes, document.getElementById('room-types'));
 </script>
@stop