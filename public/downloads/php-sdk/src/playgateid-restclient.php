<?php
/**
 * Created by PhpStorm.
 * User: Firzen
 * Date: 8/21/14
 * Time: 9:13 AM
 */
require_once 'RestClient.php';
class PlaygateIDRestClient extends RestClient {
	const PLAYGATE_ID_BASE_URL='https://id.maxgate.vn/';
	const APP_ID='1';
	const APP_SECRET='123456';

	public function get($path, $params=array(), $headers = array(), $timeout = 30) {
		$this->_signData($params);
		$payload=http_build_query($params);
		$path.='?'.$payload;
		$response = parent::get(self::PLAYGATE_ID_BASE_URL.$path, $headers, $timeout);
		return json_decode($response->getContent(),true);
	}

	public function post($path, $params=array(), $headers = array(), $timeout = 30) {
		$this->_signData($params);
		$payload=http_build_query($params);
		$response = parent::post(self::PLAYGATE_ID_BASE_URL.$path, $payload, $headers, $timeout);
		return json_decode($response->getContent(),true);
	}

	protected function _signData(&$params){
		$params['client_id']=self::APP_ID;
		ksort($params);
		$params['checksum'] = hash_hmac('SHA1',implode('|',$params),self::APP_SECRET);
	}
} 