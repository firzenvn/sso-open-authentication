@extends('layouts.before-login')

@section('title')
Đăng ký nhanh
@endsection

@section('content')
{{ Form::open(array('url'=>'users/quick-create','role'=>'form')) }}
{{Form::hidden('return_url',Input::get('return_url'))}}
{{Form::hidden('_source',Input::get('_source'))}}
<h3 class="form-title">Đăng ký nhanh</h3>
<p class="slogan">Miễn phí và sẽ luôn như vậy</p>

<div class="form-group">
    {{ Form::text('username', Input::get('username'), array('class'=>'form-control', 'placeholder'=>'Tên đăng nhập', 'required','autofocus')) }}
</div>
<p class="remind">Nhập mật khẩu để bảo mật tài khoản tốt hơn (mật khẩu nên có từ 6-8 ký tự, gồm cả chữ và số)</p>
<div class="form-group">
    {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Mật khẩu', 'required')) }}
</div>
<div class="form-group">
    {{ Form::password('password_confirmation', array('class'=>'form-control',  'placeholder'=>'Nhập lại mật khẩu', 'required')) }}
</div>

<section class="form-submit">
    <div class="row">
        {{ Form::submit('Tạo tài khoản', array('class'=>'col-sm-4 register-submit btn btn-primary')) }}
        <section class="email-resend col-sm-8">
            <a href="#">Gửi lại email kích hoạt</a>
        </section>
    </div>
</section>

{{ Form::close() }}

<section class="social text-right">
    <span>Hoặc đăng nhập với tài khoản:</span>
	<a href="{{$fbLoginUrl}}"><img src="/images/icon-fb.png" alt="facebook" /></a>
	<a href="{{$googleLoginUrl}}"><img src="/images/icon-gplus.png" alt="googlge plus" /></a>
</section>
@endsection
