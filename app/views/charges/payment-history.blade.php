@extends('layouts.logged-in')

@section('title')
Lịch sử giao dịch
@endsection

@section('content')
<h3>Lịch sử giao dịch</h3>
<section class="charge-history">
    {{Form::open(array('url'=>'/charges/payment-history','method'=>'get','class'=>'form-horizontal'))}}
    <div class="form-group col-xs-3">
        {{Form::label('start_date','Từ:',array('class'=>'control-label'))}}
        <div class="col-xs-10">
            {{Form::text('start_date',Input::get('start_date'),array('class'=>'form-control','placeholder'=>'dd-mm-yyyy'))}}
        </div>
    </div>
    <div class="form-group col-xs-3">
        {{Form::label('end_date','Đến:',array('class'=>'control-label'))}}
        <div class=" col-xs-10">
            {{Form::text('end_date',Input::get('end_date'),array('class'=>'form-control','placeholder'=>'dd-mm-yyyy'))}}
        </div>
    </div>
    <div class="form-group col-xs-3">
        <div class="col-xs-12">
            {{Form::select('status',Config::get('common.txn_payment_status')+array(''=>'Tình trạng'),Input::get('status'),array('class'=>'form-control'))}}
        </div>
    </div>
    <div class="form-group col-xs-1">
        {{HTML::decode(Form::button('<i class="glyphicon glyphicon-search"></i>',array('type'=>'submit','class'=>'btn btn-default')))}}
    </div>
    {{Form::close()}}
    <div class="clear"></div>
    <ul class="nav nav-tabs" role="tablist">
        <li><a href="/charges/card-history">Từ thẻ cào</a></li>
        <li><a href="/charges/bank-history">Từ ngân hàng</a></li>
		<li class="active"><a href="javascript:;">Nạp game</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="coin">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td>STT</td>
                    <td>Mã giao dịch</td>
                    <td>Số xu</td>
                    <td>Mô tả</td>
                    <td>Thời gian</td>
                    <td>Tình trạng</td>
                </tr>
                </thead>
                <tbody>
                <?php $count = $txn_payments->getFrom() ?>
                @foreach($txn_payments as $coin)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$coin->ref_txn_id}}</td>
                    <td>{{number_format($coin->amount)}}</td>
                    <td>{{$coin->description}}</td>
                    <td>{{date('d-m-Y H:i',strtotime($coin->created_at))}}</td>
                    <td>{{isset($coin->status) ? $coin->statusmsg : ''}}</td>
                </tr>
                <?php $count++ ?>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {{$txn_payments->appends(array(
                'start_date'=>Input::get('start_date'),
                'end_date'=>Input::get('end_date'),
                'status'=>Input::get('status')
                ))->links()}}
            </div>
        </div>

    </div>
</section>
@endsection

