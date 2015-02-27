@extends('layouts.main')

@section('content')

<h2>Edit Room price calendar record</h2>
<table>
	{{ Form::open(array('url'=>'/admin/calendar/update')) }}
	<tr>
		<td clospan="2"> 
			@if(Session::has('message'))
				<h3>{{ Session::get('message') }}</h3>
			@endif
		 </td>
	</tr>
	<?php
		$roomTypes = RoomType::lists('name', 'id');
		$services = Service::lists('name', 'id');

		$record = Calendar::find(Input::get('id'));

		//$record = DB::table('room_price_calenders')->where('room_type_id','=',Input::get('room_id'))->get();
	?>
	{{ Form::hidden('room_id', $record->room_type_id) }}
	{{ Form::hidden('sdate',$record->start_date) }}
	{{ Form::hidden('edate',$record->end_date) }}
	<tr>
		<td> {{ Form::label('lbluname', 'Room type') }} </td>
		<td> {{ Form::select('roomType', $roomTypes, $record->room_type_id, array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblservice', 'Service') }} </td>
		<td> {{ Form::select('service', $services, $record->service_id, array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lblfrom', 'Start date') }} </td>
		<td>
			{{ Form::text('from', $record->start_date, array('required', 'id'=>'from')) }} 
			{{ Form::label('lblend', 'End date') }}
		 	{{ Form::text('to', $record->end_date, array('required', 'id'=>'to')) }} 
		</td>
	</tr>
	<tr>
		<td> {{ Form::label('lblprice', 'Room price') }} </td>
		<td> {{ Form::text('price', $record->price, array('required')) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('lbldiscount', 'Discount rate') }} </td>
		<td> {{ Form::text('discount', $record->discount_rate, array('required')) }} </td>
	</tr>
	<tr>
		<td colspan="2" align="center"> {{ Form::submit('Update calendar record') }} </td>
	</tr>
	{{ Form::close() }}	
</table>
@stop


 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>