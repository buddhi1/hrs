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

	@endif
</div>

@stop