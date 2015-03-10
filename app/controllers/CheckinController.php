<?php

class CheckinController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex() {
		return View::make('checkin.add');
	}

	public function postCreate() {
		$check = new Checkin();

		$check->authorizer = Input::get('auth');
		$check->check_in = Input::get('check_in');
		$check->check_out = Input::get('check_out');
		$check->advance_payment = Input::get('advance_payment');
		$check->payment = Input::get('payment');
		$check->booking_id = Input::get('booking_id');

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

	public function getAddpayment() {
		return View::make('checkin.search');
	}

	// public function postSearch() {
	// 	$check = Checkin::find(Input::get('check_id'));

	// 	$book = Booking::find($check->booking_id);

	// 	$total = 0;

	// 	if(is_array(json_decode($check->payment, true))) {
	// 		foreach(json_decode($check->payment, true) as $payment) {
	// 		$total = $total+$payment;
	// 		}
	// 	} else {
	// 		$total = intval(json_decode($check->payment, true));
	// 	}

	// 	$amount_due = $book->total_charges - $total;

	// 	return Redirect::to('admin/checkin/addpayment')
	// 		->with('checkin', $check)
	// 		->with('booking', $book)
	// 		->with('payment', $total)
	// 		->with('due', $amount_due);
	// }

	// public function postUpdate() {

	// }
}