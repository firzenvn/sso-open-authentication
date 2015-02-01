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
			    if (window!=window.top) {
			        window.top.location = "<?php echo $return_url ?>";
			    }else{
				    window.location = "<?php echo $return_url ?>";
				}
			}, 3000);
		})
	</script>
</head>

<body>
<div class="container">
	<p>Xin đợi một lát...</p>
	@foreach($notificationUris as $uri)
	<img src="{{$uri}}" alt="signin in..." width="1px" height="1px"/>
	@endforeach
</div>
</body>
</html>