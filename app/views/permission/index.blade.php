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
		<td data-bind="text: create_user"></td>
		<td data-bind="text: index_user"></td>
		<td data-bind="text: destroy_user"></td>
		<td data-bind="text: edit_user"></td>
		<td data-bind="text: create_service"></td>
		<td data-bind="text: index_service"></td>
		<td data-bind="text: destroy_service"></td>
		<td data-bind="text: create_room"></td>
		<td data-bind="text: index_room"></td>
		<td data-bind="text: destroy_room"></td>
		<td data-bind="text: edit_room"></td>
		<td data-bind="text: create_promotion"></td>
		<td data-bind="text: index_promotion"></td>
		<td data-bind="text: destroy_promotion"></td>
		<td data-bind="text: edit_promotion"></td>
		<td data-bind="text: create_promo"></td>
		<td data-bind="text: index_promo"></td>
		<td data-bind="text: destroy_promo"></td>
		<td data-bind="text: edit_promo"></td>
		<td data-bind="text: create_permission"></td>
		<td data-bind="text: index_permission"></td>
		<td data-bind="text: destroy_permission"></td>
		<td data-bind="text: edit_permission"></td>
		<td data-bind="text: create_facility"></td>
		<td data-bind="text: index_facility"></td>
		<td data-bind="text: destroy_facility"></td>
		<td data-bind="text: create_checkin"></td>
		<td data-bind="text: index_checkin"></td>
		<td data-bind="text: destroy_checkin"></td>
		<td data-bind="text: edit_checkin"></td>
		<td data-bind="text: create_calendar"></td>
		<td data-bind="text: index_calendar"></td>
		<td data-bind="text: destroy_calendar"></td>
		<td data-bind="text: edit_calendar"></td>
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

				permission = new PermissionIndex();
				for(var col in permissionArr[per]) {
					if (permission.hasOwnProperty(col)) {
						permission[col](permissionArr[per][col]);
					}
				}

				allPermissions.permission.push(permission);
			}
		});
	}

	var allPermissions = new PermissionDisplay();
	ko.applyBindings(allPermissions);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>

@stop