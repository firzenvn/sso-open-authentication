<?php

class Province extends \Eloquent {
	protected $fillable = [];

    protected $table = 'provinces';

    public function districts()
    {
        return $this->hasMany('District');
    }
}