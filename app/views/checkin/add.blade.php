@extends('layouts.main')

@section('content')

<table>
	{{ Form::open(array('url' => 'admin/checkin/create')) }}

	<tr>
		<td>Authorizer</td>
		<td>{{ Form::text('auth', null) }}</td>
	</tr>

	<tr>
		<td>Booking ID</td>
		<td>{{ Form::text('booking_id', null) }}</td>
	</tr>

	<tr>
		<td>Check In</td>
		<td>{{ Form::checkbox('check_in')}}</td>
	</tr>
	
	<tr>
		<td>Check Out</td>
		<td>{{ Form::checkbox('check_out') }}</td>
	</tr>
	
	<tr>
		<td>Advance Payment</td>
		<td>{{ Form::text('advance_payment', null) }}</td>
	</tr>

	<tr>
		<td>Payment</td>
		<td>{{ Form::text('payment', null) }}</td>
	</tr>

	<tr>
		<td>{{ Form::submit('Submit') }}</td>
	</tr>

	{{ Form::close() }}
</table>

{{ HTML::link('admin/checkin/addpayment', 'Add a Payment to an exsisting Check in') }}

@if(Session::has('message'))

	<p class="text-success">{{ Session::get('message') }}</p>

@endif


@stop