<?php

class District extends \Eloquent {
	protected $fillable = [];

    protected $table = 'districts';

    public function province()
    {
        return $this->belongsTo('Province');
    }
}