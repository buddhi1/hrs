<?php

class CustomerController extends BaseController {

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	public function getIndex() {
	// display the index page where customer can select dates
		return View::make('customer.index');
	}

	public function getRooms() {
		return View::make('customer.rooms');
	}

	public function postRooms() {
		$start_date = Input::get('start_date');
		$end_date = Input::get('end_date');

		//output array
		$all_available_rooms = array();

		//get all prices set rooms within given dates
		$calendar = DB::table('room_price_calenders')
								->select('room_type_id', 'price', 'service_id', 'discount_rate')
								->where('start_date', '>=', $start_date)
								->where('start_date', '<=', $end_date)
								->where('end_date', '>=', $end_date)
								->distinct()
								->get();

		foreach ($calendar as $room_types) {
			$single_room = array();

			// get the total of booked room types from the above selected room types
			$room_no = DB::table('bookings')
							->whereNull('check_out')
							->where('room_type_id', $room_types->room_type_id)
							->sum('no_of_rooms');



			$cart_rooms = 0;

			//getting rooms in the cart
			foreach (Cart::contents() as $carts) {
				if($carts->id == $room_types->room_type_id) {
					$cart_rooms = $cart_rooms + $carts->quantity;
				}
			}


			//get room type details of the available rooms
			$available_room = RoomType::find($room_types->room_type_id);
			$available_service = Service::find($room_types->service_id);
			
			$single_room["id"] = $available_room['id'];
			$single_room["name"] = $available_room['name'];
			$single_room["service"] = $available_service['name'];
			$single_room["price"] = $room_types->price;
			$single_room["facility"] = $available_room['facilities'];

			//calculating the availble rooms
			$single_room["rooms_qty"] = $available_room['no_of_rooms']-$cart_rooms-intval($room_no);

			$all_available_rooms[] = $single_room;
			
		}

		return View::make('customer.rooms')
			->with('available_rooms',$all_available_rooms);
	}

	public function postBookingsummary() {
		$summary = array();

		$summary['name'] = Input::get('name');
		$summary['service'] = Input::get('service');
		$summary['facility'] = Input::get('facility');
		$summary['price'] = Input::get('price')*Input::get('number');
		$summary['room_no'] = Input::get('number');
		$summary['no_of_adults'] = Input::get('no_of_adults');
		$summary['no_of_kids'] = Input::get('no_of_kids');

		Session::put('name', $summary['name']);
		Session::put('service', $summary['service']);
		Session::put('facility', $summary['facility']);
		Session::put('price', $summary['price']);
		Session::put('room_no', $summary['room_no']);
		Session::put('no_of_adults', $summary['no_of_adults']);
		Session::put('no_of_kids', $summary['no_of_kids']);

		return View::make('customer.summary')
			->with('summarys', $summary);
	}

	public function postCustomerform() {
		return View::make('customer.add');
	}

	public function postCreate() {

		$validator = Validator::make(Input::all(), Customer::$rules);

		if($validator->passes()) {
			Customer::Create(Input::all());

			return Redirect::to('customer/customerform')
				->with('message', 'Customer is Successfully Created');
		}

		return Redirect::to('customer/customerform')
			->withInput()
			->withErrors($validator);
	}
}