<?php

class RoomController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex() {
		return View::make('room.view')
			->with('rooms', RoomType::all());
	}

	public function getCreate() {
		return View::make('room.add')
			->with('facilities', Facility::all())
			->with('services', Service::all());
	}

	public function postCreate() {
		$room = New RoomType();

		$fac = implode('","name": "',Input::get('facility'));
		$ser = implode('","name": "',Input::get('service'));

		$room->name = Input::get('name');
		$room->facilities = '{"name": "'.$fac.'"}';
		$room->services = '{"name": "'.$ser.'"}';
		$room->no_of_rooms = Input::get('no_of_room');

		$room->save();

		return Redirect::to('admin/room')
			->with('room_message_add','Room is succesfully added');
	}
}