@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	<h3>{{ Session::get('message') }}</h3>
@endif
@if($errors->has())
	<ul>
		@foreach($errors->all() as $error)			
				<li> {{ $error }} </li>			
		@endforeach
	</ul>
@endif
<table border="1">
	<tr>
		<th>Permission id</th>
		<th>Permission group name</th>
	</tr>
</table>
<table data-bind="foreach: permission">
	<tr>
		<td data-bind="text: id"></td>
		<td data-bind="text: name"></td>
		<td>
			<button data-bind="click: editPer">Edit</button> 
			<button data-bind="click: deletePer">Delete</button>
		</td>
	</tr>
</table>	
<script type="text/javascript" src="{{url()}}/js/permission.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	var permissionArr;
	window.onload = function() {
		// load all the permissions in the database when the page loads
		var foo;
		sendRequestToServerPost('/admin/permission/index', foo, function(res) {
			permissionArr = res;
			permissionArr = JSON.parse(permissionArr);
			console.log(permissionArr);

			for(per in permissionArr) {

				permission = new Permission();
				permission.id = permissionArr[per].id;
				permission.name = permissionArr[per].name;

				allPermissions.permission.push(permission);
			}
		});
	}

	var allPermissions = new PermissionDisplay();
	ko.applyBindings(allPermissions);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>

@stop