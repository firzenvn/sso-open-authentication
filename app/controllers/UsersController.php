<?php
use Gregwar\Captcha\CaptchaBuilder;
class UsersController extends \BaseController
{

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('except' => array(
            'getRegister'
            ,'postCreate'
            ,'getLogin'
            ,'postSignin'
            ,'postQuickSignin'
            ,'getFacebookOauth2callback'
            ,'getGoogleOauth2callback'
            ,'getQuickRegister'
            ,'postQuickCreate'
            ,'getRecoverPassword'
            ,'postRemindPassword'
            ,'getResetPassword'
            ,'postNewPassword'
			,'getSigninByTicket'
			,'getRegisterByTicket'
			,'getExternalRegister'
			,'postExternalCreate'
        )));

        $this->beforeFilter('guest', array('only' => array(
            'getRegister',
            'getQuickRegister'
        )));
    }

    public function getRegister(){
		return View::make('users.register')->with($this->_generateOauthUrl());
    }

    public function postCreate() {
        $builder = new CaptchaBuilder;
        $builder->setPhrase(Session::get('captchaPhrase'));
        if(!$builder->testPhrase(Input::get('captcha'))) {
            return Redirect::to('users/register')->with('error', 'Mã an toàn nhập không chính xác')->withInput();
        }

        $validator = Validator::make(Input::all(), User::$rules);
        if(!$validator->passes()){
            return Redirect::to('users/register')->with('error', 'Hãy hoàn thiện các lỗi sau')->withErrors($validator)->withInput();
        }

        if(Input::has('email')){
            $used_email = User::where('email',Input::get('email'))->whereNotIn('source',Config::get('common.check_email_except'))->first();
            if($used_email){
                return Redirect::to('users/register')->with('error', 'Email đã được sử dụng')->withInput();
            }
        }

        $user = new User;
        $user->username = Input::get('username');
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->email = Input::get('email');
        $user->phone = AppHelper::standardizePhone(Input::get('phone'));
        $user->identity_number = Input::get('identity_number');
        $user->password = Hash::make(Input::get('password'));
		$user->source=Input::get('_source');
        $user->save();

        if(Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password'))))
        {
			$return_url=Input::has('return_url')?Input::get('return_url'):url('users/profile');
			return Redirect::to('users/sso-registering?return_url='.urlencode($return_url));
		}

		return Redirect::back()->with('error','Xảy ra lỗi trong quá trình đăng ký')->withInput();
    }

    public function getLogin()
    {
		if(Auth::user()){
			return Redirect::to('users/sso-signing-in?return_url='.urlencode(Input::get('return_url')));
		}
		$username=Input::get('username');
		while(Input::has('signin-ticket') && Input::has('_cid')){
			$client=OauthClient::find(Input::get('_cid'));
			if(!$client)
				break;
			$signinData=AppHelper::decryptTicket(Input::get('signin-ticket'),$client->secret);
			if($signinData!==false){
				$username=$signinData['username'];
			}
			break;
		}

        //Đổi layout theo yêu cầu
        if(Input::has('ui_mode'))
            $this->layout = View::make('layouts.'.Input::get('ui_mode'));

        // get fb oauth service
        $fb = OAuth::consumer('Facebook', URL::to('users/facebook-oauth2callback'));
        $fbLoginUrl = $fb->getAuthorizationUri();

        // get google oauth service
        $googleService = OAuth::consumer( 'Google', URL::to('users/google-oauth2callback'));
        $googleLoginUrl = $googleService->getAuthorizationUri();

		Session::set('return_url',Input::get('return_url'));

        return View::make('users.login')->with(array(
            'fbLoginUrl'=>$fbLoginUrl,
            'googleLoginUrl'=>$googleLoginUrl,
			'username'=>$username,
        ));
    }

    public function postSignin()
    {
		$validator=Validator::make(Input::all(),array(
			'username'=>'required',
			'password'=>'required',
		));
		if($validator->fails()){
			return Redirect::to('users/login')->with('message',implode('<br> ',$validator->messages()->all()))->withInput();
		}
        $remember = (Input::has('remember'))?true:false;
        if ((Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')),$remember))
            ||(Auth::attempt(array('email' => Input::get('username'), 'password' => Input::get('password')), $remember))
            ||(Auth::attempt(array('phone' => AppHelper::standardizePhone(Input::get('username')), 'password' => Input::get('password')),$remember)))
        {
			return Redirect::to('users/sso-signing-in?return_url='.urlencode(Input::get('return_url')));
        } else {
            return Redirect::to('users/login')
                ->with('message', 'Username/Mật khẩu không chính xác')
                ->withInput();
        }
    }

    public function getDashboard()
    {
        $this->layout->content = View::make('users.dashboard');
    }

    public function getLogout()
    {
        Auth::logout();

		$endpoints=OauthClientEndpoint::where('type','=','logout')->get();
		$notificationUris=array();
		foreach($endpoints as $endpoint){
			$notificationUris[]=$endpoint->redirect_uri;
		}

		$return_url=Input::has('return_url')?Input::get('return_url'):url('/');
		return View::make('users.sso-logging-out')->with(array(
			'notificationUris'=>$notificationUris,
			'return_url'=>$return_url
		));
    }

    /**
     * Login user with facebook callback
     *
     * @return void
     */
    public function getFacebookOauth2callback() {

        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = OAuth::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );

//			$message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
//			echo $message. "<br/>";

            //Var_dump
            //display whole array().
//			dd($result);

            $user = User::firstOrNew(array('oauth2_provider' => 'Facebook','oauth2_provider_id' => $result['id']));
            $user->oauth2_provider='Facebook';
            $user->oauth2_provider_id=$result['id'];
            $user->username=$result['email'];
            $user->first_name = $result['first_name'];
            $user->last_name = $result['last_name'];
            $user->email = $result['email'];
            $user->password = 'N/A';
            $user->save();

            Auth::login($user);
			return Redirect::to('users/sso-signing-in?return_url='.urlencode(Session::get('return_url')));
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }

    }

    /**
     * Login user with Google callback
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getGoogleOauth2callback() {

        // get data from input
        $code = Input::get( 'code' );

        // get google service
        $googleService = OAuth::consumer( 'Google' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

//			$message = 'Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
//			echo $message. "<br/>";
//
//			//Var_dump
//			//display whole array().
//			dd($result);

            //Tạo user mới

            $user = User::firstOrNew(array('oauth2_provider' => 'Google','oauth2_provider_id' => $result['id']));
            $user->oauth2_provider='Google';
            $user->oauth2_provider_id=$result['id'];
            $user->username=$result['email'];
            $user->first_name = $result['given_name'];
            $user->last_name = $result['family_name'];
            $user->email = $result['email'];
            $user->password = 'N/A';
            $user->save();

            Auth::login($user);
			return Redirect::to('users/sso-signing-in?return_url='.urlencode(Session::get('return_url')));
        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }
    }

    /**
     * Update thông tin tài khoản
     */
    public function getEdit(){
        $user=Auth::user();

        // build captcha
        $builder = new CaptchaBuilder;
        $builder->build();
        $captcha=$builder->inline();
        Session::put('captchaPhrase', $builder->getPhrase());

        $this->layout->content=View::make('users.edit')->with(array(
            'user'=>$user,
            'captcha'=>$captcha
        ));
    }

    /**
     * Submit update thông tin tài khoản
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdate() {
        $builder = new CaptchaBuilder;
        $builder->setPhrase(Session::get('captchaPhrase'));
        if(!$builder->testPhrase(Input::get('captcha')))
            return Redirect::back()->with('message', 'Mã an toàn nhập không chính xác')->withInput();

        $user=Auth::user();

        $rules=User::$rules;
        $rules['username']=$rules['username'].",username,".$user->id;
        unset($rules['password']);
        unset($rules['password_confirmation']);
        $validator = Validator::make(Input::all(), $rules);
        if(!$validator->passes())
            return Redirect::back()->with('message', 'Hãy hoàn thiện các lỗi sau')->withErrors($validator)->withInput();

        $user->username=Input::get('username');
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->email = Input::get('email');
        $user->phone=AppHelper::standardizePhone(Input::get('phone'));
        $user->save();

        return Redirect::to('users/show')->with('message', 'Thông tin của bạn đã được cập nhật thành công!');
    }

    public function getQuickRegister(){
        return View::make('users.quick-register')->with($this->_generateOauthUrl());
    }

    public  function postQuickCreate(){
        $validator = Validator::make(Input::all(), User::$rules);
        if(!$validator->passes()){
            return Redirect::to('users/quick-register')->with('message', 'Hãy hoàn thiện các lỗi sau')->withErrors($validator)->withInput();
        }

		$user = new User;
		$user->username = Input::get('username');
		$user->password = Hash::make(Input::get('password'));
		$user->source=Input::get('_source');
		if(!$user->save()){
			Redirect::back()->with('error','DB error occured');
		}

		if(Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password'))))
		{
			$return_url=Input::has('return_url')?Input::get('return_url'):url('users/profile');
			return Redirect::to('users/sso-registering?return_url='.urlencode($return_url));
		}

		return Redirect::back()->with('error','Xảy ra lỗi trong quá trình đăng ký')->withInput();
    }

	public function getExternalRegister(){
		return View::make('users.external-register')->with($this->_generateOauthUrl());
	}

	public  function postExternalCreate(){
		$validator = Validator::make(Input::all(), User::$rules);
		if(!$validator->passes()){
			$args=Input::all();
			unset($args['password']);
			unset($args['password_confirmation']);
			Session::flash('error',implode('<br>',$validator->messages()->all()));
			return View::make('users.external-register-processing',array('redirect_to'=>url('users/quick-register?'.http_build_query($args))));
		}

		$user = new User;
		$user->username = Input::get('username');
		$user->password = Hash::make(Input::get('password'));
		$user->source=Input::get('_source');
		if(!$user->save()){
			Redirect::back()->with('error','DB error occured');
		}

		if(Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password'))))
		{
			$return_url=Input::has('return_url')?Input::get('return_url'):url('users/profile');
			return View::make('users.external-register-processing',array('redirect_to'=>url('users/sso-registering?return_url='.urlencode($return_url))));
		}

		return Redirect::back()->with('error','Xảy ra lỗi trong quá trình đăng ký')->withInput();
	}

    public function getProfile(){
        $ui_mode = Input::has('ui_mode')?Input::get('ui_mode'):'logged-in';
        $user = Auth::user();
        $default['day'] = isset($user->dob)?date_format(date_create($user->dob),'d'):'';
        $default['mon'] = isset($user->dob)?date_format(date_create($user->dob),'m'):'';
        $default['year'] = isset($user->dob)?date_format(date_create($user->dob),'Y'):'';
        $provinces = Province::orderBy('name')->lists('name','id');
        $user_districts = isset($user->province_id)?Province::find($user->province_id)->districts()->orderBy('name')->lists('name','id'):array(''=>'--Quận/Huyện--');
        return  View::make('users.profile',array(
            'user'=> $user,
            'provinces'=>$provinces,
            'user_districts'=>$user_districts,
            'default'=>$default,
            'ui_mode'=>$ui_mode
        ));
    }

    public function postUpdateProfile()
    {
        if(Input::has('day')&&Input::has('month')&&Input::has('year'))
        {
            $day = Input::get('day');
            $month = Input::get('month');
            $year = Input::get('year');
            if(!checkdate($month,$day,$year))
            {
                return Response::json(array('success'=>false, 'msg'=>'Ngày sinh không hợp lệ'));
            }
            $dob = date('y-m-d',mktime(0,0,0,$month,$day,$year));
        }
        elseif(!Input::has('day')&&!Input::has('month')&&!Input::has('year'))
        {
            $dob = null;
        }
        else return Response::json(array('success'=>false, 'msg'=>'Ngày sinh không hợp lệ'));

        $user = Auth::user();
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->gender = Input::has('gender') ? Input::get('gender') : null;
        $user->identity_number = Input::has('identity_number') ? Input::get('identity_number') : null;
        $user->dob = $dob;
        $user->address = Input::has('address') ? Input::get('address') : null;
        $user->province_id = Input::has('province_id') ? Input::get('province_id') : null;
        $user->district_id = Input::has('district_id') ? Input::get('district_id') : null;
        $user->save();

        return Response::json(array('success'=>true, 'msg'=>'Cập nhật thông tin thành công'));
    }

    public function getDistrict()
    {
        $id = Input::get('id');
        $districts = ($id!='')?Province::find($id)->districts()->orderBy('name')->lists('name','id'):array(''=>'--Quận/Huyện--');
        return Form::select('district_id',array(''=>'--Quận/Huyện--')+$districts,null,array('class'=>'form-control district', 'id'=>'cboDistrict'));
    }

    public function postUpdatePass()
    {
        $user = Auth::user();
        if(!Hash::check(Input::get('old_password'),Auth::user()->password))
            return Response::json(array('success'=>false, 'msg'=>'Mật khẩu cũ không đúng!'));

        $rules = array(
            'password'=>'alpha_num|between:6,12|confirmed',
            'password_confirmation'=>'alpha_num|between:6,12',
        );
        $validator = Validator::make(Input::all(),$rules);
        if(!$validator->passes())
            return Response::json(array('success'=>false, 'msg'=>$validator->errors()->first()));

        $user->password = Hash::make(Input::get('password'));
        $user->save();

        return Response::json(array('success'=>true, 'msg'=>'Đổi mật khẩu thành công!'));
    }

    public function getRecoverPassword(){
        return View::make('users.recover-password');
    }

    public function postRemindPassword()
    {
        $builder = new CaptchaBuilder;
        $builder->setPhrase(Session::get('captchaPhrase'));
        if(!$builder->testPhrase(Input::get('captcha'))) {
            return Redirect::back()->with('error','Mã an toàn nhập không chính xác')->withInput();
        }

        $user = User::where('email',Input::get('email'))->whereNotIn('source',Config::get('common.check_email_except'))->first();
        if(!isset($user)){
            return Redirect::back()->with('error','Email này chưa được đăng ký')->withInput();
        }

        $now = time();
        $token = Hash::make($now.$user->id.$user->password);

        //Gửi email
        $data = array('name'=>$user->username,'id'=>$user->id,'token'=>$token,'time'=>$now);
        Mail::send('emails.auth.recover', $data, function($message) use ($user)
        {
            $message->to($user->email, $user->last_name." ".$user->first_name)->subject('Khôi phục mật khẩu.');
        });

        return View::make('users.message',array(
            'title'=>'Khôi phục mật khẩu',
            'message'=>'Một email đã được gửi tới địa chỉ <b>'.$user->email.'</b>. Hãy kiểm tra hòm thư và hoàn tất việc khôi phục mật khẩu của bạn.'
        ));
    }

    public function getResetPassword()
    {
        if(!Input::has('token') || !Input::has('id') || !Input::has('time'))
        {
            return View::make('users.message',array(
                'title'=>'Khôi phục mật khẩu',
                'message'=>'Liên kết không hợp lệ!'
            ));
        }
        $time = Input::get('time');
        $timeout = Config::get('common.password_reminder_timeout');
        if(abs(time() - $time)/60 > $timeout)
        {
            return View::make('users.message',array(
                'title'=>'Khôi phục mật khẩu',
                'message'=>'Liên kết đã quá hạn.'
            ));
        }

        $user = User::find(Input::get('id'));
        $token = Input::get('token');
        if(!Hash::check($time.$user->id.$user->password,$token))
        {
            return View::make('users.message',array(
                'title'=>'Xảy ra lỗi',
                'message'=>'Thao tác không hợp lệ.'
            ));
        }

        return View::make('users.reset-password');

    }

    public function postNewPassword()
    {
        $builder = new CaptchaBuilder;
        $builder->setPhrase(Session::get('captchaPhrase'));
        if(!$builder->testPhrase(Input::get('captcha'))) {
            return Redirect::back()->with('error','Mã an toàn nhập không chính xác')->withInput();
        }

        $rules = array(
            'password'=>'required|alpha_num|between:6,12|confirmed',
            'password_confirmation'=>'required|alpha_num|between:6,12',
        );

        $validator = Validator::make(Input::all(), $rules);
        if(!$validator->passes())
            return Redirect::back()->with('error', 'Hãy hoàn thiện các lỗi sau')->withErrors($validator)->withInput();

        $id = Input::get('id');
        $time = Input::get('time');
        $token = Input::get('token');
        $user = User::find($id);
        if(!Hash::check($time.$id.$user->password,$token))
        {
            return View::make('users.message',array(
                'title'=>'Xảy ra lỗi',
                'message'=>'Thao tác không hợp lệ.'
            ));
        }

        $user->password = Hash::make(Input::get('password'));
        $user->save();

        return View::make('users.message',array(
            'title'=>'Khôi phục mật khẩu',
            'message'=>'Mật khẩu của bạn đã được thay đổi.'
        ));
    }

    public function postUpdateAccount()
    {
        $input = Input::all();
        $input['phone'] = AppHelper::standardizePhone(Input::get('phone'));
        $rules = array(
            'email'=>'email|confirmed',
            'email_confirmation'=> 'email',
            'phone'=>'regex:/^[0-9]{9,13}$/|unique:users,phone,'.Auth::user()->id,
        );

        $validator = Validator::make($input,$rules);
        if(!$validator->passes())
        {
            return Response::json(array('success'=>false, 'msg'=>$validator->errors()->first()));
        }

        $user = Auth::user();
        if($user->email != null && $input['email'] != $user->email){
            if($input['email'] != null){
                $used_email = User::where('email',$input['email'])->whereNotIn('source',Config::get('common.check_email_except'))->first();
                if($used_email){
                    return Response::json(array('success'=>false, 'msg'=>'Email đã được sử dụng'));
                }
                //gửi email xác nhận
                $now = time();
                $token = Hash::make($now.$user->id.$user->email.$input['email']);
                $data = array('username'=>$user->username,'id'=>$user->id,'new_email'=>$input['email'],'token'=>$token,'time'=>$now);
                Mail::send('emails.auth.update-email', $data, function($message) use ($user)
                {
                    $message->to($user->email, $user->name)->subject('Thay đổi email ID.MAXGATE.VN');
                });

                return Response::json(array('success'=>true, 'msg'=>'Bạn cần đăng nhập vào email <span class="text-primary">'.AppHelper::maskEmail($user->email).'</span> để xác nhận thay đổi thông tin.'));
            }
        }else {
            $user->email = $input['email'];
        }
        if($input['phone'] !=null){
            $user->phone = $input['phone'];
        }
        $user->save();

        return Response::json(array('success'=>true, 'msg'=>'Cập nhật thông tin thành công'));
    }

    public function getUpdateEmail(){
        if(!Input::has('token') || !Input::has('id') || !Input::has('time') || !Input::has('new'))
        {
            return View::make('users.message',array(
                'title'=>'Thay đổi email',
                'message'=>'Liên kết không hợp lệ!'
            ));
        }
        $time = Input::get('time');
        $timeout = Config::get('common.email_update_timeout');
        if(abs(time() - $time)/60 > $timeout)
        {
            return View::make('users.message',array(
                'title'=>'Thay đổi email',
                'message'=>'Liên kết đã quá hạn.'
            ));
        }

        $id = Input::get('id');
        $time = Input::get('time');
        $token = Input::get('token');
        $new_email = Input::get('new');
        $user = User::find($id);
        if(!Hash::check($time.$id.$user->email.$new_email,$token))
        {
            return View::make('users.message',array(
                'title'=>'Xảy ra lỗi',
                'message'=>'Thao tác không hợp lệ.'
            ));
        }

        $user->email = $new_email;
        if(!$user->save()){
            return View::make('users.message',array(
                'title'=>'Xảy ra lỗi',
                'message'=>'DB Error.'
            ));
        }

        return View::make('users.message',array(
            'title'=>'Thay đổi email thành công!',
            'message'=>'Email hiện tại của bạn là: '.AppHelper::maskEmail($new_email)
        ));
    }

    public function postUpdatePhone()
    {
        $input['phone'] = AppHelper::standardizePhone(Input::get('phone'));
        $rules = array(
            'phone'=>'regex:/^[0-9]{9,13}$/|unique:users,phone,'.Auth::user()->id,
        );

        $validator = Validator::make($input,$rules);
        if(!$validator->passes())
        {
            return Redirect::back()->with('error','Hãy hoàn thiện các lỗi sau')->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $user->phone = AppHelper::standardizePhone(Input::get('phone'));
        $user->save();

        return Redirect::back()->with('success','Bạn đã thay đổi số điện thoại thành công!');
    }

	/**
	 * @param $user
	 * @return \Illuminate\Http\RedirectResponse
	 */
	private function _buildClientRedirectUri($user)
	{
		$client = OauthClient::find(Input::get('_cid'));
		if(!$client)
			return false;
		$params = array(
			'client_id' => Input::get('_cid'),
			'response_type' => 'code',
			'redirect_uri' => $client->endpoints()->first()->redirect_uri,
			'scope' => 'id,username,email,phone,first_name,last_name',
			'scopes' => OauthScope::all()->toArray(),
			'state' => Input::get('_state')
		);
		$code = AuthorizationServer::newAuthorizeRequest('user', $user->id, $params);
		$redirect_uri = Redirect::to(AuthorizationServer::makeRedirectWithCode($code, $params));
		return $redirect_uri;
	}

	/**
	 * User đăng nhập bằng signin-ticket
	 */
	public function getSigninByTicket(){
		$validator=Validator::make(Input::all(),array(
			'signin-ticket'=>'required',
			'_cid'=>'required',
			'return_url'=>'required'
		));
		if($validator->fails()){
			return Redirect::to('users/login')->with('message',$validator->messages());
		}

		$client=OauthClient::find(Input::get('_cid'));
		if(!$client){
			return Redirect::to('users/login');
		}

		$signinData=AppHelper::decryptTicket(Input::get('signin-ticket'),$client->secret);

		if (Auth::attempt(array('username' => $signinData['username'], 'password' => $signinData['password']))||
			Auth::attempt(array('email' => $signinData['username'], 'password' => $signinData['password']))||
			Auth::attempt(array('phone' => AppHelper::standardizePhone($signinData['username']), 'password' => $signinData['password'])))
		{
			return Redirect::to('users/sso-signing-in?return_url='.urlencode(Input::get('return_url')));
		}else{ //Dang nhap that bai
			return Redirect::route('login', Input::all());
		}
	}

	/**
	 * Tạo view load các link login notification đến các website đăng nhập sso
	 */
	public function getSsoSigningIn(){
		$return_url=Input::get('return_url');
		if(!$return_url)
			$return_url=url('users/profile');
		$user=Auth::user();
		$clients = OauthClient::where('sso_on','=',1)->get();
		$notificationUris=array();
		foreach($clients as $client){
			$params = array(
				'client_id' => $client->id,
				'response_type' => 'code',
				'redirect_uri' => $client->endpoints()->first()->redirect_uri,
				'scope' => 'id,username,email,phone,first_name,last_name',
				'scopes' => OauthScope::all()->toArray(),
				'state' => ''
			);
			$code = AuthorizationServer::newAuthorizeRequest('user', $user->id, $params);
			$notificationUris[] = AuthorizationServer::makeRedirectWithCode($code, $params);
		}

		//log hành vi đăng nhập
		Activity::log(array(
			'contentID'   => Auth::user()->id,
			'contentType' => 'User',
			'description' => 'Dang nhap',
			'updated'     => true,
		));

		return View::make('users.sso-signing-in')->with(array(
			'notificationUris'=>$notificationUris,
			'return_url'=>$return_url
		));
	}

    public function getSsoRegistering(){
        $return_url = Input::get('return_url');
        return View::make('users.sso-registering')->with('return_url',$return_url);
    }

	/**
	 * User đăng ký bằng signin-ticket
	 */
	public function getRegisterByTicket(){
		$validator=Validator::make(Input::all(),array(
			'register-ticket'=>'required',
			'_cid'=>'required',
			'return_url'=>'required'
		));
		if($validator->fails()){
			return Redirect::route('register',Input::all())->withErrors($validator);
		}

		$client=OauthClient::find(Input::get('_cid'));
		if(!$client){
			return Redirect::to('users/login');
		}

		$registerData=AppHelper::decryptTicket(Input::get('register-ticket'),$client->secret);
		$registerData['password_confirmation']=$registerData['password'];
		$validator=Validator::make($registerData,User::$rules);
		if(!$validator->passes()){
			unset($registerData['password']);
			unset($registerData['password_confirmation']);
			return Redirect::route('register', $registerData)->with('error', 'Hãy hoàn thiện các lỗi sau')->withErrors($validator)->withInput();
		}

		$user = new User;
		$user->username = $registerData['username'];
		$user->first_name = isset($registerData['first_name'])?$registerData['first_name']:'';
		$user->last_name = isset($registerData['last_name'])?$registerData['last_name']:'';
		$user->email = isset($registerData['email'])?$registerData['email']:'';
		$user->source=isset($registerData['source'])?$registerData['source']:'';
		$user->phone = isset($registerData['phone'])?AppHelper::standardizePhone($registerData['phone']):'';
		$user->password = Hash::make($registerData['password']);

		$user->save();

		if(Auth::attempt(array('username' => $registerData['username'], 'password' => $registerData['password']))){
			return Redirect::to('users/sso-registering?return_url='.urlencode(Input::get('return_url')));
		}else{
			unset($registerData['password']);
			unset($registerData['password_confirmation']);
			return Redirect::route('register', $registerData);
		}
	}

	/**
	 * @return array
	 */
	private function _generateOauthUrl()
	{
		// get fb oauth service
		$fb = OAuth::consumer('Facebook', URL::to('users/facebook-oauth2callback'));
		$fbLoginUrl = $fb->getAuthorizationUri();

		// get google oauth service
		$googleService = OAuth::consumer('Google', URL::to('users/google-oauth2callback'));
		$googleLoginUrl = $googleService->getAuthorizationUri();

		Session::set('return_url', Input::get('return_url'));

		return array(
			'fbLoginUrl'=>$fbLoginUrl,
			'googleLoginUrl'=>$googleLoginUrl,
		);
	}
}