<?php

/*
	Name:		PromotionController
	Purpose:	Controllers for Promotion_Calendar

	History:	Created 02/03/2015 by buddhi ashan	 
*/

class PromotionController extends BaseController{

	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
	}

	//Views the create promotion page
	public function getCreate(){
		return View::make('promotion.create')
			->with('services',Service::all());
	}

	// add a new promotion to the database
	public function postCreate() {
	

		$validator = Validator::make(Input::all(), PromoCode::$rules);

		if($validator->passes()) {

			//read from date
			$date = Input::get('from');
			$price = Input::get('price');
			$stays = Input::get('stays');
			$room_type_id = Input::get('room_id');
			$rooms = Input::get('rooms');

			//validate the availability for the same promotion
			$record = DB::table('promotion_calenders')
				->where('room_type_id','=', $room_type_id)
				->where('start_date','=', $date)
				->where('end_date','=', Input::get('to'))
				->where('services','=', json_encode(Input::get('service')))
				->get();

			if(!$record){
				//convert from date to dateTime format
				$from = new DateTime($date );
				//convert to date to dateTime format
				$to = new DateTime(Input::get('to'));

				//finds the days between from and to dates
				$days = $to->diff($from)->format("%a");		
				
				//loop inserts new rows for all days between from and to dates
				for ($i=0; $i <= $days; $i++) { 
					$promotion = New Promotion();

					$promotion->start_date = $date;
					$promotion->end_date = $to;
					$promotion->price = $price;
					$promotion->days = $stays;
					$promotion->room_type_id = $room_type_id;
					$promotion->no_of_rooms = $rooms;
					$promotion->services = json_encode(Input::get('service'));
					$promotion->save();
					//get next date
					$date = date('Y-m-d', strtotime($date.' +1 day'));	
				}	

				return Redirect::to('admin/promotion/create')
					->with('message','Promotion has been added to calendar succesfully');
			}
		
			return Redirect::to('admin/promotion/create')
				->with('message','The promotion already exists');
			
		}

		return Redirect::to('admin/promotion/create')
			->with('message','Something went wrong.Please try again')
			->withErrors($validator)
			->withInput();
	}

	//Views index page of promotion calendar
	public function getIndex(){
		return View::make('promotion.index')
			->with('start_date', DB::table('promotion_calenders')->orderBy('start_date')->pluck('start_date'))
			->with('end_date', DB::table('promotion_calenders')->orderBy('start_date', 'desc')->pluck('start_date'))
			->with('rooms', DB::table('promotion_calenders')->select('id','room_type_id','services')->groupBy('room_type_id')->get())
			->with('calendar', DB::table('promotion_calenders')->select(DB::raw('count(*) as days'),'id','room_type_id','end_date','price','discount_rate',
				'service_id','start_date')->groupBy('end_date','room_type_id','service_id')->get());
	}
}