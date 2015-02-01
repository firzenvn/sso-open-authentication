<?php

/**
 * Actors model config
 */

return array(

	'title' => 'Scopes',

	'single' => 'Scope',

	'model' => 'OauthScope',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id',
		'scope',
		'name',
		'description',
		'created_at',
		'updated_at'
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'id',
		'scope',
		'name',
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'text',
		),
		'scope' => array(
			'title' => 'Scope',
			'type' => 'text',
		),
		'name' => array(
			'title' => 'Name',
			'type' => 'text',
		),
		'description' => array(
			'title' => 'Description',
			'type' => 'text',
		),
	),

);