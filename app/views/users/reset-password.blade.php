@extends('layouts.before-login')

@section('title')
Tạo mật khẩu mới
@endsection

@section('content')
{{ Form::open(array('url'=>'users/new-password','role'=>'form')) }}
<h3 class="form-title">Tạo mật khẩu mới</h3>
{{Form::hidden('id',Input::get('id'))}}
{{Form::hidden('time',Input::get('time'))}}
{{Form::hidden('token',Input::get('token'))}}
<div class="form-group">
    {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Mật khẩu mới', 'required','autofocus')) }}
</div>
<div class="form-group">
    {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Nhập lại khẩu mới', 'required','autofocus')) }}
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
        {{ Form::submit('Cập nhật', array('class'=>'register-submit btn btn-primary')) }}
    </div>
</section>
{{ Form::close() }}

@endsection
