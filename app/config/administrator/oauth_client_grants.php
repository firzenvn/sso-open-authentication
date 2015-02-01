<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Client grants',

	'single' => 'Client grant',

	'model' => 'OauthClientGrant',

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
		'grant_id',
		'grant' => array(
			'title' => 'Grant',
			'relationship' => 'grant',
			'select'=>'`grant`',
		),
		'created_at',
		'updated_at'
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'client_id',
		'client' => array(
			'title' => 'Client name',
			'type' => 'relationship',
			'name_field'=> "name"
		),
		'grant_id',
		'grant' => array(
			'title' => 'Grant',
			'type' => 'relationship',
			'name_field'=> "grant"
		),
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
		'grant' => array(
			'title' => 'Grant',
			'type' => 'relationship',
			'name_field'=> "grant"
		),
	),

);