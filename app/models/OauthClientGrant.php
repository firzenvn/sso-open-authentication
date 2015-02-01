<?php

class OauthClientGrant extends \Eloquent {
	protected $fillable = [];

	public function client(){
		return $this->belongsTo('OauthClient','client_id');
	}

	public function grant(){
		return $this->belongsTo('OauthGrant','grant_id');
	}
}