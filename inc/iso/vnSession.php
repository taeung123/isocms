<?
/*======================================================================*\
|| #################################################################### ||
|| # The Session Manual of the ISOCMS                                 # ||
|| # ISOCMS 6.0.0 By Luong Tien Dung (luongtiendung@gmail.com)        # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
class vnSession implements SessionHandlerInterface
{
    protected $dbConnection;
    protected $dbTable;

    public function setDbDetails($dbHost, $dbUser, $dbPassword, $dbDatabase)
    {
        $this->dbConnection = new mysqli($dbHost, $dbUser, $dbPassword, $dbDatabase);
        if ($this->dbConnection->connect_error) {
            throw new Exception('Connect Error (' . $this->dbConnection->connect_errno . ') ' . $this->dbConnection->connect_error);
        }
    }

    public function setDbConnection($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function setDbTable($dbTable)
    {
        $this->dbTable = $dbTable;
    }

    // === PHP 8: BẮT BUỘC ===
    public function open($savePath, $sessionName): bool
    {
        // Xóa session cũ mỗi ngày (24h)
        $limit = time() - (3600 * 24);
        $sql = "DELETE FROM `{$this->dbTable}` WHERE `timestamp` < ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return true;
    }

    public function close(): bool
    {
        return true; // Không cần close mysqli ở đây
    }

    public function read($id): string
    {
        $sql = "SELECT `data` FROM `{$this->dbTable}` WHERE `id` = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['data'] ?? '';
        }
        return '';
    }

    public function write($id, $data): bool
    {
        global $core;
        $user_id = $core->_SESS->user_id ?? 0;
        $site_root = defined('_SITE_ROOT') ? _SITE_ROOT : '';
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        $sql = "REPLACE INTO `{$this->dbTable}` 
                (`id`, `data`, `timestamp`, `user_id`, `_site_root`, `_ip`, `browser`) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->dbConnection->prepare($sql);
        $time = time();
        $stmt->bind_param("ssissss", $id, $data, $time, $user_id, $site_root, $ip, $agent);
        return $stmt->execute();
    }

    public function destroy($id): bool
    {
        $sql = "DELETE FROM `{$this->dbTable}` WHERE `id` = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("s", $id);
        return $stmt->execute();
    }

    public function gc($maxlifetime): int
    {
        $old = time() - $maxlifetime;
        $sql = "DELETE FROM `{$this->dbTable}` WHERE `timestamp` < ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("i", $old);
        return $stmt->execute();
    }
}
if (!isset($SESSION_NAME)) {
    $SESSION_NAME = "VNNC";
}
$SESSION_NAME = $SESSION_NAME . "_ISOCMS";
/**
 * Set up session handling
 */
function vnSessionSetup()
{
    global $SESSION_NAME, $SESSION_COOKIE, $SESSION_TIME_OUT;
    $session = new vnSession();
    $session->setDbDetails(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // OR alternatively send a MySQLi ressource
    // $session->setDbConnection($mysqli);
    $session->setDbTable('isosessionhandlertable');
    session_set_save_handler(
        array($session, 'open'),
        array($session, 'close'),
        array($session, 'read'),
        array($session, 'write'),
        array($session, 'destroy'),
        array($session, 'gc')
    );
    // The following prevents unexpected effects when using objects as save handlers.
    register_shutdown_function('session_write_close');
    //phpinfo();
    /*echo "Session save handler: " . ini_get('session.save_handler') . "<br>";
	echo "Session save path: " . ini_get('session.save_path') . "<br>";
	echo "Path exists: " . (is_dir('/home/isocms/tmp') ? 'YES' : 'NO') . "<br>";
	echo "Path writable: " . (is_writable('/home/isocms/tmp') ? 'YES' : 'NO') . "<br>";*/

    session_start();

    /*$_SESSION['test'] = time();
	echo "Session ID: " . session_id() . "<br>";
	echo "Session saved!";*/

    return true;
}
/**
 * Initialise session
 */
function vnSessionInit($_sessid = "")
{
    global $SESSION_NAME;
    return true;
}
/**
 * Get a session variable
 * @param name $ name of the session variable to get
 */
function vnSessionGetVar($name)
{
    global $SESSION_NAME;
    if (isset($_SESSION[$SESSION_NAME . '_' . $name])) {
        return $_SESSION[$SESSION_NAME . '_' . $name];
    }
    return false;
}
/**
 * Determine a session variable is set or not
 * @param name $ name of the session variable
 */
function vnSessionExist($name)
{
    global $SESSION_NAME;
    if (isset($_SESSION[$SESSION_NAME . '_' . $name])) {
        return true;
    }
    return false;
}
/**
 * Set a session variable
 * @param name $ name of the session variable to set
 * @param value $ value to set the named session variable
 */
function vnSessionSetVar($name, $value)
{
    global $SESSION_NAME;
    $_SESSION[$SESSION_NAME . '_' . $name] = $value;
    return true;
}
/**
 * Delete a session variable
 * @param name $ name of the session variable to delete
 */
function vnSessionDelVar($name)
{
    global $SESSION_NAME;
    $_SESSION[$SESSION_NAME . '_' . $name] = '';
    unset($_SESSION[$SESSION_NAME . '_' . $name]);
    unset($GLOBALS[$SESSION_NAME . '_' . $name]);
    return true;
}
if (!function_exists('redirect')) {
    function redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }
}
