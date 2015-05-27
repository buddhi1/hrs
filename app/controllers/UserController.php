<?php
/*
	Name:		 UserController
	Purpose:	Controllers for user

	History:	Created 25/02/2015 by buddhi ashan	 
*/

class UserController extends BaseController {
	

	// public function __construct(){
	// 	$this->beforeFilter('csrf',array('on'=>'post'));
	// 	// $this->beforeFilter('user_group');
	// }

	//Views the create user form
	
	public function getCreate(){
		//Views the create user form

		return View::make('user.create');
	}

	public function postPermissions() {
		// populate the permissions dropdown on the create page

		$permission = DB::table('permissions')
							->select('id', 'name')
							->get();

		return $permission;
	}

	//Posts the create form details to database

	public function postCreate(){

		$uname = Input::get('uname');
		$password = Hash::make(Input::get('password'));
		$permission = Input::get('chosenPermission');
		$permission_id = DB::table('permissions')
								->where('name', $permission)
								->pluck('id');
		
		$user =DB::table('users')->where('name', $uname)->first();

		if(!$user){
			$user = new User;
			$user->name = $uname;
			$user->password = $password;
			$user->permission_id = $permission_id;
			$user->save();
			return 'success';
		}else{
			return 'failure';
		}
	}

	public function getIndex(){
		//shows the index page

		return View::make('user.index');
	}

	public function postIndex(){
		// send all the user details according to the ajax request

		$permissions = DB::table('users')
			->leftJoin('permissions', 'permissions.id', '=', 'permission_id')
			->select('users.id as uid','users.name as uname','permission_id', 'permissions.id','permissions.name')						
	        ->get();

	    return $permissions;
	}

	//Views the uder edit form

	public function postEdit(){
		// put the edit id to a session and redirect edit page

		Session::put('user_edit_id', Input::get('id'));

		return 'success';
	}

	public function getEdit(){
		// show the edit page of a user

		return View::make('user.edit');
	}

	public function postShowedit() {
		// this function runs on load of the edit page and return the details of the user who is in the session

		if(Session::has('user_edit_id')) {

			$user = DB::table('users')
				->leftJoin('permissions', 'permissions.id', '=', 'permission_id')
				->select('users.id as uid','users.name as uname','permission_id','permissions.name')
				->where('users.id','=', Session::get('user_edit_id'))
		        ->get();

			return $user;
		} else {

			return 'failure';
		}	
	}

	public function postUpdate(){
		//Updates the edits to user
		
		$user = User::find(Input::get('userID'));

		if($user){

			$user->name = Input::get('uname');
			$permission_id = DB::table('permissions')
									->where('name', Input::get('chosenPermission'))
									->pluck('id');

			if(Input::get('password') !== ''){

				$user->password = Hash::make(Input::get('password'));
			}
			$user->permission_id = $permission_id;
			$user->save();
			Session::forget('user_edit_id');
			return 'success';
		}else{
			Session::forget('user_edit_id');
			return 'failure';
		}
	}

	//Deletes the selected user
	public function postDestroy(){
		$user = User::find(Input::get('id'));

		if($user){
			$user->delete();

			return 'success';
		}

		return 'failure';
	}
}