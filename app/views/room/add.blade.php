@extends('layouts.main')

@section('content')

	<h3>Add a New Room Type</h3>
	<form action="{{url()}}/admin/room/create">
	<table>
		<div id="room-container">
		<tr>
			<td><label>Room name</label></td>
			<td><input required="required" name="name" /></td>
		</tr>

		<tr>
			<td><label>No of rooms</label></td>
			<td><input name="no_of_room" required="required"></td>
		</tr>
		<tr>
			<td colspan = "2" align = "right"><button data-bind="click: add Room">Add new room</button></td>
		</tr>
		</div>
		<tr>
			<td>
				<strong>Facilities</strong>
				<div id="facility-container">
					<div data-bind="foreach: facilityArray">
						<div>
							<input type="checkbox" name="facility[]"  data-bind="value: name" />
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
							<input type="checkbox" name="service[]" />
							<label data-bind="text: name"></label>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
	</form>

	@if(Session::has('room_message_add'))

		<p>{{ Session::get('room_message_add') }}</p>
		
	@endif


<script type="text/javascript">
	http_url = '{{url()}}';
	services = {{$services}};
	facilities = {{$facilities}};
</script>
<script type="text/javascript" src="{{url()}}/js/room.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop