@extends('layouts.logged-in')

@section('title')
Tài khoản phụ
@endsection

@section('content')
<h3>Tài khoản phụ</h3>
<div class="show-info">
    <div class="account-balance text-center">
        Số tiền: <b>{{number_format(Auth::user()->subAccount()->balance)}}</b> XU
    </div>
    <div class="">
        Bạn có thể dùng tiền để nạp vào các game trên hệ thống.
        Khi nạp tiền, bạn sẽ có cơ hội được nhận tiền thưởng vào tài khoản phụ.
    </div>
    <div>
        <a href="/charges/index">Click nạp tiền</a>
    </div>
</div>
@endsection