@extends('layouts.main')

@section('content')

	<h3>All Rooms</h3>

	<table border = "1">
		<th>Room Name</th>
		<th>Delete</th>
	@foreach($rooms as $room)
	
		<tr>
			<td>{{ $room->name }}</td>
			<td>
				{{ Form::open(array('url' => 'admin/room/destroy')) }}
				{{ Form::hidden('id', $room->id) }}
				{{ Form::submit('Delete') }}
				{{ Form::close() }}
			</td>
		</tr>
	
	@endforeach
	</table>

	@if(Session::has('room_message_del'))

	<p class="text-success">{{ Session::get('room_message_del') }}</p>
	
	@endif

@stop