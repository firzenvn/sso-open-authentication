<?php

class PaymentsApiController extends \AccountingBaseController {

	public function __construct(){
		$this->beforeFilter('checksum_validate');
		$this->beforeFilter('oauth',array('except'=>array('postRefundPayment')));
		$this->beforeFilter('oauth_load_data',array('except'=>array('postRefundPayment')));
		$this->beforeFilter('payment_check_amount',array('except'=>array('postPayByMobileCard','postRefundPayment')));
	}

	/**
	 * API Restful thanh toán tiền (nạp game)
	 */
	public function postPayByAccounts(){
		$myApp=App::make('myApp');
		$validator = Validator::make(
			Input::all(),
			array(
				'ref_txn_id' => "required|max:255|unique:txn_payments,ref_txn_id,0,id,oauth_client_id,".$myApp->oauthClient->id,
				'amount' => 'required|numeric|min:1',
				'description' => 'required|max:500',
			)
		);
		if ($validator->fails()){
			return Response::json(array(
				'status'=>400,
				'error'=>'Bad request',
				'error_message'=>implode(' ',$validator->messages()->all()),
			));
		}

		//Tao giao dich
		$txnPayment=new TxnPayment();
		$txnPayment->ref_txn_id=Input::get('ref_txn_id');
		$txnPayment->user_id=$myApp->oauthUser->id;
		$txnPayment->oauth_client_id=$myApp->oauthClient->id;
		$txnPayment->amount=Input::get('amount');
		$txnPayment->description=Input::get('description');

		try{
			$this->_processTxnPayment($txnPayment);
		}catch (Exception $e){
			return Response::json(array(
				'status'=>500
				,'error'=>'Server error'
				,'error_message'=>$e->getMessage()
			));
		}

		//Tra kq giao dich
		return Response::json(array(
			'status'=>200,
			'success'=>'Bạn đã thanh toán thành công số tiền '.$txnPayment->amount,
			'txn_amount'=>$txnPayment->amount,
			'ref_txn_id'=>$txnPayment->ref_txn_id,
		));
	}

	/**
	 * API tặng thưởng xu vào tài khoản
	 */
	public function postAddBonusXu(){
		$myApp=App::make('myApp');
		$validator = Validator::make(
			Input::all(),
			array(
				'ref_txn_id' => "required|max:255|unique:txn_add_bonus,ref_txn_id,0,id,oauth_client_id,".$myApp->oauthClient->id,
				'amount' => 'required|numeric|min:1',
				'description' => 'required|max:500',
			)
		);
		if ($validator->fails()){
			return Response::json(array(
				'status'=>400,
				'error'=>'Bad request',
				'error_message'=>implode(' ',$validator->messages()->all()),
			));
		}

		//Tao giao dich
		$txnAddBonus=new TxnAddBonus();
		$txnAddBonus->ref_txn_id=Input::get('ref_txn_id');
		$txnAddBonus->user_id=$myApp->oauthUser->id;
		$txnAddBonus->oauth_client_id=$myApp->oauthClient->id;
		$txnAddBonus->amount=Input::get('amount');
		$txnAddBonus->description=Input::get('description');

		try{
			$accountTrace = new AccountTrace();
			$accountTrace->account_id = $myApp->oauthUser->mainAccount()->id;
			$accountTrace->change_balance = Input::get('amount');
			$accountTrace->save();
		}catch (Exception $e){
			return Response::json(array(
				'status'=>500
				,'error'=>'Server error'
				,'error_message'=>$e->getMessage()
			));
		}

		//Tra kq giao dich
		return Response::json(array(
			'status'=>200,
			'success'=>'Bạn đã tặng thưởng thành công số tiền '.$txnAddBonus->amount,
			'txn_amount'=>$txnAddBonus->amount,
			'ref_txn_id'=>$txnAddBonus->ref_txn_id,
		));
	}

	/**
	 * Thanh toán game bằng thẻ điện thoại
	 */
	public function postPayByMobileCard(){
		$myApp=App::make('myApp');
		$validator = Validator::make(
			Input::all(),
			array(
				'ref_txn_id' => "required|max:255|unique:txn_cards,ref_txn_id,0,id,oauth_client_id,".$myApp->oauthClient->id,
				'card_type' => 'required|in:VMS,VNP,VTE,vms,vnp,vte',
				'pin' => 'required|min:10|max:20',
				'seri' => 'required|min:5|max:20',
				'description' => 'required|max:500'
			)
		);
		if ($validator->fails()){
			ob_clean ();
			return Response::json(array(
				'status'=>400,
				'error'=>'Bad request',
				'error_message'=>implode(' ',$validator->messages()->all()),
			));
		}

		//Lưu giao dịch thẻ cào
		$txnCard = new TxnCard;
		$txnCard->oauth_client_id=$myApp->oauthClient->id;
		$txnCard->user_id = $myApp->oauthUser->id;
		$txnCard->card_type = Input::get('card_type');
		$txnCard->pin = Input::get('pin');
		$txnCard->seri = Input::get('seri');
		$txnCard->ref_txn_id = Input::get('ref_txn_id');
		if(!$txnCard->save()){
			ob_clean ();
			return Response::json(array(
				'status'=>500
				,'error'=>'Server error'
				,'error_message'=>'Database error occured while saving card transaction'
			));
		}

		//Gọi sang cổng thẻ cào
		if(count(Config::get('common.true_cards')) && in_array($txnCard->pin, Config::get('common.true_cards')) && $txnCard->user_id==1){
			list($response_code,$card_amount,$response_message)=array(TXN_CARD_RESPONSE_CODE_SUCCESS,10000,'success');
		}else{
			list($response_code,$card_amount,$response_message)=$this->_processChargeByMobileCard($txnCard);
		}

		//Xử lý kết quả trả về
		$txnCard->card_amount=$card_amount;
		$txnCard->response_code=$response_code;
		if($response_code!=TXN_CARD_RESPONSE_CODE_SUCCESS){
			$this->_onCardFail($txnCard);
			ob_clean ();
			return Response::json(array(
				'status'=>406
				,'error'=>'Not acceptable'
				,'error_message'=>$response_message
			));
		}

		try{
			$this->_onCardSuccess($txnCard);

			$txnPayment=new TxnPayment();
			$txnPayment->ref_txn_id=$txnCard->ref_txn_id;
			$txnPayment->user_id=$myApp->oauthUser->id;
			$txnPayment->oauth_client_id=$myApp->oauthClient->id;
			$txnPayment->amount=$txnCard->card_amount * Config::get('common.vnd_to_xu_rate');
			$txnPayment->description=Input::get('description');
			$this->_processTxnPayment($txnPayment);
		}catch (Exception $e){
			ob_clean ();
			return Response::json(array(
				'status'=>500
				,'error'=>'Server error'
				,'error_message'=>$e->getMessage()
			));
		}

		//Tra kq giao dich
		ob_clean ();
		return Response::json(array(
			'status'=>200,
			'success'=>'Bạn đã thanh toán thành công số tiền '.$txnPayment->amount,
			'txn_amount'=>$txnPayment->amount,
			'ref_txn_id'=>$txnPayment->ref_txn_id,
		));
	}

	private function _processTxnPayment(TxnPayment &$txnPayment){
		DB::beginTransaction();
		try{
			$txnPayment->save();
			$this->_subtractUserBalance($txnPayment);
		}catch (Exception $e){
			DB::rollBack();
			throw $e;
		}
		DB::commit();
	}

	public function postRefundPayment(){
		$validator = Validator::make(
			Input::all(),
			array(
				'client_id' => 'required',
				'ref_txn_id' => "required|max:45",
			)
		);
		if ($validator->fails()){
			ob_clean ();
			return Response::json(array(
				'status'=>400,
				'error'=>'Bad request',
				'error_message'=>implode(' ',$validator->messages()->all()),
			));
		}

		$txnPayment=TxnPayment::where('oauth_client_id',Input::get('client_id'))
			->where('ref_txn_id',Input::get('ref_txn_id'))
			->first();
		if(!$txnPayment){
			return Response::json(array(
				'status'=>404,
				'error'=>'Not found',
				'error_message'=>'Không tìm thấy giao dịch cần hoàn',
			));
		}

		if($txnPayment->status!=TXN_PAYMENT_STATUS_SUCCESS){
			return Response::json(array(
				'status'=>406,
				'error'=>'Not acceptable',
				'error_message'=>'Bạn chỉ được phép hoàn tiền những giao dịch có trạng thái thành công',
			));
		}

		if($this->_refundPayment($txnPayment)){
			return Response::json(array(
				'status'=>200,
				'success'=>'Bạn đã hoàn thành công số tiền '.$txnPayment->amount,
				'txn_amount'=>$txnPayment->amount,
				'ref_txn_id'=>$txnPayment->ref_txn_id,
			));
		}else{
			return Response::json(array(
				'status'=>500
				,'error'=>'Server error'
				,'error_message'=>'System error occured'
			));
		}
	}
}