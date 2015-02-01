<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	// Set guarded to an empty array to allow mass assignment of every field
	protected $guarded = array('password');

	public static 	$rules = array(
		'username'=>'required|min:6|max:45|alpha_num|unique:users',
		'first_name'=>'min:2',
		'last_name'=>'min:2',
		'email'=>'email',
		'phone'=>'regex:/^[0-9]{9,13}$/|unique:users',
		'password'=>'required|alpha_num|min:6|max:12|confirmed',
		'password_confirmation'=>'required|alpha_num|min:6|max:12'
	);

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function roles() {
		return $this->belongsToMany('Role');
	}
	public function hasRole($key)
	{
		foreach ($this->roles as $role) {
			if ($role->role_name === $key) {
				return true;
			}
		}
		return false;
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'remember_token';
	}

    public function accounts()
    {
        return $this->hasMany('Account');
    }

    public function mainAccount()
    {
		$account = Account::firstOrNew(array('user_id'=>$this->id, 'account_type'=>ACCOUNT_TYPE_MAIN));
		if(!$account->exists){
			$account->balance=0;
			$account->sealed_balance=0;
			$account->save();
		}
		return $account;
    }

    public function subAccount()
    {
		$account = Account::firstOrNew(array('user_id'=>$this->id, 'account_type'=>ACCOUNT_TYPE_SUB));
		if(!$account->exists){
			$account->balance=0;
			$account->sealed_balance=0;
			$account->save();
		}
		return $account;
	}

    public function txnCards(){
		return $this->hasMany('TxnCard');
	}

    public function txn_payments(){
        return $this->hasMany('TxnPayment');
    }

    public function txn_baokim_cards(){
        return $this->hasMany('TxnBaokimCard');
    }
}