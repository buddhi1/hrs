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
		return View::make('permission.create');
	}

	//Posts the create form details to database

	public function postCreate(){

		$validator = Validator::make(Input::all(), Permission::$rules);

		//validates whether atleast a permission is selected
		if($validator->passes()){
			$name = Input::get('name');
			$record = DB::table('permissions')
				->where('name','=', $name)
				->get();

			//checks for the availability of the permission group name
			if(!$record){

				$group = new Permission;
				$group->name =  $name;
				
				foreach (Input::get('permission') as $value) {
					$group->$value = 1;
				}
				$group->save();
				return Redirect::to('admin/permission/create')
					->with('message','New permission group added successfully');
				
			}
			return Redirect::to('admin/permission/create')
				->with('message','Permission group already exists');
		}

		return Redirect::to('admin/permission/create')
			->with('message','Something went wrong')
			->withErrors($validator)
			->withInput();
	}

	//Views index page for permissions
	public function getIndex(){
		return View::get('permission.edit');
	}

}