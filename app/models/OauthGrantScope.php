<?php

class OauthGrantScope extends \Eloquent {
	protected $fillable = [];

	public function grant(){
		return $this->belongsTo('OauthGrant','grant_id');
	}

	public function scope(){
		return $this->belongsTo('OauthScope','scope_id');
	}
}