@extends('layouts.main')

@section('content')

@if($errors->has())
	<div>
		<p>Following errors occured:</p>
		<ul>
			@foreach($errors->all() as $error)
				<li>{{$error }}</li>
			@endforeach
		</ul>
	</div>
@endif

@if(Session::has('message'))
	{{ Session::get('message') }}
@endif	

Tax Name: <input type="text" data-bind="value: name" />
Tax Rate: <input type="text" data-bind="value: rate" />
<button data-bind="click: saveTax">Add Tax</button>

<script type="text/javascript" src="{{url()}}/js/tax.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	var tax = new Tax();
	ko.applyBindings(tax);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>

@stop