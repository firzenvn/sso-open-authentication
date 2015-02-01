@extends('layouts.before-login')

@section('title')
Khôi phục mật khẩu
@endsection

@section('content')
{{ Form::open(array('url'=>'users/remind-password','role'=>'form')) }}
<h3 class="form-title">Khôi phục mật khẩu</h3>
<p class="slogan">Bạn chỉ cần nhập địa chỉ Email của bạn. Hệ thống sẽ gửi cho bạn email xác nhận, bạn chỉ cần ấn vào link xác nhận và tiến hành thay đổi mật khẩu mới theo mong muốn.</p>

<div class="form-group">
    {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email', 'required','autofocus')) }}
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
        {{ Form::submit('Khôi phục', array('class'=>'register-submit btn btn-primary')) }}
    </div>
</section>
{{ Form::close() }}

@endsection
