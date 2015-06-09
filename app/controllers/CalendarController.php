<?php
/*
	Name:		CalendarController
	Purpose:	Controllers for Room_price_Calendar

	History:	Created 26/02/2015 by buddhi ashan	 
*/

class CalendarController extends BaseController {

	public function __construct(){
		//$this->beforeFilter('csrf',array('on'=>'post'));
		$this->beforeFilter('user_group');
	}

	//Views the create Room_price_Calendar form
	
	public function getCreate(){
		return View::make('calendar.create')
			->with('roomTypes', RoomType::all(['id', 'name']))
			->with('services', Service::all(['id', 'name']));
	}

	//Posts the create form details to database

	public function postCreate(){
		
		//read from date
		$date = date('Y-m-d', strtotime(Input::get('from').' +0 day'));	
		$to_d = date('Y-m-d', strtotime(Input::get('to').' +0 day'));

		$room_type_id = Input::get('roomType');
		$service_id = Input::get('service');

		//check for availability of date range for selected room type and service type
		$fdate = DB::table('room_price_calenders')
			->where('start_date','=',$date)
			->where('room_type_id','=',$room_type_id)
			->where('service_id','=',$service_id)
			->get();

		//if such date range does not exist for the selected room type and service type
		if(!$fdate){
			//convert from date to dateTime format
			$from = new DateTime($date );
			//convert to date to dateTime format
			$to = new DateTime($to_d);

			//finds the days between from and to dates
			$days = $to->diff($from)->format("%a");		

			//loop inserts new rows for all days between from and to dates
			for ($i=0; $i <= $days; $i++) { 
				$calendar = new Calendar;
				$calendar->room_type_id = $room_type_id;
				$calendar->service_id = $service_id;
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime($to_d);
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	

			}	
				return 1;		
			
			}
			//if the given date range existing for the selected room type and service type
			else{
				return 2;
			}		

		
	}

	//Views the user Room_price_Calendar page

	public function getIndex(){
		return View::make('calendar.index')
			->with('start_date', DB::table('room_price_calenders')->orderBy('start_date')->pluck('start_date'))
			->with('end_date', DB::table('room_price_calenders')->orderBy('start_date', 'desc')->pluck('start_date'))
			->with('rooms', Calendar::select('id','room_type_id','service_id')->groupBy('service_id','room_type_id')->get())
			->with('calendar', Calendar::select('id','room_type_id','end_date','price','discount_rate',
				'service_id','start_date')->groupBy('end_date','room_type_id','service_id')->get());
	}

	//Views edit page for selected record
	public function postEdit(){
		
		Session::put('calendar_id', Input::get('id'));
		return 1;
	}

	//Views edit page for selected record
	public function getEdit(){	

		$rec = Calendar::find(Session::get('calendar_id'));

		if($rec){
			return View::make('calendar.edit')
						->with('record', $rec);
		}	
		return Redirect::to('/');
	}

	//Views edit time line page for selected record
	public function postEdittimeline(){
		Session::put('room_id', Input::get('roomType'));
		Session::put('service_id', Input::get('service'));
		return 1;
	}

	//Views edit time line page for selected record
	public function getEdittimeline(){

		$room_type_id = Session::get('room_id');
		$service_id = Session::get('service_id');

		$start = Calendar::where('room_type_id','=',$room_type_id)
					->where('service_id','=',$service_id)
					->orderBy('start_date')
					->select('start_date')
					->first();
		$end = Calendar::where('room_type_id','=',$room_type_id)
					->where('service_id','=',$service_id)
					->orderBy('start_date', 'DESC')
					->select('start_date')
					->first();
		return View::make('calendar.edittimeline')
			->with('room_type_id', $room_type_id)
			->with('service_id', $service_id )
			->with('start', $start)
			->with('end', $end);
	}

	//edit function for selected record
	public function postUpdate(){
			
		DB::table('room_price_calenders')
			->where('room_type_id','=',Input::get('roomType'))
			->where('service_id','=',Input::get('service'))
			->where('end_date','=', Input::get('to'))
			->update(['price'=>Input::get('price'),
						'discount_rate'=>Input::get('discount')]);

		Session::forget('calendar_id');
		return 1;			
		
	}	

	//edit function for selected time line
	public function postUpdatetimeline(){

		if(!Session::has('room_id') || !Session::has('service_id')){
			return 3;
		}
		$room = Session::get('room_id');
		$service = Session::get('service_id');
		Session::forget('room_id');
		Session::forget('service_id');
		
		$top_date = Input::get('sdate');
		$bottom_date = Input::get('edate');
		$from_date = date('Y-m-d', strtotime(Input::get('from').' 0 day'));
		$to_date = date('Y-m-d', strtotime(Input::get('to').' 0 day'));

		//reads the end date of editing time line block
		$end_date = DB::table('room_price_calenders')
			->where('start_date','=',$from_date)
			->where('room_type_id','=',$room)
			->where('service_id','=',$service)
			->get();

		//replacing existing time line with a single price and discount

		if($top_date >= $from_date && $bottom_date <= $to_date){

			//deletes ovelapping records
			DB::table('room_price_calenders')
			->where('room_type_id','=',$room)
			->where('service_id','=',$service)
			->delete();

			//read from date
			$date = Input::get('from');	

			//convert from date to dateTime format
			$from = new DateTime($date );
			//convert to date to dateTime format
			$to = new DateTime(Input::get('to'));

			//finds the days between from and to dates
			$days = $to->diff($from)->format("%a");		
			
			//loop inserts new rows for all days between from and to dates
			for ($i=0; $i <= $days; $i++) { 
				$calendar = new Calendar;
				$calendar->room_type_id = $room;
				$calendar->service_id = $service;
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime($to_date);
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}

			return 1;	
		}

		//replacing existing block(s) in time line
		elseif($top_date < $from_date || $bottom_date > $to_date){

			

			//deletes ovelapping records
			DB::table('room_price_calenders')
				->where('room_type_id','=',$room)
				->where('service_id','=',$service)
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
				$calendar = new Calendar;
				$calendar->room_type_id = $room;
				$calendar->service_id = $service;
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime($to_date);
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}


			//change end_dates of existing block 
			DB::table('room_price_calenders')
				->where('room_type_id','=',$room)
				->where('service_id','=',$service)
				->where('start_date','<',$from_date)
				->where('end_date','=', $end_date[0]->end_date)
				->update(['end_date'=>date('Y-m-d', strtotime($from_date.' -1 day'))]);

			return 1;
		}else{
			if($top_date = $from_date){
				//deletes ovelapping records
				DB::table('room_price_calenders')
					->where('room_type_id','=',$room)
					->where('service_id','=',$service)
					->where('start_date','=',$top_date)
					->delete();
			}
			if ($bottom_date = $to_date) {
				//deletes ovelapping records
				DB::table('room_price_calenders')
					->where('room_type_id','=',$room)
					->where('service_id','=',$service)
					->where('start_date','=',$bottom_date)
					->delete();

				//change end_dates of existing block 
				DB::table('room_price_calenders')
					->where('room_type_id','=',$room)
					->where('service_id','=',$service)
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
				$calendar = new Calendar;
				$calendar->room_type_id = $room;
				$calendar->service_id = $service;
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime($to_date);
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}

			return 1;

		}

	
		return 3;	
	}

	//deletes selected calendar record
	public function postDestroy(){

		$room = Input::get('roomType');
		$service = Input::get('service');
		$date = Input::get('to');

		if($room && $service && $date){
			DB::table('room_price_calenders')
			->where('room_type_id','=', $room)
			->where('service_id','=', $service)
			->where('end_date','=', $date)
			->delete();

		return 1;
		}
		return 3;
		
	}


	//deletes selected time line
	public function postDestroytimeline(){

		$room = Input::get('roomType');
		$service = Input::get('service');

		if($room && $service){
			DB::table('room_price_calenders')
				->where('room_type_id','=', $room)
				->where('service_id','=', $service)
				->delete();

			return 1;
		}

		return 2;		
	}
}
