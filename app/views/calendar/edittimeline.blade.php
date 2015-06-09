@extends('layouts.main')

@section('content')

<h2>Edit Room price calendar record</h2>

	
@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif

<div>
	Room type: <label data-bind="text: roomType"></label>
</div>	
<div>
	Service: <label data-bind="text: service"></label>
</div>
<div>
	Start_date: <input data-bind="value: from" id="from" /> End date: <input data-bind="value: to" id="to" />
</div>
<div>
	Room price: <input data-bind="value: price" id="price" />
</div>
<div>
	Discount rate: <input data-bind="value: discount" id="discount" />
</div>
<div>
	<button data-bind="click: saveEditedCalendarTimeline">Update timeline</button>
</div>

 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>
<script type="text/javascript" src="{{url()}}/js/calendar.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
 <script type="text/javascript">
 	http_url = '{{url()}}';
 	room = {{ $room_type_id }};
 	service = {{ $service_id }};
 	s_date = '{{$start->start_date}}';
 	e_date = '{{$end->start_date}}';

	window.onload = function(){
 		loadCalendarTimeline();
	}
 	
 	var calendarRec = new CalendarRec();

 	ko.applyBindings(calendarRec); 	
 </script>

@stop