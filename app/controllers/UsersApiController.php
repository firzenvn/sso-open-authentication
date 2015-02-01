<?php

class UsersApiController extends \AccountingBaseController {

	public function __construct(){
		$this->beforeFilter('checksum_validate');
		$this->beforeFilter('oauth',array('except'=>array('postCreateBySource')));
	}

	/**
	 * API Restful thanh toán tiền (nạp game)
	 */
	public function postCreateBySource(){
		$validator = Validator::make(Input::all(), array(
			'username'=>'required|max:45',
			'email'=>'email',
			'source'=>'required',
			'source_user_id'=>'required'
		));
		if(!$validator->passes()){
			return Response::json(array(
				'status'=>400,
				'error'=>'Bad request',
				'error_message'=>implode(' ',$validator->messages()->all())
			));
		}
		$username=Input::get('source').'_'.Input::get('username');
		$user=User::where('username','=',$username)->orWhere(function ($query){
			$query->where('oauth2_provider','=',Input::get('source'))->where('oauth2_provider_id','=',Input::get('source_user_id'));
		})->first();
		if($user){
			return Response::json(array(
				'status'=>200,
				'success'=>'User đã tồn tại',
				'user'=>$user->attributesToArray(),
			));
		}

		$user = new User;
		$user->username = $username;
		$user->password = 'NA';
		$user->source=Input::get('source');
		$user->oauth2_provider=Input::get('source');
		$user->oauth2_provider_id=Input::get('source_user_id');
		$email_validator = Validator::make(Input::all(), array(
			'email'=>'unique:users',
		));
		if($email_validator->passes())
			$user->email = Input::get('email');
		$user->save();

		//Tra kq giao dich
		return Response::json(array(
			'status'=>200,
			'success'=>'Tạo user thành công',
			'user'=>$user->attributesToArray(),
		));
	}
}