<?php
/**
 * Thư viện tích hợp thẻ cào maxpay.vn
 * Version 1.0
 */

class MaxpayClient {
	const SERVICE_URL="https://maxpay.vn/apis/card/charge?";
    const RECHECK_SERVICE_URL="https://maxpay.vn/apis/card/recheck?";
	const MERCHANT_ID="1000065"; //TODO: Thay bằng Merchant ID maxpay.vn cung cấp cho bạn
	const SECRET_KEY="1WZq0c4QqDQnEs7w"; //TODO: Thay bằng Secret Key ID maxpay.vn cung cấp cho bạn

	/**
	 * Hàm thực hiện gọi sang maxpay.vn để gạch thẻ
	 * @param $merchant_txn_id mã giao dịch duy nhất của merchant
	 * @param $cardType loại thẻ
	 * @param $pin mã thẻ (pin)
	 * @param $serial số seri
	 * @return mixed
	 */
	public function charge($merchant_txn_id, $cardType, $pin, $serial){
		$args = array('merchant_id'=>self::MERCHANT_ID, 'pin'=>$pin,
			'seri'=>$serial, 'card_type'=>$cardType,'merchant_txn_id'=>$merchant_txn_id);
		//Create checksum security code
		$args['checksum'] = $this->_createChecksum($args);

		//Build request url
		$requestUrl = self::SERVICE_URL.http_build_query($args);

		//Call maxpay.vn's web service
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $requestUrl);
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/ca.crt");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$output = curl_exec($ch);

		//If curl error?
		if($output===false){
			$response = array(
				'code'=>99,
				'message'=>'Your curl error: '.curl_error($ch)
			);
			curl_close($ch);
			return $response;
		}

		curl_close($ch);

		$response = json_decode($output,true);
		//If json format error?
		if($response===false){
			return array(
				'code'=>99,
				'message'=>$output
			);
		}

		return $response;
	}

    /**
     * Hàm thực hiện gọi sang maxpay.vn để kiểm tra tình trạng của một giao dịch thẻ
     * @param $merchant_txn_id mã giao dịch duy nhất của merchant
     * @return mixed
     */
    public function recheck($merchant_txn_id){
        $args = array('merchant_id'=>self::MERCHANT_ID, 'merchant_txn_id'=>$merchant_txn_id);

        //Create checksum security code
        $args['checksum'] = $this->_createChecksum($args);

        //Build request url
        $requestUrl = self::RECHECK_SERVICE_URL.http_build_query($args);

        //Call maxpay.vn's web service
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__)."/ca.crt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $output = curl_exec($ch);

        //If curl error?
        if($output===false){
            $response = array(
                'code'=>99,
                'message'=>'Your curl error: '.curl_error($ch)
            );
            curl_close($ch);
            return $response;
        }

        curl_close($ch);

        $response = json_decode($output,true);
        //If json format error?
        if($response===false){
            return array(
                'code'=>99,
                'message'=>$output
            );
        }

        return $response;
    }

	/**
	 * Hàm thực hiện tạo mã bảo mật checksum
	 * @param $args
	 * @return string
	 */
	private function _createChecksum($args){
		ksort($args);
		return hash_hmac('SHA1',implode('|',$args),self::SECRET_KEY);
	}

    /*
     * Hàm check mã bảo mật
     * */

    public function verifyChecksum($args,$checksum){
        return $this->_createChecksum($args) == $checksum;
    }
}
