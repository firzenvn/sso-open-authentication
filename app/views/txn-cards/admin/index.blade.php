@extends('layouts.logged-in')
@section('title')
Quản trị giao dịch thẻ cào
@endsection

@section('content')
<h3>Quản trị giao dịch thẻ cào</h3>
    {{Form::open(array('url'=>'admin/txn-cards/index','method'=>'get','role'=>'form'))}}
        <div class="form-group">
            <div class="row">
                <div class="col-xs-3">
                    {{Form::text('pin',Input::get('pin'),array('class'=>'form-control','placeholder'=>'Mã thẻ:','autofocus'))}}
                </div>
                <div class="col-xs-2">
                    {{Form::text('seri',Input::get('seri'),array('class'=>'form-control','placeholder'=>'Seri:'))}}
                </div>
                <div class="col-xs-3">
                    {{Form::text('username',Input::get('username'),array('class'=>'form-control','placeholder'=>'Username:'))}}
                </div>
                <div class="col-xs-3">
                    {{ Form::select('chart_type',Config::get('common.chart_types'), Input::get('chart_type'),array('class'=>'form-control'))}}
                </div>
                <div class="col-xs-1 text-right">
                    {{HTML::decode(Form::button('<i class="glyphicon glyphicon-search"></i>',array('class'=>'btn btn-default','type'=>'submit')))}}
                </div>
            </div>
        </div>

    {{Form::close()}}

<section>
{{$chart}}
</section>

<section class="table-show col-xs-12" style="padding-right: 0">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Loại thẻ</td>
            <td>Mã thẻ (Pin)</td>
            <td>Seri</td>
            <td>Mệnh giá</td>
            <td>Thời gian</td>
            <td>Trạng thái</td>
            <td>Hành động</td>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $t)
            <tr id="row_{{$t->id}}">
                <td>{{$t->id}}</td>
                <td>{{$t->user->username}}</td>
                <td>{{Config::get('common.card_types.'.$t->card_type)}}</td>
                <td>{{isset($t->pin) && $t->pin != '' ? AppHelper::maskPhone($t->pin) : ''}}</td>
                <td>{{$t->seri}}</td>
                <td class="money">{{number_format($t->card_amount)}}</td>
                <td>{{$t->created_at}}</td>
                <td>{{Config::get('common.txn_card_response_codes.'.$t->response_code)}}</td>
                <td class="text-center">
                    @if($t->response_code != 1)
                        <a class="btn btn-default" href="/admin/txn-cards/manual-recheck?id={{$t->id}}"><i class="glyphicon glyphicon-refresh"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</section>
<div class="text-center">
    {{$rows->appends(array(
        'pin'=>Input::get('pin'),
        'seri'=>Input::get('seri'),
        'username'=>Input::get('username'),
    ))->links()}}
</div>

@endsection