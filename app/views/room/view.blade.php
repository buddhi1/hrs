@extends('layouts.main')

@section('content')

	<h3>All Rooms</h3>

	<table border = "1">
		<tr>
			<th>Room Name</th>
			<th>Room Facilities</th>
			<th>Room Services</th>
			<th>No of Rooms</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	
	</table>
	<div id="rooms-container" data-bind="foreach: roomArray">
		<div>
			<label data-bind="text: name"></label>
			<input type="hidden" data-bind="text: id" id="room_id">
			<label data-bind="text: facilities"></label>
			<label data-bind="text: services"></label>
			<label data-bind="text: no_of_rooms"></label>
			<button data-bind="click: $parent.loadEditSavedRoom">Edit</button>
			<button data-bind="click: $parent.deleteSavedRoom">Delete</button>
		</div>
	</div>
	@if(Session::has('room_message_del'))

		<p>{{ Session::get('room_message_del') }}</p>
	
	@endif

	@if(Session::has('room_message_add'))

		<p>{{ Session::get('room_message_add') }}</p>
	
	@endif

<script type="text/javascript" src="{{url()}}/js/room.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	rooms = {{$rooms}};
	

	window.onload = function(){		
		loadRooms();
	}
	
	var savedRooms = new RoomArray();

	ko.applyBindings(savedRooms, document.getElementById('rooms-container'));
</script>

@stop