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

<table border="1">
	<tr>
		<th>Room type</th>
		<th>Description</th>	
		<th colspan="2">Edit/Delete</th>	
	</tr>
	<?php //var_dump($calendar); //die(); ?>
		<div id="promotion-container">
			<!-- foreach($rooms as $room) -->
			<div data-bind="foreach: ">			
				<td><label data-bind="text: room_id"></label></td>
				<td>
					<table>
						<tr>
							<div data-bind="foreach: ">
							<!-- foreach($calendar as $type) -->
							<td> 
								<ul>
									@if($room->room_type_id == $type->room_type_id)
									<li>Duration: <label data-bind="text: from"></label> to <label data-bind="text: to"></label></li>
									<li>Services: <label data-bind=""></label>{{ implode(",",json_decode($type->services)) }} </li>
									<li>Price:<label data-bind="text: price"></label></li>
									<li>Discount rate:<label data-bind="text: discount"></label></li>
									<li>No. of days:<label data-bind="text: stays"></label></li>
									<li>
										{{ Form::open(array('url'=>'admin/promotion/destroy')) }}	
										<input type="hidden" data-bind="text: room_id" />{{ Form::hidden('room_id',$type->room_type_id) }}
										<input type="hidden" data-bind="text: " />{{ Form::hidden('services', $type->services) }}
										<input type="hidden" data-bind="text: to" />
				 						<button data-bind="click: ">Delete</button>{{ Form::submit('Delete') }}		
										{{ Form::close() }}
									</li>
									<li>
										{{ Form::open(array('url'=>'admin/promotion/edit')) }}
										<input type="hidden" data-bind="" />{{ Form::hidden('id',$type->id) }}
										<input type="hidden" data-bind="" />{{ Form::hidden('date',$type->end_date) }}
										<button data-bind="">Edit</button>{{ Form::submit('Edit') }} 
										{{ Form::close() }}	
									</li>
									@endif
								</ul>
							</td>
							</div>
						</div>
					</tr>
				</table>
			</td>
			{{ Form::open(array('url'=>'admin/promotion/edittimeline')) }}
				<input type="hidden" data-bind="" />{{ Form::hidden('room_id',$room->room_type_id) }}
				{{-- Form::hidden('service_id',$room->service_id) --}}
			<td>	{{ Form::submit('Edit time line') }} </td>
			{{ Form::close() }}			
			
			{{ Form::open(array('url'=>'admin/promotion/destroytimeline')) }}	
				<input type="hidden" data-bind="" />{{ Form::hidden('room_id',$room->room_type_id) }}
		 		<td>{{ Form::submit('Delete time line') }} </td>		
			{{ Form::close() }}
						
		</tr>		
		</div>
		

		
</table>

 <script type="text/javascript" src="{{url()}}/js/promotion.js"></script>
 <script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
 <script type="text/javascript">
 	rooms = {{ $rooms[0]->id }};
 	console.log(rooms);
 	//calendar = {{-- $calendar --}};
 </script>
@stop


<!-- @for($i=date("m",strtotime($start_date)); $i <= date("m",strtotime($end_date)); $i++)
	<th>{{ date("F",strtotime($start_date))  }}</th>
	<?php
		//$start_date = date("F",strtotime($start_date. '+1 month'));
	?>
@endfor -->	
