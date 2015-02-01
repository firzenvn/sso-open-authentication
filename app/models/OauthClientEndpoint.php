<?php

class OauthClientEndpoint extends \Eloquent {
	protected $fillable = [];

	public function client(){
		return $this->belongsTo('OauthClient','client_id');
	}
}