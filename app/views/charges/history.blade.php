@extends('layouts.logged-in')

@section('title')
Lịch sử giao dịch
@endsection

@section('content')
<h3>Lịch sử giao dịch</h3>
<section class="charge-history">
{{Form::open(array('url'=>'/charges/history','method'=>'get','class'=>'form-horizontal'))}}
        {{Form::hidden('type',Input::get('type'),array('id'=>'type'))}}
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
            <div class="col-xs-12 status @if(Input::get('type')=='coin' || !Input::has('type')) active @endif" id="txn_coin_status">
                {{Form::select('txn_coin_status',Config::get('common.txn_payment_status')+array(''=>'Tình trạng'),Input::get('txn_coin_status'),array('class'=>'form-control'))}}
            </div>
            <div class="col-xs-12 status @if(Input::get('type')=='card') active @endif" id="txn_card_response_code">
                {{Form::select('txn_card_response_code',Config::get('common.txn_card_response_codes')+array(''=>'Tình trạng'),Input::get('txn_card_response_code'),array('class'=>'form-control'))}}
            </div>
            <div class="col-xs-12 status @if(Input::get('type')=='bank') active @endif" id="txn_bank_status">
                {{Form::select('txn_bank_status',Config::get('common.baokim_txn_status')+array(''=>'Tình trạng'),Input::get('txn_bank_status'),array('class'=>'form-control'))}}
            </div>
        </div>
    <div class="form-group col-xs-1">
        {{HTML::decode(Form::button('<i class="glyphicon glyphicon-search"></i>',array('type'=>'submit','class'=>'btn btn-default')))}}
    </div>
{{Form::close()}}
<div class="clear"></div>
<ul class="nav nav-tabs" role="tablist">
    <li class=" @if(Input::get('type')=='coin' || !Input::has('type')) active @endif"><a href="#coin" role="tab" data-toggle="tab">Max XU</a></li>
    <li class=" @if(Input::get('type')=='card') active @endif"><a href="#card" role="tab" data-toggle="tab">Thẻ cào</a></li>
    <li class=" @if(Input::get('type')=='bank') active @endif"><a href="#bank" role="tab" data-toggle="tab">Ngân hàng</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane @if(Input::get('type')=='coin' || !Input::has('type')) active @endif" id="coin">
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
            <?php $count = $txn_coins->getFrom() ?>
            @foreach($txn_coins as $coin)
            <tr>
                <td>{{$count}}</td>
                <td>{{$coin->ref_txn_id}}</td>
                <td>{{number_format($coin->amount)}}</td>
                <td>{{$coin->desccription}}</td>
                <td>{{date('d-m-Y H:i',strtotime($coin->created_at))}}</td>
                <td>{{isset($coin->status) ? $coin->statusmsg : ''}}</td>
            </tr>
            <?php $count++ ?>
            @endforeach
            </tbody>
        </table>
        <div class="text-center">
            {{$txn_coins->appends(array(
            'start_date'=>Input::get('start_date'),
            'end_date'=>Input::get('end_date'),
            'txn_coin_status'=>Input::get('txn_coin_status'),
            'type'=>Input::get('type')
            ))->links()}}
        </div>
    </div>
    <div class="tab-pane @if(Input::get('type')=='card') active @endif" id="card">
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
                <td>{{number_format($card->amount)}}</td>
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
            'txn_card_response_code'=>Input::get('txn_card_response_code'),
            'type'=>Input::get('type')
            ))->links()}}
        </div>
    </div>
    <div class="tab-pane @if(Input::get('type')=='bank') active @endif" id="bank">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>STT</td>
                <td>Mã giao dịch</td>
                <td>Số xu</td>
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
                <td>{{date('d-m-Y H:i',strtotime($card->created_at))}}</td>
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
            'txn_bank_status'=>Input::get('txn_bank_status'),
            'type'=>Input::get('type')
            ))->links()}}
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
            $("#type").val($(".tab-content>.active").attr('id'));
            $(".status").removeClass('active');
            $(".tab-content .tab-pane").each(function(e){
                if($(this).hasClass('active')){
                    $(".status").eq(e).addClass('active');
                };
            });
        });
    });
</script>
</section>
@endsection

