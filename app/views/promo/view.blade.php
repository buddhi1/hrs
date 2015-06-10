@extends('layouts.main')

@section('content')
<h3>All Promo Codes</h3>
@if(Session::has('promo_message'))
	<p>{{ Session::get('promo_message') }}</p>

@endif
	

	<table border = "1">
		<tr>
			<th>Promo Code</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Price</th>
			<th>Stays</th>
			<th>Room Type</th>
			<th>No of Rooms</th>
			<th>Services</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</table>
	<div data-bind="foreach: promoArray">
		<label data-bind="text: code"></label>
		<label data-bind="text: from"></label>
		<label data-bind="text: to"></label>
		<label data-bind="text: price"></label>
		<label data-bind="text: stays"></label>
		<label data-bind="text: room_name"></label>
		<label data-bind="text: rooms"></label>
		<label data-bind="text: services"></label>
		<button data-bind="click: $parent.loadEditSavedPromo" >Edit</button>
		<button data-bind="click: $parent.deleteSavedPromo" >Delete</button>
	</div>


<script type="text/javascript" src="{{url()}}/js/promo.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	roomTypes= {{$roomTypes}}
	promos = {{$promos}};

	window.onload = function(){
		loadPromos();
	}

	var allPromo = new PromoArray();

	ko.applyBindings(allPromo);
</script>	

@stop