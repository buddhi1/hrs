@extends('layouts.main')

@section('content')

<h3>Edit Promo Code</h3>
@if(Session::has('room_message_add'))
	<p>{{ Session::get('room_message_add') }}</p>	
@endif

<div id="room-container">
	Room Type: <label data-bind="text: name"></label>
</div>
<div id="service-container">
	Services:
	<div data-bind="foreach: serviceArray">
		<div>
			<input type="checkbox" data-bind="click: toggleCheckbox, checked: state" />
			<label data-bind="text: name"></label>
		</div>
	</div>
</div>
<div id="promo-container">
	<div>
		Promo Code: <label data-bind="text: code"></label>
	</div>
	<div>
		Start Date: <input data-bind="value: from" id="from" />
	</div>
	<div>
		End Date: <input data-bind="value: to" id="to" />
	</div>
	<div>
		Price: <input data-bind="value: price" id="price" />
	</div>
	<div>
		Stays: <input data-bind="value: stays" id="stays" />
	</div>
	<div>
		No of Rooms: <input data-bind="value: rooms" id="rooms" />
	</div>
	<div>
		<button data-bind="click: saveEditedPromo">Save changes</button>
	</div>
</div>


<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>
<script type="text/javascript" src="{{url()}}/js/promo.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	roomTypes= {{$roomTypes}};
	services = {{$services}};
	promo = {{$promo}};

	window.onload = function(){
		loadServices();
		loadPromo();
	}

	var allServices = new ServiceArray();
	var roomType = new Room();
	var currPromo = new Promo();

	ko.applyBindings(roomType, document.getElementById('room-container'));
	ko.applyBindings(allServices, document.getElementById('service-container'));
	ko.applyBindings(currPromo, document.getElementById('promo-container'));
</script>	

@stop