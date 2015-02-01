<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Client endpoints',

	'single' => 'Client endpoint',

	'model' => 'OauthClientEndpoint',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'client_id',
		'client' => array(
			'title' => 'Client name',
			'relationship' => 'client',
			'select'=>'name',
		),
		'redirect_uri',
		'type',
		'created_at',
		'updated_at'
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'client_id',
		'client' => array(
			'title' => 'Client name',
			'type' => 'relationship',
			'name_field'=> "name"
		),
		'type',
		'redirect_uri'
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'client' => array(
			'title' => 'Client',
			'type' => 'relationship',
			'name_field'=> "name"
		),
		'redirect_uri' => array(
			'title' => 'Redirect URI',
			'type' => 'text',
		),
		'type' => array(
			'title' => 'login/logout',
			'type' => 'text',
		),
	),

);