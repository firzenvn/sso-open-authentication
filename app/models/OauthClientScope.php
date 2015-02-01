<?php

class OauthClientScope extends \Eloquent {
	protected $fillable = [];

	public function client(){
		return $this->belongsTo('OauthClient','client_id');
	}

	public function scope(){
		return $this->belongsTo('OauthScope','scope_id');
	}
}