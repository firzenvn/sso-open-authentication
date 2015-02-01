<?php

class Account extends \Eloquent {
	protected $fillable = array('user_id', 'account_type');

    protected $table = 'accounts';

    protected $softDelete = true;

	public function account_type(){
		return $this->belongsTo('AccountType','account_type','id');
	}

	public function user(){
		return $this->belongsTo('User');
	}
}