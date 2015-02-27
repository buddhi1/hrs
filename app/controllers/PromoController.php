<?php

class PromoController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex() {
	// display all the promo codes

		return View::make('promo.view')
			->with('promos', PromoCode::all());
	}

	public function getCreate() {
	// display the form to create the new promo code
		return View::make('promo.add')
			->with('services', Service::all())
			->with('rooms', RoomType::all());
	}

	public function postCreate() {
	// add a new promo code to the database
		$promo = New PromoCode();

		$promo->promo_code = Input::get('promo_code');
		$promo->start_date = Input::get('start_date');
		$promo->end_date = Input::get('end_date');
		$promo->price = Input::get('price');
		$promo->days = Input::get('days');
		$promo->room_type_id = Input::get('room_id');
		$promo->no_of_rooms = Input::get('no_of_rooms');
		$promo->services = json_encode(Input::get('service'));

		// var_dump($promo);
		// die();

		$promo->save();

		return Redirect::to('admin/promo')
			->with('promo_message_add','Promo Code is succesfully added');
	}

}