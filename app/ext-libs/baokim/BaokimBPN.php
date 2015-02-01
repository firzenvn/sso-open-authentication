<?php
/**
 * Created by PhpStorm.
 * User: Firzen
 * Date: 10/27/2014
 * Time: 10:29 AM
 */

class BaokimBPN {
	public static function verify(){
		$rs=false;
		$req = '';
		$args=Input::all();
		foreach ($args as $key => $value ) {
			$value = urlencode ( stripslashes ( $value ) );
			$req .= "&$key=$value";
		}

		//thuc hien  ghi log cac tin nhan BPN
		$myFile = app_path("storage/logs/baokim-bpn.log");
		$fh = fopen($myFile, 'a') or die("can't open file");
		fwrite($fh, $req);

		//Call baokim to verify bpn
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'https://www.baokim.vn/bpn/verify');
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//		$error 	= curl_error($ch);
		curl_close($ch);

		if($result != '' && strstr($result,'VERIFIED') && $status==200){
			//thuc hien update hoa don
			fwrite($fh, ' => VERIFIED');
			$rs=true;
		}else{
			fwrite($fh, ' => INVALID');
		}
		fclose($fh);
		return $rs;
	}
}