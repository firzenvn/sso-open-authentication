<?php
/**
 * Created by PhpStorm.
 * User: Firzen
 * Date: 6/12/14
 * Time: 9:05 PM
 */

class AppHelper {

	/**
	 * Format số điện thoại theo chuẩn quốc tế 84...
	 * @param string $phone
	 * @return mixed|null
	 */
	public static function standardizePhone($phone = ''){
		if(!$phone)
			return null;
		if(!preg_match('/^(0)|(84)|(\+84)/',$phone))
			$phone="84".$phone;
		return preg_replace('/^(0)|(\+84)/','84',$phone);
	}

	/**
	 * Hàm giải mã signinTicket thành username/password để kiểm tra đăng nhập
	 * Returns decrypted original string
	 */
	public static function decryptTicket($ticket,$encryptionKey) {
		$ticket=base64_decode($ticket);
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryptionKey, $ticket, MCRYPT_MODE_ECB, $iv);
		$decrypted_string = trim($decrypted_string, "\0\4");
		return json_decode($decrypted_string,true);
	}
	/**
	 * @param $chart_query
	 * @return array
	 */
	public static function assignChartDate(&$chart_query)
	{
		if (Input::has('created_at_from'))
			$start_date = Input::get('created_at_from');
		else
			$start_date = date('Y-m', time()) . '-01';

		if (Input::has('created_at_to'))
			$end_date = Input::get('created_at_to');
		else
			$end_date = date('Y-m-d', time());

		$chart_query = $chart_query->whereBetween('created_at', array($start_date, $end_date));
		return array($start_date, $end_date);
	}

	public static function drawChart($chart_query){
		$chart_type = Input::get('chart_type') ? Input::get('chart_type') : 'AreaChart';

		list($start_date, $end_date) = AppHelper::assignChartDate($chart_query);

		$timesTable = Lava::DataTable('Times');

		$timesTable->addColumn('date', 'Dates', 'dates')
			->addColumn('number', 'Số bản ghi', 'run')
			->addColumn('number', 'Sản lượng (x 100K)', 'run');

		$chartRecords = $chart_query->get();

		$total_count = 0;
		$total_sum = 0;
		if (!empty($chartRecords)) {
			foreach ($chartRecords as $rec) {
				$data = array(
					Lava::jsDate(date('Y', strtotime($rec->row_date)), intval(date('m', strtotime($rec->row_date))) - 1, date('d', strtotime($rec->row_date))),
					$rec->row_count,
					round($rec->row_sum/100000),
				);

				$total_sum += round($rec->row_sum/100000);
				$total_count += $rec->row_count;

				$timesTable->addRow($data);
			}
		}

		$summary = array(
			'Tổng số bản ghi' => number_format($total_count),
			'Tổng sản lượng' => number_format($total_sum).' x 100K',
			'Từ ngày' => $start_date,
			'Đến ngày' => $end_date
		);

		$config = array(
			'title' => 'Biểu đồ',
			'hAxis' => Lava::hAxis(array('title' => 'Thời gian')),
			'vAxis' => Lava::vAxis(array('title' => 'Giá trị'))
		);
		Lava::$chart_type('Times')->setConfig($config);

		return View::make("charts.index", array('summary' => $summary, 'chart_type' => $chart_type));
	}

    /**
     * Chuẩn bị file csv để export
     * @return resource
     */
    public static function prepareCSVFile($filename)
    {
        set_time_limit(3600);
        $fileName = $filename .'-'. date('YmdHis',time()) . '.csv';

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");

        $fh = @fopen('php://output', 'w');
        return $fh;
    }

    /**
     * Hiển thị số điện thoại dạng che
     */
    public static function maskPhone($phone){
        return strlen($phone)<=6 ? $phone : substr($phone,0,3).str_repeat('*',strlen($phone)-6)
        .substr($phone,strlen($phone)-3,3);
    }

    /**
     * Hiển thị email dạng che
     */
    public static function maskEmail($email){
        $arr = explode('@',$email);
        if(strlen($arr[0])<=3){
            return $email;
        }else
            return substr($arr[0],0,3).str_repeat('*',strlen($arr[0])-3).'@'.$arr[1];
    }

} 