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

Permission Group: <input type="text" data-bind="value: perName" name="groupName" required />
Permissions:
<div data-bind="foreach:permission">
	<input type="checkbox" data-bind="click: toggleState"><span data-bind="text:chkName"></span></br>
</div>

<script type="text/javascript" src="{{url()}}/js/permission.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	var permissionArr;
	window.onload = function() {
		// load permission details on the page load
		var foo;
		
		sendRequestToServerPost('/admin/permission/showedit', foo, function(res) {

			if(res) {

				var perArr = res;
				perArr = JSON.parse(perArr);

				permissionData.groupID(perArr[0].id);
				permissionData.perName(perArr[0].name);
				for(per in perArr[0]) {
					if(per === 'id') {
						
					} else if(per === 'name') {

					} else if(per === 'created_at') {

					} else if(per === 'updated_at') {

					}else {
						var permission = new Permission();
						permission.chkName(per);
						permission.state(perArr[0][per]);
						permissionData.permission.push(permission);
					}
				}
				
			// 	userDataEdit.uname(perArr[0].uname);
			// 	userDataEdit.userID(perArr[0].uid);
			// 	userDataEdit.chosenPermission.push(perArr[0].name);
			// } else {

				// window.location = "{{url()}}/admin/permission/index";
			}
		});
	}
	
	var permissionData = new PermissionDisplay();
	ko.applyBindings(permissionData);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop