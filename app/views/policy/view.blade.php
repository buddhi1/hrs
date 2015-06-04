@extends('layouts.main')

@section('content')
	<h3>Add a New Policy</h3>
	{{ Form::open(array('url' => 'admin/policy/create')) }}

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
		</br></br>
	</div>


<a href="#" data-bind="click: addNewVar">Add New</a>
	{{ Form::close()}}

	@if(Session::has('policy_message_add'))

	<p class="text-success">{{ Session::get('fac_message_add') }}</p>
		
	@endif

	@if(Session::has('policy_message_add'))

	<p class="text-danger">{{ Session::get('policy_message') }}</p>
	
	@endif


	<h3>All Policies</h3>

	<table border = "1">
		<th>Policy Description</th>
		<th>Variables</th>
		<th>Edit</th>
		<th>Delete</th>
	@foreach($policies as $policy)
	
		<tr>
			<td>{{ $policy->description }}</td>
			<td>{{ $policy->variables }}</td>
			<td>
				{{ Form::open(array('url' => 'admin/policy/edit')) }}
				{{ Form::hidden('id', $policy->id) }}
				{{ Form::submit('Edit') }}
				{{ Form::close() }}
			</td>
			<td>
				{{ Form::open(array('url' => 'admin/policy/destroy')) }}
				{{ Form::hidden('id', $policy->id) }}
				{{ Form::submit('Delete') }}
				{{ Form::close() }}
			</td>
		</tr>
	
	@endforeach
	</table>

	@if(Session::has('policy_message'))

	<p class="text-success">{{ Session::get('policy_message') }}</p>

	@endif

<script type="text/javascript" src="{{url()}}/js/policy.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	var policy = new Policy();
	ko.applyBindings(policy);
	
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop