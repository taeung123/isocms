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
class vnSession{
    /**
     * a database MySQLi connection resource
     * @var resource
     */
    protected $dbConnection;
    /**
     * the name of the DB table which handles the sessions
     * @var string
     */
    protected $dbTable;
	/**
	 * Set db data if no connection is being injected
	 * @param 	string	$dbHost	
	 * @param	string	$dbUser
	 * @param	string	$dbPassword
	 * @param	string	$dbDatabase
	 */	
	public function setDbDetails($dbHost, $dbUser, $dbPassword, $dbDatabase){
		//create db connection
		$this->dbConnection = new mysqli($dbHost, $dbUser, $dbPassword, $dbDatabase);
		//check connection
		if (mysqli_connect_error()) {
		    throw new Exception('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}//if
	}//function
	/**
	 * Inject DB connection from outside
	 * @param 	object	$dbConnection	expects MySQLi object
	 */
	public function setDbConnection($dbConnection){
		$this->dbConnection = $dbConnection;
	}
	/**
	 * Inject DB connection from outside
	 * @param 	object	$dbConnection	expects MySQLi object
	 */
	public function setDbTable($dbTable){
		$this->dbTable = $dbTable;
	}
    /**
     * Open the session
     * @return bool
     */
    public function open() {
        //delete old session handlers
        $limit = time() - (3600 * 24);
        $sql = sprintf("DELETE FROM %s WHERE timestamp < %s", $this->dbTable, $limit);
        return $this->dbConnection->query($sql);
    }
    /**
     * Close the session
     * @return bool
     */
    public function close() {
        return $this->dbConnection->close();
    }
    /**
     * Read the session
     * @param int session id
     * @return string string of the sessoin
     */
    public function read($id) {
        $sql = sprintf("SELECT data FROM %s WHERE id = '%s'", $this->dbTable, $this->dbConnection->escape_string($id));
        if ($result = $this->dbConnection->query($sql)) {
            if ($result->num_rows && $result->num_rows > 0) {
                $record = $result->fetch_assoc();
                return $record['data'];
            } else {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }
    /**
     * Write the session
     * @param int session id
     * @param string data of the session
     */
    public function write($id, $data) {
		global $core;
		if(isset($core->_SESS->user_id)){
			$user_id = $core->_SESS->user_id;
		}
		else{
			$user_id = 0;
		}
        $sql = sprintf("REPLACE INTO %s VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        			   $this->dbTable, 
                       $this->dbConnection->escape_string($id),
                       $this->dbConnection->escape_string($data),
                       time(),
					   $user_id
					   ,_SITE_ROOT
					   ,$_SERVER['REMOTE_ADDR']
					   ,$_SERVER['HTTP_USER_AGENT']
					   );
        return $this->dbConnection->query($sql);
    }
    /**
     * Destoroy the session
     * @param int session id
     * @return bool
     */
    public function destroy($id) {
        $sql = sprintf("DELETE FROM %s WHERE `id` = '%s'", $this->dbTable, $this->dbConnection->escape_string($id));
        return $this->dbConnection->query($sql);
	}
    /**
     * Garbage Collector
     * @param int life time (sec.)
     * @return bool
     * @see session.gc_divisor      100
     * @see session.gc_maxlifetime 1440
     * @see session.gc_probability    1
     * @usage execution rate 1/100
     *        (session.gc_probability/session.gc_divisor)
     */
    public function gc($max) {
        $sql = sprintf("DELETE FROM %s WHERE `timestamp` < '%s'", $this->dbTable, time() - intval($max));
        return $this->dbConnection->query($sql);
    }
}
if (!isset($SESSION_NAME)){
	$SESSION_NAME = "VNNC";
}
$SESSION_NAME = $SESSION_NAME."_ISOCMS";
/**
 * Set up session handling
 */
function vnSessionSetup(){
	global $SESSION_NAME, $SESSION_COOKIE, $SESSION_TIME_OUT;
	$session = new vnSession();
	$session->setDbDetails(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	// OR alternatively send a MySQLi ressource
	// $session->setDbConnection($mysqli);
	$session->setDbTable('isosessionhandlertable');
	session_set_save_handler(array($session, 'open'),
							 array($session, 'close'),
							 array($session, 'read'),
							 array($session, 'write'),
							 array($session, 'destroy'),
							 array($session, 'gc'));
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
function vnSessionInit($_sessid=""){
	global $SESSION_NAME;
    return true;
} 
/**
 * Get a session variable
 * @param name $ name of the session variable to get
 */
function vnSessionGetVar($name){
	global $SESSION_NAME;
    if(isset($_SESSION[$SESSION_NAME.'_'.$name])) {
        return $_SESSION[$SESSION_NAME.'_'.$name];
    }
    return false;
}
/**
 * Determine a session variable is set or not
 * @param name $ name of the session variable
 */
function vnSessionExist($name) {
	global $SESSION_NAME;
	if(isset($_SESSION[$SESSION_NAME.'_'.$name])) {
    return true;
  }
  return false;
}
/**
 * Set a session variable
 * @param name $ name of the session variable to set
 * @param value $ value to set the named session variable
 */
function vnSessionSetVar($name, $value){
	global $SESSION_NAME;
    $_SESSION[$SESSION_NAME.'_'.$name] = $value;
    return true;
} 
/**
 * Delete a session variable
 * @param name $ name of the session variable to delete
 */
function vnSessionDelVar($name){
	global $SESSION_NAME;
	 $_SESSION[$SESSION_NAME.'_'.$name] = '';
    unset($_SESSION[$SESSION_NAME.'_'.$name]);
    unset($GLOBALS[$SESSION_NAME.'_'.$name]);
    return true;
} 
if(!function_exists('redirect')){
	function redirect($url, $permanent = false){
		header('Location: ' . $url, true, $permanent ? 301 : 302);
		exit();
	}
}
?>