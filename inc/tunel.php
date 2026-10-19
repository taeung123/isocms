<?php
/**
 * Navicat HTTP Tunnel — Production Hardened
 * =========================================================
 * Kiến trúc: Dev → OpenVPN (124.158.4.43) → tunel.php → MySQL
 *
 * Mọi thay đổi tập trung ở khối SECURITY CONFIGURATION bên dưới.
 * Toàn bộ logic giao tiếp với Navicat/MySQL giữ nguyên 100%.
 * =========================================================
 */
//ini_set( "display_errors", 1);
$versionNum = 206; // remark: require update CC_HTTP_TUNNEL_SCRIPT_LATEST_VERSION_MYSQL

// ============================================================
// SECURITY CONFIGURATION — chỉnh sửa tại đây
// ============================================================

// [SEC-1] Test page — LUÔN để false trên production
// Để true chỉ khi debug tạm thời, xong phải đổi lại ngay
$allowTestMenu = false;

// [SEC-2] Whitelist IP — chỉ VPN server được phép gọi tunnel
// Dev muốn vào DB bắt buộc phải connect OpenVPN trước
// Khi dev nghỉ việc: xóa account VPN → lập tức mất quyền
$allowed_ips = [
    '124.158.4.43',  // OpenVPN Server
];

// [SEC-3] Rate limiting — chống brute-force và abuse
// VPN server gom traffic của tất cả dev → nâng limit phù hợp
$rate_limit_max    = 300;  // request tối đa
$rate_limit_window = 60;   // trong vòng 60 giây

// [SEC-4] Whitelist DB host — chỉ cho phép kết nối localhost
// MySQL cùng máy với webserver, không chấp nhận IP nào khác
$allowed_db_hosts = [
    '127.0.0.1',
    'localhost',
];

// [SEC-5] Giới hạn số query trong một request
$max_queries_per_request = 50;

// ============================================================
// END SECURITY CONFIGURATION
// ============================================================


// ============================================================
// BOOTSTRAP
// ============================================================

$use_mysqli = function_exists("mysqli_connect");

// Ẩn thông tin server khỏi HTTP response header
header("Content-Type: text/plain; charset=x-user-defined");
header_remove("X-Powered-By");
header_remove("Server");

error_reporting(0);
set_time_limit(0);


// ============================================================
// SECURITY FUNCTIONS
// ============================================================

/**
 * Lấy IP thực của client.
 * Chỉ dùng REMOTE_ADDR — không tin các header X-Forwarded-For
 * vì có thể bị giả mạo dễ dàng.
 */
function getClientIp()
{
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
}

/**
 * [SEC-2] Kiểm tra IP có trong whitelist không.
 * Request từ IP lạ bị chặn tại đây, PHP không xử lý thêm.
 */
function checkIpWhitelist($allowed_ips)
{
    if (empty($allowed_ips)) return;
    if (!in_array(getClientIp(), $allowed_ips, true)) {
        http_response_code(403);
        exit();
    }
}

/**
 * [SEC-3] Rate limiting dùng file tạm — không cần Redis/Memcache.
 * Mỗi IP có một counter riêng, reset theo $window giây.
 */
function checkRateLimit($max, $window)
{
    $tmpFile = sys_get_temp_dir() . '/tunnel_rl_' . md5(getClientIp());
    $now     = time();
    $data    = ['count' => 0, 'start' => $now];

    if (file_exists($tmpFile)) {
        $raw = @file_get_contents($tmpFile);
        if ($raw !== false) {
            $parsed = json_decode($raw, true);
            if (is_array($parsed)) $data = $parsed;
        }
    }

    if ($now - $data['start'] > $window) {
        $data = ['count' => 1, 'start' => $now];
    } else {
        $data['count']++;
        if ($data['count'] > $max) {
            http_response_code(429);
            exit();
        }
    }

    @file_put_contents($tmpFile, json_encode($data), LOCK_EX);
}

/**
 * [SEC-4] Kiểm tra DB host có trong whitelist không.
 * Ngăn SSRF — không cho tunnel kết nối tới server nội bộ khác.
 */
function checkDbHostWhitelist($host, $allowed_db_hosts)
{
    if (empty($allowed_db_hosts)) return;
    if (!in_array($host, $allowed_db_hosts, true)) {
        EchoHeader(202);
        echo GetBlock("connection to this host is not permitted");
        exit();
    }
}

/**
 * [SEC-6] Validate port — chỉ chấp nhận giá trị hợp lệ 1-65535.
 */
function validatePort($port)
{
    if ($port === '' || $port === null || $port === false) return true;
    $p = intval($port);
    return ($p >= 1 && $p <= 65535);
}

/**
 * [SEC-7] Validate host — chỉ cho phép ký tự hợp lệ trong hostname/IP.
 * Ngăn injection qua trường host.
 */
function validateHost($host)
{
    return preg_match('/^[a-zA-Z0-9\.\-\_]+$/', $host) === 1;
}


// ============================================================
// ORIGINAL HELPER FUNCTIONS — giữ nguyên 100%
// ============================================================

function phpversion_int()
{
    $ver = phpversion();
    
    // L?y 3 s? d?u ti�n c?a version
    if (preg_match('/^(\d+)\.(\d+)(?:\.(\d+))?/', $ver, $matches)) {
        $major   = (int)$matches[1];
        $minor   = (int)$matches[2];
        $patch   = isset($matches[3]) ? (int)$matches[3] : 0;
        
        return $major * 10000 + $minor * 100 + $patch;
    }
    
    return 0; // fallback
}

if (phpversion_int() < 50300) {
    set_magic_quotes_runtime(0);
}

function GetLongBinary($num)
{
    return pack("N", $num);
}

function GetShortBinary($num)
{
    return pack("n", $num);
}

function GetDummy($count)
{
    $str = "";
    for ($i = 0; $i < $count; $i++)
        $str .= "\x00";
    return $str;
}

function GetBlock($val)
{
    $len = strlen($val);
    if ($len < 254)
        return chr($len) . $val;
    else
        return "\xFE" . GetLongBinary($len) . $val;
}

function EchoHeader($errno)
{
    global $versionNum;
    $str  = GetLongBinary(1111);
    $str .= GetShortBinary($versionNum);
    $str .= GetLongBinary($errno);
    $str .= GetDummy(6);
    echo $str;
}

function EchoConnInfo($conn)
{
    if ($GLOBALS['use_mysqli']) {
        $str  = GetBlock(mysqli_get_host_info($conn));
        $str .= GetBlock(mysqli_get_proto_info($conn));
        $str .= GetBlock(mysqli_get_server_info($conn));
        echo $str;
    } else {
        $str  = GetBlock(mysql_get_host_info($conn));
        $str .= GetBlock(mysql_get_proto_info($conn));
        $str .= GetBlock(mysql_get_server_info($conn));
        echo $str;
    }
}

function EchoResultSetHeader($errno, $affectrows, $insertid, $numfields, $numrows)
{
    $str  = GetLongBinary($errno);
    $str .= GetLongBinary($affectrows);
    $str .= GetLongBinary($insertid);
    $str .= GetLongBinary($numfields);
    $str .= GetLongBinary($numrows);
    $str .= GetDummy(12);
    echo $str;
}

function EchoFieldsHeader($res, $numfields)
{
    $str = "";
    for ($i = 0; $i < $numfields; $i++) {
        if ($GLOBALS['use_mysqli']) {
            $finfo    = mysqli_fetch_field_direct($res, $i);
            $str     .= GetBlock($finfo->name);
            $str     .= GetBlock($finfo->table);
            $type     = $finfo->type;
            $length   = $finfo->length;
            $str     .= GetLongBinary($type);
            $intflag  = $finfo->flags;
            $str     .= GetLongBinary($intflag);
            $str     .= GetLongBinary($length);
        } else {
            $str .= GetBlock(mysql_field_name($res, $i));
            $str .= GetBlock(mysql_field_table($res, $i));

            $type   = mysql_field_type($res, $i);
            $length = mysql_field_len($res, $i);
            switch ($type) {
                case "int":
                    if ($length > 11) $type = 8;
                    else              $type = 3;
                    break;
                case "real":
                    if ($length == 12)      $type = 4;
                    elseif ($length == 22)  $type = 5;
                    else                    $type = 0;
                    break;
                case "null":      $type = 6;   break;
                case "timestamp": $type = 7;   break;
                case "date":      $type = 10;  break;
                case "time":      $type = 11;  break;
                case "datetime":  $type = 12;  break;
                case "year":      $type = 13;  break;
                case "blob":
                    if ($length > 16777215)  $type = 251;
                    elseif ($length > 65535) $type = 250;
                    elseif ($length > 255)   $type = 252;
                    else                     $type = 249;
                    break;
                default: $type = 253;
            }
            $str .= GetLongBinary($type);

            $flags   = explode(" ", mysql_field_flags($res, $i));
            $intflag = 0;
            if (in_array("not_null",       $flags)) $intflag += 1;
            if (in_array("primary_key",    $flags)) $intflag += 2;
            if (in_array("unique_key",     $flags)) $intflag += 4;
            if (in_array("multiple_key",   $flags)) $intflag += 8;
            if (in_array("blob",           $flags)) $intflag += 16;
            if (in_array("unsigned",       $flags)) $intflag += 32;
            if (in_array("zerofill",       $flags)) $intflag += 64;
            if (in_array("binary",         $flags)) $intflag += 128;
            if (in_array("enum",           $flags)) $intflag += 256;
            if (in_array("auto_increment", $flags)) $intflag += 512;
            if (in_array("timestamp",      $flags)) $intflag += 1024;
            if (in_array("set",            $flags)) $intflag += 2048;
            $str .= GetLongBinary($intflag);
            $str .= GetLongBinary($length);
        }
    }
    echo $str;
}

function EchoData($res, $numfields, $numrows)
{
    for ($i = 0; $i < $numrows; $i++) {
        $str = "";
        $row = null;
        if ($GLOBALS['use_mysqli'])
            $row = mysqli_fetch_row($res);
        else
            $row = mysql_fetch_row($res);
        for ($j = 0; $j < $numfields; $j++) {
            if (is_null($row[$j]))
                $str .= "\xFF";
            else
                $str .= GetBlock($row[$j]);
        }
        echo $str;
    }
}

function doSystemTest()
{
    global $versionNum;

    function output($description, $succ, $resStr)
    {
        // [SEC-8] Escape output HTML — chống XSS
        $desc   = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        $result = htmlspecialchars($succ ? $resStr[0] : $resStr[1], ENT_QUOTES, 'UTF-8');
        echo "<tr><td class=\"TestDesc\">$desc</td><td ";
        echo ($succ)
            ? "class=\"TestSucc\">$result</td></tr>"
            : "class=\"TestFail\">$result</td></tr>";
    }

    output("PHP version >= 4.0.5",
        phpversion_int() >= 40005,
        ["Yes (" . phpversion() . ")", "No (" . phpversion() . ")"]);
    output("mysql_connect() available",
        function_exists("mysql_connect"),
        ["Yes", "No"]);
    output("mysqli_connect() available",
        function_exists("mysqli_connect"),
        ["Yes", "No"]);
    if (phpversion_int() >= 40302
        && substr($_SERVER["SERVER_SOFTWARE"], 0, 6) == "Apache"
        && function_exists("apache_get_modules")) {
        if (in_array("mod_security2", apache_get_modules()))
            output("Mod Security 2 installed", false, ["No", "Yes"]);
    }
    output("Current tunnel file version",
        true,
        [(int)($versionNum / 100) . "." . ($versionNum % 100), ""]);
}


// ============================================================
// MAIN — kiểm tra version PHP
// ============================================================

if (phpversion_int() < 40005) {
    EchoHeader(201);
    echo GetBlock("unsupported php version");
    exit();
}

if (phpversion_int() < 40010) {
    global $HTTP_POST_VARS;
    $_POST = &$HTTP_POST_VARS;
}


// ============================================================
// SECURITY GATE — chạy trước mọi logic khác
// ============================================================

// [SEC-2] Chặn mọi IP không phải VPN server
checkIpWhitelist($allowed_ips);

// [SEC-3] Chặn abuse / brute-force
checkRateLimit($rate_limit_max, $rate_limit_window);


// ============================================================
// ROUTING — test menu hay tunnel request?
// ============================================================

$testMenu = false;

if (!isset($_POST["actn"]) || !isset($_POST["host"]) ||
    !isset($_POST["port"]) || !isset($_POST["login"])) {
    if (!$allowTestMenu) {
        EchoHeader(202);
        echo GetBlock("invalid parameters");
        exit();
    }
    $testMenu = false;
}


// ============================================================
// TUNNEL REQUEST PROCESSING
// ============================================================

if (!$testMenu) {

    // [SEC-9] Validate action — chỉ chấp nhận 'C' (connect) và 'Q' (query)
    $actn = isset($_POST["actn"]) ? $_POST["actn"] : '';
    if (!in_array($actn, ['C', 'Q'], true)) {
        EchoHeader(202);
        echo GetBlock("invalid action");
        exit();
    }

    // [SEC-6] Validate port
    $port_input = isset($_POST["port"]) ? $_POST["port"] : '';
    if (!validatePort($port_input)) {
        EchoHeader(202);
        echo GetBlock("invalid port");
        exit();
    }

    // [SEC-7] Validate và sanitize host
    $host_input = isset($_POST["host"]) ? $_POST["host"] : '';
    if (!validateHost($host_input)) {
        EchoHeader(202);
        echo GetBlock("invalid host");
        exit();
    }

    // [SEC-4] Chặn SSRF — chỉ cho phép kết nối tới localhost
    checkDbHostWhitelist($host_input, $allowed_db_hosts);

    // Decode base64 queries nếu có, giới hạn số lượng
    if (isset($_POST["encodeBase64"]) && $_POST["encodeBase64"] == '1') {
        if (isset($_POST["q"]) && is_array($_POST["q"])) {
            $_POST["q"] = array_slice($_POST["q"], 0, $max_queries_per_request);
            foreach ($_POST["q"] as $k => $v) {
                $_POST["q"][$k] = base64_decode($v);
            }
        }
    }

    if (!function_exists("mysql_connect") && !function_exists("mysqli_connect")) {
        EchoHeader(203);
        echo GetBlock("MySQL not supported on the server");
        exit();
    }

    $errno_c  = 0;
    $hs       = $host_input;
    $db_input = isset($_POST["db"]) ? $_POST["db"] : '';

    // ----------------------------------------------------------
    // mysqli branch (PHP 5+)
    // ----------------------------------------------------------
    if ($use_mysqli) {
        mysqli_report(MYSQLI_REPORT_OFF);

        $port_val = ($port_input !== '') ? intval($port_input) : null;
        if ($port_val !== null)
            $conn = mysqli_connect($hs, $_POST["login"], $_POST["password"], '', $port_val);
        else
            $conn = mysqli_connect($hs, $_POST["login"], $_POST["password"]);

        $errno_c = mysqli_connect_errno();
        if ($errno_c > 0) {
            EchoHeader($errno_c);
            echo GetBlock(mysqli_connect_error());
            exit;
        }

        if (phpversion_int() >= 50005)
            mysqli_set_charset($conn, 'UTF8');

        if (($errno_c <= 0) && ($db_input != "")) {
            mysqli_select_db($conn, $db_input);
            $errno_c = mysqli_errno($conn);
        }

        EchoHeader($errno_c);
        if ($errno_c > 0) {
            echo GetBlock(mysqli_error($conn));
        } elseif ($actn == "C") {
            EchoConnInfo($conn);
        } elseif ($actn == "Q") {
            $queries = (isset($_POST["q"]) && is_array($_POST["q"]))
                ? array_slice($_POST["q"], 0, $max_queries_per_request)
                : [];
            $count = count($queries);

            for ($i = 0; $i < $count; $i++) {
                $query = $queries[$i];
                if ($query == "") continue;

                if (phpversion_int() < 50400 && get_magic_quotes_gpc())
                    $query = stripslashes($query);

                mysqli_real_query($conn, $query);
                $res = false;
                if (mysqli_field_count($conn))
                    $res = mysqli_store_result($conn);

                $errno        = mysqli_errno($conn);
                $affectedrows = mysqli_affected_rows($conn);
                $insertid     = mysqli_insert_id($conn);

                if (false !== $res) {
                    $numfields = mysqli_field_count($conn);
                    $numrows   = mysqli_num_rows($res);
                } else {
                    $numfields = 0;
                    $numrows   = 0;
                }

                EchoResultSetHeader($errno, $affectedrows, $insertid, $numfields, $numrows);
                if ($errno > 0) {
                    echo GetBlock(mysqli_error($conn));
                } else {
                    if ($numfields > 0) {
                        EchoFieldsHeader($res, $numfields);
                        EchoData($res, $numfields, $numrows);
                    } else {
                        echo GetBlock(phpversion_int() >= 40300 ? mysqli_info($conn) : "");
                    }
                }

                echo ($i < ($count - 1)) ? "\x01" : "\x00";
                if (false !== $res) mysqli_free_result($res);
            }
        }

    // ----------------------------------------------------------
    // mysql branch (PHP 4 legacy)
    // ----------------------------------------------------------
    } else {
        if ($port_input !== '') $hs .= ":" . intval($port_input);

        $conn    = mysql_connect($hs, $_POST["login"], $_POST["password"]);
        $errno_c = mysql_errno();

        if (phpversion_int() >= 50203)
            mysql_set_charset('UTF8', $conn);

        if (($errno_c <= 0) && ($db_input != "")) {
            mysql_select_db($db_input, $conn);
            $errno_c = mysql_errno();
        }

        EchoHeader($errno_c);
        if ($errno_c > 0) {
            echo GetBlock(mysql_error());
        } elseif ($actn == "C") {
            EchoConnInfo($conn);
        } elseif ($actn == "Q") {
            $queries = (isset($_POST["q"]) && is_array($_POST["q"]))
                ? array_slice($_POST["q"], 0, $max_queries_per_request)
                : [];
            $count = count($queries);

            for ($i = 0; $i < $count; $i++) {
                $query = $queries[$i];
                if ($query == "") continue;

                if (phpversion_int() < 50400 && get_magic_quotes_gpc())
                    $query = stripslashes($query);

                $res          = mysql_query($query, $conn);
                $errno        = mysql_errno();
                $affectedrows = mysql_affected_rows($conn);
                $insertid     = mysql_insert_id($conn);
                $numfields    = ($res !== false) ? mysql_num_fields($res) : 0;
                $numrows      = ($res !== false) ? mysql_num_rows($res)   : 0;

                EchoResultSetHeader($errno, $affectedrows, $insertid, $numfields, $numrows);
                if ($errno > 0) {
                    echo GetBlock(mysql_error());
                } else {
                    if ($numfields > 0) {
                        EchoFieldsHeader($res, $numfields);
                        EchoData($res, $numfields, $numrows);
                    } else {
                        echo GetBlock(phpversion_int() >= 40300 ? mysql_info($conn) : "");
                    }
                }

                echo ($i < ($count - 1)) ? "\x01" : "\x00";
                if ($res !== false) mysql_free_result($res);
            }
        }
    }

    exit();
}


// ============================================================
// TEST MENU — chỉ hiển thị khi $allowTestMenu = true
// Không bao giờ để true trên production
// ============================================================

header("Content-Type: text/html");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Navicat HTTP Tunnel Tester</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <style type="text/css">
        body { margin:30px; font-family:Tahoma; font-weight:normal; font-size:14px; color:#222222; }
        table { width:100%; border:0px; }
        input { font-family:Tahoma,sans-serif; border-style:solid; border-color:#666666; border-width:1px; }
        fieldset { border-style:solid; border-color:#666666; border-width:1px; }
        .Title1  { font-size:30px; color:#003366; }
        .Title2  { font-size:10px; color:#999966; }
        .TestDesc { width:70% }
        .TestSucc { color:#00BB00; }
        .TestFail { color:#DD0000; }
        .mysql  {}
        .pgsql  { display:none; }
        .sqlite { display:none; }
        #page   { max-width:42em; min-width:36em; border-width:0px; margin:auto auto; }
        #host, #dbfile { width:300px; }
        #port   { width:75px; }
        #login, #password, #db { width:150px; }
        #Copyright { text-align:right; font-size:10px; color:#888888; }
    </style>
    <script type="text/javascript">
        function getInternetExplorerVersion() {
            var ver = -1;
            if (navigator.appName == "Microsoft Internet Explorer") {
                var regex = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
                if (regex.exec(navigator.userAgent)) ver = parseFloat(RegExp.$1);
            }
            return ver;
        }
        function setText(element, text, succ) {
            element.className = (succ) ? "TestSucc" : "TestFail";
            element.innerHTML = text;
        }
        function getByteAt(str, offset) { return str.charCodeAt(offset) & 0xff; }
        function getIntAt(binStr, offset) {
            return (getByteAt(binStr, offset) << 24) +
                   (getByteAt(binStr, offset+1) << 16) +
                   (getByteAt(binStr, offset+2) << 8) +
                   (getByteAt(binStr, offset+3) >>> 0);
        }
        function getBlockStr(binStr, offset) {
            if (getByteAt(binStr, offset) < 254)
                return binStr.substring(offset+1, offset+1+binStr.charCodeAt(offset));
            else
                return binStr.substring(offset+5, offset+5+getIntAt(binStr, offset+1));
        }
        function doServerTest() {
            var version = getInternetExplorerVersion();
            if (version == -1 || version >= 9.0) {
                var xmlhttp = (window.XMLHttpRequest)
                    ? new XMLHttpRequest()
                    : new ActiveXObject("Microsoft.XMLHTTP");

                xmlhttp.onreadystatechange = function() {
                    var outputDiv = document.getElementById("ServerTest");
                    if (xmlhttp.readyState == 4) {
                        if (xmlhttp.status == 200) {
                            var errno = getIntAt(xmlhttp.responseText, 6);
                            if (errno == 0)
                                setText(outputDiv, "Connection Success!", true);
                            else
                                setText(outputDiv, parseInt(errno) + " - " + getBlockStr(xmlhttp.responseText, 16), false);
                        } else {
                            setText(outputDiv, "HTTP Error - " + xmlhttp.status, false);
                        }
                    }
                };

                var params = "";
                var form = document.getElementById("TestServerForm");
                for (var i = 0; i < form.elements.length; i++) {
                    if (i > 0) params += "&";
                    // [SEC-10] encodeURIComponent — encode đúng toàn bộ ký tự đặc biệt
                    params += encodeURIComponent(form.elements[i].id) + "=" +
                              encodeURIComponent(form.elements[i].value);
                }

                document.getElementById("ServerTest").className = "";
                document.getElementById("ServerTest").innerHTML = "Connecting...";
                xmlhttp.open("POST", "", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.setRequestHeader("Content-length", params.length);
                xmlhttp.setRequestHeader("Connection", "close");
                xmlhttp.send(params);
            } else {
                document.getElementById("ServerTest").className = "";
                document.getElementById("ServerTest").innerHTML =
                    "Internet Explorer " + version + " is not supported, " +
                    "please use Internet Explorer 9.0 or above, Firefox, Chrome or Safari";
            }
        }
    </script>
</head>
<body>
    <div id="page">
        <p>
            <font class="Title1">Navicat&trade;</font><br>
            <font class="Title2">The gateway to your database!</font>
        </p>
        <fieldset>
            <legend>System Environment Test</legend>
            <table>
                <tr style="<?php echo "display:none"; ?>">
                    <td width="70%">PHP installed properly</td>
                    <td class="TestFail">No</td>
                </tr>
                <?php doSystemTest(); ?>
            </table>
        </fieldset>
        <br>
        <fieldset>
            <legend>Server Test</legend>
            <form id="TestServerForm" action="#" onsubmit="return false;">
                <input type="hidden" id="actn" value="C">
                <table>
                    <tr class="mysql">
                        <td width="35%">Hostname/IP Address:</td>
                        <td><input type="text" id="host" placeholder="localhost"></td>
                    </tr>
                    <tr class="mysql">
                        <td>Port:</td>
                        <td><input type="text" id="port" placeholder="3306"></td>
                    </tr>
                    <tr class="pgsql">
                        <td>Initial Database:</td>
                        <td><input type="text" id="db" placeholder="template1"></td>
                    </tr>
                    <tr class="mysql">
                        <td>Username:</td>
                        <td><input type="text" id="login" placeholder="root"></td>
                    </tr>
                    <tr class="mysql">
                        <td>Password:</td>
                        <td><input type="password" id="password" placeholder=""></td>
                    </tr>
                    <tr class="sqlite">
                        <td>Database File:</td>
                        <td><input type="text" id="dbfile" placeholder="sqlite.db"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><br><input id="TestButton" type="submit" value="Test Connection" onclick="doServerTest()"></td>
                    </tr>
                </table>
            </form>
            <div id="ServerTest"><br></div>
        </fieldset>
        <p id="Copyright">Copyright &copy; PremiumSoft&trade; CyberTech Ltd. All Rights Reserved.</p>
    </div>
</body>
</html>
