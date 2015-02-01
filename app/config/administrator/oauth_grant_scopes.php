<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Grant scopes',

	'single' => 'Grant scope',

	'model' => 'OauthGrantScope',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'grant_id',
		'grant' => array(
			'title' => 'Grant',
			'relationship' => 'grant',
			'select'=>'`grant`',
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
		'grant_id',
		'grant' => array(
			'title' => 'Grant',
			'type' => 'relationship',
			'name_field'=> "grant"
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
		'grant' => array(
			'title' => 'Grant',
			'type' => 'relationship',
			'name_field'=> "grant"
		),
		'scope' => array(
			'title' => 'Scope',
			'type' => 'relationship',
			'name_field'=> "scope"
		),
	),

);