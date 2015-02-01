<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Bạn đã nạp tiền thành công, xin chờ trong giây lát...</title>

	@include('layouts._resources')

	<script type="text/javascript">
		$( document ).ready( function(){
			setTimeout(function() {
			    if (window!=window.top) {
			        window.top.location = '{{$return_url}}';
			    }else{
				    window.location = "{{$return_url}}";
				}
			}, 1000);
		})
	</script>
</head>

<body>
<div class="container">
	<h3>Bạn đã nạp tiền thành công, xin chờ trong giây lát...</h3>
</div>
</body>
</html>