<?php
/*
	Name:		PermissionController
	Purpose:	Controllers for Permissions

	History:	Created 25/02/2015 by buddhi ashan	 
*/

class PermissionController extends BaseController {
	

	public function __construct(){
		$this->beforeFilter('csrf',array('on'=>'post'));
	}

	//Views the create Permission form
	
	public function getCreate(){
		return View::make('user.create');
	}

	//Posts the create form details to database

	public function postCreate(){
		$user = User::find(Input::get('uname'));

		if(!$user){
			$user = new User;
			$user->name = Input::get('uname');
			$user->password = Input::get('password');
			$user->permission_id = Input::get('permission');
			$user->save();
		}
		echo "User name exists";
	}

}