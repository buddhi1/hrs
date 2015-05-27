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
			<button onclick="saveUser()">Update User</button>
		</td>
	</tr>
</table>

<script type="text/javascript">
	http_url = '{{url()}}';
	var permissionArr;
	var User = function() {
		// User class is used to bind variables with input fields

		var self = this;

		self.uname = ko.observable('');
		self.password = ko.observable('');
		self.permissions = ko.observableArray();
		self.chosenPermission = ko.observableArray();
		self.userID = ko.observable();
	}

	window.onload = function() {
		// load the pemission dropbox when the page loads
		var foo;
		sendRequestToServerPost('/admin/user/permissions', foo, function(res) {
			permissionArr = res;
			permissionArr = JSON.parse(permissionArr);

			for(per in permissionArr) {

				userData.permissions.push(permissionArr[per]['name']);
			}

			sendRequestToServerPost('/admin/user/showedit', foo, function(res) {

				if(res !== 'failure') {

					userArr = res;
					userArr = JSON.parse(userArr);
					userData.uname(userArr[0].uname);
					userData.userID(userArr[0].uid);
					userData.chosenPermission.push(userArr[0].name);
				} else {

					window.location = "{{url()}}/admin/user/index";
				}
			});
		});
	}

	var userData = new User();

	ko.applyBindings(userData);

	var cleanJson = function(que) {
		//this function remove all the permissions from the userData object
		
		var copy = ko.toJS(que);

		delete copy.permissions;
		copy.chosenPermission = copy.chosenPermission[copy.chosenPermission.length-1];
		return copy;
	}

	function saveUser() {
		//save the user in the user table

		var clean = cleanJson(userData);
		var sendData = ko.toJSON(clean);
		
		sendRequestToServerPost('/admin/user/update', sendData, function(res){
			if(res === 'success') {
				window.location = "{{url()}}/admin/user/index";
			}
		});
	}
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop



