<?php

class TxnPayment extends \Eloquent {
	protected $fillable = [];
	protected $softDelete = true;
	public function user(){
		return $this->belongsTo('User');
	}

    public function getStatusmsgAttribute(){
        return Config::get('common.txn_payment_status.'.$this->status);
    }
}