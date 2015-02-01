<?php

/**
 * Actors model config
 */

return array(

	'title' => 'GD Baokim',

	'single' => 'gd Baokim',

	'model' => 'TxnBaokimCard',

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
		'baokim_txn_id' => array(
			'title'=>'Mã GD Baokim',
			'select'=>'baokim_txn_id'
		),
		'baokim_txn_status' => array(
			'title' => 'Trạng thái GD (4: ok)',
			'select' => "baokim_txn_status",
		),
		'bank_payment_method_id' => array(
			'title' => 'Mã loại thẻ',
			'select' => "bank_payment_method_id",
		),
		'amount' => array(
			'title' => 'Số tiền',
			'select' => "amount",
		),
		'created_at' => array(
			'title' => 'Thời gian GD',
			'select' => "created_at",
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
        'baokim_txn_id'=>array(
            'title'=>'Mã GD Baokim'
        ),
		'baokim_txn_status' => array(
			'title' => 'Trạng thái GD',
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