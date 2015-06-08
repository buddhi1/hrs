@extends('layouts.main')

@section('content')
<div id="currentPolicy">

	<h3>Add a New Policy</h3>

	</br>
	Policy Description: <input type="text" data-bind="value: des" />
	</br></br></br>
	Variables:
	</br>
	<div data-bind="foreach: variables">
		Property:
		<input type="text" data-bind="value: id" />
		Value:
		<input type="text" data-bind="value: values" />
		<a href="#" data-bind="click: $parent.removeProperty">Remove</a>
		</br></br>
	</div>

	<a href="#" data-bind="click: addNewVar">Add New</a>
	</br>
	<button data-bind="click:savePolicy">Save Policy</button>
</div>
<h3>All Policies</h3>
<div id="savedPolicy">
	<table border = "1">
		<th>Policy Description</th>
		<th>Variables</th>
		<th>Edit</th>
		<th>Delete</th>
	</table>

	<table data-bind="foreach: policy">
		<tr>
			<td data-bind="text: des"></td>
			<td data-bind="text: variables"></td>
			<td><button data-bind="click:editPolicy">Edit</button></td>
			<td><button data-bind="click:deletePolicy">Delete</button></td>
		</tr>
	</table>
</div>
	@if(Session::has('policy_message_add'))

	<p class="text-success">{{ Session::get('fac_message_add') }}</p>
		
	@endif

	@if(Session::has('policy_message_add'))

	<p class="text-danger">{{ Session::get('policy_message') }}</p>
	
	@endif

	@if(Session::has('policy_message'))

	<p class="text-success">{{ Session::get('policy_message') }}</p>

	@endif

<script type="text/javascript" src="{{url()}}/js/policy.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	window.onload = function() {
		var foo;
		sendRequestToServerPost('/admin/policy/index', foo, function(res) {
			policyArr = res;
			policyArr = JSON.parse(policyArr);

			for(pol in policyArr) {

				var policyIndex = new SavedPolicy();
				for(var col in policyArr[pol]) {
					if (policyIndex.hasOwnProperty(col)) {
						policyIndex[col](policyArr[pol][col]);
					}
				}

				savedPolicy.policy.push(policyIndex);
			}
		});
	}

	var policy = new Policy();
	var savedPolicy = new SavedPolicyView();

	ko.applyBindings(policy, document.getElementById('currentPolicy'));
	ko.applyBindings(savedPolicy, document.getElementById('savedPolicy'));
	
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop