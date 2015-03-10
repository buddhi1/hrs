@extends('layouts.main')

@section('content')

	{{ Form::open(array('url' => 'admin/checkin/search')) }}

	{{ Form::label('Checkin ID') }}
	{{ Form::text('check_id') }}
	{{ Form::submit('Search') }}

	{{ Form::close() }}

@stop
<!--

@if($checkin)
<table border = "1">
	<tr>
		<th>Checkin ID</th>
		<th>Authorizer</th>
		<th>Checkin Date</th>
		<th>Checkout Date</th>
		<th>Advance Payment</th>
		<th>Other Payments</th>
		<th>Total Payments</th>
		<th>Total Charge</th>
		<th>Amount Due</th>
	</tr>
		<tr>

			
		<td>{{ $checkin->id }}</td>
		<td>{{ $checkin->authorizer }}</td>
		<td>{{ $checkin->check_in }}</td>
		<td>{{ $checkin->check_out }}</td>
		<td>{{ $checkin->advance_payment }}</td>
		<td>{{ $checkin->payment }}</td>
		<td>{{ $payment }}</td>
		<td>{{ $booking->total_charges }}</td>
		<td>{{ $due }}</td>
	</tr>
</table>
@endif

-->

