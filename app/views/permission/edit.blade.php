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
<?php
	$record = Permission::find(Input::get('id'));
?>

<table>
	{{ Form::open(array('url'=>'/admin/permission/update')) }}
	{{ Form::hidden('id', $record->id) }}
	<tr>
		<td> {{ Form::label('name', 'Permission name') }} </td>
		<td> {{ Form::text('name',$record->name,array('required')) }} </td>
	</tr>
	<?php
		$permissions = Schema::getColumnListing('permissions');
		
	?>			
	@foreach($permissions as $permission)
		<tr>
			<td>&nbsp;</td>
			<td>
				<?php $i=0 ?>
				@if($record->$permission == '1')
				<?php $i=1 ?>
					{{ Form::checkbox('permission[]', $permission, array('required')) }}
				@endif
				@if($i ==0 )
					{{ Form::checkbox('permission[]', $permission) }}
				@endif
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