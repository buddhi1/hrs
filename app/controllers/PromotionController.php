<?php

/*
	Name:		PromotionController
	Purpose:	Controllers for Promotion_Calendar

	History:	Created 02/03/2015 by buddhi ashan	 
*/

class PromotionController extends BaseController{

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	//Views the create promotion page
	public function getCreate(){
		return View::make('promotion.create')
			->with('services',Service::all());
	}

	// add a new promotion to the database
	public function postCreate() {
	

		$validator = Validator::make(Input::all(), PromoCode::$rules);

		if($validator->passes()) {
			$promotion = New Promotion();

			$promotion->promo_code = Input::get('promo_code');
			$promotion->start_date = Input::get('start_date');
			$promotion->end_date = Input::get('end_date');
			$promotion->price = Input::get('price');
			$promotion->days = Input::get('days');
			$promotion->room_type_id = Input::get('room_id');
			$promotion->no_of_rooms = Input::get('no_of_rooms');
			$promotion->services = json_encode(Input::get('service'));

			$promo->save();

			return Redirect::to('admin/promo')
				->with('promo_message','Promo Code is succesfully added');
		}

		return Redirect::to('admin/promo')
				->with('promo_message','Services cannot be empty');
	}
}