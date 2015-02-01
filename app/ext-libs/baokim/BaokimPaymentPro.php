<?php
class BaokimPaymentPro {
//	private $connection=array(
//		'base_url'=>'http://kiemthu.baokim.vn',
//		'username'=>'merchant',
//		'password'=>'1234',
//		'secure_pass'=>'cdf9de7b4249e27a',
//		'private_key'=>'-----BEGIN PRIVATE KEY-----
//MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDZZBAIQz1UZtVm
//p0Jwv0SnoIkGYdHUs7vzdfXYBs1wvznuLp/SfC/MHzHVQw7urN8qv+ZDxzTMgu2Q
//3FhMOQ+LIoqYNnklm+5EFsE8hz01sZzg+uRBbyNEdcTa39I4X88OFr13KoJC6sBE
//397+5HG1HPjip8a83v8G4/IPcna5/3ydVbJ9ZeMSUXP6ZyKAKay4M22/Wli7PLrm
//1XNR9JgIuQLma74yCGkaXtCJQswjyYAmwDPpz4ZknSGuBYUmwaHMgrDOQsOXFW7/
//7M2KbjenwggAW98f0f97AR2DEq9Eb5r8vzyHURnHGD3/noZxl993lM2foPI3SKBO
//1KpSeXRzAgMBAAECggEANMINBgRTgQVH6xbSkAxLPCdAufTJeMZ56bcKB/h2qVMv
//Wvejv/B1pSM489nHaPM5YeWam35f+PYZc5uWLkF23TxvyEsIEbGLHKktEmR73WkS
//eqNI+/xd4cJ3GOtS2G2gEXpBVwdQ/657JPvz4YZNdjfmyxMOr02rNN/jIg6Uc8Tz
//vbpGdtP49nhqcOUpbKEyUxdDo6TgLVgmLAKkGJVW40kwvU9hTTo6GXledLNtL2kD
//l6gpVWAiT6xlTsD5m74YzsxCSjkh60NdYeUDYwMbv0WWH3kJq6qD063ac3i/i8H+
//B5nGf4KbKg1bBjPLNymUj7RRnKjHr301i2u8LUQYuQKBgQD15YCoa5uHd6DHUXEK
//kejU34Axznr3Gs6LqcisE7t0oQ9hB4s16U9f4DBHDOvnkLb0zkadwdEmwo/D/Tdf
//5c/JEk8q/aO9Wk8uV4Bswnx1OV9uKMzMOZbv/So1DQg1aW1MgvRnj3SiKpDUkNwr
//en4NT9tbH21SmVIO9Da5KpiFRwKBgQDiUrg1hp8EDaeZFTG9DvcwyTTrpD/YT9Wr
//s/NtEnPMjy0NXWcEXwGzx90P+qjJ+J29Hk89QHON6S7o0X2lUIer3uXokc86ce76
//5UIbR6u7R1T6TUNfwqwwNfIbgtFN4+7ybodPNZ5DWslKLqMr5wpwIOr7/U5ih7BH
//JK0cSriddQKBgGXzNZiepOlRrBN3rMqZHFPGJrx/w3PYZXJ6fnz54WrFrD6qhglg
//Jky2As4yiUyFL5XoQFcAGNtdJ4Y24lKcUb4oHTLR3qWPX+zy0ohFSpy/oNVnjSHP
//bskpyeoc8R5UC8EBOpwFWnIx+8JmHSLZspGKXoQ1T3pDn0Yb8uRqyLnZAoGBAKdk
//NwqfvwzobIU0v8ztPLbAmnuOyAndQlP0jJ6nfy5U1yWDZ6Y7/q5RrJcc9aosT76I
//pGLRQKY9SYy5JQ0YOsBL5A/XiEXZ7r9ywSocIFAruhZG/wXcni4qOB9Q6i2J4Dk+
//tqVHKv72LtrHE7hs8bNtJV+rQkZtxVtZLRA308PhAoGBALVEaYMRm97V+Tnsej6q
//fuT/6oKHPqZpur2rNfEKVn5Aq2kmFrvyUhvXi0IAWQ/XS3XJ7faQnprrWT6pYiSy
//2YQuaghlNG1SATVd5eUadq2pA8DuSzqWFa0Ac1IAyliBO2uLPL7LzuEKmmuQk0vI
//TU2Q8idAb77K7mvVguA3LDhN
//-----END PRIVATE KEY-----'
//	);

	private $connection=array(
		'base_url'=>'https://www.baokim.vn',
		'merchant_id'=>14409,
		'username'=>'id_maxgate_vn',
		'password'=>'bKiMWaJDh6qMCXyEP09YIhr7BH',
		'secure_pass'=>'f9df6ccdfbd73a08',
		'private_key'=>'-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEA7TQKD+bnAAFTdwclEj9RbVU2ZqWWxnrG54DbRdq+QtjwGhTF
HnWWZtsbNIDRnp0riuGetQ9VqNGTDgx/BFrnJ77Psq6p9pinsFAx2P7P8SXhkdMJ
Nl7eyyALLPOC3G/bLqb6Lq9GFsMZ6eE7MBoEAdIRICi6T1Wki/lSCZvKk/S/0mR+
tupIxNJOnX3EOM6ac/1FFjCGCgMyxHTjL+Ksm+iu8KP2eVg5RoIBZWUXJY83IMis
+nxvqtyFekQ9wP2FxCtDfsmhwZDaOuY3zQN1wS9MvRYzRkHn9STDgoJ3znJztrtP
EvSt5aauxmVS9lEVvd4uyzDO4afKY+25+Nc78wIDAQABAoIBACMOq+YJxF5V09Yl
si7uOMSl8XJeSthu0PLqMn4yhCgxE9tm8nM8AcyV2YF7AIAmzoaqLeCosYpP3yIW
ardkEAHpy5ym/+u4SCBg2d0uW+FSLfJ1dEka4Ga5B63PF6ooxgYxG4zGzt8SWsQc
S7kiPzFdsLZGDrMm/zjI0n0lD12qZ821qAr/YbLZWAqCziGUQ7/41JiIidEkYVB4
2BBvRh2CqvGzN+GPnZIlsHuY8pSQq6EBNd/BsIL1CM6FVnY3yXo3mfhXFKdvKjwg
IdrboCmYCOL4l96f9J3fQyV4E4VY8ChpMhKKMzQfQWDDu9hPX0/WEbcf18p6pVk6
O4fuYmECgYEA+mby/+U6cKE9mHeqbWhKEdOZcsG1kmKV8Zi1VQN1t6MU0DY0o+Oo
9ovQCv/p1b0aKuCzVk1QNaHO8rMVnuE+OXGd89XyPqUMuU7BTtGHjgOCLlaslyZ6
8PhK3cEdRLr9zqaBgDpK40+5x6dpxizQS9QLFtIx9YU3CO+mBgyPvWkCgYEA8oGN
kgrzArzmTbNcmVrXYfrRVQQoAWfv2+v+wvJZpggVWe9KVPFbV517tjDLmQJ1JgBr
AEcqNgA8yIxYaB99VlAXiNr6P5N0mLizr1bJXuhUMiSdp5AA0D77YjiP1MoS+RMm
ctMNi2jgcO0Nt7VHSYmwYGlwocwEFJskowDllvsCgYEA76WLt0Cpd5W5n6wXXfJL
wVfkKiIeJmVX4AsosJ5JEWFwz/yw0JFX6e3RRFW8c6Ux4AuBV31S4KFlsH2YmaA0
r0F/zBfcafwIe2lWNJrvwwi0lKi7MUXQr8LR0/24h0j3E8njctdXSMnKobwlzVai
W5AqtMKisbm2/ERvfqaTAtECgYAzAyGeqQL5fncLvUErWTqZd8N1GMy5jv2by4bp
x0Uocebb5kRCngrS4WPWrWkGpMez2L6pbk7o0R/4J92o+YbKE0sAFOAzY3dRcPkL
VzxA5KphaeZoCxjAtZ73yGIpJuDa2DZsTQ06WDNuTc9m55E5XOdnQIba4imxk/ke
+N9S5QKBgA7Cp+mdVHGaIj7ilt6zFhgvoGcykPQzjNDnkdWhJbP1Io/f2F8WBebQ
CBHwe4GUr31hPjOdp7+/hk+D9ndXLc7kkS9akcTME/+xyahMYwLQWR51CoDR4UHu
ly9X2ybz+7naJt8VISWStrLZCLXgDD/Y0DOZFlSiBEegwe0EePI2
-----END RSA PRIVATE KEY-----');

	private $businessEmail='dattq.vn86@gmail.com';
	private $_verifyBpnUrl='https://www.baokim.vn/bpn/verify';

	public function getSellerInfo(){
		$ch = curl_init();
		assert('$ch !== FALSE');

		$signature=$this->makeBaoKimAPISignature('get','/payment/rest/payment_pro_api/get_seller_info',array('business'=>$this->businessEmail),array(),$this->connection['private_key']);
		$url=$this->connection['base_url'].'/payment/rest/payment_pro_api/get_seller_info?business='.urlencode($this->businessEmail).'&signature='.urlencode($signature);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt_array($ch, array(
			CURLOPT_HEADER=>false,
			CURLINFO_HEADER_OUT=>false,
			CURLOPT_HTTPAUTH=>CURLAUTH_ANY,
			CURLOPT_USERPWD=>$this->connection['username'].':'.$this->connection['password'],
			CURLOPT_TIMEOUT=>30,
			CURLOPT_RETURNTRANSFER=>true,
		));
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/ca.crt");
		$content=curl_exec($ch);
		$response=curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($response==200){
			$resp = json_decode($content,true);
			if($resp===false){
				var_dump('json last error: '.json_last_error());
			}
			return $resp;
		}else{
			var_dump($content);die;
		}
	}

	public function payByCard($user,$txn){
		$order=array(
			'business'=>$this->businessEmail,
			'order_id'=>$txn->id,
			'total_amount'=>$txn->amount,
			'bank_payment_method_id'=>$txn->bank_payment_method_id,
			'order_description'=>'Nap tien cho user '.$user->username,

			"payer_name"=>$user->username,
			"payer_email"=>$user->email?$user->email:'maxgate@ptonline.vn',
			"payer_phone_no"=>$user->phone?$user->phone:'0466872648',
			"payer_address"=>'Ha noi | viet nam',

			'url_success'=>url('/charges/charge-by-bank-card-return'),
		);

		$ch = curl_init();
		assert('$ch !== FALSE');

		$signature=$this->makeBaoKimAPISignature('post','/payment/rest/payment_pro_api/pay_by_card',array(),$order,$this->connection['private_key']);
		curl_setopt($ch, CURLOPT_URL, $this->connection['base_url'].'/payment/rest/payment_pro_api/pay_by_card?signature='.$signature);
		curl_setopt_array($ch, array(
			CURLOPT_HEADER=>false,
			CURLINFO_HEADER_OUT=>false,
			CURLOPT_POST=>1,
			CURLOPT_POSTFIELDS=>http_build_query($order),
			CURLOPT_HTTPAUTH=>CURLAUTH_ANY,
			CURLOPT_USERPWD=>$this->connection['username'].':'.$this->connection['password'],
			CURLOPT_TIMEOUT=>30,
			CURLOPT_RETURNTRANSFER=>true,
		));
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/ca.crt");
		$content=curl_exec($ch);
		$response=curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if($response==200){
			return json_decode($content,true);
		}else{
			var_dump($content);die;
		}
	}

	function makeBaoKimAPISignature($method, $uri, $getArgs=array(), $postArgs=array(), $priKeyFile)
	{
		if(strpos($uri,'?') !== false)
		{
			list($uri,$get) = explode('?', $uri);
			parse_str($get, $get);
			$getArgs=array_merge($get, $getArgs);
		}

		ksort($getArgs);
		ksort($postArgs);

		$method=strtoupper($method);
		$data = $this->_combineRawUrlencodeMessage($method, $uri, $getArgs, $postArgs);
		$priKey = openssl_get_privatekey($priKeyFile);
		assert('$priKey !== false');
		$x=openssl_sign($data, $signature, $priKey, OPENSSL_ALGO_SHA1);
		assert('$x !== false');

		return urlencode(base64_encode($signature));
	}

	function _combineRawUrlencodeMessage($request_method, $request_uri, $get_args, $post_args)
	{
		$message='';
		$message .= $request_method;
		$message .= "&" . rawurlencode($request_uri);
		$message .= "&" . rawurlencode($this->_normalizeArrayToString($get_args));
		$message .= "&" . rawurlencode($this->_normalizeArrayToString($post_args));
		return $message;
	}

	function _normalizeArrayToString($data)
	{
		$items=array();
		$this->_makeQueryStrings($data, $items);
		ksort($items);

		$tmp = array();
		foreach ($items as $k=>$v) $tmp[] = $k.'='.$v;

		return implode('&', $tmp);
	}

	function _makeQueryStrings($data, & $queryStrings, $prefix=null)
	{
		foreach ($data as $k=>$v) {
			if (!empty($prefix)) $k = $prefix.'['.$k.']';
			if (is_array($v)) $this->_makeQueryStrings($v, $queryStrings, $k);
			else $queryStrings[rawurlencode($k)] = rawurlencode($v);
		}
	}

	/**
	 * Hàm thực hiện xác minh tính chính xác thông tin trả về từ BaoKim.vn
	 * @param $url_params chứa tham số trả về trên url
	 * @return true nếu thông tin là chính xác, false nếu thông tin không chính xác
	 */
	public function verifyResponseUrl($url_params = array())
	{
		if(empty($url_params['checksum'])){
			echo "invalid parameters: checksum is missing";
			return FALSE;
		}

		$checksum = $url_params['checksum'];
		unset($url_params['checksum']);

		ksort($url_params);

		if(strcasecmp($checksum,hash_hmac('SHA1',implode('',$url_params),$this->connection['secure_pass']))===0)
			return TRUE;
		else
			return FALSE;
	}

	public function validateBpnData($bpnData=array())
	{
		$req = '';

		//Kiểm tra sự tồn tại dữ liệu nhận từ BaoKim
		if (empty($bpnData)) {
			return false;
		}

		foreach ($bpnData as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}

		/**
		 * Gửi dữ liệu về Bảo Kim. Kiểm tra tính chính xác của dữ liệu
		 * @param $result Kết quả xác thực thông tin trả về.
		 * @paran $status Mã trạng thái trả về.
		 * @error $error  Lỗi được ghi vào file bpn.log
		 */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_verifyBpnUrl);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca.crt');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = curl_error($ch);

		if ($error){
			echo $error;
			return false;
		}

		if ($result != '' && strstr($result, 'VERIFIED') && $status == 200) {
			return true;
		} else {
			return false;
		}

		return false;
	}

	public function queryTransaction($transaction_id){
		$ch = curl_init();
		assert('$ch !== FALSE');

		$args=array(
			'merchant_id'=>$this->connection['merchant_id'],
			'transaction_id'=>$transaction_id
		);
		ksort($args);
		$args['checksum']=hash_hmac('SHA1',implode('',$args),$this->connection['secure_pass']);

		$url=$this->connection['base_url'].'/payment/order/queryTransaction?'.http_build_query($args);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt_array($ch, array(
			CURLOPT_HEADER=>false,
			CURLINFO_HEADER_OUT=>false,
			CURLOPT_HTTPAUTH=>CURLAUTH_ANY,
			CURLOPT_USERPWD=>$this->connection['username'].':'.$this->connection['password'],
			CURLOPT_TIMEOUT=>30,
			CURLOPT_RETURNTRANSFER=>true,
		));
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/ca.crt");
		$content=curl_exec($ch);
		$response=curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($response==200){
			parse_str($content,$transactionInfo);
			return $transactionInfo;
		}else{
			var_dump($content);die;
		}
	}
}