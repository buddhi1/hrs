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
	
		<div id="promotion-container">
			@foreach($rooms as $room)
						
				<td><label data-bind=""></label> {{ $room->room_type_id }}</td>
				<td>
					<table>
						<tr>
							@foreach($calendar as $type)
							<td> 
								<ul>
									@if($room->room_type_id == $type->room_type_id)
									<li>Duration: <label data-bind=""></label>{{ $type->start_date." to ".$type->end_date }} </li>
									<li>Services: <label data-bind=""></label>{{ implode(",",json_decode($type->services)) }} </li>
									<li>Price:<label data-bind=""></label>{{ $type->price }}</li>
									<li>Discount rate:<label data-bind=""></label>{{ $type->discount_rate }}</li>
									<li>No. of days:<label data-bind=""></label>{{ $type->days }}</li>
									<li>
										{{ Form::open(array('url'=>'admin/promotion/destroy')) }}	
										<input type="hidden" data-bind="" />{{ Form::hidden('room_id',$type->room_type_id) }}
										<input type="hidden" data-bind="" />{{ Form::hidden('services', $type->services) }}
										<input type="hidden" data-bind="" />{{ Form::hidden('date',$type->end_date) }}
				 						<button data-bind="">Delete</button>{{ Form::submit('Delete') }}		
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
							@endforeach
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
		@endforeach
		

		
</table>



@stop


<!-- @for($i=date("m",strtotime($start_date)); $i <= date("m",strtotime($end_date)); $i++)
	<th>{{ date("F",strtotime($start_date))  }}</th>
	<?php
		//$start_date = date("F",strtotime($start_date. '+1 month'));
	?>
@endfor -->	
