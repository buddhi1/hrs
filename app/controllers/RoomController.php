<?php

class RoomController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
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
		$room->facilities = json_encode(Input::get('facility'));
		$room->services = json_encode(Input::get('service'));
		$room->no_of_rooms = Input::get('no_of_room');

		$room->save();

		return Redirect::to('admin/room')
			->with('room_message_add','Room is succesfully added');
	}

	public function postDestroy() {
	// delete a room type from the database

		$room = RoomType::find(Input::get('id'));

		if($room) {
			$room->delete();

			return Redirect::To('admin/room')
				->with('room_message_del','Room type is successfully deleted');
		}
	}
}