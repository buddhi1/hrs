<?php

class ServiceController extends BaseController {

	public function __construct() {
		$this->beforeFilter('csrf',array('on' => 'post'));
	}

	public function getIndex() {
	// display all the services on the database

		return View::make('service.view')
			->with('services', Service::all());
	}

	public function postCreate() {
	// add a new service to the database

		$service = new Service();

		//checking whether a service already exists

		$service_name = DB::table('services')->where('name', Input::get('name'))->first();

		if(!$service_name) {
			$service->name = Input::get('name');

			$service->save();

			return Redirect::to('admin/service')
				->with('ser_message_add','Service is succesfully added');
		}

		return Redirect::to('admin/service')
			->with('ser_message_err','Service already exists');

		
	}

	public function postDestroy() {
	// delete a service from the database

		$service = Service::find(Input::get('id'));


		// remove the deleted service from the room types table
		$rooms = DB::table('room_types')->get();
		// var_dump($ser);
		// die();

		foreach ($rooms as $room) {
			$json = json_decode($room->services, true);
			// var_dump($json);
			// die();
			if(($key = array_search($service->name, $json)) !== false) {
			    unset($json[$key]);
			    $json = array_values($json);

			    //after the delete updating the services table
			    DB::table('room_types')
			    	->where('id', $room->id)
			    	->update(array('services'=> json_encode($json)));


			}
		}


		if($service) {
			$service->delete();

			return Redirect::To('admin/service')
				->with('ser_message_del','Service is successfully deleted');
		}

		return Redirect::To('admin/service')
			->with('ser_message_del','Service is successfully deleted');
	}
}