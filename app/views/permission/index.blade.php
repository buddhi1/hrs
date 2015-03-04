@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif

<table border="1">
	</tr>
	<tr>
		<th>Permission id</th>
		<th>Permission group name</th>
		<?php
		$permissions = Schema::getColumnListing('permissions');
		
	?>	
		@foreach($permissions as $permission)
			<th>{{ $permission }}</th>
		@endforeach
		<th colspan="2">Edit / Delete</th>
	</tr>
	@foreach($groups as $group)
	<tr>
		<td>{{$group->id}}</td>
		<td>{{$group->name}}</td>
		@foreach($permissions as $permission)
			@if($group->$permission == '1')
				<td>{{ 'Yes' }}</td>
			@else
				<td>{{ 'No' }}</td>
			@endif
		@endforeach
		{{ Form::open(array('url'=>'admin/permission/edit')) }}
		<td>
			{{Form::hidden('id',$group->id)}} 
			{{ Form::submit('Edit') }} 
		</td>
		{{ Form::close() }}
		{{ Form::open(array('url'=>'admin/permission/destroy')) }}
		<td> 
			{{Form::hidden('id',$group->id)}}
			{{ Form::submit('Delete') }}
		 </td>
		{{ Form::close() }}
	</tr>
@endforeach	
</table>	


@stop