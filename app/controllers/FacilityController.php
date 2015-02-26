<?php

class FacilityController extends BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex() {
		//display all the facilities in the database

		return View::make('facility.view')
			->with('facilities', Facility::all());
	}

	public function postCreate() {
		//add a facility to the database

		$facility = new Facility();

		//checking whether a facility already exists

		$fac_name = DB::table('facilities')->where('name', Input::get('name'))->first();

		if(!$fac_name) {

			$facility->name = input::get('name');

			$facility->save();

			return Redirect::To('admin/facility')
				->with('fac_message_add','Facility is succesfully added');
		} 

		return Redirect::To('admin/facility')
			->with('fac_message_err','Facility already exists');
	}

	public function postDestroy(){
		//delete a facility from the database

		$facility = Facility::find(Input::get('id'));

		if($facility) {
			$facility->delete();

			return Redirect::To('admin/facility')
				->with('fac_message_del','Facility is successfully deleted');
		}

	}
}