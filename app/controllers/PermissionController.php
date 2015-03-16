<?php
/*
	Name:		PermissionController
	Purpose:	Controllers for Permissions

	History:	Created 25/02/2015 by buddhi ashan	 
*/

class PermissionController extends BaseController {
	

	public function __construct(){
		$this->beforeFilter('csrf',array('on'=>'post'));
		$this->beforeFilter('user_group');
	}

	//Views the create Permission form
	
	public function getCreate(){
		return View::make('permission.create')
			->with('permissions', Schema::getColumnListing('permissions'));
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
		return View::make('permission.index')
			->with('groups', Permission::all())
			->with('permissions', Schema::getColumnListing('permissions'));
	}

	//Deletes the selected permission group
	public function postDestroy(){
		$group = Permission::find(Input::get('id'));

		if($group){
			$group->delete();

			return Redirect::to('admin/permission/index')
				->with('message','Permission group deleted Successfully');
		}

	}

	//Views the edit page for the selected permission group
	public function postEdit(){
		return View::make('permission.edit')
			->with('record', Permission::find(Input::get('id')))
			->with('permissions', Schema::getColumnListing('permissions'));
	}

	//Update operation for the selected permission group
	public function postUpdate(){
		$validator = Validator::make(Input::all(), Permission::$rules);

		if($validator->passes()){			

			$name = Input::get('name');
			$record = DB::table('permissions')
				->where('name','=', $name)
				->get();

			//checks for the availability of the permission group name
			if(!$record){
				$group = Permission::find(Input::get('id'));
				$group->name =  Input::get('name');
				
				foreach (Input::get('permission') as $value) {
					$group->$value = 1;
				}
				$group->save();
				return Redirect::to('admin/permission/index')
					->with('message','New permission group added successfully');
				
			}
			return Redirect::to('admin/permission/index')
				->with('message','Permission group already exists');

		}
	}

}