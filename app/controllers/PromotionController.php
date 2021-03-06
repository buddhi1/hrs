<?php

/*
	Name:		PromotionController
	Purpose:	Controllers for Promotion_Calendar

	History:	Created 02/03/2015 by buddhi ashan	 
*/

class PromotionController extends BaseController{

	public function __construnct() {
		// $this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	//Views the create promotion page
	public function getCreate(){
		return View::make('promotion.create')
			->with('services',Service::all())
			->with('roomTypes', RoomType::all(['id', 'name']));
	}

	// add a new promotion to the database
	public function postCreate() {	
		
		//read from date
		$date = date('Y-m-d', strtotime(Input::get('from').' 0 day'));
		$price = Input::get('price');
		$stays = Input::get('stays');
		$room_type_id = Input::get('room_id');
		$rooms = Input::get('rooms');
		$discount = Input::get('discount');

		//validate the availability for the same promotion
		$record = DB::table('promotion_calenders')
			->where('room_type_id','=', $room_type_id)
			->where('start_date','=', $date)
			->where('services','=', json_encode(explode(',', Input::get('services'))))
			->get();
			
		if(!$record){
			//convert from date to dateTime format
			$from = new DateTime($date);
			//convert to date to dateTime format
			$to = new DateTime(Input::get('to'));

			//finds the days between from and to dates
			$days = $to->diff($from)->format("%a");		
			
			//loop inserts new rows for all days between from and to dates
			for ($i=0; $i <= $days; $i++) { 
				$promotion = New Promotion();

				$promotion->start_date = date('Y-m-d', strtotime($date.' +0 day'));
				$promotion->end_date = $to;
				$promotion->price = $price;
				$promotion->discount_rate = $discount;
				$promotion->days = $stays;
				$promotion->room_type_id = $room_type_id;
				$promotion->no_of_rooms = $rooms;
				$promotion->services = json_encode(explode(',', Input::get('services')));;
				$promotion->save();
				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}	

			return 1;
		}
	
		return 2;
			
		
	}

	//Views index page of promotion calendar
	public function getIndex(){
		// 
		// DB::table('promotion_calenders')->select('id','room_type_id','services')->groupBy('room_type_id')->get()
		return View::make('promotion.index')
			->with('start_date', DB::table('promotion_calenders')->orderBy('start_date')->pluck('start_date'))
			->with('end_date', DB::table('promotion_calenders')->orderBy('start_date', 'desc')->pluck('start_date'))
			->with('rooms',Promotion::select('id','room_type_id','services')->groupBy('room_type_id')->get())
			->with('calendar', Promotion::select(DB::raw('count(*) as days'),'id','room_type_id','end_date','price','discount_rate',
				'services','start_date')->groupBy('end_date','room_type_id')->get());
	}

	//Deletes the time line block of selected room type		

	public function postDestroy(){


		DB::table('promotion_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('services','=',json_encode(explode(',', Input::get('services'))))
			->where('end_date','=',Input::get('to'))
			->delete();
		return 1;
	}

	//Deletes the whole time line of a selected room type
	public function postDestroytimeline(){
		
		DB::table('promotion_calenders')
			->where('room_type_id','=',Input::get('room_type_id'))
			->delete();

		return 1;
	}

	//Views the time line block edit page
	public function postEdit(){

		Session::put('promotion_id', Input::get('id'));
		return 1;
	}

	public function getEdit(){

		$record = Promotion::find(Session::get('promotion_id'));
		
		return View::make('promotion.edit')
			->with('services', Service::all())
			->with('promotion', Promotion::find(Session::get('promotion_id')))
			->with('roomTypes', RoomType::all(['id', 'name']))
			->with('room_name', RoomType::find($record->room_type_id)); 	
	}

	//Views the time line edit page of selected room type
	public function postEdittimeline(){
		
		// $start_date = DB::table('promotion_calenders')->where('room_type_id','=',Input::get('room_type_id'))->first();
		// $record = DB::table('promotion_calenders')->where('room_type_id','=',Input::get('room_type_id'))->first();

		Session::put('promotion_id', Input::get('id'));
		return 1;

		// return View::make('promotion.edittimeline')
		// 	->with('services', Service::all())
		// 	->with('start_date', $start_date)
		// 	->with('record', $record)
		// 	->with('checks', json_decode($record->services));
	}

	public function getEdittimeline() {
	// display the edit promotion
		$record = Promotion::find(Session::get('promotion_id'));

		return View::make('promotion.edittimeline')
			->with('services', Service::all())
			->with('promotion', Promotion::find(Session::get('promotion_id')))
			->with('room_name', RoomType::find($record->room_type_id));				
		
	}


	//Update function for edit time line block
	public function postUpdate(){
		
		$stays = Input::get('stays');
		$rooms = Input::get('rooms');
		
		DB::table('promotion_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('services','=',json_encode(explode(',', Input::get('serviceArray'))))
			->where('end_date','=', Input::get('to'))
			->update(['price'=>Input::get('price'),
						'discount_rate'=>Input::get('discount'),
						'services'=>json_encode(explode(',', Input::get('services'))),
						'days'=>$stays,
						'no_of_rooms'=>$rooms]);

		return 1;	
		
	}

	//Update function for edit time line for selected room type
	public function postUpdatetimeline(){
		
		$top_date = Input::get('sdate');
		$bottom_date = Input::get('edate');
		$from_date = date('Y-m-d', strtotime(Input::get('from').' 0 day'));
		$to_date = date('Y-m-d', strtotime(Input::get('to').' 0 day'));
		$services = json_encode(explode(',', Input::get('services')));
		$stays = Input::get('stays');
		$rooms = Input::get('rooms');

		//reads the end date of editing time line block
		$end_date = DB::table('promotion_calenders')
		->where('start_date','=',$from_date)
		->where('room_type_id','=',Input::get('room_id'))
		->where('services','=', $services)
		->get();
		
		//replacing existing time line with a single price and discount

	if($top_date >= $from_date && $bottom_date <= $to_date){

		//deletes ovelapping records
		DB::table('promotion_calenders')
		->where('room_type_id','=',Input::get('room_id'))
		->where('services','=', $services)
		->delete();

		//read from date
		$date = $from_date;	

		//convert from date to dateTime format
		$from = new DateTime($date );
		//convert to date to dateTime format
		$to = new DateTime(Input::get('to'));

		//finds the days between from and to dates
		$days = $to->diff($from)->format("%a");		
		
		//loop inserts new rows for all days between from and to dates
		for ($i=0; $i <= $days; $i++) { 
			$promotion = new Promotion;
			$promotion->room_type_id = Input::get('room_id');
			$promotion->services = $services;
			$promotion->start_date = $date;
			$promotion->end_date = new DateTime($to_date);
			$promotion->price = Input::get('price');
			$promotion->discount_rate = Input::get('discount');			
			$promotion->no_of_rooms = $rooms;
			$promotion->days = $stays;

			$promotion->save();

			//get next date
			$date = date('Y-m-d', strtotime($date.' +1 day'));	
		}

		return 1;	
	}

	//replacing existing block(s) in time line
	elseif($top_date < $from_date || $bottom_date > $to_date){

		

		//deletes ovelapping records
		DB::table('promotion_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('services','=', $services)
			->where('start_date','>=',$from_date)
			->where('start_date','<=',$to_date)
			->delete();
		//read from date
		$date = $from_date;	

		//convert from date to dateTime format
		$from = new DateTime($date );
		//convert to date to dateTime format
		$to = new DateTime(Input::get('to'));

		//finds the days between from and to dates
		$days = $to->diff($from)->format("%a");		

		//loop inserts new rows for all days between from and to dates
		for ($i=0; $i <= $days; $i++) { 
			$promotion = new Promotion;
			$promotion->room_type_id = Input::get('room_id');
			$promotion->services = $services;
			$promotion->start_date = $date;
			$promotion->end_date = new DateTime($to_date);
			$promotion->price = Input::get('price');
			$promotion->discount_rate = Input::get('discount');	
			$promotion->no_of_rooms = $rooms;
			$promotion->days = $stays;

			$promotion->save();

			//get next date
			$date = date('Y-m-d', strtotime($date.' +1 day'));	
		}


		//change end_dates of existing block 
		// DB::table('promotion_calenders')
		// 	->where('room_type_id','=',Input::get('room_id'))
		// 	->where('services','=', $services)
		// 	->where('start_date','<',$from_date)
		// 	->where('end_date','=', $end_date[0]->end_date)
		// 	->update(['end_date'=>date('Y-m-d', strtotime($from_date.' -1 day'))]);

		return 1;
	}else{
		if($top_date = $from_date){
			//deletes ovelapping records
			DB::table('promotion_calenders')
				->where('room_type_id','=',Input::get('room_id'))
				->where('services','=', $services)
				->where('start_date','=',$top_date)
				->delete();
		}
		if ($bottom_date = $to_date) {
			//deletes ovelapping records
			DB::table('promotion_calenders')
				->where('room_type_id','=',Input::get('room_id'))
				->where('services','=', $services)
				->where('start_date','=',$bottom_date)
				->delete();

			//change end_dates of existing block 
			DB::table('promotion_calenders')
				->where('room_type_id','=',Input::get('room_id'))
				->where('services','=', $services)
				->where('end_date','=', $to_date)
				->update(['end_date'=>date('Y-m-d', strtotime($to_date.' -1 day'))]);
		}

		//read from date
		$date = $from_date;	

		//convert from date to dateTime format
		$from = new DateTime($date );
		//convert to date to dateTime format
		$to = new DateTime(Input::get('to'));

		//finds the days between from and to dates
		$days = $to->diff($from)->format("%a");		
		
		//loop inserts new rows for all days between from and to dates
		for ($i=0; $i <= $days; $i++) { 
			$promotion = new Promotion;
			$promotion->room_type_id = Input::get('room_id');
			$promotion->services= $services;
			$promotion->start_date = $date;
			$promotion->end_date = new DateTime($to_date);
			$promotion->price = Input::get('price');
			$promotion->discount_rate = Input::get('discount');				
			$promotion->no_of_rooms = $rooms;
			$promotion->days = $stays;
			$promotion->save();

			//get next date
			$date = date('Y-m-d', strtotime($date.' +1 day'));	
		}

		return 1;
	}	

	return 0;	
	
}
}
