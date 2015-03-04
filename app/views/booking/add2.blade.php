@extends('layouts.main')

@section('content')

<?php
	$service = Service::lists('name', 'id');
	$rooms = RoomType::lists('name', 'id');
?>

{{ Form::open(array('url' => 'booking/create')) }}

{{ Form::label('Room Type') }}
{{ Form::select('room_type_id', $rooms) }}

{{ Form::label('Service') }}
{{ Form::select('service_id', $service) }}

{{ Form::label('Total Charges') }}
{{ Form::text('total_charges', null) }}

{{ Form::label('Paid Amount') }}
{{ Form::text('paid_amount', null) }}

{{ Form::submit('Place Booking')}}
{{ Form::close() }}

<?php
var_dump(Session::get('no_of_adults'));
?>

@stop