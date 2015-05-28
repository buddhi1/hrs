@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif

<table border="1">
	<tr>
		<th>User id</th>
		<th>User name</th>
		<th>Permission ID</th>
		<th>Permission Group</th>
		<th>Edit / Delete</th>
	</tr>
	<table data-bind="foreach: user">
		<tr>
			<td data-bind="text: uid"></td>
			<td data-bind="text: uname"></td>
			<td data-bind="text: permission_id"></td>
			<td data-bind="text: permission_name"></td>
			<td>
				<button data-bind="click: editUser">Edit</button> 
				<button data-bind="click: deleteUser">Delete</button>
			</td>
		</tr>
	</table>
</table>
<script type="text/javascript" src="{{url()}}/js/user.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	var userArr;
	window.onload = function() {
		// load all the users in the database when the page loads
		var foo;
		sendRequestToServerPost('/admin/user/index', foo, function(res) {
			userArr = res;
			userArr = JSON.parse(userArr);

			for(use in userArr) {

				userDetails = new UserDetails();
				userDetails.uid = userArr[use].uid;
				userDetails.uname = userArr[use].uname;
				userDetails.permission_id = userArr[use].permission_id;
				userDetails.permission_name = userArr[use].name;

				userData.user.push(userDetails);
			}
		});
	}

	var userData = new UserDisplay();
	ko.applyBindings(userData);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop