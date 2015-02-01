<?php

class TxnBaokimCard extends \Eloquent {
	protected $fillable = [];

    protected $table = 'txn_baokim_cards';

	protected $softDelete = true;

	public function user(){
		return $this->belongsTo('User');
	}

    public function getStatusmsgAttribute(){
        return Config::get('common.baokim_txn_status.'.$this->baokim_txn_status);
    }
}