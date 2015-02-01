@extends('layouts.logged-in')
@section('title')
Quản trị users
@endsection

@section('content')
<h3>Quản trị users</h3>

{{Form::open(array('url'=>'admin/users/list-with-charge-amount','method'=>'get','role'=>'form'))}}
        <div class="form-group">
            <div class="row">
                <div class="col-xs-3">
                    {{Form::text('username',Input::get('username'),array('class'=>'form-control','placeholder'=>'Username:'))}}
                </div>
                <div class="col-xs-2">
                    {{Form::text('source',Input::get('source'),array('class'=>'form-control','placeholder'=>'Source:'))}}
                </div>
                <div class="col-xs-2">
                    {{Form::text('created_at_from',Input::get('created_at_from'),array('class'=>'form-control','id'=>'start_date','placeholder'=>'Từ:'))}}
                </div>
                <div class="col-xs-2">
                    {{Form::text('created_at_to',Input::get('created_at_to'),array('class'=>'form-control','id'=>'end_date','placeholder'=>'Đến:'))}}
                </div>
                <div class="col-xs-2">
                    {{ Form::select('chart_type',Config::get('common.chart_types'), Input::get('chart_type'),array('class'=>'form-control'))}}
                </div>
                <div class="col-xs-1 text-left">
                    {{HTML::decode(Form::button('<i class="glyphicon glyphicon-search"></i>',array('class'=>'btn btn-default','type'=>'submit')))}}
                </div>
            </div>
        </div>

    {{Form::close()}}

<section>
{{$chart}}
</section>

<section class="table-show table-bodered col-xs-12" style="padding-right: 0">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nguồn</th>
            <th>Ngày đăng ký</th>
            <th>Thẻ cào đã nạp(VND)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $t)
            <tr>
                <td>{{$t->id}}</td>
                <td>{{$t->username}}</td>
                <td>{{$t->source}}</td>
                <td>{{$t->created_at}}</td>
                <td align="right">{{number_format($t->txnCards()->where('response_code','=',1)->sum('card_amount'))}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</section>
<div class="text-center">
    {{$rows->appends(array(
        'source'=>Input::get('source'),
        'username'=>Input::get('username'),
        'created_at_from'=>Input::get('created_at_from'),
        'created_at_to'=>Input::get('created_at_to'),
        'chart_type'=>Input::get('chart_type'),
    ))->links()}}
</div>


@endsection