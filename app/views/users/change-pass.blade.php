@extends('layouts.logged-in')

@section('title')
Đổi mật khẩu
@endsection

@section('content')
<h3>Đổi mật khẩu</h3>
{{ Form::open(array('url'=>'users/update-pass', 'class'=>'form col-sm-12'))}}
<div class="form-input">
    <div class="row">
        <div class="form-group">
            <label class="col-sm-4 control-label">Mật khẩu cũ:</label>
            <div class="col-sm-8">
                {{ Form::password('old_password', array('class'=>'form-control', 'autofocus', 'required')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Mật khẩu mới:</label>
            <div class="col-sm-8">
                {{ Form::password('password', array('class'=>'form-control','required')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Nhập lại mật khẩu mới:</label>
            <div class="col-sm-8">
                {{ Form::password('password_confirmation', array('class'=>'form-control','required')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Mã xác thực:</label>
            <div class="col-sm-4">
                {{ Form::text('captcha',null,array('class'=>'form-control')) }}
            </div>
            <div class="col-sm-4">
                @captcha()
            </div>
        </div>
    </div>
</div>
<div class="form-group form-button">
    <div class="col-sm-8 col-sm-offset-4">
        {{Form::submit('Cập nhật', array('class'=>'btn btn-primary'))}}
    </div>
</div>

{{ Form::close() }}
@endsection

