@extends('layouts.main')

@section('content')

	<h3>Add a New Room Type</h3>
	{{ Form::open(array('url' => 'admin/room/create')) }}

	<table>
		<tr>
			<td>{{ Form::label('room_name', 'Room Name') }}</td>
			<td>{{ Form::text('name',null, array('required')) }}</td>
		</tr>

		<tr>
			<td>{{ Form::label('room_no', 'No Room Name') }}</td>
			<td>{{ Form::text('no_of_room',null, array('required')) }}</td>
		</tr>

		<tr>
			<td valign = "top">{{ Form::label('lblFacilities', 'Facilities') }}</td>
			<td>
				@foreach($facilities as $facility)
					{{ Form::checkbox('facility[]', $facility->name)}}
					{{ $facility->name }}
					<br>
				@endforeach
			</td>
		</tr>

		<tr>
			<td valign = "top">{{ Form::label('lblServices', 'services')}}</td>
			<td>
				@foreach($services as $service)
					{{ Form::checkbox('service[]', $service->name) }}
					{{ $service->name }}
					<br>
				@endforeach
			</td>
		</tr>

		<tr>
			<td colspan = "2" align = "right">{{ Form::submit('Submit') }}</td>
		</tr>

	</table>
	{{ Form::close()}}

	@if(Session::has('room_message_add'))

		<p class="text-success">{{ Session::get('room_message_add') }}</p>
		
	@endif

@stop