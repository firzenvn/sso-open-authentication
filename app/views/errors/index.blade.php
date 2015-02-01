@extends('layouts.before-login')

@section('content')
	<div class="form-group">
		<p class="text-danger">{{$message}}</p>
	</div>
	<section class="form-submit nomargin" style="border-top: 1px solid #cccccc; padding-top: 0.5em">
			<a href="/" class="btn btn-default register-submit">Về trang chủ</a>
	</section>
@endsection
