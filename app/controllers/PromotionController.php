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
				'services','start_date')->groupBy('end_date','room_type_id')->get());
	}

	//Deletes the time line block of selected room type		

	public function postDestroy(){
		
		DB::table('promotion_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('services','=',Input::get('services'))
			->where('end_date','=',Input::get('date'))
			->delete();

		return Redirect::to('admin/promotion/index')
			->with('message','Record removed successfully');
	}

	//Deletes the whole time line of a selected room type
	public function postDestroytimeline(){

		DB::table('promotion_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->delete();

		return Redirect::to('admin/promotion/index')
			->with('message','Time line removed successfully');
	}

	//Views the time line block edit page
	public function postEdit(){
		return View::make('promotion.edit')
			->with('services', Service::all());
	}

	//Views the time line edit page of selected room type
	public function postEdittimeline(){
		return View::make('promotion.edittimeline')
			->with('services', Service::all());
	}


	//Update function for edit time line block
	public function postUpdate(){

		$validator = Validator::make(Input::all(), PromoCode::$rules);

		if($validator->passes()) {

			DB::table('promotion_calenders')
				->where('room_type_id','=',Input::get('room_id'))
				->where('services','=',Input::get('serviceArray'))
				->where('end_date','=', Input::get('to'))
				->update(['price'=>Input::get('price'),
							'discount_rate'=>Input::get('discount'),
							'services'=>json_encode(Input::get('service'))]);

			return Redirect::to('admin/promotion/index')
				->with('message', 'Calendar record has been update successfully');	
		}
		return Redirect::to('admin/promotion/index')
			->with('message', 'Something went wrong.Please try again')
			->withErrors($validator)
			->withInput();	
	}

	//Update function for edit time line for selected room type
	public function postUpdatetimeline(){

	}
}
