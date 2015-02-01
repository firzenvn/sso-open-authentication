<?php
require_once "../src/playgateid-oauth2.php";
use PlaygateID\Oauth2\PlaygateIDOauth2;

$playgateIDOauth2=new PlaygateIDOauth2();

list($accessTokenInfo,$userInfo)=$playgateIDOauth2->loginCallback();

echo "User has logged in with access_token info: <br>";
var_dump($accessTokenInfo);
echo "<br>And user info: <br>";
var_dump($userInfo);die;

 ?>