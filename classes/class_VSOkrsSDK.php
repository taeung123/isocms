<?php 
class VSOkrsSDK {
	public $api_key		= '';
	public $api_secret 	= '';
	public $api_url 	= 'https://okrs.vietiso.com';
	// Init
	function __construct($config=''){
		if(is_array($config)){
			foreach($config as $k=>$v){
				$this->{$k} = $v;
			}
		}
	}
	// Get configuration
	function _getConfig($config_key){
		return $this->{$config_key};
	}
	// Set configuration
	function _setConfig($key, $val){
		$this->{$key} = $val;
	}
	function get($request_url=NULL){
        global $_LANG_ID,$clsISO;
        $curl = @curl_init();
        $url = $this->api_url.$request_url;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
			CURLOPT_TIMEOUT => 60,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
                "Authorization: Bearer {$this->api_key}"
            ),
        ));
        $response = @curl_exec($curl);
        $err = @curl_error($curl);
        @curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return @json_decode($response,true);
        }
    }
    function post($request_url=NULL,$param=NULL){
        global $_LANG_ID,$clsISO;
        $curl = @curl_init();
        $url = $this->api_url.$request_url;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
			CURLOPT_TIMEOUT => 60,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_POSTFIELDS => $param,
			CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
                "Authorization: Bearer {$this->api_key}"
            ),
        ));
        $response = @curl_exec($curl);
        $response_info = @curl_getinfo($curl);
        $err = @curl_error($curl);
        @curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return @json_decode($response,true);
        }
    }
}	
?>