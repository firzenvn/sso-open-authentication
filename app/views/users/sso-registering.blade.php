<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Bạn đã đăng ký tài khoản thành công, xin chờ trong giây lát...</title>

	@include('layouts._resources')

	<script type="text/javascript">
		$( document ).ready( function(){
			setTimeout(function() {
			    if (window!=window.top) {
			        window.top.location = "/users/sso-signing-in?return_url=<?php echo $return_url ?>";
			    }else{
				    window.location = "/users/sso-signing-in?return_url=<?php echo $return_url ?>";
				}
			}, 1000);
		})
	</script>
</head>

<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-K8Z8ZF"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K8Z8ZF');</script>
<!-- End Google Tag Manager -->
<div class="container">
	<p>Bạn đã đăng ký tài khoản thành công, xin chờ trong giây lát...</p>
</div>
</body>
</html>