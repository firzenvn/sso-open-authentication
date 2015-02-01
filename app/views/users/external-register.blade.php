@extends('layouts.blank-transparent')

@section('title')
Đăng ký nhanh
@endsection

@section('css')
{{Input::get('css')}}
@endsection

@section('content')
{{ Form::open(array('url'=>'users/external-create','role'=>'form')) }}
{{Form::hidden('return_url',Input::get('return_url'))}}
{{Form::hidden('_source',Input::get('_source'))}}
<h3 class="form-title">Đăng ký nhanh</h3>

<div class="form-group">
	{{ Form::text('username', '', array('class'=>'form-control', 'placeholder'=>'Tên đăng nhập', 'required','autofocus')) }}
</div>
<div class="form-group">
	{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Mật khẩu', 'required')) }}
</div>
<div class="form-group">
	{{ Form::password('password_confirmation', array('class'=>'form-control',  'placeholder'=>'Nhập lại mật khẩu', 'required')) }}
</div>
<label for="checkbox" class="control-label"><input type="checkbox" checked name="checkbox" id="checkbox" required> Tôi đã đọc và đồng ý với <a href="/terms" target="_blank">các điều khoản</a> của MAXGATE</label>
<section class="form-submit">
	<div class="row">
		{{ Form::submit('Tạo tài khoản', array('class'=>'col-sm-4 register-submit btn btn-primary')) }}
	</div>
</section>

{{ Form::close() }}

<section class="social text-right">
	<span>Hoặc đăng nhập với tài khoản</span>
	<a href="javascript:redirect('{{$fbLoginUrl}}')"><img src="/images/icon-fb.png" alt="facebook" /></a>
	<a href="javascript:redirect('{{$googleLoginUrl}}')"><img src="/images/icon-gplus.png" alt="googlge plus" /></a>
</section>
<script type="text/javascript">
function redirect(url){
	if (window!=window.top) {
		window.top.location = url;
	}else{
		window.location = url;
	}
}

</script>
@endsection

