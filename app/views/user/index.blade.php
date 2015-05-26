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
				<button onclick="deleteUser()">Delete</button>
			</td>
		</tr>
	</table>
</table>
<script type="text/javascript">
	http_url = '{{url()}}';
	var permissionArr;
	var UserDetails = function() {
		// User class is used to bind variables with display fields

		var self = this;

		self.uid = ko.observable();
		self.uname = ko.observable();
		self.permission_id = ko.observable();
		self.permission_name = ko.observable();

		self.editUser = function() {
			editUser(self.uid);
		}
	}

	var UserDisplay = function() {
		// display the array of users

		var self = this;

		self.user = ko.observableArray();
	}

	window.onload = function() {
		// load all the users in the database when the page loads
		var foo;
		sendRequestToServerPost('/admin/user/index', foo, function(res) {
			userArr = res;
			userArr = JSON.parse(userArr);
			console.log(userArr);

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

	// var cleanJson = function(que) {
	// 	//this function remove all the permissions from the userData object
		
	// 	var copy = ko.toJS(que);

	// 	delete copy.permissions;
	// 	return copy;
	// }
</script>	
<script type="text/javascript">
	http_url = '{{url()}}';

	function editUser(uid) {
		// this function send the user id of the user to be edited, to the controller
	
		var editID = uid;
		var sendData = ko.toJSON({"id": editID});
		sendRequestToServerPost('/admin/user/edit', sendData, function(res){
			if(res === 'success') {
				window.location = "{{url()}}/admin/user/index";
			}
		});
	}
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop