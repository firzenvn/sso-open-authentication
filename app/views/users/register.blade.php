@extends('layouts.before-login')

@section('title')
Đăng ký tài khoản
@endsection

@section('content')
{{Form::open(array('url'=>'users/create', 'class'=>'form-signup')) }}
{{Form::hidden('return_url',Input::get('return_url'))}}
{{Form::hidden('_source',Input::has('_source')?Input::get('_source'):Input::get('source'))}}
<h3 class="form-title">Đăng ký tài khoản</h3>
<p class="slogan">Miễn phí và sẽ luôn như vậy</p>

<div class="form-group">
    {{ Form::text('username', Input::get('username'), array('class'=>'form-control', 'placeholder'=>'Tên đăng nhập:', 'autofocus', 'required')) }}
</div>
<div class="form-group">
    <div class="row">
        <div class="col-xs-4">
    {{ Form::text('first_name', Input::get('first_name'), array('class'=>'form-control', 'placeholder'=>'Tên:')) }}
        </div>
        <div class="col-xs-8">
            {{ Form::text('last_name', Input::get('last_name'), array('class'=>'form-control', 'placeholder'=>'Họ và tên đệm:')) }}
        </div>
    </div>
</div>

<div class="form-group">
    {{ Form::text('email', Input::get('email'), array('class'=>'form-control', 'placeholder'=>'Email:')) }}
</div>
<div class="form-group">
    {{ Form::text('phone', Input::get('phone'), array('class'=>'form-control', 'placeholder'=>'Số điện thoại:')) }}
</div>
<div class="form-group">
    {{ Form::text('identity_number', Input::get('identity_number'), array('class'=>'form-control', 'placeholder'=>'Số CMND:')) }}
</div>
<div class="form-group">
    <div class="row">
        <div class="col-xs-6">
            {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Mật khẩu:', 'required')) }}
        </div>
        <div class="col-xs-6">
            {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Nhập lại mật khẩu:', 'required')) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-xs-6">
            {{Form::text('captcha', null, array('class'=>'form-control','required','placeholder'=>'Mã an toàn:'))}}
        </div>
        <div class="col-xs-6">
            @captcha()
        </div>
    </div>
</div>

<section class="form-submit">
    <div class="row">
        {{ Form::submit('Đăng ký', array('class'=>'col-sm-4 register-submit btn btn-primary'))}}
    </div>
</section>
{{ Form::close() }}
<section class="social text-right">
    <span>Hoặc đăng nhập với tài khoản:</span>
    <a href="{{$fbLoginUrl}}"><img src="/images/icon-fb.png" alt="facebook" /></a>
    <a href="{{$googleLoginUrl}}"><img src="/images/icon-gplus.png" alt="googlge plus" /></a>
</section>
@endsection