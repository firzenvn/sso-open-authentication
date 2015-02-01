<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Client scopes',

	'single' => 'Client scope',

	'model' => 'OauthClientScope',

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
		'scope_id',
		'scope' => array(
			'title' => 'Scope',
			'relationship' => 'scope',
			'select'=>'scope',
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
		'scope_id',
		'scope' => array(
			'title' => 'Scope',
			'type' => 'relationship',
			'name_field'=> "scope"
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
		'scope' => array(
			'title' => 'Scope',
			'type' => 'relationship',
			'name_field'=> "scope"
		),
	),

);