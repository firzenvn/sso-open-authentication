<?php

/**
 * Actors model config
 */

return array(

	'title' => 'GD nạp game',

	'single' => 'gd nạp game',

	'model' => 'TxnPayment',

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
		'amount' => array(
			'title' => 'Số tiền',
			'select' => "amount",
		),
		'status' => array(
			'title' => 'Trạng thái',
			'select' => "status",
		),
		'description' => array(
			'title' => 'Nội dung GD',
			'select' => "description",
		),
		'created_at' => array(
			'title' => 'Thời gian GD',
			'select' => "created_at",
		),
		'oauth_client_id' => array(
			'title'=>'Mã client',
			'select'=>'oauth_client_id'
		),
		'ref_txn_id' => array(
			'title'=>'Mã GD client',
			'select'=>'ref_txn_id'
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'ref_txn_id'=>array(
			'title'=>'Mã GD client'
		),
        'oauth_client_id'=>array(
            'title'=>'Mã client'
        ),
		'user' => array(
			'title' => 'Username',
			'type' => 'relationship',
			'name_field' => "username",
			'autocomplete' => true,
			'num_options' => 5,
		),
		'status'=>array(
			'title'=>'Trạng thái (1:success, 2:hoàn tiền)'
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