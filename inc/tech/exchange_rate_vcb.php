<?php
/*======================================================================*\
|| #################################################################### ||
|| # The database configurations of the ISOCMS                        # ||
|| # ISOCMS By VietISO (support@vietiso.com)        			      # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2025 VietISO JSC.             # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/

$fileExchangeRate = $_SERVER['DOCUMENT_ROOT'] . '/xml_exchange_rate_vcb.xml';

function curl_get_contents($url)
{
    $curl = curl_init();
    $headers = [
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        "accept-encoding: gzip, deflate, br",
        "accept-language: en,en-US;q=0.9,vi;q=0.8,ja;q=0.7",
        "cache-control: no-cache",
        "dnt: 1",
        "pragma: no-cache",
        "sec-ch-ua: \"Not_A Brand\";v=\"99\", \"Google Chrome\";v=\"109\", \"Chromium\";v=\"109\"",
        "sec-ch-ua-mobile ?0",
        "sec-ch-ua-platform: \"Windows\"",
        "sec-fetch-dest: document",
        "sec-fetch-mode: navigate",
        "sec-fetch-site: none",
        "sec-fetch-user: ?1",
        "upgrade-insecure-requests: 1",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36",
    ];
    // Thiết lập URL và các tùy chọn cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Để trả về kết quả thay vì xuất ra màn hình
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
    curl_setopt($curl, CURLOPT_TIMEOUT, 5); // Thời gian tối đa thực hiện request (5 giây)
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);

    $response = curl_exec($curl);
    $response_info = curl_getinfo($curl);
    $err = curl_error($curl);
    curl_close($curl);
    return $response;
}

// $url_exchangerates = "https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx?b=1";
$url_exchangerates = "https://www.vietiso.com/xml_exchange_rate_vcb.xml";
if (filemtime($fileExchangeRate) < strtotime('today midnight')) {
    $xml_exchangerates = curl_get_contents($url_exchangerates);
    $data_exchangerates = simplexml_load_string($xml_exchangerates);
    if ($data_exchangerates != '') {
        $data_exchangerates->saveXML($fileExchangeRate);
    }
}

header("Content-type: text/xml");
echo file_get_contents($fileExchangeRate);
