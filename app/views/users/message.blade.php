@extends('layouts.before-login')

@section('title')
{{$title}}
@endsection

@section('content')
{{Form::open()}}
<h3 class="form-title">{{$title}}</h3>
<div class="form-group">
    <p class="">{{$message}}</p>
</div>
<section class="form-submit nomargin" style="border-top: 1px solid #cccccc; padding-top: 0.5em">
        <a href="/" class="btn btn-default register-submit">Về trang chủ</a>
</section>
{{Form::close()}}
@endsection
