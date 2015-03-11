@extends('layouts.main')

@section('content')

	{{ Form::open(array('url' => 'admin/checkin/search')) }}

	{{ Form::label('Checkin ID') }}
	{{ Form::text('check_id') }}
	{{ Form::submit('Search') }}

	{{ Form::close() }}

@stop
