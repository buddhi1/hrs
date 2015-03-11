@extends('layouts.main')

@section('content')

<h2>Search booking</h2>
<table>
	<tr>
	{{ Form::open(array('url'=>'admin/booking/search')) }}		
		<td> {{ Form::text('booing_id', '') }} </td>
		<td> {{ Form::submit('Search') }} </td>
	{{ Form::close() }}
	</tr>
	<tr>
	{{ Form::open(array('url'=>'admin/booking/search')) }}		
		<td> {{ Form::text('id', '') }} </td>
		<td> {{ Form::submit('Search') }} </td>
	{{ Form::close() }}
	</tr>
	
</table>

<div>
	@if(Session::has('booking_id'))
		{{ Session::get('booking_id') }}
		{{ Session::get('identification_no') }}
		{{ Session::get('room_type_id') }}
		{{ Session::get('no_of_rooms') }}
		{{ Session::get('no_of_adults') }}
		{{ Session::get('no_of_kids') }}
		{{ Session::get('services') }}
		{{ Session::get('total_charges') }}
		{{ Session::get('paid_amount') }}
		{{ Form::open(array('url'=>'admin/checkin/create', 'method'=>'GET')) }}
			{{ Form::submit('Mark Checkin') }}
		{{ Form::close() }}

	@endif
</div>

@stop