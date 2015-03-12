@extends('layouts.main')

@section('content')

{{ Form::open(array('url' => 'customer/add')) }}


@foreach($available_rooms as $room)
	<div>
		{{ $room['name'] }} with 
		{{ $room['service'] }}&nbsp;Facilities - 
		<?php if(json_decode($room['facility']) !== null) { ?>
				{{ implode(", ", json_decode($room['facility'])) }}
		<?php } ?>
		{{ $room['price'] }}
		{{ Form::selectRange('number', 1, $room['rooms_qty']) }}
	</div>
@endforeach


{{ Form::close() }}

@stop