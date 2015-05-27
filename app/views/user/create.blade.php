@extends('layouts.main')

@section('content')
<table>
	<tr>
		<td clospan="2"> 
			@if(Session::has('message'))
				<h3>{{ Session::get('message') }}</h3>
			@endif
		 </td>
	</tr>
	<tr>
		<td><label>User name</label></td>
		<td><input type="text" data-bind="value: uname" name="uname" required /></td>
	</tr>
	<tr>
		<td><label>Permission Group</label></td>
		<td>
			<select data-bind="options: permissions, selectedOptions: chosenPermission" name="permission" required></select>
		</td>
	</tr>
	<tr>
		<td><label>Password</label></td>
		<td><input type="password" data-bind="value: password" name="password" required></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<button onclick="saveCreateUser()">Add User</button>
		</td>
	</tr>
</table>

<script type="text/javascript" src="{{url()}}/js/user.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';
	var permissionArr;
	window.onload = function() {
		// load the pemission dropdown when the page loads
		var foo;
		sendRequestToServerPost('/admin/user/permissions', foo, function(res) {
			permissionArr = res;
			permissionArr = JSON.parse(permissionArr);

			for(per in permissionArr) {

				userDataCreate.permissions.push(permissionArr[per]['name']);
			}
		});
	}

	var userDataCreate = new UserCreate();
	ko.applyBindings(userDataCreate);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop