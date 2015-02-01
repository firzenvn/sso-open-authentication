@include('layouts._header')

<main>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <aside class="sidebar">
                    <section class="account">
                        <h3>Sản lượng</h3>
                        <ul class="list-unstyled">
                            <li><p style="background: url(/images/icon_recharge.png) no-repeat 10px 2px"><a href="/charges/card-summarize">Sản lượng thẻ cào</a></p></li>
                        </ul>
                    </section>

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
        </div>
    </div>
</main>
<script>
    $(function() {
        $( "#start_date" ).datepicker({ dateFormat: 'dd-mm-yy' }).val();
        $("#end_date").datepicker({ dateFormat: 'dd-mm-yy' }).val();
    });
</script>

@include('layouts._footer')