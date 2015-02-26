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
		$record =DB::table('room_price_Calendars')->where('name', Input::get('uname'))->first();

		if(!$user){
			$calendar = new Calendar;
			$calendar->name = Input::get('uname');
			$calendar->password = Hash::make(Input::get('password'));
			$calendar->permission_id = Input::get('permission');
			$calendar->save();
			return Redirect::to('admin/user/create')
				->with('message', 'A user has been added successfully');
		}else{
			return Redirect::to('admin/user/create')
				->with('message', 'The user name already exists. Please enter differernt user name');
		}
		
	}
}