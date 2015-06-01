<?php
/*
	Name:		PermissionController
	Purpose:	Controllers for Permissions

	History:	Created 25/02/2015 by buddhi ashan	 
*/

class PermissionController extends BaseController {
	

	// public function __construct(){
	// 	$this->beforeFilter('csrf',array('on'=>'post'));
	// 	$this->beforeFilter('user_group');
	// }

	//Views the create Permission form
	
	public function getCreate() {
		//show the create page for permissions

		return View::make('permission.create');
	}

	public function postPermissions(){
		// send all the permissions for the create page

		$permissions = Schema::getColumnListing('permissions');
		unset($permissions[0]); //remove permission id
		unset($permissions[1]); //remove permission name
		unset($permissions[sizeof($permissions)]); //remove permission created at
		unset($permissions[sizeof($permissions)+2]); //remove permission updated at
		$permissions = array_values($permissions); //reindex array
		
		foreach ($permissions as $value) {
			$names[] = explode("_",$value);
			
		}
		
		foreach ($names as $name) {
			
			if (sizeof($name) > 1) {
				$titles[] = ucfirst($name[1]).' '.$name[0];

			}
			  
		}
		
		for ($i=0; $i < sizeof($permissions); $i++) { 
			$info[$i][0] = $titles[$i];
			$info[$i][1] = $permissions[$i];
		}
			
		return $info;
	}

	//Posts the create form details to database

	public function postCreate(){

		$permission_obj = json_decode(Input::get('variables'));
		

		$validator = Validator::make(array('permission' => $permission_obj->permission), Permission::$rules);

		//validates whether atleast a permission is selected
		if($validator->passes()){
			$name = $permission_obj->perName;
			$record = DB::table('permissions')
				->where('name','=', $name)
				->get();

			//checks for the availability of the permission group name
			if(!$record){

				$group = new Permission;
				$group->name =  $name;
				
				foreach ($permission_obj->permission as $value) {
					$col_value = $value->name;
					$group->$col_value = 1;
				}
				$group->save();
				return 'success';
				
			}
			return 'failure';
		}
		return 'failure';
	}

	public function getIndex() {
		return View::make('permission.index');
	}
	//Views index page for permissions
	public function postIndex(){
		

		$permissions = Schema::getColumnListing('permissions');
		unset($permissions[0]); //remove permission id
		unset($permissions[1]); //remove permission name
		unset($permissions[sizeof($permissions)]); //remove permission created at
		unset($permissions[sizeof($permissions)+2]); //remove permission updated at
		$permissions = array_values($permissions); //reindex array
		
		foreach ($permissions as  $value) {
			$names[] = explode("_",$value);
			
		}
		
		foreach ($names as $name) {
			
			if (sizeof($name) > 1) {
				$titles[] = ucfirst($name[1]).' '.$name[0];

			}
			  
		}	
		for ($i=0; $i < sizeof($permissions); $i++) { 
			$info[$i][0] = $titles[$i];
			$info[$i][1] = $permissions[$i];
		}
		// $per = array();
		$per = Permission::all();
		// $per[1] = $info;
		
		return $per;
	}

	//Deletes the selected permission group
	public function postDestroy(){
		$group = Permission::find(Input::get('id'));

		if($group){
			$group->delete();

			return 'success';
		}
	}

	public function postEdit(){
		// put the edit id to a session and redirect edit page

		Session::put('permission_edit_id', Input::get('id'));

		return 'success';
	}

	public function getEdit(){
		// show the edit page of a user

		return View::make('permission.edit');
	}

	public function postShowedit() {
		// this function runs on load of the edit page and return the details of the user who is in the session

		if(Session::has('permission_edit_id')) {
			$permissions = Schema::getColumnListing('permissions');
			unset($permissions[0]); //remove permission id
			unset($permissions[1]); //remove permission name
			unset($permissions[sizeof($permissions)]); //remove permission created at
			unset($permissions[sizeof($permissions)+2]); //remove permission updated at
			$permissions = array_values($permissions); //reindex array
			
			foreach ($permissions as  $value) {
				$names[] = explode("_",$value);
				
			}
			
			foreach ($names as $name) {
				
				if (sizeof($name) > 1) {
					$titles[] = ucfirst($name[1]).' '.$name[0];

				}
				  
			}	
			for ($i=0; $i < sizeof($permissions); $i++) { 
				$info[$i][0] = $titles[$i];
				$info[$i][1] = $permissions[$i];
			}

			$data = array();
			$data[0] = Permission::find(Session::get('permission_edit_id'));
			$data[1] = $info;

			return $data;
		}	
	}

	//Update operation for the selected permission group
	public function postUpdate(){

		$permission_obj = json_decode(Input::get('variables'));
		
		$validator = Validator::make(array('permission' => $permission_obj->permission), Permission::$rules);

		//validates whether atleast a permission is selected
		if($validator->passes()){
			$name = $permission_obj->perName;
			$id = $permission_obj->groupID;


			$group = Permission::find($id);
			$group->name =  $name;
			
			foreach ($permission_obj->permission as $value) {

				$col_value = $value->chkName;
				$group->$col_value = 1;
			}
			$group->save();
			Session::forget('permission_edit_id');
			return 'success';
		}else{
			Session::forget('permission_edit_id');
			return 'failure';
		}
	}
}