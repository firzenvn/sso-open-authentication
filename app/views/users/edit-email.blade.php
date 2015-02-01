@extends('layouts.logged-in')

@section('title')
Thêm, Sửa email
@endsection

@section('content')
<h3>Thêm/Sửa email</h3>

{{Form::open(array('url'=>'users/update-email','class'=>'form-horizontal'))}}
<div class="form-input">
    <div class="row">
        <div class="form-group">
            <label class="col-xs-3 control-label">Địa chỉ email hiện tại:</label>
            <div class="col-xs-9">
                <p class="form-control-static">{{isset(Auth::user()->email) ? Auth::user()->email : 'Chưa có email'}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">Địa chỉ email mới:</label>
            <div class="col-xs-9">
                {{ Form::text('email',null, array('class'=>'form-control', 'autofocus','required')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">Nhập lại địa chỉ email:</label>
            <div class="col-xs-9">
                {{ Form::text('email_confirmation',null, array('class'=>'form-control','required')) }}
            </div>
        </div>
    </div>
</div>
<div class="form-group form-button">
    <div class="col-xs-2 col-xs-offset-3">
        {{Form::submit('Cập nhật', array('class'=>'btn btn-primary'))}}
    </div>
</div>
{{Form::close()}}

@endsection