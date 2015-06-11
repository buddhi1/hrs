<?php
/*
	Name:		TaxController
	Purpose:	Controllers for Tax

	History:	Created 13/03/2015 by buddhi ashan	 
*/

class TaxController extends BaseController {

	public function __construct() {
		//$this->beforeFilter('csrf',array('on' => 'post'));
		//change migration
		$this->beforeFilter('user_group');

	}

	//views the add tax page
	public function getCreate(){

		return View::make('tax.create');
	}

	//create tax operation
	public function postCreate(){
		
			$tax = new Tax;

			$tax->name = Input::get('name');
			$tax->rate = Input::get('rate');

			$tax->save();

			return 1;
		
	}


	//Views all tax page
	public function getIndex(){

		return View::make('tax.view')
			->with('taxes', Tax::all());
	}

	//views the tax edit page
	public function postEdit(){
	
		$id = Input::get('id');
		if($id){
			Session::put('tax_id', $id);
			return 1;
		}
		return 3;
		
	}

	//views the tax edit page
	public function getEdit(){
	
		$tax = Tax::find(Session::get('tax_id'));
		Session::forget('tax_id');
		if($tax){
			return View::make('tax.edit')
					->with('id', $tax->id)
					->with('name', $tax->name)
					->with('rate', $tax->rate);
		}

		return Redirect::to('/');
		
	}

	//Edit operation
	public function postUpdate(){
		
		$tax = Tax::find(Input::get('id') );
		$tax->name = Input::get('name');
		$tax->rate = Input::get('rate');

		$tax->save();

		return 1;
		
	}

	//Delete existing tax
	public function postDestroy(){

		$tax = Tax::find(Input::get('id'));
		if($tax){
			$tax->delete();

			return 1;
		}
		return 0;
	}
}