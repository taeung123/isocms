<?php
	class VietISOSDK2{
		public $url = 'http://ilooca-cus.itourism.vn/api/';
		public $version = 'v1';
		public $mediatype = 'json';
		public $apiKey = 'c87a8db0272d006c3b59922b9957af0d';
		//public $apiKey = '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';
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
		function _setConfig($config_key, $config_value){
			$this->{$config_key} = $config_value;
		}
		function print_pre ($expression, $wrap = false)
		{
		  $css = 'border:1px dashed #06f;padding:1em;text-align:left;';
		  if ($wrap) {
			$str = '<p style="' . $css . '"><tt>' . str_replace(
			  array('  ', "\n"), array('&nbsp; ', '<br />'),
			  htmlspecialchars(print_r($expression, true))
			) . '</tt></p>';
		  } else {
			$str = '<pre style="' . $css . '">'
			. htmlspecialchars(print_r($expression, true)) . '</pre>';
		  }
		  echo $str;
		}
		function rmkdir($path, $mode = 0777) {
			return is_dir($path) || ( $this->rmkdir(dirname($path), $mode) && $this->_mkdir($path, $mode) );
		}
		function _mkdir($path, $mode = 0777) {
			$old = umask(0);
			$res = @mkdir($path, $mode);
			umask($old);
			return $res;
		}
        function base64ToJPEG($string, $folder){
            if($folder=='' || $string=='') return;
            #
            $dirname = ftp_abs_path_info.'/avatar/'.$this->replaceSpace($folder);
            $dirname = str_replace('//','/',$dirname);
            if(!is_dir(PCMS_DIR.$dirname)){
                $this->rmkdir(PCMS_DIR.$dirname,0777);
            }
            #
            list($type, $string) = explode(';', $string);
            list(, $string) = explode(',', $string);
            $extension = end(explode('/',$type));
            #
            $filename = $dirname.'/'.md5(time().uniqid()).'.'.$extension;
            $filename = str_replace('//','/',$filename);
            $data = base64_decode($string);
            //header('Content-Type: image/jpeg');
            $this->write_file_FIXED(PCMS_DIR.$filename,$data);
            return $filename;
        }
        
		function downloadImageFromUrl($file, $folder=''){
			$host = ftp_host_info;
			$usr = ftp_usr_info;
			$pwd = ftp_pwd_info;
			$abs_path = ftp_abs_path_info;
			$path_parts = pathinfo($file);
			$ext = $path_parts['extension'];
			if($ext!='jpg' && $ext!='png' && $ext!='gif'){
				$ext = 'jpg';
			}
			$dirname = $abs_path.'/content';
			if($folder){
				$dirname .= '/'.$folder;	
			}
			$dirname = str_replace('//','/',$dirname);
			if($folder)
				$this->rmkdir($_SERVER['DOCUMENT_ROOT'].$dirname,0777);
			
			// Name of file
			$name = $dirname.'/'.$path_parts['filename'].'.'.$ext;
			// Mở một file mới với đường dẫn và tên file là tham số $saveTo
			$fp = fopen ($_SERVER['DOCUMENT_ROOT'].$name, 'w+');
			 
			// Bắt đầu CURl
			$ch = curl_init($file);
			 
			// Thiết lập giả lập trình duyệt
			// nghĩa là giả mạo đang gửi từ trình duyệt nào đó, ở đây tôi dùng Firefox
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
			 
			// Thiết lập trả kết quả về chứ không print ra
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  
			// Thời gian timeout
			curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
			 
			// Lưu kết quả vào file vừa mở
			curl_setopt($ch, CURLOPT_FILE, $fp);
			 
			// Thực hiện download file
			$result = curl_exec($ch);
			 
			// Đóng CURL
			curl_close($ch);
			
			// Return
			return ($result) ? $name : '';
		}
		
		function doInApp($method=NULL,$request_url=NULL,$param=NULL){
		    global $_LANG_ID,$clsISO;
			$curl = curl_init();
			//$url = $this->url.'/'.$this->version.$request_url;
			$url =$this->url.$request_url;
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 60,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => $method,
			  CURLOPT_POSTFIELDS =>$param,
			  CURLOPT_HTTPHEADER => array(
				"authorization: Bearer ".$this->apiKey,
				"content-type: application/json",
                "Accept-Language: ".$_LANG_ID.""
			  ),
			));
			$response = curl_exec($curl);
			$response_info = curl_getinfo($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			  	echo "cURL Error #:" . $err;
			} else {
			  	return $response;	
			}	
		}
		function doInAppLogin($method=NULL,$request_url=NULL,$param=NULL,$token=''){
			$curl = curl_init();
			$url = $this->url.'/'.$this->version.$request_url;
			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => $method,
			  CURLOPT_POSTFIELDS =>$param,
			  CURLOPT_HTTPHEADER => array(
				"authorization: Bearer ".$token,
				"content-type: application/json"
			  ),
			));
			$response = curl_exec($curl);
			$response_info = curl_getinfo($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			  	echo "cURL Error #:" . $err;
			} else {
			  	return $response;	
			}	
		}
        function get($request_url=NULL,$param=NULL){
            global $_LANG_ID,$clsISO;
            $curl = curl_init();
            $url =$request_url;
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'get',
                CURLOPT_POSTFIELDS =>$param,
                CURLOPT_HTTPHEADER => array(
                    "access_token:p2Qr61ll1Ht48RKT5-a36ySbjXyLy45jbJcpDaMuHJVeTRPYUBje9FC8etr2fdyOvpINRMQOToJY19bjDfLvC81QfMyuxqvbg7o01XtHS42W1vyn49vfGvjMXJyzxrjMZ6Q541ohPKZC6QakMxrtCCyXa48Sh3iTdthURK_O0cxBP_GqJyu8VlvlpJjOfJ5ZvXd51bBK6HZt6yPEIgGqDjauwbTAZmaUuoVQH2cvCHkF8SHF0U86BPDr-YWouorSkIx9FdE0Fr_m4VzLMTyM8_HW_4GhjYCbe1J1V3FNBtlv7zqnMBC2Q_q-oI5GX3X6nndL8MoG85_YAf8RA8Lu7K_d-uOp7_C27G"
                ),
            ));
            $response = @curl_exec($curl);
            $response_info = @curl_getinfo($curl);
            $err = @curl_error($curl);
            @curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                return json_decode($response,true);
            }
        }
        function post($request_url=NULL, $param=NULL){
            global $_LANG_ID,$clsISO;
            $curl = @curl_init();
            $url = $this->api_url.$request_url;
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_POSTFIELDS => $param,
                CURLOPT_HTTPHEADER => array(
                    "Accept-Language: ".$_LANG_ID."",
                    "Content-Type: ".$this->content_type,
                    "access_token: Czxd2pezVNOxsUSEDZjxS3ZTv0mq8YGBOwAbSJSMSKfRh-WrCoG577AQu0KkBW0QNywO1GHlMnT7qQuI3tDQQNZ4ediNUrz1UEMuJZHrMbHt-xfR3HfE9awla0CT6KmwRO6dGWuVEZa5dzGz324e9r3TqZaFN1meVixU411e011T_fnkEs5YI6heXq4c01zS9hFyI7OB2ZKgjSqmOGav8Y_kfJDzRqXCAulSSNWrE4mpYDvDCYijJNoGuaLnAG5fFgZXT41A958Gt-LsIpuZKXcRlK1G358v7fUt5K4d8Wmiii0-RpODHHsbqrbUFmXXDBxjR3aCSKPPYvLAET6iIpuXUdO"
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