<?php
use Gregwar\Captcha\CaptchaBuilder;
class ChargesController extends \AccountingBaseController {

	public function __construct()
	{
		$this->beforeFilter('auth',array('except'=>array('getChargeByBankCardReturn','postBaokimBpnCallback')));
	}

	public function getIndex()
	{

        //Load layout
        $ui_mode = Input::has('ui_mode')?Input::get('ui_mode'):'logged-in';

        //Kiểm tra đã cập nhật thông tin chưa
        if(!isset(Auth::user()->email) || !isset(Auth::user()->phone) || Auth::user()->email == '' || Auth::user()->phone == '')
            return Redirect::to('/users/profile?panel=account&updated_account=0&ui_mode='.$ui_mode.'&return_url='.Request::url());

		$card_types = Config::get('common.card_types');

		require_once app_path('/ext-libs/baokim/BaokimPaymentPro.php');

		if(Cache::has('baokim_cards')){
			$bpms=json_decode(Cache::get('baokim_cards'),true);
		}else{
			$bpp=new BaokimPaymentPro();
			$bpms=$bpp->getSellerInfo();
			Cache::put('baokim_cards', json_encode($bpms), 1440);
		}

		$atmCards=View::make('charges.baokim-cards',array('bpms'=>isset($bpms['bank_payment_methods'])?$bpms['bank_payment_methods']:[],'cardType'=>1));
		$creditCards=View::make('charges.baokim-cards',array('bpms'=>isset($bpms['bank_payment_methods'])?$bpms['bank_payment_methods']:[],'cardType'=>2));
		return View::make('charges.index', array(
			'card_types'=>$card_types,
			'atmCards'=>$atmCards,
			'creditCards'=>$creditCards,
            'ui_mode'=>$ui_mode
		));
	}

	public function postChargeByMobileCard()
	{
		$builder = new CaptchaBuilder;
		$builder->setPhrase(Session::get('captchaPhrase'));
		if(!$builder->testPhrase(Input::get('captcha'))) {
			return Redirect::back()->with('error','Mã an toàn nhập không chính xác')->withInput();
		}

		$card_type = Input::get('card_type');
		$pin = Input::get('pin');
		$seri = Input::get('seri');

		//Lưu giao dịch thẻ cào
		$txnCard = new TxnCard;
		$txnCard->user_id = Auth::user()->id;
		$txnCard->card_type = $card_type;
		$txnCard->pin = $pin;
		$txnCard->seri = $seri;
		if(!$txnCard->save()){
			return Redirect::back()->with('error','System error occured while storing card info');
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
		if($response_code==TXN_CARD_RESPONSE_CODE_SUCCESS){
			$this->_onCardSuccess($txnCard);
            if(Input::has('return_url')){
                return View::make('charges.charge-processing')->with('return_url',Input::get('return_url'));
            }else
			return Redirect::back()->with('success','Nạp thẻ thành công');
		}else{
			$this->_onCardFail($txnCard);
			return Redirect::back()->with('error',$response_message);
		}
	}

	/**
	 * Giao dịch qua Baokim
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postChargeByBankCard(){
		$validator=Validator::make(Input::all(),array(
			'bank_payment_method_id'=>'required|numeric',
			'amount'=>'required|numeric|min:10000',
		));
		if($validator->fails()){
			return Redirect::back()->with('message',$validator->messages());
		}

		$txnBaokimCard=new TxnBaokimCard();
		$txnBaokimCard->user_id=Auth::user()->id;
		$txnBaokimCard->bank_payment_method_id=Input::get('bank_payment_method_id');
		$txnBaokimCard->amount=Input::get('amount');
		$txnBaokimCard->save();

		require_once app_path('/ext-libs/baokim/BaokimPaymentPro.php');
		$bpp=new BaokimPaymentPro();
		$bkResponse=$bpp->payByCard(Auth::user(),$txnBaokimCard);
		if($bkResponse['next_action']=='redirect')
			return Redirect::to($bkResponse['redirect_url']);
		else
			return Redirect::back()->with('message','Phương thức thanh toán không được hỗ trợ');
	}

	/**
	 * Xử lý kêt quả trả về từ Baokim
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getChargeByBankCardReturn(){
		require_once app_path('/ext-libs/baokim/BaokimPaymentPro.php');
		$bpp=new BaokimPaymentPro();
		$params=Input::all();

		if(!$bpp->verifyResponseUrl($params))
			exit('Data verification invalid');

		$txnBaokimCard=TxnBaokimCard::find($params['order_id']);
		if(!$txnBaokimCard){
			exit('Transaction not found');
		}

		if($params['total_amount'] < $txnBaokimCard->amount)
			exit('So tien thanh toan khong du');

		if($params['transaction_status'] != 4)
			exit('Giao dich chua hoan thanh');

		if($txnBaokimCard->baokim_txn_id || $txnBaokimCard->baokim_txn_status!=0)
			exit('Giao dich da duoc xu ly');

		$baokimTransaction=$bpp->queryTransaction($params['transaction_id']);
		if(!$baokimTransaction)
			exit('Khong kiem tra duoc giao dich tu cong thanh toan');
		if($baokimTransaction['transaction_status']!=$params['transaction_status'])
			exit('Trang thai giao dich tra ve khong khop voi trang thai giao dich tren cong thanh toan');
		if($baokimTransaction['total_amount']!=$params['total_amount'])
			exit('So tien giao dich tra ve khong khop voi so tien giao dich tren cong thanh toan');

		DB::beginTransaction();
		try {
			$txnBaokimCard->baokim_txn_status=$params['transaction_status'];
			$txnBaokimCard->baokim_txn_id=$params['transaction_id'];
			if (!$txnBaokimCard->save()) {
				throw new Exception('DB Error');
			}

			$user=User::findOrFail($txnBaokimCard->user_id);

			//cập nhật số dư tài khoản
			$account_trace = new AccountTrace;
			$account_trace->account_id = $user->mainAccount()->id;
			$account_trace->change_balance = $txnBaokimCard->amount * Config::get('common.vnd_to_xu_rate');
			$account_trace->txn_baokim_card_id = $txnBaokimCard->id;
			if (!$account_trace->save()) {
				throw new Exception('DB Error');
			}
		} catch (Exception $e) {
			DB::rollBack();
			exit('Xay ra loi trong qua trinh xu ly giao dich');
		}
		DB::commit();

        if(Input::has('return_url')){
            return View::make('charges.charge-processing')->with('return_url',Input::get('return_url'));
        }else
		return Redirect::to('charges/index')->with('message','Chúc mừng bạn đã nạp thành công số tiền '.$txnBaokimCard->amount);
	}

	/**
	 * Baokim BPN callback
	 */
	public function postBaokimBpnCallback(){
		//verify BPN first
		require_once app_path('/ext-libs/baokim/BaokimBPN.php');
		if(!BaokimBPN::verify())
			exit('BPN verification failed');

		$params=Input::all();

		//Check order status
		$order_id=$params['order_id'];
		$txnBaokimCard=TxnBaokimCard::find($order_id);
		if(!$txnBaokimCard){
			exit('Invalid order id');
		}
		if($params['total_amount'] < $txnBaokimCard->amount)
			exit('So tien thanh toan khong du');

		if($params['transaction_status'] != 4)
			exit('Giao dich chua hoan thanh');

		if($txnBaokimCard->baokim_txn_id || $txnBaokimCard->baokim_txn_status!=0)
			exit('Giao dich da duoc xu ly');


		DB::beginTransaction();
		try {
			$txnBaokimCard->baokim_txn_status=Input::get('transaction_status');
			$txnBaokimCard->baokim_txn_id=Input::get('transaction_id');
			if (!$txnBaokimCard->save()) {
				throw new Exception('DB Error');
			}

			$user=User::findOrFail($txnBaokimCard->user_id);

			//cập nhật số dư tài khoản
			$account_trace = new AccountTrace;
			$account_trace->account_id = $user->mainAccount()->id;
			$account_trace->change_balance = $txnBaokimCard->amount * Config::get('common.vnd_to_xu_rate');
			$account_trace->txn_baokim_card_id = $txnBaokimCard->id;
			if (!$account_trace->save()) {
				throw new Exception('DB Error');
			}
		} catch (Exception $e) {
			DB::rollBack();
			exit('Xay ra loi trong qua trinh xu ly giao dich');
		}
		DB::commit();

		exit('Order updated successfully');
	}

    public function getPaymentHistory(){
        $txn_payments = Auth::user()->txn_payments();
        if(Input::has('start_date')){
            $txn_payments->where('created_at','>=',date("Y-m-d H:i:s", strtotime(Input::get('start_date'))));
        }
        if(Input::has('end_date')){
            $txn_payments->where('created_at','<=',date("Y-m-d 23:59:59", strtotime(Input::get('end_date'))));
        }
        if(Input::has('status')){
            $txn_payments->where('status',Input::get('status'));
        }

        $txn_payments = $txn_payments->paginate(10);

        return View::make('charges.payment-history')->with('txn_payments',$txn_payments);
    }

    public function getCardHistory(){
        $txn_cards = Auth::user()->txnCards();
        if(Input::has('start_date')){
            $txn_cards->where('created_at','>=',date("Y-m-d H:i:s", strtotime(Input::get('start_date'))));
        }
        if(Input::has('end_date')){
            $txn_cards->where('created_at','<=',date("Y-m-d 23:59:59", strtotime(Input::get('end_date'))));
        }
        if(Input::has('response_code')){
            $txn_cards->where('response_code',Input::get('response_code'));
        }

        $txn_cards = $txn_cards->paginate(10);

        return View::make('charges.card-history')->with('txn_cards',$txn_cards);
    }

    public function getBankHistory(){
        $txn_banks = Auth::user()->txn_baokim_cards();
        if(Input::has('start_date')){
            $txn_banks->where('created_at','>=',date("Y-m-d H:i:s", strtotime(Input::get('start_date'))));
        }
        if(Input::has('end_date')){
            $txn_banks->where('created_at','<=',date("Y-m-d 23:59:59", strtotime(Input::get('end_date'))));
        }
        if(Input::has('status')){
            $txn_banks->where('baokim_txn_status',Input::get('status'));
        }

        $txn_banks = $txn_banks->paginate(10);

        return View::make('charges.bank-history')->with('txn_banks',$txn_banks);
    }

}