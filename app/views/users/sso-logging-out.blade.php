<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Xin hãy đợi...</title>

	@include('layouts._resources')

	<script type="text/javascript">
		$(window).load( function(){
			setTimeout(function() {
				window.location = "<?php echo $return_url ?>";
			}, 3000);
		})
	</script>
</head>

<body>
<div class="container">
	<p>Đăng xuất hệ thống...</p>
	@foreach($notificationUris as $uri)
	<img src="{{$uri}}" alt="logging out..." width="1px" height="1px"/>
	@endforeach
</div>
</body>
</html>
