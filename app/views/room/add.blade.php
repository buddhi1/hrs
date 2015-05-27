@extends('layouts.main')

@section('content')

	<h3>Add a New Room Type</h3>
	
	<div id="room-container">
		<div>
			<label>Room name</label>
			<input data-bind="value: name" type="text" required="required"  />
		</div>
		<div>
			<label>No of rooms</label>
			<input type="text" data-bind="value: no_of_rooms" required="required">
		</div>
		<div>
			<button data-bind="click: addRoom">Add new room</button>
		</div>
	</div>
	<table>		
		<tr>
			<td>
				<strong>Facilities</strong>
				<div id="facility-container">
					<div data-bind="foreach: facilityArray">
						<div>
							<input type="checkbox" data-bind="click: toggleCheckbox" />
							<label data-bind="text: name"></label>
						</div>
					</div>
				</div>
			</td>		
			<td>
				<strong>Services</strong><br>
				<div id="service-container">
					<div data-bind="foreach: serviceArray">
						<div>
							<input type="checkbox" data-bind="click: toggleCheckbox" />
							<label data-bind="text: name"></label>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
	

	@if(Session::has('room_message_add'))

		<p>{{ Session::get('room_message_add') }}</p>
		
	@endif


<script type="text/javascript">
	http_url = '{{url()}}';
	services = {{$services}};
	facilities = {{$facilities}};

	window.onload = function(){
		loadFacilities();
		loadServices();
	}

	var savedRooms = new RoomArray();

	ko.applyBindings(savedRooms, document.getElementById('rooms-container'));
</script>
<script type="text/javascript" src="{{url()}}/js/room.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop