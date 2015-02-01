<section class="hello col-sm-4 pull-right">
    <div class="dropdown">
        Xin chào, <a href="javascript:;" id="dropdownHello">{{Auth::user()->username}}&#32;&#32;<img src="/images/icon_menu.png" /></a>
        <div class="headmenu" style="display: none">
            <a href="javascript:;" class="btn btn-default btn-sm"><img src="" alt=""/></a>
        </div>

        <section id="dropdown-menu">
            <div class="row">
                <div class="user-info">
                    <div class="col-xs-12">
                        <div class="avatar col-xs-3">
                            <img src="/images/no-avatar.png" alt="avatar"/>
                        </div>
                        <div class="user-name col-xs-9">
                            <p>{{Auth::user()->username}}</p>
                            <div class="email">{{isset(Auth::user()->email) ? Auth::user()->email : ''}}</div>

                        </div>
                    </div>
                    <div class="col-xs-12">
                        <p class="balance">Tài khoản chính: {{number_format(Auth::user()->mainAccount()->balance)}} XU</p>
                        <p class="balance">Tài khoản phụ: {{number_format(Auth::user()->subAccount()->balance)}} XU</p>
                    </div>
                </div>
                <ul class="link-list list-unstyled col-xs-12">
                    <li style="background: url('/images/icon_config.png') no-repeat center left"><a href="/users/profile">Thông tin cá nhân</a></li>
                    <li style="background: url('/images/icon_mail.png') no-repeat center left"><a href="/users/edit-email">Thêm/Sửa email</a></li>
                    <li style="background: url('/images/icon_recharge.png') no-repeat center left"><a href="/charges/index">Nạp tiền</a></li>
                    <li style="background: url('/images/icon_tradinghis.png') no-repeat center left"><a href="#">Lịch sử giao dịch</a></li>
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))
                         <li style="background: url('/images/icon_tradinghis.png') no-repeat center left"><a href="/admin/txn-cards/index">Quản trị GD thẻ cào</a></li>
                    @endif
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))
                         <li style="background: url('/images/icon_tradinghis.png') no-repeat center left"><a href="/admin/users/list-with-charge-amount">Quản trị user</a></li>
                    @endif
                    @if(Auth::user()->hasRole('super-admin'))
                         <li style="background: url('/images/icon_tradinghis.png') no-repeat center left"><a href="/super-admin">Super admin</a></li>
                    @endif
                </ul>

                <div class="botmenu col-xs-12 text-right">
                    <a href="/users/logout" class="btn btn-default">Đăng xuất</a>
                </div>
            </div>
        </section>
    </div>
</section>
