<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Tài khoản (tổng XU hệ thống: '. number_format(Account::sum('balance')). "XU)",

	'single' => 'tài khoản',

	'model' => 'Account',

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
		'account_type' => array(
			'title' => 'Loại tài khoản',
			'relationship' => 'account_type',
			'select' => "name"
		),
		'balance' => array(
			'title'=>'Số dư (XU)',
			'select'=>'balance'
		),
		'sealed_balance' => array(
			'title'=>'Số dư đóng băng (XU)',
			'select'=>'sealed_balance'
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
		'user' => array(
			'title' => 'Username',
			'type' => 'relationship',
			'name_field' => "username",
			'autocomplete' => true,
			'num_options' => 5,
		),
		'account_type' => array(
			'title' => 'Loại tài khoản',
			'type' => 'relationship',
			'name_field' => "name"
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
        'id',
		'balance'=>array(
			'title'=>'Số dư',
			'type'=>'number'
		),
		'sealed_balance'=>array(
			'title'=>'Số dư đóng băng',
			'type'=>'number'
		)
	),
);