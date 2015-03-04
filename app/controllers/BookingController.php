<?php

class BookingController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getBooking1() {
		return View::make('booking.add1');
	}

	public function postBooking2() {

			//getting all the values into sessions
			Session::put('id_no', Input::get('id_no'));
			Session::put('start_date', Input::get('start_date'));
			Session::put('end_date', Input::get('end_date'));
			Session::put('no_of_adults', Input::get('no_of_adults'));
			Session::put('no_of_kids', Input::get('no_of_kids'));
			Session::put('no_of_rooms', Input::get('no_of_rooms'));
			Session::put('promo_code', Input::get('promo_code'));

			$room = RoomType::find(Input::get('room_type_id'));

			//array to load the comobo box
			$no_rooms = array();

			// get all the room types that have prices withing the booked date
			$calendar = DB::table('room_price_calenders')
								->select('room_type_id')
								->where('start_date', '>=', Session::get('start_date'))
								->where('start_date', '<=', Session::get('end_date'))
								->where('end_date', '>=', Session::get('end_date'))
								->distinct()
								->get();

			foreach ($calendar as $roomss) {

				
				$room_type = RoomType::find($roomss->room_type_id);
				$booked_rooms = DB::table('bookings')
										->select('room_type_id')
										->distinct()
										->get();

				$arr_booked_rooms = array();

				foreach ($booked_rooms as $book) {
					$arr_booked_rooms[] = $book->room_type_id;
				}
				
				// get the total of booked room types from the above selected room types
				$room_no = DB::table('bookings')
								->whereNull('check_out')
								->where('room_type_id', $roomss->room_type_id)
								->sum('no_of_rooms');

				//adding the room type to the combo box array if the rooms are available
				if((Session::get('no_of_rooms')+$room_no)<=$room_type['no_of_rooms']) {
					$no_rooms[$room_type['id']] = $room_type['name'];
				}
			}

			//getting the rooms that has not been booked before
			$not_booked_rooms = DB::table('room_price_calenders')
									->select('room_types.name', 'room_types.id')
									->distinct()
									->join('room_types', 'room_types.id', '=', 'room_price_calenders.room_type_id')
									->where('start_date', '>=', Session::get('start_date'))
									->where('start_date', '<=', Session::get('end_date'))
									->where('room_types.no_of_rooms', '>=', Session::get('no_of_rooms'))
									->where('room_price_calenders.end_date', '>=', Session::get('end_date'))
				                    ->whereNotIn('room_price_calenders.room_type_id', $arr_booked_rooms)
				                    ->get();

			//adding the rooms that are not booked before to the combo box array
			foreach ($not_booked_rooms as $book) {
				$no_rooms[$book->id] = $book->name;
			}
			
			//sending the combo box array to the next page
			return View::make('booking.add2')
				->with('rooms', $no_rooms);
	}


	public function postPrice() {
		// get all the prices withing the given date range and within give services and room type

		$prices = DB::table('room_price_calenders')
						->where('start_date', '>=', Session::get('start_date'))
						->where('start_date', '<=', Session::get('end_date'))
						->where('service_id', '=', Input::get('service_id'))
						->where('room_type_id', '=', Input::get('room_type_id'))
						->get();


		$price_list = array();
		$total = 0;
		foreach ($prices as $price) {
			$price_list[] = $price->price;
			$total = $total+$price->price;
		}
		
		return $total;
	}

	public function postCreate() {
	// Create a new booking

		/*$data = array(
			'id' => Input::get('room_type_id'),
			'name' => $room->name,
			'qty' => Session::get('no_of_rooms'),
			'price' => $price
			);

		Cart::insert($data);*/

		$booking = new Booking();

		$booking->identification_no = Session::get('id_no');
		$booking->room_type_id = Input::get('room_type');
		$booking->no_of_rooms = Session::get('no_of_rooms');
		$booking->no_of_adults = Session::get('no_of_adults');
		$booking->no_of_kids = Session::get('no_of_kids');
		$booking->services = Input::get('service');
		$booking->total_charges = Input::get('total_charges');
		$booking->paid_amount = Input::get('paid_amount');
		$booking->promo_code = Session::get('promo_code');

		$booking->save();
		Session::flush();

		return Redirect::To('booking/booking1')
			->with('message', 'Booking is sucessful');
	}

	public function loaditem() {
		$room_id = Input::get('room_type_id');
		$service_id = DB::table('room_price_calenders')
							->join('services', 'room_price_calenders.service_id', '=', 'services.id')
							->select('room_price_calenders.service_id', 'services.name')
							->where('room_type_id', $room_id)
							->where('start_date', '>=', Session::get('start_date'))
							->where('start_date', '<=', Session::get('end_date'))
							->distinct()
							->get();

		return Response::json($service_id);
	}
}