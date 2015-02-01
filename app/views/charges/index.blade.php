@extends('layouts.'.$ui_mode)

@section('title')
Nạp tiền
@endsection

@section('content')
<h3>Nạp tiền</h3>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#by-mobile-card">
                    Nạp từ thẻ cào
                </a>
            </h4>
        </div>
        <div id="by-mobile-card" class="panel-collapse collapse @if(!Input::has('by') || Input::get('by')=='card')in @endif">
            <div class="panel-body">
                {{ Form::open(array('url'=>'charges/charge-by-mobile-card', 'class'=>'form col-xs-12', 'id'=>'charge-mobile-card'))}}
                <div class="form-input">
                {{Form::hidden('return_url',Input::get('return_url'))}}
                    <div class="row">
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Loại thẻ:</label>
                            <div class="col-xs-9">
                                {{ Form::select('card_type',array('-- Loại thẻ --')+$card_types, null, array('class'=>'form-control', 'autofocus', 'required')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Mã thẻ:</label>
                            <div class="col-xs-9">
                                {{ Form::text('pin', null, array('class'=>'form-control','required')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Seri:</label>
                            <div class="col-xs-9">
                                {{ Form::text('seri', null, array('class'=>'form-control','required')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Mã xác thực:</label>
                            <div class="col-xs-5">
                                {{ Form::text('captcha',null,array('class'=>'form-control')) }}
                            </div>
                            <div class="col-xs-4">
                                @captcha()
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-button">
                    <div class="col-xs-4 col-xs-offset-3">
                        {{Form::submit('Nạp thẻ', array('class'=>'btn btn-primary col-xs-12'))}}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#by-atm">
                    Nạp tiền bằng thẻ ATM nội địa
                </a>
            </h4>
        </div>
        <div id="by-atm" class="panel-collapse collapse @if(Input::get('by')=='atm') in @endif">
            <div class="panel-body">
                {{ Form::open(array('url'=>'charges/charge-by-bank-card', 'class'=>'form col-xs-12'))}}
                {{Form::hidden('return_url',Input::get('return_url'))}}
				<p>Bạn muốn nạp từ thẻ của ngân hàng nào?</p>
				{{$atmCards}}

				{{ Form::text('amount', Input::get('amount'), array('required','size'=>'30','placeholder'=>'Số tiền muốn nạp')) }}
				{{Form::submit('Nạp tiền', array('class'=>'btn btn-primary','size'=>30))}}

                {{Form::close()}}
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#by-visa">
                    Nạp tiền bằng thẻ quốc tế VISA/Master Card
                </a>
            </h4>
        </div>
        <div id="by-visa" class="panel-collapse collapse @if(Input::get('by')=='visa') in @endif">
            <div class="panel-body">
                {{ Form::open(array('url'=>'charges/charge-by-bank-card', 'class'=>'form col-xs-12'))}}
                {{Form::hidden('return_url',Input::get('return_url'))}}
				<p>Bạn muốn nạp từ loại thẻ nào?</p>
                {{$creditCards}}

				{{ Form::text('amount', Input::get('amount'), array('required','size'=>'30','placeholder'=>'Số tiền muốn nạp')) }}
				{{Form::submit('Nạp tiền', array('class'=>'btn btn-primary','size'=>30))}}

                {{Form::close()}}
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
       $(".panel-collapse").on('show.bs.collapse',function(){
           $(this).parent().find(".panel-title").addClass('active');
       });
        $(".panel-collapse").on('hide.bs.collapse',function(){
            $(this).parent().find(".panel-title").removeClass('active');
        });
    });
</script>
@endsection


