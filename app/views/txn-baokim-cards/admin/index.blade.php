@extends('layouts.logged-in')
@section('title')
Quản trị giao dịch Bảo Kim
@endsection

@section('content')
<h3>Quản trị giao dịch Bảo Kim</h3>
    {{Form::open(array('url'=>'admin/txn-baokim-cards/index','method'=>'get','role'=>'form'))}}
        <div class="form-group">
            <div class="row">
                <div class="col-xs-3">
                    {{Form::text('username',Input::get('username'),array('class'=>'form-control','placeholder'=>'Username:'))}}
                </div>
                <div class="col-xs-2">
                    {{Form::text('start_date',Input::get('start_date'),array('class'=>'form-control','placeholder'=>'Từ:','id'=>'start_date'))}}
                </div>
                <div class="col-xs-2">
                    {{Form::text('end_date',Input::get('end_date'),array('class'=>'form-control','placeholder'=>'Đến:','id'=>'end_date'))}}
                </div>
                <div class="col-xs-1 text-right">
                    {{HTML::decode(Form::button('<i class="glyphicon glyphicon-search"></i>',array('class'=>'btn btn-default','type'=>'submit')))}}
                </div>
                <div class="col-xs-1" style="padding-left: 0">
                    <label for="export_csv" class="btn btn-default nomargin">Xuất Excel <img src="/images/icon_excel.png" alt="Xuất Excel" title="Xuất Excel"/></label>
                    {{Form::submit('Go',array('class'=>'hidden','type'=>'submit','id'=>'export_csv','name'=>'export_csv'))}}
                </div>
            </div>
        </div>

    {{Form::close()}}

<section class="table-show col-xs-12" style="padding-right: 0">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Mệnh giá</td>
            <td>Mã giao dịch</td>
            <td>Thời gian</td>
            <td>Trạng thái</td>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $t)
            <tr>
                <td>{{$t->id}}</td>
                <td>{{$t->user->username}}</td>
                <td class="money">{{number_format($t->amount)}}</td>
                <td>{{$t->baokim_txn_id}}</td>
                <td>{{$t->created_at}}</td>
                <td>{{Config::get('common.baokim_txn_status.'.$t->baokim_txn_status)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

</section>
<div class="text-center">
    {{$rows->appends(array(
        'username'=>Input::get('username'),
        'start_date'=>Input::get('start_date'),
        'end_date'=>Input::get('end_date')
    ))->links()}}
</div>

@endsection