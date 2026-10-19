<?php

class VietISOSDK
{
    public $url = 'https://tmsbrate.vietiso.com';
    public $api_url = 'http://tms80.vietiso.com';
    public $version = 'v1';
    public $mediatype = 'json';
    public $apiKey = '79b7ab9c6305d420d59388e4abe95684';
    public $api_key = '79b7ab9c6305d420d59388e4abe95684';
    public $headers = array();
    public $return_type = 'json';
    public $content_type = 'application/json';
    public $debug = 0;

    // Init
    function __construct($config = '')
    {
        if (is_array($config)) {
            foreach ($config as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    // Get configuration
    function _getConfig($config_key)
    {
        return $this->{$config_key};
    }

    // Set configuration
    function _setConfig($config_key, $config_value)
    {
        $this->{$config_key} = $config_value;
    }

    function print_pre($expression, $wrap = false)
    {
        $css = 'border:1px dashed #06f;padding:1em;text-align:left;';
        if ($wrap) {
            $str = '<p style="' . $css . '"><tt>' . str_replace(
                array('  ', "\n"),
                array('&nbsp; ', '<br />'),
                htmlspecialchars(print_r($expression, true))
            ) . '</tt></p>';
        } else {
            $str = '<pre style="' . $css . '">'
                . htmlspecialchars(print_r($expression, true)) . '</pre>';
        }
        echo $str;
    }

    function rmkdir($path, $mode = 0777)
    {
        return is_dir($path) || ($this->rmkdir(dirname($path), $mode) && $this->_mkdir($path, $mode));
    }

    function _mkdir($path, $mode = 0777)
    {
        $old = umask(0);
        $res = @mkdir($path, $mode);
        umask($old);
        return $res;
    }

    function downloadImageFromUrl($file, $folder = '')
    {
        $host = ftp_host_info;
        $usr = ftp_usr_info;
        $pwd = ftp_pwd_info;
        $abs_path = ftp_abs_path_info;
        $path_parts = pathinfo($file);
        $ext = $path_parts['extension'];
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
            $ext = 'jpg';
        }
        $dirname = $abs_path . '/content';
        if ($folder) {
            $dirname .= '/' . $folder;
        }
        $dirname = str_replace('//', '/', $dirname);
        if ($folder)
            $this->rmkdir($_SERVER['DOCUMENT_ROOT'] . $dirname, 0777);

        // Name of file
        $name = $dirname . '/' . $path_parts['filename'] . '.' . $ext;
        // Mở một file mới với đường dẫn và tên file là tham số $saveTo
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . $name, 'w+');

        // Bắt đầu CURl
        $ch = curl_init($file);

        // Thiết lập giả lập trình duyệt
        // nghĩa là giả mạo đang gửi từ trình duyệt nào đó, ở đây tôi dùng Firefox
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");

        // Thiết lập trả kết quả về chứ không print ra
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Thời gian timeout
        curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // Lưu kết quả vào file vừa mở
        curl_setopt($ch, CURLOPT_FILE, $fp);

        // Thực hiện download file
        $result = curl_exec($ch);
        $response_info = curl_getinfo($ch);
        $err = curl_error($ch);

        // Đóng CURL
        curl_close($ch);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return ($result) ? $name : '';
        }
    }

    function doInApp($method = NULL, $request_url = NULL, $param = NULL)
    {
        $curl = curl_init();
        $url = $this->url . '/' . $this->version . $request_url;
        //$url = $request_url;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $this->apiKey,
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

    function doInAppLogin($method = NULL, $request_url = NULL, $param = NULL, $token = '')
    {
        $curl = curl_init();
        $url = $this->url . '/' . $this->version . $request_url;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $token,
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

    function file_get_contents_curl($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => '',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
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

    function getProperty($property_type, $update = false)
    {
        if (file_exists(DIR_INCLUDES . '/json_master/autoload.php')) {
            require_once(DIR_INCLUDES . '/json_master/autoload.php');
        }
        $file_cache_name = $property_type . '.json';
        if (file_exists(DIR_JSON_PROPERTY . DS . $file_cache_name) && !$update) {
            $decoder = new Webmozart\Json\JsonDecoder();
            return $decoder->decodeFile(DIR_JSON_PROPERTY . DS . $file_cache_name);
        } else {
            $response = $this->doInApp('GET', '/api/get_property', json_encode(array('property_type' => $property_type)));
            $response = json_decode($response, true);
            if ($response['meta']['ok']) {
                $lstProperty = $response['data']['lstProperty'];
                if (!empty($lstProperty)) {
                    $encoder = new Webmozart\Json\JsonEncoder();
                    $encoder->encodeFile($lstProperty, DIR_JSON_PROPERTY . DS . $file_cache_name);
                    return $lstProperty;
                }
            }
        }
    }

    function getInfoPrice($tour_id, $oneTour = null, $update = false)
    {
        if (file_exists(DIR_INCLUDES . '/json_master/autoload.php')) {
            require_once(DIR_INCLUDES . '/json_master/autoload.php');
        }
        $file_cache_name = 'info_price' . $tour_id . '.json';
        if (file_exists(DIR_JSON_TOUR . DS . $file_cache_name) && !$update) {
            $decoder = new Webmozart\Json\JsonDecoder();
            return $decoder->decodeFile(DIR_JSON_TOUR . DS . $file_cache_name);
        } else {
            $clsTour = new Tour();
            if (!isset($oneTour['yield_id'])) {
                $oneTour = $clsTour->getOne($tour_id, 'yield_id');
            }
            $response = $this->doInApp('GET', '/api/get_yield/' . $oneTour['yield_id']);
            $response = json_decode($response, true);
            if ($response['meta']['ok']) {
                $oneYield = $response['data']['yield'];
                if (!empty($oneYield)) {
                    $encoder = new Webmozart\Json\JsonEncoder();
                    $encoder->encodeFile($oneYield['info_price'], DIR_JSON_TOUR . DS . $file_cache_name);
                    return $oneYield['info_price'];
                }
            }
        }
    }

    function getOneEstimate($params)
    {
        //return $params;
        extract($params); //$yield_op_id,$yield_pax_id,$currency_id, $yieldEstimate
        $oneEs = array();
        foreach ($yieldEstimate as $k => $oneEstimate) {
            if ($yield_op_id == $oneEstimate['yield_op_id'] && $yield_pax_id == $oneEstimate['yield_pax_id']) {
                if ($currency_id == $oneEstimate['currency_id']) {
                    $oneEs = $oneEstimate;
                    break;
                } elseif (empty($oneEs)) {
                    $oneEs = $oneEstimate;
                }
            }
        }
        return $oneEs;
    }

    function get($request_url = NULL, $param = NULL)
    {
        global $_LANG_ID, $clsISO;
        $lang_id = $clsISO->getLangTMS($_LANG_ID);
        $stime = array_sum(explode(' ', microtime()));
        $curl = curl_init();
        $url = $this->api_url . $request_url;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => 60,
            //CURLOPT_MAXREDIRS => 10,
            CURLOPT_RETURNTRANSFER => true,
            //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => $param,
            CURLOPT_HTTPHEADER => array(
                "Accept-Language: " . $lang_id . "",
                "Content-Type: " . $this->content_type,
                "Authorization: Bearer " . $this->api_key
            ),
        ));
        $response = @curl_exec($curl);
        $err = @curl_error($curl);
        @curl_close($curl);
        $time = array_sum(explode(" ", microtime())) - $stime;
        if ($this->debug) {
            var_dump($response);
        }
        //$clsISO->tracking_execute($time, $url);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return @json_decode($response, true);
        }
    }

    function post($request_url = NULL, $params = NULL, $authorization = true)
    {
        global $_LANG_ID, $clsISO;
        $lang_id = $clsISO->getLangTMS($_LANG_ID);
        $headers = @array_merge($this->headers, array(
            "Accept-Language: {$lang_id}",
            "Content-Type: {$this->content_type}"
        ));
        if ($authorization) {
            $headers[] = "Authorization: Bearer {$this->api_key}";
        }
        
        $stime = array_sum(explode(' ', microtime()));
        $curl = @curl_init();
        $url = $this->api_url . $request_url;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => 60,
            //CURLOPT_MAXREDIRS => 10,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => $headers
        ));
        $response = @curl_exec($curl);
        $err = @curl_error($curl);
        @curl_close($curl);
        #
        #
        $time = array_sum(explode(" ", microtime())) - $stime;
        if ($this->debug) {
            var_dump($response);
        }
        //$clsISO->tracking_execute($time, $url);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if ($this->return_type == 'xml') {
                require_once(DIR_CLASSES . '/xml2php.php');
                $xmlDecoder = XML2Array::createArray($response);
                return $xmlDecoder;
            } else if ($this->return_type == 'json') {
                return @json_decode($response, true);
            }
        }
    }
}
