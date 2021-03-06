<?php

class BookingController extends BaseController {

	public function __construnct() {
		// $this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('login');
	}

	public function getBooking1() {
		return View::make('booking.add1');
	}

	public function postBooking2() {

		$validator = Validator::make(Input::all(), Booking::$rules1);

		//validating the input fields
		if(!$validator->passes()) {
			return 'failure';
			
		}
		
		//getting all the values into sessions
		Session::put('id_no', Input::get('identificationNo'));
		Session::put('start_date', Input::get('startDate'));
		Session::put('end_date', Input::get('endDate'));
		Session::put('no_of_adults', Input::get('noOfAdults'));
		Session::put('no_of_kids', Input::get('noOfKids'));
		Session::put('no_of_rooms', Input::get('noOfRooms'));
		Session::put('promo_code', Input::get('promoCode'));

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

			$start_date = Session::get('start_date');
			$end_date = Session::get('end_date');
			
			// get the total of booked room types from the above selected room types
			$room_no = DB::select(DB::raw("SELECT SUM(no_of_rooms) as room_sum
										FROM bookings
										WHERE ((start_date >= '$start_date' AND start_date <= '$end_date') OR (end_date >= '$start_date' AND end_date <= '$end_date') OR ((start_date <= '$start_date' AND end_date >= '$end_date'))) AND room_type_id = $roomss->room_type_id AND check_out is null"));


			// adding the cart rooms to the room checking
			$cart_rooms = 0;

			foreach (Cart::contents() as $carts) {
				if($carts->id == $roomss->room_type_id) {
					$cart_rooms = $cart_rooms + $carts->quantity;
				}
			}

			//adding the room type to the combo box array if the rooms are available
			if((Session::get('no_of_rooms')+intval($room_no[0]->room_sum) + $cart_rooms)<=$room_type['no_of_rooms']) {
				$no_rooms[$room_type['id']] = $room_type['name'];
			}
		}
		//getting the rooms that has not been booked before
		if(!isset($arr_booked_rooms)) {
			//this selection is to avoid error happening in the first booking
			$arr_booked_rooms = array();
		}

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
		return $no_rooms;
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
	// create a new booking
		$variables = Input::get('variables');
		$var_arr = json_decode($variables);
		$room_type = $var_arr->chosenRoomType[0]->id;
		$room_details = RoomType::find($room_type);
		$service_id = $var_arr->chosenService[0]->id;

		$room_price = DB::table('room_price_calenders')
						->select('price')
						->where('start_date', '=', Session::get('start_date'))
						->where('service_id', '=', $service_id)
						->where('room_type_id', '=', $room_type)
						->get();

		if($room_price) {
			$date_difference = date_diff(date_create(Session::get('end_date')),date_create(Session::get('start_date')))->d;
			$totalCharge = $date_difference*$room_price[0]->price;
		}

		// checking the payment amount
		$payment = $var_arr->chosenAmount[0]->id;
		
		if($payment === 'full') {

			$payment_amount = floatval($totalCharge);
		} else {

			if($room_price) {
				$payment_amount = floatval($room_price[0]->price);
			}
		}

		//adding the booking to the cart
		$data = array(
			'id' => $room_type,
			'name' => $room_details->name,
			'quantity' => Session::get('no_of_rooms'),
			'price' => $totalCharge,
			'options' => array(
						'identification_no' => Session::get('id_no'),
						'no_of_adults' => Session::get('no_of_adults'),
						'no_of_kids' => Session::get('no_of_kids'),
						'services' => $service_id,
						'paid_amount' => $payment_amount,
						'promo_code' => Session::get('promo_code')
						)
			);
		
		if(Cart::insert($data)) {
			return 'success';
		} else {
			return 'failure';
		}

		
	}

	public function getCart() {
	// Show the summary of bookings

		return View::make('booking.cart');
	}

	public function postCart() {

		return Cart::contents(true);
	}

	public function postLoaditem() {
	// load services to the combobox when room types are selected

		$room_id = Input::get('room_type_id');
		$service_id = DB::table('room_price_calenders')
							->join('services', 'room_price_calenders.service_id', '=', 'services.id')
							->select('room_price_calenders.service_id', 'services.name')
							->where('room_type_id', $room_id)
							->where('start_date', '>=', Session::get('start_date'))
							->where('start_date', '<=', Session::get('end_date'))
							->distinct()
							->get();

		return $service_id;
	}

	public function postPlacebooking() {
	//Saving the booking details to the database

		foreach (Cart::contents() as $bookings) {
			$booking = new Booking();

			$booking->identification_no = $bookings->options['identification_no'];
			$booking->room_type_id = $bookings->id;
			$booking->no_of_rooms = $bookings->quantity;
			$booking->no_of_adults = $bookings->options['no_of_adults'];
			$booking->no_of_kids = $bookings->options['no_of_kids'];
			$booking->services = $bookings->options['services'];
			$booking->total_charges = $bookings->price;
			$booking->paid_amount = $bookings->options['paid_amount'];
			$booking->promo_code = $bookings->options['promo_code'];
			$booking->start_date = Session::get('start_date');
			$booking->end_date = Session::get('end_date');
			$booking->save();
		}
		Cart::destroy();
		return 'success';
	}

	public function getRemoveitem($identifier) {
	//Remove a booking from the cart
		
		$item = Cart::item($identifier);
		$item->remove();

		return Redirect::to('booking/cart');
	}

	//Search for bookings
	public function postSearch(){

		$uid = Input::get('uid');
		$booking_id = Input::get('booking_id');

		if($uid != null){
			$booking = DB::table('bookings')
				->where('identification_no', '=', $uid)
				->first();
			if ($booking == null){
				return 'failure';
			}
		}elseif($booking_id != null){
			$booking = DB::table('bookings')
				->where('id', '=', $booking_id)
				->first();
			if ($booking == null){
				return 'failure';
			}
		}
		$search_arr = array();

		$search_arr['booking_id'] = $booking->id;
		$search_arr['identification_no'] = $booking->identification_no;
		$search_arr['room_type_id'] = $booking->room_type_id;
		$search_arr['no_of_rooms'] = $booking->no_of_rooms;
		$search_arr['no_of_adults'] = $booking->no_of_adults;
		$search_arr['no_of_kids'] = $booking->no_of_kids;
		$search_arr['services'] = $booking->services;
		$search_arr['total_charges'] = $booking->total_charges;
		$search_arr['paid_amount'] = $booking->paid_amount;
		$search_arr['check_in'] = $booking->check_in;
		$search_arr['check_out'] = $booking->check_out;
	
		return $search_arr;
	}

	//views the search page
	public function getSearch() {
		return View::make('booking.search');
	}


	public function getDestroy() {
		// display the booking delete page
		return View::make('booking.delete');
	}

	public function postDestroy() {
		// delete a booking

		$booking = Booking::find(Input::get('booking_id'));

		if($booking) {

			$transaction = DB::table('transactions')
					->where('booking_id',Input::get('booking_id'))
					->get();

			$policy = DB::table('policies')
						->where('description', "Cancel")
						->get();
			

			$charge = floatval($booking->paid_amount);

			//calculating the date difference between today and the upcoming booking date
			$date_difference = strtotime($booking->start_date) - strtotime(date("Y-m-d h:i:s"));
			$no_of_days = $date_difference/(3600*24);

			

			$cancellation_details = json_decode($policy[0]->variables);
			$cancellation_days = $cancellation_details->days;
			$cancellation_rate = $cancellation_details->rate;


			if($no_of_days > $cancellation_days) {

				$cancellation_charge = $charge*$cancellation_rate;

				$booking->paid_amount = $cancellation_charge;
				$booking->cancellation = 1;

				$booking->save();

				return 'success';
			} else {

				$cancellation_charge = 0;

				$booking->paid_amount = $cancellation_charge;
				$booking->cancellation = 1;

				$booking->save();

				return 'success';
			}	
		} else {
			return 'failure';
		}
	}
}