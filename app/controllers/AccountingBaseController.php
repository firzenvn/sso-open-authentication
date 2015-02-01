<?php

class AccountingBaseController extends \BaseController {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Trừ số dư khi người dùng tạo giao dịch thanh toán
	 * @param $txnPayment
	 */
	protected function _subtractUserBalance(TxnPayment $txnPayment)
	{
		$myApp=App::make('myApp');
		$subAccount=$myApp->oauthUser->subAccount();
		$subtractAmount=$txnPayment->amount;
		if($subAccount->balance > 0){
			$changeBalance=$subtractAmount > $subAccount->balance ? $subAccount->balance:$subtractAmount;
			$accountTrace = new AccountTrace();
			$accountTrace->account_id = $subAccount->id;
			$accountTrace->change_balance = -$changeBalance;
			$accountTrace->txn_payment_id = $txnPayment->id;
			$accountTrace->save();

			$subtractAmount-=$changeBalance;
		}

		if($subtractAmount > 0){
			$mainAccount=$myApp->oauthUser->mainAccount();
			if($mainAccount->balance < $subtractAmount)
				throw new Exception('Số dư tài khoản không đủ để thanh toán');
			$accountTrace = new AccountTrace();
			$accountTrace->account_id = $mainAccount->id;
			$accountTrace->change_balance = -$subtractAmount;
			$accountTrace->txn_payment_id = $txnPayment->id;
			$accountTrace->save();
		}
	}

	protected function _processChargeByMobileCard(TxnCard $txnCard){
		return $this->_chargeByMaxpay($txnCard);
	}

	/**
	 * Xử lý nạp thẻ qua cổng maxpay
	 * @param $txnCard
	 */
	protected function _chargeByMaxpay(TxnCard $txnCard)
	{
		//Lưu log
		$log = new LogMaxpay;
		$log->txn_card_id = $txnCard->id;
		$log->card_type = $txnCard->card_type;
		$log->pin = $txnCard->pin;
		$log->seri = $txnCard->seri;
		$log->merchant_txn_id = $txnCard->id . '-' . time();
		if (!$log->save()) {
			throw new Exception('DB error while storing maxpay log');
		}

		require_once app_path('/ext-libs/maxpay/MaxpayClient.php');
		$mpc = new MaxpayClient();

		$rs = $mpc->charge($log->merchant_txn_id, $txnCard->card_type, $txnCard->pin, $txnCard->seri);

		//update kết quả trả về vào trong log
		$log->response_code = $rs['code'];
		$log->response_message = $rs['message'];
		$log->card_amount = isset($rs['card_amount']) ? $rs['card_amount'] : 0;
		if (!$log->save()) {
			throw new Exception('DB error while storing maxpay log');
		}

		switch ($rs['code']) {
			case 1:
				return array(TXN_CARD_RESPONSE_CODE_SUCCESS, $rs['card_amount'], $rs['message']);
				break;
			case 98:
				return array(TXN_CARD_RESPONSE_CODE_PENDING, 0, $rs['message']);
				break;
			default:
				return array(TXN_CARD_RESPONSE_CODE_FAIL, 0, $rs['message']);
				break;
		}
	}

	/**
     * Xử lý khi nạp thẻ thành công
     * @param $txnCard
     * @return \Illuminate\Http\RedirectResponse
     */
	protected function _onCardSuccess(TxnCard $txnCard)
	{
		DB::beginTransaction();
		try {
			//cập nhật bảng txn_cards
			if (!$txnCard->save()) {
				throw new Exception('DB Error');
			}

			$user=User::findOrFail($txnCard->user_id);

			//cập nhật số dư tài khoản
			$account_trace = new AccountTrace;
			$account_trace->account_id = $user->mainAccount()->id;
			$account_trace->change_balance = $txnCard->card_amount * Config::get('common.vnd_to_xu_rate');
			$account_trace->txn_card_id = $txnCard->id;
			if (!$account_trace->save()) {
				throw new Exception('DB Error');
			}
		} catch (Exception $e) {
			DB::rollBack();
			throw $e;
		}
		DB::commit();
	}

	/**Xử lý khi nạp thẻ thất bại
     * @param $txnCard
     * @return \Illuminate\Http\RedirectResponse
     */
	protected function _onCardFail(TxnCard $txnCard)
	{
		DB::beginTransaction();
		try {
			//cập nhật bảng txn_cards
			if (!$txnCard->save()) {
				throw new Exception('DB Error');
			}
		} catch (Exception $e) {
			DB::rollBack();
		}
		DB::commit();
	}

	/*
	 * Hoàn thiền giao dịch nạp game
	 */
	protected function _refundPayment(TxnPayment $txnPayment){
		DB::beginTransaction();
		try {
			$txnPayment->status=TXN_PAYMENT_STATUS_REFUNDED;
			$txnPayment->save();

			$traces=AccountTrace::where('txn_payment_id',$txnPayment->id)->get();
			foreach($traces as $trace){
				$account_trace = new AccountTrace;
				$account_trace->account_id = $trace->account_id;
				$account_trace->change_balance = -$trace->change_balance;
				$account_trace->txn_payment_id = $trace->txn_payment_id;
				$account_trace->save();
			}
		} catch (Exception $e) {
			DB::rollBack();
			return false;
		}
		DB::commit();
		return true;
	}
}