<?php

class RoomController extends BaseController {

	public function __construnct() {
		// $this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	public function getIndex() {
	// display all the room types
	
		return View::make('room.view')
			->with('rooms', RoomType::all());
	}

	public function getCreate() {
	// display the form to create the new room type
		return View::make('room.add')
			->with('facilities', Facility::all())
			->with('services', Service::all());
	}

	public function postCreate() {
	// add a new room type to the database
	
		$room = New RoomType();

		$room->name = Input::get('name');
		$room->facilities = json_encode(explode(',', Input::get('facilities')));
		$room->services = json_encode(explode(',', Input::get('services')));
		$room->no_of_rooms = Input::get('no_of_rooms');

		$room->save();
		return 1;
		
	}

	public function postDestroy() {
	// delete a room type from the database

		$room = RoomType::find(Input::get('id'));

		$promotion = Promotion::where('room_type_id', '=', Input::get('id'))->first();
		$calendar = Calendar::where('room_type_id', '=', Input::get('id'))->first();
		$promo = PromoCode::where('room_type_id', '=', Input::get('id'))->first();
		$booking = Booking::where('room_type_id', '=', Input::get('id'))->first();

		if(!$promotion && !$calendar && !$promo && !$booking){
			//delete a room only if it doesn't exists in promotion, calendar, promo and booking tables

			if($room) {
				$room->delete();
				return 1;
			}
		return 0;
		}
		return 2;
	}

	//
	public function postEdit(){
		$room = RoomType::find(Input::get('id'));
		
			if($room){
				Session::put('room', $room);
				return 1;
			}
	}

	public function getEdit() {
	// display the edit room type form	
		
		return View::make('room.edit')
			->with('room', Input::get('value'))
			->with('facilities', Facility::all())
			->with('services', Service::all());				
		
	}

	public function postUpdate() {
		// update an existing room type
						
		$room = RoomType::find(Session::get('room')->id);

		$room->name = Input::get('name');
		$room->facilities = json_encode(explode(',', Input::get('facilities')));
		$room->services = json_encode(explode(',', Input::get('services')));
		$room->no_of_rooms = Input::get('no_of_rooms');

		$room->save();
		Session::forget('room');
		return 1;
		
	}
}