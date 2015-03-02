@extends('layouts.main')

@section('content')

<h2>Edit Room price calendar record</h2>
<table>
	{{ Form::open(array('url'=>'/admin/calendar/updatetimeline')) }}
	<tr>
		<td clospan="2"> 
			@if(Session::has('message'))
				<h3>{{ Session::get('message') }}</h3>
			@endif
		 </td>
	</tr>
	<?php

		$room_type_id = Input::get('room_id');
		$service_id = Input::get('service_id');

		$start = DB::table('room_price_calenders')
			->where('room_type_id','=',$room_type_id)
			->where('service_id','=',$service_id)
			->orderBy('start_date')
			->first();
		$end= DB::table('room_price_calenders')
			->where('room_type_id','=',$room_type_id)
			->where('service_id','=',$service_id)
			->orderBy('start_date', 'DESC')
			->first();


	?>
	{{ Form::hidden('sdate',$start->start_date) }}
	{{ Form::hidden('edate',$end->end_date) }}
	<tr>
		<td> {{ Form::label('lbluname', 'Room type') }} </td>
		<td> {{ Form::text('room_id', $room_type_id, array('readonly')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblservice', 'Service') }} </td>
		<td> {{ Form::text('service_id', $service_id, array('readonly')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblfrom', 'Start date') }} </td>
		<td>
			{{ Form::text('from', $start->start_date, array('required', 'id'=>'from')) }} 
			{{ Form::label('lblend', 'End date') }}
		 	{{ Form::text('to', $end->end_date, array('required', 'id'=>'to')) }} 
		</td>
	</tr>
	<tr>
		<td> {{ Form::label('lblprice', 'Room price') }} </td>
		<td> {{ Form::text('price', '', array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lbldiscount', 'Discount rate') }} </td>
		<td> {{ Form::text('discount', '', array('required')) }} </td>
	</tr>
	<tr>
		<td  > {{ Form::submit('Update calendar record') }} </td>
		{{ Form::close() }}	
		{{ Form::open(array('url'=>'admin/calendar/index','method'=>'GET')) }}

		<td > {{ Form::submit('Cancel') }} </td>

	{{ Form::close() }}	
	</tr>	
</table>
@stop


 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>