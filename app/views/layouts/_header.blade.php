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

<header>
    <div class="container">
        <div class="row">
            <section class="logo col-xs-2">
                <a href="/"><img src="/media/common/img/idlogo.png" /></a>
            </section>
            @if(Auth::guest())
            @loginform()
            @else
            @hello()
            @endif
        </div>
    </div>
</header>