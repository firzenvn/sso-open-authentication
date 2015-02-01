<?php
use Gregwar\Captcha\CaptchaBuilder;
class TxnCardsAdminController extends AccountingBaseController {

	public function __construct()
	{
		$this->beforeFilter('admin', array('except'=>array(
            'postCallback'
        )));
		$this->beforeFilter('permission', array('except'=>array(
            'postCallback'
        )));
	}

	public function getIndex()
	{
		$query = new TxnCard;
		if(Input::has('pin'))
		{
			$query=$query->where('pin','=',Input::get('pin'));
		}
		if(Input::has('seri'))
		{
			$query=$query->where('seri','=',Input::get('seri'));
		}
		if(Input::has('username'))
		{
            $user = User::where('username',Input::get('username'))->first();
            $query=$query->where('user_id',$user ? $user->id : '');
		}

		$chart=null;
		if (Input::get('chart_type')) {
			$chart_query = clone $query;
			$chart_query=$chart_query->groupBy(DB::raw('date(`created_at`)'))
				->select(DB::raw('date(`created_at`) as row_date,count(id) as row_count,sum(card_amount) as row_sum'))
				->orderBy('created_at', 'asc');

			$chart=AppHelper::drawChart($chart_query);
		}

		$query = $query->orderBy('id','desc');
		$rows=$query->paginate(10);

		return View::make('txn-cards.admin.index',array(
			'rows'=>$rows,
			'chart'=>$chart
		));
	}

	public function getManualUpdate(){
		$id=Input::get('id');
		if(!$id) return Redirect::to('admin/txn-cards/index')->with('message','id is missing');
		$row=TxnCard::find($id);
		if($row->response_code==TXN_CARD_RESPONSE_CODE_SUCCESS)
			return Redirect::to('admin/txn-cards/index')->with('message','GD đã hoàn thành');
		return View::make('txn-cards.admin.manual-update',array(
			'row'=>$row,
		));
	}

	public function postManualUpdate(){
		if(Input::get('btn-complete')){
			$id=Input::get('id');
			if(!$id) return Redirect::to('admin/txn-cards/index')->with('message','id is missing');
			$row=TxnCard::find($id);
			if($row->response_code==TXN_CARD_RESPONSE_CODE_SUCCESS)
				return Redirect::back()->with('message','GD đã hoàn thành');
			$row->card_amount=Input::get('card_amount');
			$row->response_code=TXN_CARD_RESPONSE_CODE_SUCCESS;
			$this->_onCardSuccess($row);

			Activity::log(array(
				'contentId'=> $id,
				'contentType'=>'txn_cards',
				'description'=>'Hoan thanh GD the cao',
				'updated'=>true
			));

			return Redirect::to('admin/txn-cards/index')->with('success','Cập nhật thành công');
		}
	}

    public function getManualRecheck(){

        $id = Input::get('id');
        if(!$id)
            return Redirect::back()->with('message','id is missing');

        $record = TxnCard::find($id);
        if(!$record)
            return Redirect::back()->with('message','Không tìm thấy GD');

        if($record->response_code == TXN_CARD_RESPONSE_CODE_SUCCESS)
            return Redirect::back()->with('message','Giao dịch đã hoàn thành');

		require_once app_path('/ext-libs/maxpay/MaxpayClient.php');
		$mpc = new MaxpayClient();
		$logMaxpay=LogMaxpay::where('txn_card_id','=',$record->id)->first();
		if(!$logMaxpay)
			return Redirect::back()->with('message','Không tìm thấy bản ghi log gọi sang maxpay');
		$response = $mpc->recheck($logMaxpay->merchant_txn_id);

		if($response['response_code'] != 200)
			return Redirect::back()->with('message','Lỗi: '.$response['response_message']);

		DB::beginTransaction();
		try{
			//update lại giao dịch
			//$record->response_code = $response['code'];
            switch ($response['code']) {
                case 1:
                    $record->response_code = TXN_CARD_RESPONSE_CODE_SUCCESS;
                    break;
                case 98:
                    $record->response_code = TXN_CARD_RESPONSE_CODE_PENDING;
                    break;
                default:
                    $record->response_code = TXN_CARD_RESPONSE_CODE_FAIL;
                    break;
            }
			$record->card_amount = $response['card_amount'];
            if(!$record->save()){
                throw new Exception('DB Error');
            }

            if($record->response_code == TXN_CARD_RESPONSE_CODE_SUCCESS){
                $this->_onCardSuccess($record);
            }
            $message = $response['response_message'];
        }catch (Exception $e){
            DB::rollBack();
            Log::error($e);
            return Redirect::back()->with('message',$e->getMessage());
        }

        DB::commit();
        return Redirect::back()->with('message',$message);
    }

    public function postCallback(){
        $validator = Validator::make(Input::all(),array(
            'merchant_txn_id'=>'required',
            'code'=>'required|numeric',
            'card_amount'=>'required',
            'net_amount'=>'required',
            'seri'=>'required',
            'checksum'=>'required'
        ));
        if($validator->fails()) exit('Lỗi Validate');

        $args = array(
            'merchant_txn_id' => Input::get('merchant_txn_id'),
            'code' => Input::get('code'),
            'card_amount' => Input::get('card_amount'),
            'net_amount' => Input::get('net_amount'),
            'seri' => Input::get('seri'),
        );

        require_once app_path('/ext-libs/maxpay/MaxpayClient.php');
        $mpc = new MaxpayClient();
        if(!$mpc->verifyChecksum($args,Input::get('checksum'))) exit('Checksum sai!');
        $logMaxpay = LogMaxpay::where('merchant_txn_id',Input::get('merchant_txn_id'))->where('seri',Input::get('seri'))->first();
        $record = TxnCard::find($logMaxpay->txn_card_id);

        if(!$logMaxpay || !$record)
            exit('GD không tồn tại');
        if($record->response_code == TXN_CARD_RESPONSE_CODE_SUCCESS)
            exit('GD đã thành công');

        DB::beginTransaction();
        try{
            switch (Input::get('code')) {
                case 1:
                    $record->response_code = TXN_CARD_RESPONSE_CODE_SUCCESS;
                    break;
                case 98:
                    $record->response_code = TXN_CARD_RESPONSE_CODE_PENDING;
                    break;
                default:
                    $record->response_code = TXN_CARD_RESPONSE_CODE_FAIL;
                    break;
            }
            $record->card_amount = Input::get('card_amount');
            if(!$record->save()){
                throw new Exception('DB Error');
            }
            if($record->response_code == TXN_CARD_RESPONSE_CODE_SUCCESS){
                $this->_onCardSuccess($record);
            }
        }catch (Exception $e){
            DB::rollBack();
            Log::error($e);
            exit;
        }

        DB::commit();
        return 'ok';
    }
}