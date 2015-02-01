<?php
use Gregwar\Captcha\CaptchaBuilder;
class UsersAdminController extends AccountingBaseController {

	public function __construct()
	{
		$this->beforeFilter('admin');
		$this->beforeFilter('permission');
	}

	public function getListWithChargeAmount()
	{
		$query = new User;

		if(Input::has('source'))
			$query=$query->where('source','=',Input::get('source'));
		if(Input::has('username'))
			$query=$query->where('username','=',Input::get('username'));
		if(Input::has('created_at_from'))
			$query->where('created_at','>=',date("Y-m-d H:i:s", strtotime(Input::get('created_at_from'))));
		if(Input::has('created_at_to'))
			$query->where('created_at','<=',date("Y-m-d 23:59:59", strtotime(Input::get('created_at_to'))));

		$chart=null;
		if (Input::get('chart_type')) {
			$chart_query = clone $query;
			$chart_query=$chart_query->select(DB::raw('date(`created_at`) as row_date,count(id) as row_count,0 as row_sum'));
			$chart_query=$chart_query->groupBy(DB::raw('date(`created_at`)'))
				->orderBy('created_at', 'asc');
			$chart=AppHelper::drawChart($chart_query);
		}

		$query = $query->select('id','username','source','created_at');
		$query = $query->orderBy('id','desc');
		$rows=$query->paginate(10);

		return View::make('users.admin.index',array(
			'rows'=>$rows,
			'chart'=>$chart
		));
	}
}