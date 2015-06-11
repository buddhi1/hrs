<?php

class PolicyController extends BaseController {
	
	public function __construnct() {
		// $this->beforeFilter('csrf', array('on' => 'post'));
		$this->beforeFilter('user_group');
	}

	public function getIndex() {
		// show the index blade

		return View::make('policy.view');
	}

	public function postIndex() {
		//show all the policies available

		$policy_arr = array();
		$i = 0;
		$policies = Policy::all();
		foreach ($policies as $key => $value) {

			$policy_arr[$i]['id'] = $value->id;
			$policy_arr[$i]['des'] = $value->description;
			$policy_arr[$i]['variables'] = $value->variables;
			$i++;
		}
		return $policy_arr;
	}

	public function postCreate() {
		// create a new policy

		$sendData = json_decode(Input::get('variables'));
		
		$policy_arr = array();

		foreach ($sendData->variables as $key => $value) {
			if(isset($value->id) && isset($value->values)) {
				$policy_arr[$value->id] = $value->values;
			}
		}

		$variables = json_encode($policy_arr);
		
		$description = $sendData->des;
		
		if(!isset($sendData->id)) {
			$policy = new Policy();

			$policy->description = $description;
			$policy->variables = $variables;

			if($policy) {
				$policy->save();
				return 'success';
			} else {
				return 'failure';
			}
		} else {
			$policy_edit = Policy::find($sendData->id);

			$policy_edit->description = $description;
			$policy_edit->variables = $variables;

			if($policy_edit) {
				$policy_edit->save();
				return 'success';
			} else {
				return 'failure';
			}
		}
		
	}

	public function postEdit() {
		//Show the edit page for the policy

		return Policy::find(Input::get('id'));
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

	public function postDestroy() {
		$policy = Policy::find(Input::get('id'));

		if($policy){
			$policy->delete();

			return 'success';
		}
	}
}