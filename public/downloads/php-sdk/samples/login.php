<?php
require_once "../src/playgateid-oauth2.php";
use \PlaygateID\Oauth2\PlaygateIDOauth2;

$playgateIDOauth2=new PlaygateIDOauth2();
$loginUrl=$playgateIDOauth2->generateLoginUrl();
//$pwdLoginUrl=$playgateIDOauth2->loginPasswordFlowCredentials('firzen','fighting');
?>

<h1>Test client for PtoID oauth2</h1>
<a href="<?php echo $loginUrl?>">Click to login</a>

<form action="http://id.game.vn/users/client-signin" method="post">
	<input type="hidden" name="return_url" value="http://id.game.vn/users/edit-email"/>
	<input type="text" name="username"/>
	<input type="password" name="password"/>
	<input type="submit" name="Login"/>
</form>



