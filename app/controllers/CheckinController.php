<?php

class CheckinController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getCreate() {
		
		return View::make('checkin.add')
		->with('booking_id', Input::get('booking_id'))
		->with('identification_no', Input::get('identification_no'));
	}

	public function postCreate() {
		$check = new Checkin();

		$check->authorizer = Input::get('auth');
		$check->check_in = Input::get('check_in');
		$check->check_out = Input::get('check_out');
		$check->advance_payment = Input::get('advance_payment');
		$check->payment = Input::get('payment');
		$check->booking_id = Input::get('booking_id');
		//var_dump($check);
		//die();
		if($check->check_in === '1') {
			$check->check_in = date('Y-m-d H:i:s');
		}

		if($check->check_out === '1') {
			$check->check_out = date('Y-m-d H:i:s');
		}

		if($check->payment) {
			$check->payment = json_encode($check->payment);
		}

		if($check) {
			$booking = Booking::find($check->booking_id);

			$check->save();

			if($check->check_in) {
				$booking->check_in = $check->check_in;
			}

			if($check->check_out) {
				$booking->check_out = $check->check_out;
			}

			$booking->save();
			
			return Redirect::to('admin/checkin')
				->with('message', 'Checkin Successful');
		}
	}

	//views the index page
	public function getIndex() {
		return View::make('checkin.index');
	}

	
}