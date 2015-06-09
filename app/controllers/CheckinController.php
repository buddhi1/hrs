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
		return $booking_id;
	}

	//marks checkin and checkout
	public function postCreate() {

		$booking_id = Input::get('bookingID');
		
		$checkin = DB::table('checkins')->where('booking_id', '=', $booking_id)->first();
	
		if($checkin == null){
			$check = new Checkin();

			$check->authorizer = 1;	//Auth::id()
			$check->check_in = Input::get('checkin');
			$check->check_out = Input::get('check_out');
			$check->advance_payment = Input::get('advancedPay');
			$check->payment = Input::get('payment');
			$check->booking_id = $booking_id;
			
			if($check->check_in === 'true') {
				$check->check_in = date('Y-m-d H:i:s');
			}

			if($check->check_out === 'true') {
				$check->check_out = date('Y-m-d H:i:s');
			}
/*
			if($check->payment) {
				$check->payment = json_encode($check->payment);
			}
*/
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
		return View::make('checkin.index')
			->with('checkins', Checkin::all());
	}

	public function getEdit(){
		//show the edit page

		return View::make('checkin.edit');	
	}

	public function postEdit() {

		
		// ->with('booking_id', Input::get('booking_id'))
		// ->with('identification_no', Input::get('identification_no'))
		// ->with('check_in', Input::get('check_in'))
		// ->with('check_out', Input::get('check_out'))
		// ->with('payments', DB::table('checkins')->where('booking_id', '=', Input::get('booking_id'))->pluck('payment'))
	}
	

	//Update functionality
	public function postUpdate(){

		$booking_id = Input::get('booking_id');
		$checkin = DB::table('checkins')->where('booking_id', '=', $booking_id)->first();

		if($checkin != null){

			$payment = Input::get('payment');

			if($payment){
				$payHistory = DB::table('checkins')->where('booking_id', '=', $booking_id)->pluck('payment');
				if($payHistory != null){
					$pay = json_decode($payHistory);
					$pay[] = $payment;

					DB::table('checkins')->where('booking_id', '=', $booking_id)
						->update(['payment'=>json_encode($pay)]);

		
				}elseif($payHistory == null){
					DB::table('checkins')->where('booking_id', '=', $booking_id)
						->update(['payment'=>'['.json_encode($payment).']']);

				}
				
			
			}

			if(Input::get('check_out') === '1') {
				DB::table('checkins')->where('booking_id', '=', $booking_id)
					->update(['check_out'=>date('Y-m-d H:i:s')]);

				DB::table('bookings')->where('id', '=', $booking_id)
					->update(['check_out'=>date('Y-m-d H:i:s')]);
			}

			
			return Redirect::to('admin/checkin')
					->with('message', 'Checkin Updated');
		}
	}
}