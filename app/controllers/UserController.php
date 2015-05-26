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
		
		return View::make('user.create')
			->with('permissions', Permission::lists('name', 'id'));
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

	//Views the user index page

	public function getIndex(){
		$permissions = DB::table('users')
			->leftJoin('permissions', 'permissions.id', '=', 'permission_id')
			->select('users.id as uid','users.name as uname','permission_id', 'permissions.id','permissions.name')						
	        ->get();
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
		var_dump(Input::get('id'));
		die();
		return View::make('user.edit')
			->with('user', User::find(Input::get('id')))
			->with('permissions', Permission::lists('name', 'id'));
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
	public function postPermissions() {

		$permission = DB::table('permissions')
							->select('id', 'name')
							->get();

		return $permission;
	}
}