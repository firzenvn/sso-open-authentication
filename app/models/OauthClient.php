<?php

class OauthClient extends \Eloquent {
	protected $fillable = [];

	public function endpoints()
	{
		return $this->hasMany('OauthClientEndpoint','client_id');
	}
}