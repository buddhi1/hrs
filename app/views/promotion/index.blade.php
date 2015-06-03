@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif

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

	
<div id="promotion-container">
	<!-- foreach($rooms as $room) -->
	<div data-bind="foreach: roomArray">			
		<label data-bind="text: id"></label>
		Services: 
		<div data-bind="foreach: services">
			<label data-bind="text: name"></label>{{-- implode(",",json_decode($type->services)) --}}
		</div>				
		<div data-bind="foreach: $parent.promotionArray">
		<!-- foreach($calendar as $type) -->		
			<ul>
				<!-- if($room->room_type_id == $type->room_type_id) -->
				<li>Duration: <label data-bind="text: from"></label> to <label data-bind="text: to"></label></li>
				
								
				<li>Price:<label data-bind="text: price"></label></li>
				<li>Discount rate:<label data-bind="text: discount"></label></li>
				<li>No. of days:<label data-bind="text: stays"></label></li>
				<li>
					<form>{{-- Form::open(array('url'=>'admin/promotion/destroy')) --}}	
						<input type="hidden" data-bind="text: room_id" />{{-- Form::hidden('room_id',$type->room_type_id) --}}
						<input type="hidden" data-bind="" />{{-- Form::hidden('services', $type->services) --}}
						<input type="hidden" data-bind="text: to" />
 						<button data-bind="click: ">Delete</button>{{-- Form::submit('Delete') --}}		
					</form>
					{{-- Form::close() --}}
				</li>
				<li>
					<form>{{-- Form::open(array('url'=>'admin/promotion/edit')) --}}
					<input type="hidden" data-bind="" />{{-- Form::hidden('id',$type->id) --}}
					<input type="hidden" data-bind="" />{{-- Form::hidden('date',$type->end_date) --}}
					<button data-bind="">Edit</button>{{-- Form::submit('Edit') --}} 
					</form>
					{{-- Form::close() --}}	
				</li>
				<!-- endif -->
			</ul>			
		</div>				

	{{-- Form::open(array('url'=>'admin/promotion/edittimeline')) --}}
		<input type="hidden" data-bind="" />{{-- Form::hidden('room_id',$room->room_type_id) --}}
		{{-- Form::hidden('service_id',$room->service_id) --}}
		<button data-bind="">Edit timeline</button>{{-- Form::submit('Edit time line') --}} 
	{{-- Form::close() --}}			
	
	{{-- Form::open(array('url'=>'admin/promotion/destroytimeline')) --}}	
		<input type="hidden" data-bind="" />{{-- Form::hidden('room_id',$room->room_type_id) --}}
 		<button data-bind="">Delete timeline</button>{{-- Form::submit('Delete time line') --}} 		
	{{-- Form::close() --}}
	</div>				
</div>


 <script type="text/javascript" src="{{url()}}/js/promotion.js"></script>
 <script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
 <script type="text/javascript">
 	http_url = '{{url()}}';
 	rooms = {{$rooms}};
 	calendar = {{$calendar}};

 	window.onload = function(){
 		loadPromotions();
 	} 	

	var promotions = new PromotionArray();	
	
	ko.applyBindings(promotions);
 </script>
@stop


<!-- @for($i=date("m",strtotime($start_date)); $i <= date("m",strtotime($end_date)); $i++)
	<th>{{ date("F",strtotime($start_date))  }}</th>
	<?php
		//$start_date = date("F",strtotime($start_date. '+1 month'));
	?>
@endfor -->	
