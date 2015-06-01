<?php

class Booking extends Eloquent {

	protected $guarded = array();
	public static $rules = array();
	
	public static $rules1 = array(
		'identificationNo'=> 'required',
		'startDate' => 'required|date',
		'endDate' => 'required|date',
		'noOfAdults'=>'required|numeric',
		'noOfKids'=>'required|numeric',
		'noOfRooms' => 'required|numeric',
		'promoCode'=>'required'
		);
}