@extends('layouts.main')

@section('content')

{{ Form::open(array('url' => 'booking/create')) }}

{{ Form::label('Room Type') }}
{{ Form::select('room_type', $rooms, null, array('id'=>'room_type')) }}

{{ Form::label('Service') }}
{{ Form::select('service', array(), null, array('id'=>'service')) }}

{{ Form::label('Total Charges') }}
{{ Form::text('total_charges', null) }}

{{ Form::label('Paid Amount') }}
{{ Form::text('paid_amount', null) }}

{{ Form::submit('Place Booking')}}
{{ Form::close() }}

<?php
var_dump(Session::get('no_of_adults'));
?>

<script>
	var http_path = '{{URL::to('/')}}';
</script>
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/js_config.js"></script>
<script type="text/javascript" src="{{URL::to('/')}}/js/script.js"></script>

@stop