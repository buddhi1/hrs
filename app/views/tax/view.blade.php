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
	<div>{{ Session::get('message') }}</div>
@endif	
<table border="1">
	<tr>
		<th>Id</th>
		<th>Tax Name</th>
		<th>Tax Rate</th>
		<th colspan="2">Edit/Delete</th>
	</tr>
</table>
	<div data-bind="foreach: taxArray">
		<div>
			<label data-bind="text: id"></label>
			<label data-bind="text: name"></label>
			<label data-bind="text: rate"></label>
			<button data-bind="click: ">Edit</button>
			<button data-bind="click: ">Delete</button>
		</div>
	</div>

<script type="text/javascript" src="{{url()}}/js/tax.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	taxes = {{$taxes}};

	window.onload = function(){
		loadTaxes();
	}
	var allTax = new TaxArray();

	ko.applyBindings(allTax);
</script>

@stop