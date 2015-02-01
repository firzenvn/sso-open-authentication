<?php
use Gregwar\Captcha\CaptchaBuilder;
class TxnBaoKimCardsAdminController extends AccountingBaseController {

    public function __construct()
    {
        $this->beforeFilter('admin');
        $this->beforeFilter('permission');
    }

    public function getIndex()
    {
        $query = TxnBaokimCard::where('id','!=','');
        if(Input::has('username'))
        {
            $user = User::where('username',Input::get('username'))->first();
            $query=$query->where('user_id',$user ? $user->id : '');
        }
        if(Input::has('start_date')){
            $query->where('created_at','>=',date("Y-m-d H:i:s", strtotime(Input::get('start_date'))));
        }
        if(Input::has('end_date')){
            $query->where('created_at','<=',date("Y-m-d 23:59:59", strtotime(Input::get('end_date'))));
        }

        if(Input::has('export_csv')){
            $fh = AppHelper::prepareCSVFile("GiaoDichBaoKim");
            fputcsv($fh, array("ID","User","Menh gia","Ma GD", "Thoi gian", "Trang thai(4:ok)"));
            $query->chunk(100, function ($rows) use ($fh) {
                foreach ($rows as $row) {
                    fputcsv($fh, array(
                        $row->id,
                        $row->user->username,
                        number_format($row->amount),
                        $row->baokim_txn_id,
                        $row->created_at,
                        $row->baokim_txn_status
                    ));
                }
                flush();
            });
            fclose($fh);
            exit;
        }

        $query = $query->orderBy('id','desc');
        $rows=$query->paginate(10);

        return View::make('txn-baokim-cards.admin.index',array(
            'rows'=>$rows
        ));
    }

}