@extends('layouts.logged-in')

@section('title')
Thêm, Sửa số điện thoại
@endsection

@section('content')
<h3>Thêm, Sửa số điện thoại</h3>

{{Form::open(array('url'=>'users/update-phone','class'=>'form-horizontal'))}}
<div class="form-input">
    <div class="row">
        <div class="form-group">
            <label class="col-xs-3 control-label">Số điện thoại hiện tại:</label>
            <div class="col-xs-9">
                <p class="form-control-static">{{isset(Auth::user()->phone) ? Auth::user()->phone : 'Chưa có SĐT'}}</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">Số điện thoại mới:</label>
            <div class="col-xs-9">
                {{ Form::text('phone',null, array('class'=>'form-control', 'autofocus','required')) }}
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