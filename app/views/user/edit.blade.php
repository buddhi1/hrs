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
			<button onclick="saveEditUser()">Update User</button>
		</td>
	</tr>
</table>

<script type="text/javascript" src="{{url()}}/js/user.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	var permissionArr;
	window.onload = function() {
		// load the pemission dropbox when the page loads
		var foo;
		sendRequestToServerPost('/admin/user/permissions', foo, function(res) {
			permissionArr = res;
			permissionArr = JSON.parse(permissionArr);

			for(per in permissionArr) {

				userDataEdit.permissions.push(permissionArr[per]['name']);
			}

			sendRequestToServerPost('/admin/user/showedit', foo, function(res) {

				if(res !== 'failure') {

					userArr = res;
					userArr = JSON.parse(userArr);
					userDataEdit.uname(userArr[0].uname);
					userDataEdit.userID(userArr[0].uid);
					userDataEdit.chosenPermission.push(userArr[0].name);
				} else {

					window.location = "{{url()}}/admin/user/index";
				}
			});
		});
	}
	
	var userDataEdit = new UserEdit();
	ko.applyBindings(userDataEdit);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop



