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

		$date = Input::get('from');
		$from = new DateTime($date );
		$to = new DateTime(Input::get('to'));
		$days = $to->diff($from)->format("%a");		
		
		for ($i=0; $i <= $days; $i++) { 
			$calendar = new Calendar;
			$calendar->room_type_id = Input::get('roomType');
			$calendar->service_id = Input::get('service');
			$calendar->start_date = $date;
			$calendar->end_date = $date;
			$calendar->price = Input::get('price');
			$calendar->discount_rate = Input::get('discount');			
			$calendar->save();
			$date = date('Y-m-d', strtotime($date.' +1 day'));	
		}
	
			
			return Redirect::to('admin/calendar/create')
				->with('message', 'Calendar record has been added successfully');
		
		
	}
}