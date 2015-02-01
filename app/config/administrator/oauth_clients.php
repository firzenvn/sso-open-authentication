<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Clients',

	'single' => 'Client',

	'model' => 'OauthClient',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'secret',
		'name',
		'sso_on',
		'created_at',
		'updated_at'
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'name',
		'sso_on',
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'text',
		),
		'name' => array(
			'title' => 'Name',
			'type' => 'text',
		),
		'secret' => array(
			'title' => 'Secret',
			'type' => 'text',
		),
		'sso_on' => array(
			'title' => 'Bật sso',
			'type' => 'text',
		),
	),

);