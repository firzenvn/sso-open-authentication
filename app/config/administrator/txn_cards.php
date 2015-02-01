<?php

/**
 * Actors model config
 */

return array(

	'title' => 'GD thẻ cào',

	'single' => 'gd thẻ cào',

	'model' => 'TxnCard',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
        'user' => array(
			'title' => 'User',
			'relationship' => 'user',
			'select' => "username",
		),
		'response_code' => array(
			'title' => 'Trạng thái',
			'select' => "response_code",
		),
		'card_amount' => array(
			'title' => 'Mệnh giá',
			'select' => "card_amount",
		),
		'card_type' => array(
			'title' => 'Loại thẻ',
			'select' => "card_type",
		),
		'pin' => array(
			'title' => 'Pin',
			'select' => "pin",
		),
		'seri' => array(
			'title' => 'Seri',
			'select' => "seri",
		),
		'ref_txn_id' => array(
			'title'=>'Mã GD client',
			'select'=>'ref_txn_id'
		),
		'created_at' => array(
			'title'=>'Thời gian giao dịch',
			'select'=>'created_at'
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
        'ref_txn_id'=>array(
            'title'=>'Mã GD Client'
        ),
		'card_type' => array(
			'title' => 'Loại thẻ',
		),
		'pin' => array(
			'title' => 'Pin',
		),
		'seri' => array(
			'title' => 'Seri',
		),
		'response_code' => array(
			'title' => 'Trạng thái trả về',
		),
		'user' => array(
			'title' => 'Username',
			'type' => 'relationship',
			'name_field' => "username",
			'autocomplete' => true,
			'num_options' => 5,
		),
		'created_at' => array(
			'title' => 'Thời gian GD',
			'type' => 'date',
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
        'id'
	),
);