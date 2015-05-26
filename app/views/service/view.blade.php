@extends('layouts.main')

@section('content')
	<h3>Add a New Service</h3>
	<div id="add-service">
		<!-- <form action="{{url()}}/admin/service/create"> -->
			<table>
				<tr>
					<td><label>Service Name</label></td>
					<td><input data-bind="value: name" id="service_name" /> </td>
				</tr>

				<tr>
					<td colspan = "2" align = "right"><button type="submit" data-bind="click: addService">Add service</button></td>
				</tr>

			</table>
	<!-- 	</form> -->
	</div>

	@if(Session::has('ser_message_add'))

	<p class="text-success">{{ Session::get('ser_message_add') }}</p>
		
	@endif

	@if(Session::has('ser_message_err'))

	<p class="text-danger">{{ Session::get('ser_message_err') }}</p>
	
	@endif


	<h3>All Services</h3>
		
	<div  id="saved-services">
		<div data-bind="foreach: services">	
			<div>		
				<label data-bind="text: name"></label>			
				<button data-bind="click: $parent.removeService">Remove</button>		
			</div>
		</div>
	</div>


	@if(Session::has('ser_message_del'))

	<p class="text-success">{{ Session::get('ser_message_del') }}</p>
	
	@endif
<script type="text/javascript">
	http_url = '{{url()}}';
</script>
<script type="text/javascript" src="{{url()}}/js/service.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
@stop