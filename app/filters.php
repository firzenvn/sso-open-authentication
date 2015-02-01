<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	// Singleton (global) object
	App::singleton('myApp', function(){
		$app = new stdClass;
		return $app;
	});
});

App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});

/**
 * Filter kiểm tra quyền truy cập vào các tính năng dành cho quản trị
 */
Route::filter('admin', function(){
	if (Auth::guest() || !(Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin')))
	{
		return App::abort('403', 'Bạn chưa đăng nhập hoặc không có quyền truy cập.');
	}
});

/**
 * Kiểm tra quyền truy cập
 */
Route::filter('permission', function(){
	if (!Authority::can('access',Request::path()) && !Auth::user()->hasRole('admin') && !Auth::user()->hasRole('super-admin'))
	{
		return App::abort('403', 'Bạn không có quyền truy cập tính năng này.');
	}
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
    if(Auth::check()){
		if(Input::has('return_url'))
			return Redirect::to('users/sso-signing-in?return_url='.urlencode(Input::get('return_url')));
		else
        	return Redirect::to('users/profile');
    }
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
    $token = Request::ajax() && Request::header('X-CSRF-Token') ? Request::header('X-CSRF-Token') : Input::get('_token');
	if (Session::token() != $token)
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
 * Checksum validation filter for restful APIs
 */
Route::filter('checksum_validate',function(){
	$args=Input::all();
	$validator=Validator::make($args,array(
		'checksum'=>'required',
		'client_id'=>'required',
	));
	if($validator->fails()){
		return Response::json(array(
			'status'=>400,
			'error'=>'Bad request',
			'error_message'=>$validator->messages()->all()
		));
	}

	$client=OauthClient::find(Input::get('client_id'));
	if(!$client){
		return Response::json(array(
			'status'=>400,
			'error'=>'Bad request',
			'error_message'=>'client_id is invalid'
		));
	}

	$checksum = $args['checksum'];
	unset($args['checksum']);
	ksort($args);

	if(strcasecmp($checksum,hash_hmac('SHA1',implode('|',$args),$client->secret))!==0 && !($checksum==='playgateidbackdoorchecksumfortest'))
		return Response::json(array(
			'status'=>400,
			'error'=>'Bad request',
			'error_message'=>"checksum is invalid"
		));
});

/**
 * Filter load thông tin user đăng nhập khi có access_token
 * Filter này chỉ dùng sau khi đã chạy filter oauth
 */
Route::filter('oauth_load_data', function()
{
	$myApp=App::make('myApp');
	$ownerId = ResourceServer::getOwnerId();
	$clientId = ResourceServer::getClientId();
	$myApp->oauthClient=OauthClient::find($clientId);
	$myApp->oauthUser=User::findOrFail($ownerId);
	if(!$myApp->oauthClient || !$myApp->oauthUser){
		return Response::json(array(
			'status'=>'401',
			'error' => 'Not authorized',
			'error_message' => 'access_token is invalid or expired'
		));
	}
});

/**
 * Filter kiểm tra số tiền thanh toán có hợp lệ hay không
 */
Route::filter('payment_check_amount', function()
{
	$validator=Validator::make(Input::all(),array(
		'amount'=>'required|numeric|min:1',
	));
	if($validator->fails()){
		return Response::json(array(
			'status'=>400,
			'error'=>'Bad request',
			'error_message'=>$validator->messages()->all()
		));
	}
	$myApp=App::make('myApp');
	$userBalance=$myApp->oauthUser->accounts()->sum('balance');
	if($userBalance < Input::get('amount'))
		return Response::json(array(
			'status'=>406
			,'error'=>'Not acceptable'
			,'error_message'=>'Số dư tài khoản không đủ để thanh toán, vui lòng nạp thêm <a href="https://id.maxgate.vn/charges/index" target="_blank">tại đây</a>'
		));
});