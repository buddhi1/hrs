@extends('layouts.main')

@section('content')
<div>
	@if($errors->has())
	<ul>
		@foreach($errors->all() as $error)			
				<li> {{ $error }} </li>			
		@endforeach
	</ul>
	@endif
	@if(Session::has('message'))
		<h3>{{ Session::get('message') }}</h3>
	@endif
</div>
<table>
	{{ Form::open(array('url'=>'/admin/permission/create')) }}
	<tr>
		<td> {{ Form::label('name', 'Permission name') }} </td>
		<td> {{ Form::text('name','',array('required')) }} </td>
	</tr>
	<?php
		$permissions = Schema::getColumnListing('permissions');
		
	?>			
	@foreach($permissions as $permission)
		<tr>
			<td>&nbsp;</td>
			<td>
				{{ Form::checkbox('permission[]', $permission) }}
				{{ $permission }}
				<br />
			</td>
		</tr>
	@endforeach
	<tr>
		<td colspan="2" align="center"> {{ Form::submit('Add Permission group') }} </td>
	</tr>
	{{ Form::close() }}
</table>
@stop