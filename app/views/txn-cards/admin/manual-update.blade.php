@extends('layouts.logged-in')

@section('title')
Kiểm tra lại/hoàn thành GD thẻ cào
@endsection

@section('content')
{{Form::open(array('url'=>'admin/txn-cards/manual-update','role'=>'form'))}}
{{Form::hidden('id',Input::get('id'))}}
<h3 class="form-title">Kiểm tra lại/hoàn thành GD thẻ cào</h3>

<div class="form-group">
    Loại thẻ: {{Config::get('common.card_types.'.$row->card_type)}}
</div>
<div class="form-group">
    Mã thẻ: {{$row->pin}}
</div>
<div class="form-group">
    Seri: {{$row->seri}}
</div>
<div class="form-group">
    User: {{$row->user->username}}
</div>
<div class="form-group">
    Mệnh giá: {{ Form::text('card_amount', $row->card_amount, array('size'=>20,'placeholder'=>'Mệnh giá thẻ', 'required','autofocus')) }}
</div>

<section class="form-submit">
    <div class="row">
        <input type="submit" name="btn-complete" value="Hoàn thành" class="col-sm-2 btn btn-primary">
    </div>
</section>

{{ Form::close() }}

@endsection