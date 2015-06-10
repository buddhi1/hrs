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


<div>
	<div>Tax Name: <input data-bind="value: name" id="name" /></div>
	<div>Tax Rate: <input data-bind="value: rate" id="rate" /></div>
	<div><button data-bind="click: addTax">Add Tax</button> </div>
</div>


<script type="text/javascript" src="{{url()}}/js/tax.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';

	var newTax = new Tax();

	ko.applyBindings(newTax);
</script>


@stop