<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Authentication Popup With Laravel 4</title>

	@include('layouts._resources')
</head>

<body>
	@include('layouts._global_bar')

	<div class="container">
		@include('layouts._messages')
		@yield('content')
	</div>
</body>
</html>