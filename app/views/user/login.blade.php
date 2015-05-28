@extends('layouts.main')

@section('content')

@if(Session::has('message'))
	{{ Session::get('message') }}
@endif
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
<input type="text" data-bind="value: name" name="name" placeholder="user name here" required />
<input type="password" data-bind="value: password" name="password" required>
<button onclick="login()">Login</button>
<script type="text/javascript" src="{{url()}}/js/user.js"></script>
<script type="text/javascript">
	var http_url = '{{url()}}';

	var user = new UserLogin();
	ko.applyBindings(user);
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>

@stop