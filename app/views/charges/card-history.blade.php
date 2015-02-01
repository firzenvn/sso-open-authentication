@extends('layouts.logged-in')

@section('title')
Lịch sử giao dịch
@endsection

@section('content')
<h3>Lịch sử giao dịch</h3>
<section class="charge-history">
    {{Form::open(array('url'=>'/charges/card-history','method'=>'get','class'=>'form-horizontal'))}}
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
            {{Form::select('response_code',Config::get('common.txn_payment_status')+array(''=>'Tình trạng'),Input::get('response_code'),array('class'=>'form-control'))}}
        </div>
    </div>
    <div class="form-group col-xs-1">
        {{HTML::decode(Form::button('<i class="glyphicon glyphicon-search"></i>',array('type'=>'submit','class'=>'btn btn-default')))}}
    </div>
    {{Form::close()}}
    <div class="clear"></div>
    <ul class="nav nav-tabs" role="tablist">
		<li class="active"><a href="javascript:;">Từ thẻ cào</a></li>
		<li><a href="/charges/bank-history">Từ ngân hàng</a></li>
		<li><a href="/charges/payment-history">Nạp game</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="card">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td>STT</td>
                    <td>Mã giao dịch</td>
                    <td>Mã thẻ</td>
                    <td>Seri</td>
                    <td>Số xu</td>
                    <td>Chuyển tới</td>
                    <td>Thời gian</td>
                    <td>Tình trạng</td>
                </tr>
                </thead>
                <tbody>
                <?php $count = $txn_cards->getFrom() ?>
                @foreach($txn_cards as $card)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$card->ref_txn_id}}</td>
                    <td>{{$card->pin}}</td>
                    <td>{{$card->seri}}</td>
                    <td>{{number_format($card->card_amount)}}</td>
                    <td>{{isset($card->ref_txn_id)?'Nạp vào game' : 'Nạp Max XU'}}</td>
                    <td>{{date('d-m-Y H:i',strtotime($card->created_at))}}</td>
                    <td>{{isset($card->response_code) ? $card->responsemsg : ''}}</td>
                </tr>
                <?php $count++ ?>
                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {{$txn_cards->appends(array(
                'start_date'=>Input::get('start_date'),
                'end_date'=>Input::get('end_date'),
                'response_code'=>Input::get('response_code')
                ))->links()}}
            </div>
        </div>
    </div>

</section>
@endsection

