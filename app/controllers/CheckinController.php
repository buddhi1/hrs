<?php

class CheckinController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	public function getCheckindetails() {

		Session::put('booking_id', Input::get('booking_id'));
	}

	public function getCreate() {

		return View::make('checkin.add');
	}

	public function postOnload() {

		$booking_id = Session::get('booking_id');
		$payment = DB::table('bookings')
						->select('paid_amount','total_charges')
						->where('id', '=', $booking_id)
						->first();
		
		$check_arr = array();
		$check_arr['booking_id'] = $booking_id;
		$check_arr['payment'] = $payment->total_charges;
		$check_arr['paid'] = $payment->paid_amount;

		return $check_arr;
	}

	//marks checkin and checkout
	public function postCreate() {

		$booking_id = Input::get('bookingID');
		
		$checkin = DB::table('checkins')->where('booking_id', '=', $booking_id)->first();
	
		if($checkin == null){
			$check = new Checkin();
			$pay_arr = array();
			$pay_arr[0] = Input::get('paid');
			$pay_arr[1] = Input::get('advancedPay');


			$check->authorizer = 1;	//Auth::id()
			$check->check_in = Input::get('checkin');
			$check->check_out = Input::get('check_out');
			$check->advance_payment = Input::get('advancedPay');
			$check->payment = json_encode($pay_arr);
			$check->booking_id = $booking_id;
			
			if($check->check_in === 'true') {
				$check->check_in = date('Y-m-d H:i:s');
			}

			if($check->check_out === 'true') {
				$check->check_out = date('Y-m-d H:i:s');
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
				Session::forget('booking_id');
				
				return 'success';
			}
		
		}
	}

	//views the index page
	public function getIndex() {

		return View::make('checkin.index');
	}

	public function postIndex() {

		$checkins = Checkin::all();
		return $checkins;
	}

	public function getEdit(){
		//show the edit page

		return View::make('checkin.edit');	
	}

	public function postEdit() {
		//load booking_id and payment fields onLoad of edit page
		$total = 0;
		$booking_id = Session::get('booking_id');
		$payments = DB::table('checkins')->where('booking_id', '=', $booking_id)->pluck('payment');
		$total_charge = DB::table('bookings')->where('id', '=', $booking_id)->pluck('total_charges');
		$pay_arr = json_decode($payments);
		foreach ($pay_arr as $key => $value) {
			$total += floatval($value);
		}

		$check_arr = array();
		$check_arr['booking_id'] = $booking_id;
		$check_arr['payments'] = $total;
		$check_arr['total_charge'] = $total_charge;
		return $check_arr;
	}
	
	public function postUpdate(){
		//update the checkin table with checkout details

		$booking_id = Input::get('bookingID');
		$checkin = DB::table('checkins')->where('booking_id', '=', $booking_id)->first();

		if($checkin != null){

			$payment = Input::get('payment');

			if($payment){
				$payHistory = DB::table('checkins')->where('booking_id', '=', $booking_id)->pluck('payment');
				if($payHistory != null){
					
					$pay = json_decode($payHistory,true);
					$pay[] = $payment;

					DB::table('checkins')->where('booking_id', '=', $booking_id)
						->update(['payment'=>json_encode($pay)]);
				}elseif($payHistory == null){
					DB::table('checkins')->where('booking_id', '=', $booking_id)
						->update(['payment'=>'['.json_encode($payment).']']);
				}
			}

			if(Input::get('checkout') === 'true') {
				DB::table('checkins')->where('booking_id', '=', $booking_id)
					->update(['check_out'=>date('Y-m-d H:i:s')]);

				DB::table('bookings')->where('id', '=', $booking_id)
					->update(['check_out'=>date('Y-m-d H:i:s')]);
			}
			Session::forget('booking_id');
			return 'success';
		} else {
			return 'failure';
		}
	}

	public function postNewpayment() {
		// put the checkin_id to the session

		Session::put('checkin_id',Input::get('id'));
		return 'success';
	}

	public function getAddpayment() {
		// return the payment blade

		if(Session::has('checkin_id')) {

			return View::make('checkin.payment');
		}
	}

	public function postAddpayment() {
		// return the payment blade

		$checkin_id = Session::get('checkin_id');
		$checkin = DB::table('checkins')
						->select('booking_id', 'payment')
						->where('id','=',$checkin_id)
						->first();

		$booking_id = $checkin->booking_id;
		$paid = $checkin->payment;

		if($booking_id) {

			$payment = DB::table('bookings')
							->where('id', '=', $booking_id)
							->pluck('total_charges');
		}

		$check_arr = array();
		$check_arr['checkin_id'] = $checkin_id;
		$check_arr['booking_id'] = $booking_id;
		$check_arr['payment'] = $payment;
		$check_arr['paid'] = $paid;

		return $check_arr;
	}
}