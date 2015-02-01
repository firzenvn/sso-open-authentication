@extends('layouts.logged-in')

@section('title')
Lịch sử giao dịch
@endsection

@section('content')
<h3>Lịch sử giao dịch</h3>
<section class="charge-history">
    {{Form::open(array('url'=>'/charges/bank-history','method'=>'get','class'=>'form-horizontal'))}}
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
		<li class="active"><a href="javascript:;">Từ ngân hàng</a></li>
		<li><a href="/charges/payment-history">Nạp game</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="bank">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td>STT</td>
                    <td>Mã giao dịch</td>
                    <td>Số tiền</td>
                    <td>Ngân hàng</td>
                    <td>Thời gian</td>
                    <td>Tình trạng</td>
                </tr>
                </thead>
                <tbody>
                <?php $count = $txn_banks->getFrom() ?>
                @foreach($txn_banks as $bank)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$bank->baokim_txn_id}}</td>
                    <td>{{number_format($bank->amount)}}</td>
                    <td>{{$bank->bank_payment_method_id}}</td>
                    <td>{{date('d-m-Y H:i',strtotime($bank->created_at))}}</td>
                    <td>{{isset($bank->baokim_txn_status) ? $bank->statusmsg : ''}}</td>
                </tr>
                <?php $count++?>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {{$txn_banks->appends(array(
                'start_date'=>Input::get('start_date'),
                'end_date'=>Input::get('end_date'),
                'status'=>Input::get('status')
                ))->links()}}
            </div>
        </div>
    </div>

</section>
@endsection

