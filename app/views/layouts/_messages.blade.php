@if(Session::has('message'))
<p class="text-info">{{ Session::get('message') }}</p>
@endif

@if(Session::has('error'))
<p class="text-danger">{{ Session::get('error') }}</p>
@endif

@if(Session::has('success'))
<p class="text-success">{{ Session::get('success') }}</p>
@endif

<ul>
    @foreach($errors->all() as $error)
    <li class="text-danger">{{ $error }}</li>
    @endforeach
</ul>