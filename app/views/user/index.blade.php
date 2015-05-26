@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif

<table border="1">
	</tr>
	<tr>
		<th>User id</th>
		<th>User name</th>
		<th>permission group</th>
		<th colspan="2">Edit / Delete</th>
	</tr>
	@foreach($users as $user)
	<tr>
		<td>{{$user->uid}}</td>
		<td>{{$user->uname}}</td>
		<td>{{ $user->name }}</td>
		<td>
			<button onclick="editUser()" id="{{$user->uid}}">Edit</button>
		</td>
		{{ Form::open(array('url'=>'admin/user/destroy')) }}
		<td> 
			{{Form::hidden('id',$user->uid)}}
			{{ Form::submit('Delete') }}
		 </td>
		{{ Form::close() }}
	</tr>
@endforeach	
</table>	
<script type="text/javascript">
	http_url = '{{url()}}';

	function editUser() {
		// this function send the user id of the user to be edited, to the controller
	
		var editID = window.event.target.id;
		var sendData = ko.toJSON({"id": editID});
		console.log(sendData);
		sendRequestToServerPost('/admin/user/edit', sendData, function(res){
			if(res === 'success') {
				window.location = "{{url()}}/admin/user/index";
			}
		});
	}
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop