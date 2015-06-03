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
{{ Form::select('paid_amount', array(
    'full' => 'Full Payment',
    'part' => '1st Night',
)) }}

{{ Form::submit('Place Booking')}}
{{ Form::close() }}

<script type="text/javascript" src="{{url()}}/js/booking.js"></script>
<script>
	http_url = '{{url()}}';
	// window.onload = function(){

	// 	getServices('/booking/loaditem','room_type_id='+document.getElementById('room_type').value,handleResponce);
	// }

	document.getElementById('room_type').onchange = function(){

	  getServices('/booking/loaditem','room_type_id='+this.value,handleResponce);
	}
</script>
<script type="text/javascript" src="{{url()}}/js/js_config.js"></script>

@stop