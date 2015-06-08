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
	Start date: <label data-bind="text: from"></label> End date: <label data-bind="text: to"></label>
</div>
<div>
	Room price: <input data-bind="value: price" id="price" />
</div>
<div>
	Discount rate: <input data-bind="value: discount" id="discount" />
</div>
<div><button data-bind="click: saveEditedCalendarRecord">Update calendar record</button> </div>

 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>
<script type="text/javascript" src="{{url()}}/js/calendar.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
 <script type="text/javascript">
 	http_url = '{{url()}}';
 	record = {{$record}};

	window.onload = function(){
 		loadCalendarRec();
	}

 	var calendarRec = new CalendarRec();

 	ko.applyBindings(calendarRec);
 </script>

@stop