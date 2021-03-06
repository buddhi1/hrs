<?php

class ServiceController extends BaseController {

	public function __construct() {
		// $this->beforeFilter('csrf',array('on' => 'post'));
		$this->beforeFilter('user_group');
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

			return 1;
		}

		return 0;

		
	}

	public function deleteService($table,$name) {
		// This function is used to delete a service from any table when the original service is deleted.

		$rooms = DB::table($table)->get();

		foreach ($rooms as $room) {
			$json = json_decode($room->services, true);

			if(($key = array_search($name, $json)) !== false) {
			    unset($json[$key]);
			    $json = array_values($json);

			    //after the delete updating the services table
			    DB::table($table)
			    	->where('id', $room->id)
			    	->update(array('services'=> json_encode($json)));
			}
		}
	}

	public function postDestroy() {
	// delete a service from the database

		$service = Service::where('name', '=', Input::get('name'))->first();

		$room_calendar = Calendar::where('service_id', '=', $service->id)->first();
		if($room_calendar) {
			return 0;
		} else {
			// remove the deleted service from the room types table
			$this->deleteService('room_types', $service->name);


			if($service) {
				$service = Service::find($service->id);
				$service->delete();

				return 1;
			}
		}
		
		return 0;
	}
}