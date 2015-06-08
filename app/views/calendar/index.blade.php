@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif

<div data-bind="foreach: roomArray">					
	<div><label data-bind="text: roomType"></label></div>
	<div><label data-bind="text: service"></label></div>
	
	<div data-bind="foreach: $root.calendarRecArray">
		<ul>
			<!-- ko if: $parent.roomType() == roomType() && $parent.service() == service() -->
			<li>Duration: <label data-bind="text: from"></label> to <label data-bind="text: to"></label></li>
			<li>Price: <label data-bind="text: price"></label></li>
			<li>Discount rate: <label data-bind="text: discount"></label></li>
			<li>
				<button data-bind="">Delete</button>
			</li>
			<li>
				<button data-bind="click: $root.loadSavedCalendar">Edit</button>	
			</li>
			<!-- /ko -->
		</ul>					
	</div>		
	<div><button data-bind="click: $root.loadSavedCalendarTimeline">Edit timeline</button> </div>
 	<div><button>Delete timeline</button> </div>		
</div>	

 
 <script type="text/javascript" src="{{url()}}/js/calendar.js"></script>
 <script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
 <script type="text/javascript">
 	http_url = '{{url()}}';
 	rooms = {{ $rooms }};
 	calendar = {{ $calendar }};

	window.onload = function(){
 		loadCalendar();
	}
 	
 	var calendarArray = new Calendar();

 	ko.applyBindings(calendarArray); 	
 </script>

@stop


	<!-- @for($i=date("m",strtotime($start_date)); $i <= date("m",strtotime($end_date)); $i++)
		<th>{{ date("F",strtotime($start_date))  }}</th>
		<?php
			$start_date = date("F",strtotime($start_date. '+1 month'));
		?>
	@endfor	 -->
