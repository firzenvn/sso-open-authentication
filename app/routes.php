<?php
Route::get('/',array('before'=>'guest','uses'=>'UsersController@getQuickRegister'));

Route::controller('users', 'UsersController');
Route::get('/login', array('as'=>'login', 'uses'=>'UsersController@getLogin'));
Route::get('/register', array('as'=>'register', 'uses'=>'UsersController@getRegister'));
Route::get('/external-register', array('as'=>'external-register', 'uses'=>'UsersController@getExternalRegister'));

Route::controller('admin/txn-cards', 'TxnCardsAdminController');
Route::controller('admin/users', 'UsersAdminController');
Route::controller('admin/txn-baokim-cards', 'TxnBaoKimCardsAdminController');

//oauth 2 server
Route::match(array('GET', 'POST'), 'oauth/access_token', function()
{
	return AuthorizationServer::performAccessTokenFlow();
});

Route::get('/oauth/authorize', array('before' => 'check-authorization-params|auth', function()
{
	// get the data from the check-authorization-params filter
	$params = Session::get('authorize-params');

	// get the user id
	$params['user_id'] = Auth::user()->id;

	// display the authorization form
//	return View::make('authorization-form', array('params' => $params));

	$code = AuthorizationServer::newAuthorizeRequest('user', $params['user_id'], $params);

	Session::forget('authorize-params');

	return Redirect::to(AuthorizationServer::makeRedirectWithCode($code, $params));
}));

Route::post('/oauth/authorize', array('before' => 'check-authorization-params|auth|csrf', function()
{
	// get the data from the check-authorization-params filter
	$params = Session::get('authorize-params');

	// get the user id
	$params['user_id'] = Auth::user()->id;

	// check if the user approved or denied the authorization request
	if (Input::get('approve') !== null) {

		$code = AuthorizationServer::newAuthorizeRequest('user', $params['user_id'], $params);

		Session::forget('authorize-params');

		return Redirect::to(AuthorizationServer::makeRedirectWithCode($code, $params));
	}

	if (Input::get('deny') !== null) {

		Session::forget('authorize-params');

		return Redirect::to(AuthorizationServer::makeRedirectWithError($params));
	}
}));

Route::get('graph-api/me', array('before' => 'oauth', function(){
	$ownerId = ResourceServer::getOwnerId();
//	$clientId = ResourceServer::getClientId();
	$user=User::select(ResourceServer::getScopes())->findOrFail($ownerId);
	return Response::json($user);
}));

Route::get('graph-api/my-accounts', array('before' => 'oauth', function(){
	$ownerId = ResourceServer::getOwnerId();
	$user=User::find($ownerId);
	$mainAccount=$user->mainAccount();
	$subAccount=$user->subAccount();
	return Response::json(array('status'=>200,'accounts'=>array($mainAccount->account_type=>$mainAccount->attributesToArray(),$subAccount->account_type=>$subAccount->attributesToArray())));
}));

Route::get('/captcha', 'CaptchaController@getBuild');

Route::controller('accounts', 'AccountsController');
Route::controller('charges', 'ChargesController');
Route::controller('payments-api', 'PaymentsApiController');
Route::controller('users-api', 'UsersApiController');

Route::group(array('before' => array('auth','permission')), function()
{
	\Route::get('elfinder', 'Barryvdh\Elfinder\ElfinderController@showIndex');
	\Route::any('elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
	\Route::get('elfinder/tinymce', 'Barryvdh\Elfinder\ElfinderController@showTinyMCE4');
	\Route::get('elfinder/ckeditor4', 'Barryvdh\Elfinder\ElfinderController@showCKeditor4');
});

Route::any('pages/{uri}', 'Fbf\LaravelPages\PagesController@view')->where('uri', Config::get('laravel-pages::route'));
Route::get('/terms',function(){
   return View::make('terms');
});
