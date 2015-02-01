@include('layouts._header')

<main>
    <div class="container">
        <div class="row">
            <section class="leftside col-sm-5">
                @include('layouts._messages')
                @yield('content')
            </section>

            <section class="rightside col-sm-6 pull-right">
                @slider()
            </section>
        </div>
    </div>
</main>

@include('layouts._footer')