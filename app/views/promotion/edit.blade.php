@extends('layouts.main')

@section('content')

<h2>Promotion calendar</h2>

	@if($errors->has())
	<div>
		<p>Following errors occured:</p>
		<ul>
			@foreach($errors->all() as $error)
				<li>{{$error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	
	@if(Session::has('message'))
		<div>{{ Session::get('message') }}</div>
	@endif

	<div>
				
		<div id="room-types">
			<label>Room type</label>
			<label data-bind="text: name"></label>
		</div>		
	</div>
	<div>		
		<div id="service-container">
			<label>Service</label>	 
			<div data-bind="foreach: serviceArray">
				<div>
					<input type="checkbox" data-bind="checked: state, click: $parent.toggleCheckbox">
					<label data-bind="text: name"></label>
				</div>
			</div>
		</div>		
	</div>

<div id="promotion-container">
	<table>
		<tr>			
			<td><label>Room type</label></td>
			<td><label data-bind="text: room_name"></label></td>
		</tr>
		<tr>
			<td><label>Start date</label></td>
			<td>
				<label data-bind="text: from" id="from"></label>
				<label> End date </label>
				<label data-bind="text: to" id="to"></label>				
			</td>
		</tr>
		<tr>
			<td><label>Number of stays</label></td>
			<td><input data-bind="value: stays" required="required" id="stays" /></td>
		</tr>
		<tr>
			<td><label>Number of room booked</label></td>
			<td><input data-bind="value: rooms" required="required" id="rooms" /></td>
		</tr>
		<tr>
			<td><label>Room price</label></td>
			<td><input data-bind="value: price" required="required" id="price" /></td>
		</tr>
		<tr>
			<td><label>Discount rate</label></td>
			<td><input data-bind="value: discount" required="required" id="discount" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><button data-bind="click: $root.editSavedPromotion">Save changes</button></td>
		</tr>
	</table>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
 
 <script type="text/javascript" src="{{url()}}/js/promotion.js"></script>
 <script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
 <script type="text/javascript">
 	http_url = '{{url()}}';
 	services = {{$services}};
 	promotion = {{$promotion}};
 	roomTypes = {{$roomTypes}};
 	room_name = {{$room_name}};

 	
 	window.onload = function(){
 		loadPromotion();
		loadServices();	
		loadRoomTypes();	
	}

 	var allServices = new ServiceArray();
 	var allRoomTypes = new RoomTypeArray();
 	var currPromotion = new Promotion();	
	
	ko.applyBindings(currPromotion, document.getElementById('promotion-container'));
	ko.applyBindings(allServices, document.getElementById('service-container'));
	ko.applyBindings(allRoomTypes, document.getElementById('room-types'));
 </script>
@stop



