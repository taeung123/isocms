<?php
	global $smarty,$core, $mod, $act, $_LANG_ID,$clsISO;


$feedUrl = 'https://www.vietiso.com/blog_feed.php';
$htmlBlog = '';

if (function_exists('curl_init')) {
    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_URL            => $feedUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 3,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_ENCODING       => '',
        CURLOPT_HTTPHEADER     => array(
            'Accept: text/html,application/xhtml+xml,application/json;q=0.9,*/*;q=0.8',
            'Accept-Language: vi-VN,vi;q=0.9,en;q=0.8',
            'Cache-Control: no-cache'
        ),
        CURLOPT_USERAGENT => isset($_SERVER['HTTP_USER_AGENT'])
            ? $_SERVER['HTTP_USER_AGENT']
            : 'Mozilla/5.0 (compatible; isoCMS/1.0)'
    ));

    $response = curl_exec($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    curl_close($ch);

    if ($response !== false && $httpCode >= 200 && $httpCode < 300) {
        $htmlBlog = $response;
    } else {
        error_log(
            'Cannot load VietISO blog feed. HTTP: '
            . $httpCode
            . ($curlError !== '' ? '; cURL: ' . $curlError : '')
        );
    }
} else {
    $context = stream_context_create(array(
        'http' => array(
            'method'        => 'GET',
            'timeout'       => 10,
            'ignore_errors' => true,
            'header'        =>
                "User-Agent: Mozilla/5.0 (compatible; isoCMS/1.0)\r\n" .
                "Accept: text/html,application/xhtml+xml,application/json;q=0.9,*/*;q=0.8\r\n" .
                "Accept-Language: vi-VN,vi;q=0.9,en;q=0.8\r\n"
        )
    ));

    $response = @file_get_contents($feedUrl, false, $context);

    if ($response !== false) {
        $htmlBlog = $response;
    } else {
        error_log('Cannot load VietISO blog feed using file_get_contents().');
    }
}

$assign_list['htmlBlog'] = $htmlBlog;
	$smarty->assign('htmlBlog',$htmlBlog);
?>