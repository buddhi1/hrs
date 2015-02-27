<?php
/*
	Name:		CalendarController
	Purpose:	Controllers for Room_price_Calendar

	History:	Created 26/02/2015 by buddhi ashan	 
*/

class CalendarController extends BaseController {

	public function __construct(){
		$this->beforeFilter('csrf',array('on'=>'post'));
	}

	//Views the create Room_price_Calendar form
	
	public function getCreate(){
		return View::make('calendar.create');
	}

	//Posts the create form details to database

	public function postCreate(){

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
			$calendar->room_type_id = Input::get('roomType');
			$calendar->service_id = Input::get('service');
			$calendar->start_date = $date;
			$calendar->end_date = new DateTime(Input::get('to'));
			$calendar->price = Input::get('price');
			$calendar->discount_rate = Input::get('discount');			
			$calendar->save();

			//get next date
			$date = date('Y-m-d', strtotime($date.' +1 day'));	
		}	
			
			return Redirect::to('admin/calendar/create')
				->with('message', 'Calendar record has been added successfully');		
		
	}

	//Views the user Room_price_Calendar page

	public function getIndex(){
		return View::make('calendar.index')
			->with('start_date', DB::table('room_price_calenders')->orderBy('start_date')->pluck('start_date'))
			->with('end_date', DB::table('room_price_calenders')->orderBy('start_date', 'desc')->pluck('start_date'))
			->with('calendar', DB::table('room_price_calenders')->select(DB::raw('count(*) as days'),'id','room_type_id','end_date','price','discount_rate',
				'service_id','start_date')->groupBy('end_date','room_type_id')->get());
	}

	//Views edit page for selected record
	public function postEdit(){
		return View::make('calendar.edit');
	}

	//edit function for selected record
	public function postUpdate(){

		if(Input::get('sdate') <= Input::get('from') && Input::get('edate') >= Input::get('to')){

			//delets overlapping records
			DB::table('room_price_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('start_date','>=',Input::get('from'))
			->where('start_date','<=',Input::get('to'))
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
				$calendar->room_type_id = Input::get('roomType');
				$calendar->service_id = Input::get('service');
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime(Input::get('to'));
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}
			
			DB::table('room_price_calenders')
				->where('start_date','<',Input::get('from'))
				->where('end_date','=', Input::get('edate'))
				->update(['end_date'=>date('Y-m-d', strtotime(Input::get('from').' -1 day'))]);

			return Redirect::to('admin/calendar/index')
				->with('message', 'Calendar record has been update successfully');			
		}elseif(Input::get('sdate') > Input::get('from') && Input::get('edate') < Input::get('to')){

			//deletes ovelapping records
			DB::table('room_price_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('end_date','=',Input::get('edate'))
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
				$calendar->room_type_id = Input::get('roomType');
				$calendar->service_id = Input::get('service');
				$calendar->start_date = $date;
				$calendar->end_date = new DateTime(Input::get('to'));
				$calendar->price = Input::get('price');
				$calendar->discount_rate = Input::get('discount');			
				$calendar->save();

				//get next date
				$date = date('Y-m-d', strtotime($date.' +1 day'));	
			}

			return Redirect::to('admin/calendar/index')
				->with('message', 'Calendar record has been update successfully!!!');	
		}	
		return Redirect::to('admin/calendar/index')
				->with('message', 'Something went wrong');	
	}

	//deletes selected calendar record
	public function postDestroy(){
		
		DB::table('room_price_calenders')
			->where('room_type_id','=',Input::get('room_id'))
			->where('end_date','=',Input::get('date'))
			->delete();

		return Redirect::to('admin/calendar/index')
			->with('message','Record removed successfully');
	}

}