<?php

class BookingController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getBooking1() {
		return View::make('booking.add1');
	}

	public function postBooking2() {

			Session::put('id_no', Input::get('id_no'));
			Session::put('start_date', Input::get('start_date'));
			Session::put('end_date', Input::get('end_date'));
			Session::put('no_of_adults', Input::get('no_of_adults'));
			Session::put('no_of_kids', Input::get('no_of_kids'));
			Session::put('no_of_rooms', Input::get('no_of_rooms'));
			Session::put('promo_code', Input::get('promo_code'));
			
			return View::make('booking.add2');


		// return Redirect::To('booking/booking1')
		// 	->with('message', 'All the fields are required')
		// 	->withInput();
	}

	public function postCreate() {
	// Create a new booking



			$room = RoomType::find(Input::get('room_type_id'));
			$calendar = DB::table('room_price_calenders')
								->where('room_type_id', '=', Input::get('room_type_id'))
								->where('service_id', '=', Input::get('service_id'))
								->where('start_date', '=', Session::get('start_date'))
								->where('end_date', '=', Session::get('end_date'));

			var_dump($calendar);
			die();

			$data = array(
				'id' => Input::get('room_type_id'),
				'name' => $room->name,
				'qty' => Session::get('no_of_rooms'),
				'price' => $price
				);

			Cart::insert($data);

			/*$booking = new Booking();

			$booking->identification_no = Session::get('id_no');
			$booking->room_type_id = Input::get('room_type_id');
			$booking->no_of_rooms = Session::get('no_of_rooms');
			$booking->no_of_adults = Session::get('no_of_adults');
			$booking->no_of_kids = Session::get('no_of_kids');
			$booking->services = json_encode(Input::get('service'));
			$booking->total_charges = Input::get('total_charges');
			$booking->paid_amount = Input::get('paid_amount');
			$booking->check_in = Input::get('check_in');
			$booking->check_out = Input::get('check_out');
			$booking->promo_code = Session::get('promo_code');

			$booking->save();*/
		return Redirect::To('/');
	}
}