<?php
/*
	Name:		 UserController
	Purpose:	Controllers for user

	History:	Created 25/02/2015 by buddhi ashan	 
*/

class UserController extends BaseController {
	

	public function __construct(){
		$this->beforeFilter('csrf',array('on'=>'post'));
	}

	//Views the create user form
	
	public function getCreate(){
		return View::make('user.create');
	}

	//Posts the create form details to database

	public function postCreate(){
		
		$user =DB::table('users')->where('name', Input::get('uname'))->first();

		if(!$user){
			$user = new User;
			$user->name = Input::get('uname');
			$user->password = Hash::make(Input::get('password'));
			$user->permission_id = Input::get('permission');
			$user->save();
			return Redirect::to('admin/user/create')
				->with('message', 'A user has been added successfully');
		}else{
			return Redirect::to('admin/user/create')
				->with('message', 'The user name already exists. Please enter differernt user name');
		}
		
	}

	//Views the user index page

	public function getIndex(){
		return View::make('user.index')			
			->with('users', User::all());
	}

	//Deletes the selected user

	public function postDestroy(){
		$user = User::find(Input::get('id'));

		if($user){
			$user->delete();

			return Redirect::to('admin/user/index')
				->with('message','User Deleted Successfully');
		}

		return Redirect::to('admin/user/index')
			->with('message','Something went wrong, Please try again');
	}

	//Views the uder edit form

	public function postEdit(){
		return View::make('user.edit')
			->with('id', Input::get('id'));
	}

	//Updates the edits to user

	public function postUpdate(){
		$user = User::find(Input::get('id'));

		if($user){
			$user->name = Input::get('uname');
			$user->password = Input::get('hashPassword');
			if(Input::get('password') != null){
				$user->password = Hash::make(Input::get('password'));
			}			
			$user->permission_id = Input::get('permission');
			$user->save();
			return Redirect::to('admin/user/index')
				->with('message', 'A user has been updated successfully');
		}else{
			return Redirect::to('admin/user/index')
				->with('message', 'Something went wrong. Please try again');
		}
	}



}