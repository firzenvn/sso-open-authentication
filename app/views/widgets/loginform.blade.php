<section class="loginform col-xs-6 pull-right">
    <div class="row">
        {{ Form::open(array('url'=>'users/signin', 'role'=>'form')) }}
        {{Form::hidden('return_url',Input::get('return_url'))}}
        <div class="form-group nomargin">
            <div class="username">
                {{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Username/Email/Số điện thoại')) }}
            </div>
            <div class="password">
                {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Mật khẩu')) }}
            </div>
            <div class="btn-login">
                {{ Form::submit('Đăng nhập', array('class'=>'btn btn-primary text-center'))}}
            </div>
        </div>
        <label class="col-xs-5 remember">
            {{Form::checkbox('remember')}} Ghi nhớ
        </label>
        <section class="forgetpass col-xs-5">
            <a href="/users/recover-password">Quên mật khẩu</a>
        </section>
        {{ Form::close() }}
    </div>
</section>