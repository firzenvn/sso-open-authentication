@include('layouts._header')

<main>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
            <aside class="sidebar">
                <section class="avatar">
                    <img class="ava" src="/media/common/img/default_avatar.jpg" alt="avatar" />
                    <a href="#"><img class="edit-ava" src="/images/icon_edit.png" /></a>
                </section>
                <section class="edit-info">
                    <h3 @if(strpos(Request::url(),'/users')) class="active" @endif style="background: url(/images/icon_config.png) no-repeat 10px 0px; padding-left: 28px"><a href="/users/profile">Thông tin cá nhân</a></h3>
                </section>
                <section class="account">
                    <h3 @if(strpos(Request::url(),'/charges')) class="active" @endif style="background: url(/images/icon_mainacc.png) no-repeat 10px 0px; padding-left: 28px">Tiền trong tài khoản</h3>
                    <ul class="list-unstyled">
                        <li @if(Request::url()==URL::to('/').'/charges/index')class="active" @endif><p style="background: url(/images/icon_recharge.png) no-repeat 10px 2px"><a href="/charges/index">Nạp tiền</a></p></li>
                        <li @if(strpos(Request::url(),'history'))class="active" @endif><p style="background: url(/images/icon_tradinghis.png) no-repeat 10px 2px"><a href="/charges/card-history">Lịch sử giao dịch</a></p></li>
                    </ul>
                </section>
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))
                <section class="account">
                    <h3 @if(strpos(Request::url(),'/admin')) class="active" @endif style="background: url(/images/icon_mainacc.png) no-repeat 10px 0px; padding-left: 28px">Quản trị</h3>
                    <ul class="list-unstyled">
                        <li @if(Request::url()==URL::to('/').'/admin/txn-cards/index')class="active" @endif><p style="background: url(/images/icon_recharge.png) no-repeat 10px 2px"><a href="/admin/txn-cards/index">Giao dịch thẻ cào</a></p></li>
                        <li @if(strpos(Request::url(),'/admin/txn-baokim-cards/index'))class="active" @endif><p style="background: url(/images/icon_tradinghis.png) no-repeat 10px 2px"><a href="/admin/txn-baokim-cards/index">Giao dịch bảo kim</a></p></li>
                    </ul>
                </section>
                @endif

            </aside>
            </div>

            <section class="content col-sm-9 pull-right">
                <div class="message" style="margin-left: 1.5em">
                    @include('layouts._messages')
                </div>
                <div class="row">
                    @yield('content')
                </div>
            </section>
            <script>
                $(function() {
                    $( "#start_date" ).datepicker({ dateFormat: 'dd-mm-yy' }).val();
                    $("#end_date").datepicker({ dateFormat: 'dd-mm-yy' }).val();
                });
            </script>
        </div>
    </div>
</main>

@include('layouts._footer')