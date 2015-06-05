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
			<label data-bind=""></label>
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
			<td><label>Start date</label></td>
			<td>
				<input data-bind="value: from" required="required" id="from" />
				<label>End date</label>
				<input data-bind="value: to" required="required" id="to" />
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
			<td colspan="2" align="center"><button data-bind="click: editSavedPromotionTimeline">Save changes</button></td>
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
 	room_name = {{$room_name}};

 	$(function() {
	    $( "#from" ).datepicker({
	      defaultDate: "",
	      changeMonth: true,
	      numberOfMonths: 2,
	      onClose: function( selectedDate ) {
	        $( "#from" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	        $( "#to" ).datepicker( "option", "minDate", selectedDate);
	      }
	    });
	    $( "#to" ).datepicker({
	      defaultDate: "",
	      changeMonth: true,
	      numberOfMonths: 2,
	      onClose: function( selectedDate ) {
	        $( "#to" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
	      }
	    });
	  });

 	window.onload = function(){
 		loadPromotion();
		loadServices();		
	}

 	var allServices = new ServiceArray();
 	var allRoomTypes = new RoomTypeArray();
 	var currPromotion = new Promotion();	
	
	ko.applyBindings(currPromotion, document.getElementById('promotion-container'));
	ko.applyBindings(allServices, document.getElementById('service-container'));
	ko.applyBindings(allRoomTypes, document.getElementById('room-types'));
 </script>
@stop



