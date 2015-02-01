<?php

class AccountTrace extends \Eloquent {
	protected $fillable = [];

    protected $table = 'account_traces';

    protected $softDelete = true;
}