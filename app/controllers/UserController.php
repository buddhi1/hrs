<?php
/*
	Name:		 UserController
	Purpose:	Controllers for user

	History:	Created 25/02/2015 by buddhi ashan	 
*/

class UserController extends BaseController {
	

	public function __construct(){
		$this->beforeFilter('csrf',array('on'=>'post'));
		$this->beforeFilter('user_group');
	}

	//Views the create user form
	
	public function getCreate(){
		return View::make('user.create')
			->with('permissions', Permission::lists('name', 'id'));
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
		$permissions = DB::table('users')
			->leftJoin('permissions', 'permissions.id', '=', 'permission_id')
			->select('users.id as uid','users.name as uname','permission_id', 'permissions.id','permissions.name')						
	        ->get();
		return View::make('user.index')			
			->with('users', $permissions);
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


	//Views login page
	public function getLogin(){
		return View::make('user.login');
	}

	//lgin for users
	public function postLogin(){

		$rules = array(
		   'name'    => 'required', 
		   'password' => 'required' 
		);

		$validator = Validator::make(Input::all(), $rules);


		if ($validator->fails()) {
		    return Redirect::to('admin/login')
		        ->withErrors($validator) // send back all errors to the login form
		        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {

		    // create our user data for the authentication
		    $userdata = array(
		        'name'     => Input::get('name'),
		        'password'  =>  Input::get('password')
   	 			);

		 		if (Auth::attempt($userdata)) {

		        // validation successful!
		     		
		        	return Redirect::to('admin/user')
		        		->with('message', 'Login successfull'.Auth::user()->permission_id);

    			} else {        

		        // validation not successful, send back to form 
		        	return Redirect::to('admin/login')
		        		->with('message', 'Login unsuccessfull.Please try again');
    			}

			}
	}

	//User logout
	public function getLogout(){	//change get to post
		Auth::logout();

		return Redirect::to('admin/login')
			->with('message', 'Logout successfully');		
	}

}