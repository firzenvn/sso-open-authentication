<?php

class TxnCard extends \Eloquent {
	protected $fillable = [];

    protected $table = 'txn_cards';

    protected $softDelete = true;

	public function user(){
		return $this->belongsTo('User');
	}

    public function getResponsemsgAttribute(){
        return Config::get('common.txn_card_response_codes.'.$this->response_code);
    }
}