@extends('layouts.admin')

@section('title')
Sản lượng thẻ cào
@endsection

@section('content')
<h3>Sản lượng thẻ cào</h3>
<div class="row">
{{Form::open(array('url'=>'charges/card-summarize','method'=>'get'))}}
<div class="form-group">
    <div class="col-xs-2">
        {{Form::text('start_date',Input::get('start_date'),array('class'=>'form-control','id'=>'start_date'))}}
    </div>
    <div class="col-xs-2">
        {{Form::text('end_date',Input::get('end_date'),array('class'=>'form-control','id'=>'end_date'))}}
    </div>
    <div class="col-xs-2">
        {{Form::button('Tìm',array('type'=>'submit','class'=>'btn btn-default'))}}
    </div>
</div>
{{ Form::close() }}
</div>

<table class="table table-borderd">
    <thead>
    <tr>
        <td>Hình thức nạp</td>
        <td>Từ</td>
        <td>Đến</td>
        <td>Thẻ đúng</td>
        <td>Sản lượng</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Nạp Max xu</td>
        <td>{{$start_date}}</td>
        <td>{{$end_date}}</td>
        <td>{{number_format($charge_coin->valid_card)}}</td>
        <td>{{number_format($charge_coin->sum)}}</td>
    </tr>
    <tr>
        <td>Nạp vào game</td>
        <td>{{$start_date}}</td>
        <td>{{$end_date}}</td>
        <td>{{number_format($charge_game->valid_card)}}</td>
        <td>{{number_format($charge_game->sum)}}</td>
    </tr>
    </tbody>
</table>
@endsection

