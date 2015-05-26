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
			<button onclick="saveUser()">Add User</button>
		</td>
	</tr>
</table>

<script type="text/javascript">

	var permissionArr;
	var User = function() {
		// User class is used to bind variables with input fields

		var self = this;

		self.uname = ko.observable();
		self.password = ko.observable();
		self.permissions = ko.observableArray();
		self.chosenPermission = ko.observable();
	}

	window.onload = function() {
		// load the pemission dropbox when the page loads

		sendRequestToServerPost('/admin/user/permissions',function(res) {
			permissionArr = res;
			permissionArr = JSON.parse(permissionArr);

			for(per in permissionArr) {

				userData.permissions.push(permissionArr[per]['name']);
			}
		});
	}

	var userData = new User();

	ko.applyBindings(userData);

	var cleanJson = function(que) {
		//this function remove all the permissions from the userData object
		
		var copy = ko.toJS(que);

		delete copy.permissions;
		return copy;
	}

	function saveUser() {
		//save the user in the user table

		var clean = cleanJson(userData);
		var sendData = ko.toJSON(clean);
		sendRequestToServerPost('/admin/user/create',function(res){
			if(res === 'success') {
				window.location = "{{url()}}/admin/user/create";
			}
		}, sendData);
	}

	function sendRequestToServerPost(url, callback, variables) {

		//retriving all the permission groups
		var headers = "variables="+variables;
		var xmlhttp=new XMLHttpRequest();
		
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
	    		callback(xmlhttp.responseText);
	    	}
	  	}

		xmlhttp.open("POST","{{url()}}"+url,true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(headers);
	}

</script>
@stop