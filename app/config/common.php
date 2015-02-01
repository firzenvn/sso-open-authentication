<?php
return array(

    'password_reminder_timeout' => 30,

    'email_update_timeout' => 30,

    'card_types' => array(
        'VTE'=>'Viettel',
        'VNP'=>'Vinaphone',
        'VMS'=>'Mobifone'
    ),

	'txn_card_response_codes'=>array(
		TXN_CARD_RESPONSE_CODE_PENDING => 'Chờ xử lý',
		TXN_CARD_RESPONSE_CODE_SUCCESS => 'Thành công',
		TXN_CARD_RESPONSE_CODE_FAIL => 'Thất bại',
	),

    'txn_payment_status'=>array(
        '0'=>'Chờ xử lý',
        '1'=>'Thành công',
        '2'=>'Thất bại',
    ),

    'baokim_txn_status'=>array(
        '4'=>'Hoàn thành',
        '13'=>'Đang tạm giữ',
        '2'=>'Xác minh-chờ xử lý',
        '3'=>'Chờ Bảo kim duyệt',
        '5'=>'Đã hủy',
        '6'=>'Bị từ chối',
        '1'=>'Chưa xác minh',
        '7'=>'Hết hạn',
        '8'=>'Thất bại',
        '9'=>'Hoàn tiền',
        '11'=>'Hoàn tiền một phần',
        '12'=>'Bị phong tỏa',
    ),

	'true_cards'=>array(
		'170219841702'
	),

	'vnd_to_xu_rate'=>1/100,

	'chart_types'=>array(
		''=>'==Biểu đồ==',
		'ColumnChart'=>'Biểu đồ cột',
		'LineChart'=>'Biểu đồ đường',
		'AreaChart'=>'Biểu đồ vùng'
	),

    'check_email_except' => array(
        'soha'
    )
);