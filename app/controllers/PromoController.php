<?php

class PromoController extends BaseController {

	public function __construnct() {
		// $this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	public function getIndex() {
	// display all the promo codes

		return View::make('promo.view')
			->with('promos', PromoCode::all())
			->with('roomTypes', RoomType::all(['id', 'name']));
	}

	public function getCreate() {
	// display the form to create the new promo code

		return View::make('promo.add')
			->with('services', Service::all(['id', 'name']))
			->with('roomTypes', RoomType::all(['id', 'name']));
	}

	public function postCreate() {
	// add a new promo code to the database
		$promo = new Promocode;
		$promo->promo_code = Input::get('code');
		$promo->start_date = date('Y-m-d', strtotime(Input::get('from').' 0 day'));
		$promo->end_date = date('Y-m-d', strtotime(Input::get('to').' 0 day'));
		$promo->price = Input::get('price');
		$promo->days = Input::get('stays');
		$promo->room_type_id = Input::get('room');
		$promo->no_of_rooms = Input::get('rooms');
		$promo->services = json_encode(explode(',', Input::get('services')));

		$promo->save();

		return 1;		
	}

	public function postEdit() {
	
		if(Input::get('id')){
			Session::put('promo_id', Input::get('id'));

			return 1;
		}
		return 3;
	}

	//direcects to edit page with data
	public function getEdit() {
		$promo_id = Session::get('promo_id');
		if($promo_id){
			Session::forget('promo_id');
			return View::make('promo.edit')
						->with('promo', Promocode::find($promo_id))
						->with('services', Service::all())
						->with('roomTypes', RoomType::all(['id', 'name']))
						->with('promo_message', ' ');
						//->with('promo_message', "Services cannot be empty");
		}
		return Redirect::to('/');
	}

	public function postUpdate() {
	// update a existing Promo Code

		$promo = PromoCode::find(Input::get('id'));

		$promo->start_date = date('Y-m-d', strtotime(Input::get('from').' 0 day'));
		$promo->end_date = date('Y-m-d', strtotime(Input::get('to').' 0 day'));
		$promo->price = Input::get('price');
		$promo->days = Input::get('stays');
		$promo->no_of_rooms = Input::get('rooms');
		$promo->services = json_encode(explode(',', Input::get('services')));

		$promo->save();

		return 1;
		
	}

	public function postDestroy() {
	// delete an existing Promo Code

		$promo = PromoCode::find(Input::get('id'));

		if($promo) {
			$promo->delete();
			return 1;
		}
		return 0;
	}

}