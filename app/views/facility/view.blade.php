@extends('layouts.main')

@section('content')
	<div id="fac-create">
		<h1>Add a New Facility</h1>

		<table>
			<tr>
				<td>Facility Name</td>
				<td><input type="text" data-bind="value: name" name="name" required /></td>
			</tr>

			<tr>
				<td colspan = "2" align = "right">
					<button onclick="saveCreateFacility()">Add Facility</button>
				</td>
			</tr>

		</table>
	</div>

	@if(Session::has('fac_message_add'))

	<p class="text-success">{{ Session::get('fac_message_add') }}</p>
		
	@endif

	@if(Session::has('fac_message_err'))

	<p class="text-danger">{{ Session::get('fac_message_err') }}</p>
	
	@endif

	<div id="fac-index">
		<h3>All Facilities</h3>

		<table border = "1">
			<th>Facility Name</th>
			<th>Delete</th>

			<table data-bind="foreach: facility">
				<tr>
					<td data-bind="text: name"></td>
					<td>
						<button data-bind="click: deleteFacility">Delete</button>
					</td>
				</tr>
			</table>
		</table>
	</div>

	@if(Session::has('fac_message_del'))

	<p class="text-success">{{ Session::get('fac_message_del') }}</p>

	@endif
	<script type="text/javascript" src="{{url()}}/js/facility.js"></script>
	<script type="text/javascript">
		http_url = '{{url()}}';
		var FacilityArr;
		window.onload = function() {
			// load all the users in the database when the page loads
			var foo;
			sendRequestToServerPost('/admin/facility/index', foo, function(res) {
				FacilityArr = res;
				FacilityArr = JSON.parse(FacilityArr);
				console.log(FacilityArr);

				for(fac in FacilityArr) {

					facility = new Facility();
					facility.id = FacilityArr[fac].id;
					facility.name = FacilityArr[fac].name;

					facData.facility.push(facility);
				}
			});
		}

		var facCreate = new Facility();
		var facData = new FacilityDisplay();
		ko.applyBindings(facCreate, document.getElementById('fac-create'));
		ko.applyBindings(facData, document.getElementById('fac-index'));
	</script>
	<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop