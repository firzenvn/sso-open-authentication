@extends('layouts.logged-in')

@section('title')
Tài khoản chính
@endsection

@section('content')
<h3>Tài khoản chính</h3>
<div class="show-info">
    <div class="account-balance text-center">
        Số tiền: <b>{{number_format(Auth::user()->mainAccount()->balance)}}</b> XU
           <a href="/charges/index" class="btn btn-default">Nạp tiền</a>
    </div>
    <div class="">
        Bạn có thể dùng tiền để nạp vào các game trên hệ thống.<br>
        Tiền đã nạp vào tài khoản trên hệ thống sẽ không được trả lại dưới bất kỳ hình
        thức nào.
    </div>
</div>

@endsection