<?php

class PolicyController extends BaseController {
	
	public function __construnct() {
		$this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	public function getIndex() {
		// show all the policies available

		return View::make('policy.view')
			->with('policies', Policy::all());
	}

	public function postCreate() {
		// create a new policy

		$policy_arr = array();
		$policy_comma = explode(",",Input::get('variables'));
		foreach ($policy_comma as $key => $value) {
			$policy_eq = explode("=",$value);

			$policy_arr[$policy_eq[0]] = $policy_eq[1];
		}
		
		$policy = new Policy();
		$policy_variables = json_encode($policy_arr);

		$policy->description = Input::get('description');
		$policy->variables = $policy_variables;

		if($policy) {
			$policy->save();
			return Redirect::To('admin/policy')
				->with('policy_message_add', 'Policy has been successfully added');
		}
	}

	public function postEdit() {
		//Show the edit page for the policy

		return View::make('policy.edit')
			->with('policies', Policy::find(Input::get('id')));
	}

	public function postUpdate() {
		// Edit a new policy

		$policy = Policy::find(Input::get('id'));

		$policy->description = Input::get('description');
		$policy->variables = Input::get('variables');



		if($policy) {
			$policy->save();
			return Redirect::To('admin/policy')
				->with('policy_message', 'Policy has been successfully Updated');
		}
	}
}