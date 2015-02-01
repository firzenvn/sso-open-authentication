@extends('layouts.before-login')

@section('title')
Đăng nhập
@endsection

@section('script')
<script>
@if(Input::has('by') && Input::get('by') == 'facebook')
    window.location.href = '{{$fbLoginUrl}}';
@endif
@if(Input::has('by') && Input::get('by') == 'google')
    window.location.href = '{{$googleLoginUrl}}';
@endif
</script>
@endsection

@section('content')

{{ Form::open(array('url'=>'users/signin', 'class'=>'form-signin')) }}
	{{Form::hidden('return_url',Input::get('return_url'))}}
	<h3 class="form-title">Đăng nhập</h3>
    <div class="form-group">
	    {{ Form::text('username', $username, array('class'=>'form-control', 'placeholder'=>'Tên đăng nhập/Email/Số điện thoại','autofocus')) }}
    </div>
    <div class="form-group">
        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Mật khẩu')) }}
    </div>
    <div class="form-group">
        <label class="col-xs-6">
            {{Form::checkbox('remember')}} Ghi nhớ
        </label>
        <div class="col-xs-6 pull-right text-right">
            <a href="/users/recover-password">Quên mật khẩu?</a>
        </div>
    </div>
<div class="clear"></div>
<section class="form-submit">
    <div class="row">
        {{ Form::submit('Đăng nhập', array('class'=>'col-sm-4 register-submit btn btn-primary')) }}
        <section class="email-resend col-sm-8">
            Chưa có tài khoản? <a href="/users/quick-register?return_url={{Input::get('return_url')}}">Đăng ký</a>
        </section>
    </div>
</section>

	{{ Form::close() }}
    <section class="social text-right">
        <span>Hoặc đăng nhập bằng tk:</span>
        <a href="{{$fbLoginUrl}}"><img src="/images/icon-fb.png" alt="Login with Facebook" /></a>
        <a href="{{$googleLoginUrl}}"><img src="/images/icon-gplus.png" alt="Login with Google" /></a>
   </section>
@endsection