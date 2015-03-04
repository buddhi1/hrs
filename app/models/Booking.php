<?php

class Booking extends Eloquent {

	protected $guarded = array();
	public static $rules = array();
	
	// public static $rules1 = array(
	// 	'identification_no'=> 'required',
	// 	'no_of_rooms'=>'required',
	// 	'no_of_adults'=>'required',
	// 	'no_of_kids'=>'required',
	// 	'promo_code'=>'required'
	// 	);

	// public static $rules2 = array(
	// 	'room_type_id'=>'required',
	// 	'services'=>'required',
	// 	'total_charges'=>'required',
	// 	'paid_amount'=>'required',
	// 	'check_in'=>'required',
	// 	'check_out'=>'required'
	// 	);
}