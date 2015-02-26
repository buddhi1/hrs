@extends('layouts.main')

@section('content')
<table>
	{{ Form::open(array('url'=>'/admin/user/create')) }}
	<tr>
		<td> {{ Form::label('uname', 'Permission name') }} </td>
		<td> {{ Form::text('uname') }} </td>
	</tr>
	<?php
		$permissions = Permission::lists('name', 'id');
	?>
	<tr>
		<td> {{ Form::label('uname', 'Permission Group') }} </td>
		<td> {{ Form::select('permission', $permissions) }} </td>
	</tr>
	<tr>
		<td> {{ Form::label('uname', 'Password') }} </td>
		<td> {{ Form::password('password') }} </td>
	</tr>
	<tr>
		<td colspan="2" align="center"> {{ Form::submit('Add user') }} </td>
	</tr>
	{{ Form::close() }}
</table>
@stop