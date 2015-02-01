<!doctype html>
<html>
<head>
    <meta charset="utf-8">
        <meta name="description" content="@yield('meta_description')">
        <meta name="keyword" content="@yield('meta_keyword')">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}"/>
        <link rel="shortcut icon" type="image/ico" href="/media/common/img/favicon.ico" />
        <title>@yield('title')</title>
        @include('layouts._resources')
        @yield('script')
</head>
<body>
<main>
<style type="text/css">
    .content{
        border: none !important;
        min-height: 0px !important;
    }
    .content h3{
    display: none;
    }
    .content .panel-group{
    margin: 0!important;
    }
</style>
    <div class="container">
        <div class="row">
            <section class="content">
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

</body>
</html>

