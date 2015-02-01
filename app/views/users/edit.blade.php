{{ Form::open(array('url'=>'users/update', 'class'=>'form-signup')) }}
<h2 class="form-signup-heading">Cập nhật thông tin tài khoản của bạn</h2>

<ul>
	@foreach($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
</ul>
<div class="form-group">
	{{ Form::text('username', $user->username, array('class'=>'input-block-level', 'placeholder'=>'Tên đăng nhập', 'autofocus', 'required')) }}
	{{ Form::text('first_name', $user->first_name, array('class'=>'input-block-level', 'placeholder'=>'Tên')) }}
	{{ Form::text('last_name', $user->last_name, array('class'=>'input-block-level', 'placeholder'=>'Họ và tên đệm')) }}
	{{ Form::text('email', $user->email, array('class'=>'input-block-level', 'placeholder'=>'Email')) }}
	{{ Form::text('phone', $user->phone, array('class'=>'input-block-level', 'placeholder'=>'Số điện thoại')) }}
	<img src="{{$captcha}}"/>
	{{ Form::text('captcha', null, array('class'=>'input-block-level', 'placeholder'=>'Mã an toàn')) }}
	{{ Form::submit('Cập nhật', array('class'=>'btn btn-large btn-primary btn-block'))}}

	{{ Form::close() }}
</div>