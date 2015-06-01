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
	<tr>
		<td>Permission name</td>
		<td><input type="text" data-bind="value: perName" name="name"  required /></td>
	</tr>
</table>
<div data-bind="foreach:permission">
	<input type="checkbox" data-bind="click: toggleState"><span data-bind="text:chkName"></span></br>
</div>
</br>
<button onclick="savePermission()">Add Permission Grooup</button>



<script type="text/javascript" src="{{url()}}/js/permission.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	var permissionArr;
	window.onload = function() {
		// load all the users in the database when the page loads
		var foo;
		sendRequestToServerPost('/admin/permission/permissions', foo, function(res) {
			permissionArr = res;
			permissionArr = JSON.parse(permissionArr);

			for(per in permissionArr) {

				var permission = new Permission();
				permission.chkName = permissionArr[per][0];
				permission.name = permissionArr[per][1];

				allPermissions.permission.push(permission);
			}
		});
	}
	
	var allPermissions = new PermissionDisplay();
	ko.applyBindings(allPermissions);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop