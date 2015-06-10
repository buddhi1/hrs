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
	<div><button data-bind="click: addTax">Save changes</button> </div>
</div>


<script type="text/javascript" src="{{url()}}/js/tax.js"></script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>
<script type="text/javascript">
	http_url = '{{url()}}';
	id = {{$id}};
	name = '{{$name}}';
	rate = {{$rate}};


	window.onload = function(){
		loadTax();
	}

	var currTax = new Tax();

	ko.applyBindings(currTax);
</script>

@stop