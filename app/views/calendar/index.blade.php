@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif
<table border="1">
	<tr>
		<th>Room type</th>
		<th>Service</th>
		<th>Start date</th>	
		<th>End date</th>
		<th>Price</th>
		<th>Discount rate</th>
		<th>No. of days</th>
		<th colspan="2">Edit/Delete</th>	
	</tr>
	
		@foreach($calendar as $type)
		<tr>			
			<td> {{ $type->room_type_id }}</td>
			<td> {{ $type->service_id }}</td>
			<td> {{ $type->start_date }}</td>
			<td> {{ $type->end_date }}</td>
			<td> {{ $type->price }}</td>
			<td> {{ $type->discount_rate }}</td>
			<td> {{ $type->days }} </td>
			{{ Form::open(array('url'=>'admin/calendar/edit')) }}
				{{ Form::hidden('id',$type->id) }}
				{{ Form::hidden('date',$type->end_date) }}
			<td>	{{ Form::submit('Edit') }} </td>
			{{ Form::close() }}			
			
			{{ Form::open(array('url'=>'admin/calendar/destroy')) }}	
				{{ Form::hidden('room_id',$type->room_type_id) }}
				{{ Form::hidden('date',$type->end_date) }}
		 		<td>{{ Form::submit('Delete') }} </td>		
			{{ Form::close() }}
						
		</tr>
		@endforeach
</table>



@stop


	@for($i=date("m",strtotime($start_date)); $i <= date("m",strtotime($end_date)); $i++)
		<th>{{ date("F",strtotime($start_date))  }}</th>
		<?php
			$start_date = date("F",strtotime($start_date. '+1 month'));
		?>
	@endfor	
