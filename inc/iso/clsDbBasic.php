<?php
class DbBasic
{
	public string $pkey = '';
	public string $tbl = '';
	var $arrCond 		= 	array();
	var $arrOperator 	=	array();
	var $arrError 		= 	array();
	var $hasError 		= 	0;
	var $objName		=	"ObjTable";
	var $arrQuery		= 	array();
	var $arrResult		= 	array();
	function __construct() {}
	function updateDataPosition($pvalTable, $direct, $_dataload)
	{
		$one = $this->getOne($pvalTable);
		$pkeyTable = $this->pkey;
		$order_no = $one['order_no'];
		$where = "is_trash=0";
		if ($_dataload != '') {
			$where .= " and " . $_dataload;
		}
		if ($direct == 'up') {
			$lst = $this->getAll($where . " and order_no < $order_no order by order_no desc limit 0,1");
			if ($lst[0][$pkeyTable] != '') {
				$this->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
				$this->updateOne($lst[0][$this->pkey], "order_no='" . $order_no . "'");
			}
		}
		if ($direct == 'down') {
			$lst = $this->getAll($where . " and order_no > $order_no order by order_no asc limit 0,1");
			if ($lst[0][$pkeyTable] != '') {
				$this->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
				$this->updateOne($lst[0][$this->pkey], "order_no='" . $order_no . "'");
			}
		}
		if ($direct == 'bottom') {
			$lst = $this->getAll($where . " and order_no > $order_no order by order_no desc LIMIT 0,1");
			if ($lst[0][$pkeyTable] != '') {
				$this->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
				$lst = $this->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no > $order_no order by order_no DESC");
				for ($i = 0; $i < count($lst); $i++) {
					$this->updateOne($lst[$i][$this->pkey], "order_no='" . ($lst[$i]['order_no'] - 1) . "'");
				}
			}
		}
		if ($direct == 'top') {
			$lst = $this->getAll($where . " and order_no < $order_no order by order_no ASC LIMIT 0,1");
			if ($lst[0][$pkeyTable] != '') {
				$this->updateOne($pvalTable, "order_no='" . $lst[0]['order_no'] . "'");
				$lst = $this->getAll($where . " and $pkeyTable <> '$pvalTable' and order_no < $order_no order by order_no asc");
				for ($i = 0; $i < count($lst); $i++) {
					$this->updateOne($lst[$i][$this->pkey], "order_no='" . ($lst[$i]['order_no'] + 1) . "'");
				}
			}
		}
		return 1;
	}
	function createTableDB($sqlCreate, $sqlInit_f, $sqlInit_v)
	{
		global $dbconn;
		$sqlExist = "SELECT * FROM " . $this->tbl;
		$result =  $dbconn->Execute($sqlExist);
		$tblName = str_replace(DB_PREFIX, '', $this->tbl);
		#
		if (!$result) {
			$sqlCreate = "CREATE TABLE " . DB_PREFIX . $tblName . "(						
						" . $sqlCreate . ",PRIMARY KEY(" . $this->pkey . ")) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
			$dbconn->Execute($sqlCreate);
			/*Create Init Row*/
			if ($sqlInit_f != '' && $sqlInit_v != '')
				$this->insertOne($sqlInit_f, $sqlInit_v);
			return 1;
		} else {
			return 2;
		}
		return 0;
	}

	/**
	 * Lấy ID lớn nhất + 1
	 */
	public function getMaxId(): int
	{
		global $dbconn;
		// Kiểm tra kết nối trước khi chạy
		if (empty($dbconn) || !is_object($dbconn)) {
			throw new Exception("Database connection not initialized in " . __METHOD__);
		}

		$pkey = $this->pkey;
		$sql = "SELECT {$pkey} FROM {$this->tbl} ORDER BY {$pkey} DESC LIMIT 1";

		$row = $dbconn->GetRow($sql);

		// Nếu không có kết quả thì coi như 0
		$maxKey = (isset($row[$pkey]) && is_numeric($row[$pkey])) ? (int)$row[$pkey] : 0;

		return $maxKey + 1;
	}
	public function getMaxOrderNo(): int
	{
		global $dbconn;

		$sql = "SELECT order_no FROM {$this->tbl} ORDER BY order_no DESC LIMIT 1";
		$arrResult = $dbconn->GetAll($sql);

		if (!empty($arrResult) && isset($arrResult[0]['order_no'])) {
			return (int)$arrResult[0]['order_no'] + 1;
		}

		return 1;
	}

	function getOneField($field, $item_id)
	{
		global $dbconn;

		$sql = "SELECT DISTINCT {$field} 
            FROM {$this->tbl} 
            WHERE {$this->pkey} = " . (int)$item_id . " 
            LIMIT 1";

		$row = $dbconn->GetRow($sql);

		return $row[$field] ?? false;
	}


	function getImageUrl($_pval)
	{
		return $this->getOneField('image', $_pval);
	}

	//Set debug mode On/Off
	function SetDebug($debug = true)
	{
		global $dbconn;
		$dbconn->debug = $debug;
	}
	//set condition $cond + $operator(AND, OR)
	function SetCond($cond, $operator = "")
	{
		array_push($this->arrCond, $cond);
		array_push($this->arrOperator, $operator);
	}
	//get contition string

	function GetCond()
	{
		$condStr = "";
		if (is_array($this->arrCond)) {
			foreach ($this->arrCond as $key => $val) {
				$condStr .= " $val " . $this->arrOperator[$key];
			}
		}
		return $condStr;
	}
	//empty condition
	function EmptyCond()
	{
		$this->arrCond = array();
	}

	function SelectOne($_pkey = "")
	{
		global $dbconn;

		// --- Lấy điều kiện ---
		$cond = $this->getCond();
		if ($cond === "") {
			$pkey = $this->pkey;
			$pkeyvalue = trim($_pkey);
			if ($pkeyvalue !== "") {
				$cond = "$pkey = '" . addslashes($pkeyvalue) . "'";
			}
		}

		// --- Khởi tạo where ---
		$where = $cond !== "" ? "WHERE $cond" : "";

		// --- Câu truy vấn ---
		$sql = "SELECT * FROM {$this->tbl} $where LIMIT 1";

		// --- Thực thi truy vấn ---
		$rs = $dbconn->Execute($sql);
		$obj = null;

		if ($rs && $rs->RecordCount() > 0) {
			$arr = $rs->FetchRow();
			if (is_array($arr) && class_exists($this->objName)) {
				$obj = new $this->objName();
				foreach ($arr as $key => $val) {
					if (method_exists($obj, 'set')) {
						$obj->set($key, $val);
					}
				}
			}
		}

		return $obj;
	}

	//Select All
	function SelectAll($orderby = "", $start = 0, $limit = 0)
	{
		global $dbconn;

		// --- Lấy điều kiện ---
		$cond = $this->getCond();
		$where = $cond !== "" ? "WHERE $cond" : "";

		// --- Order & Limit ---
		$orderby = $orderby !== "" ? "ORDER BY $orderby" : "";
		$limitClause = ($limit > 0) ? "LIMIT " . intval($start) . ", " . intval($limit) : "";

		// --- Câu truy vấn ---
		$sql = "SELECT * FROM {$this->tbl} $where $orderby $limitClause";

		// --- Thực thi ---
		$rs = $dbconn->Execute($sql);
		$arrObj = [];

		if ($rs) {
			while ($arr = $rs->FetchRow()) {
				if (class_exists($this->objName)) {
					$obj = new $this->objName();
					foreach ($arr as $key => $val) {
						if (method_exists($obj, 'set')) {
							$obj->set($key, $val);
						}
					}
					$arrObj[] = $obj;
				}
			}
		}

		return $arrObj;
	}

	//Insert obj
	function insert_query($objTable)
	{
		global $dbconn;

		if (!is_object($objTable)) {
			trigger_error("insert_query() expects an object.", E_USER_WARNING);
			return 0;
		}

		$class_vars = get_object_vars($objTable);
		$fields = [];
		$values = [];

		foreach ($class_vars as $name => $value) {
			$fields[] = $name;
			$values[] = "'" . addslashes($value) . "'";
		}

		$sql = "INSERT INTO {$this->tbl} (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ")";

		if (!$dbconn->Execute($sql)) {
			trigger_error("Cannot run SQL: `$sql`", E_USER_ERROR);
			return 0;
		}

		return 1;
	}

	//Update obj
	function update_query($objTable)
	{
		global $dbconn;

		if (!is_object($objTable)) {
			trigger_error("update_query() expects an object.", E_USER_WARNING);
			return 0;
		}

		$class_vars = get_object_vars($objTable);
		$setParts = [];

		foreach ($class_vars as $name => $value) {
			$setParts[] = "$name = '" . addslashes($value) . "'";
		}

		$setClause = implode(", ", $setParts);

		// --- Lấy điều kiện ---
		$cond = $this->getCond();
		if ($cond === "") {
			$pkey = $this->pkey;
			$pkeyvalue = $objTable->$pkey ?? "";
			$cond = ($pkeyvalue !== "") ? "$pkey = '" . addslashes($pkeyvalue) . "'" : "";
		}

		$where = $cond !== "" ? "WHERE $cond" : "";

		$sql = "UPDATE {$this->tbl} SET $setClause $where";

		if (!$dbconn->Execute($sql)) {
			trigger_error("Cannot run SQL: `$sql`", E_USER_ERROR);
			return 0;
		}

		return 1;
	}

	//Delete obj
	function delete_query()
	{
		global $dbconn;

		$cond = $this->getCond();
		$where = $cond !== "" ? "WHERE $cond" : "";

		$sql = "DELETE FROM {$this->tbl} $where";

		if (!$dbconn->Execute($sql)) {
			trigger_error("Cannot run SQL: `$sql`", E_USER_ERROR);
			return 0;
		}

		return 1;
	}

	function Count($cond = "")
	{
		global $dbconn;

		// --- Ưu tiên điều kiện truyền vào, nếu rỗng thì lấy từ getCond() ---
		$condition = $cond ?: $this->getCond();
		$where = $condition !== "" ? "WHERE $condition" : "";

		$sql = "SELECT COUNT(1) AS total FROM {$this->tbl} $where";
		$res = $dbconn->GetRow($sql);

		$total = $res['total'] ?? 0;
		return (int)$total;
	}

	function Max($field, $cond = "")
	{
		global $dbconn;

		// --- Ưu tiên điều kiện truyền vào, nếu rỗng thì lấy từ getCond() ---
		$condition = $cond ?: $this->getCond();
		$where = $condition !== "" ? "WHERE $condition" : "";

		$sql = "SELECT MAX($field) AS total FROM {$this->tbl} $where";
		$res = $dbconn->GetRow($sql);

		$maxVal = $res['total'] ?? 0;
		return (int)$maxVal + 1; // giữ nguyên logic +1 của bản gốc
	}

	function Sum($field, $cond = "")
	{
		global $dbconn;

		// --- Ưu tiên điều kiện truyền vào, nếu rỗng thì lấy từ getCond() ---
		$condition = $cond ?: $this->getCond();
		$where = $condition !== "" ? "WHERE $condition" : "";

		$sql = "SELECT SUM($field) AS total FROM {$this->tbl} $where";
		$res = $dbconn->GetRow($sql);

		$sumVal = $res['total'] ?? 0;
		return (float)$sumVal;
	}

	//Execute a sql
	function ExecSql($sql)
	{
		global $dbconn;
		return $dbconn->Execute($sql);
	}

	function checkColumnInTable($column_name)
	{
		global $dbconn;

		// Escape tên cột để tránh SQL injection
		$column_name = trim($column_name);
		if ($column_name === '') {
			return 0;
		}

		$sql = "SHOW COLUMNS FROM `{$this->tbl}` LIKE " . $dbconn->qstr($column_name);
		$lstTbl = $dbconn->GetAll($sql);

		// ADODB thường trả về mảng dạng kết hợp, nên nên kiểm tra key 'Field'
		if (!empty($lstTbl) && isset($lstTbl[0]['Field']) && $lstTbl[0]['Field'] === $column_name) {
			return 1;
		}

		return 0;
	}

	function getAll($cond = "", $field = "*")
	{
		global $dbconn, $_LANG_ID;

		$stime = microtime(true);
		$where = "";

		if (defined('MULTIPLE_LANG') && MULTIPLE_LANG) {
			if ($this->checkColumnInTable('lang_id')) {
				$clsConfiguration = new Configuration();
				$SiteDefaultLanguage = $clsConfiguration->getValue('SiteDefaultLanguage', LANG_DEFAULT);
				if (!empty($_LANG_ID) && $_LANG_ID != $SiteDefaultLanguage) {
					$where = " WHERE lang_id=" . $dbconn->qstr($_LANG_ID);
				} 
				else {
					$where = " WHERE lang_id=" .$dbconn->qstr($SiteDefaultLanguage);
				}
			}
		}

		if (!empty($cond)) {
			$where .= ($where ? " AND " : " WHERE ") . $cond;
		}

		$sql = "SELECT {$field} FROM {$this->tbl} {$where}";
		$this->arrResult = $dbconn->GetAll($sql);

		$time = microtime(true) - $stime;
		ObjQuery::addQuery([
			'query' => $sql,
			'time'  => $time,
		]);

		return !empty($this->arrResult) ? $this->arrResult : [];
	}


	function getAllOptimize($cond = "", $innerjoin = "", $field = "*", $debug = false)
	{
		global $dbconn, $_LANG_ID;

		$stime = microtime(true);
		$whereParts = [];

		if (defined('MULTIPLE_LANG') && MULTIPLE_LANG) {
			if ($this->checkColumnInTable('lang_id')) {
				$clsConfiguration = new Configuration();
				$SiteDefaultLanguage = $clsConfiguration->getValue('SiteDefaultLanguage', LANG_DEFAULT);

				if (!empty($_LANG_ID) && $_LANG_ID != $SiteDefaultLanguage) {
					$whereParts[] = "{$this->tbl}.lang_id=" . $dbconn->qstr($_LANG_ID);
				} else {
					$whereParts[] = "{$this->tbl}.lang_id=" . $dbconn->qstr($SiteDefaultLanguage);
				}
			}
		}

		if (!empty($cond)) {
			$whereParts[] = $cond;
		}

		$sql = "SELECT {$field} FROM {$this->tbl}";
		if (!empty($innerjoin)) {
			$sql .= " INNER JOIN {$innerjoin}";
		}

		if (!empty($whereParts)) {
			$sql .= " WHERE " . implode(" AND ", $whereParts);
		}

		$this->arrResult = $dbconn->GetAll($sql);

		$time = microtime(true) - $stime;
		ObjQuery::addQuery([
			'query' => $sql,
			'time'  => $time,
		]);

		if ($debug) {
			echo "<pre>SQL: {$sql}</pre>";
		}

		return !empty($this->arrResult) ? $this->arrResult : [];
	}

	function tokenizeOrderby($input, $default_ordering = "ASC")
	{
		$default_ordering = strtoupper(trim($default_ordering));
		if (!in_array($default_ordering, ['ASC', 'DESC'])) {
			$default_ordering = 'ASC';
		}

		$tokenizedFields = [];
		$fields = explode(',', $input);

		foreach ($fields as $field) {
			$field = trim($field);
			if ($field === '') continue;

			// Tách field và thứ tự (ASC/DESC)
			$parts = preg_split('/\s+/', $field);
			$column = $parts[0];
			$order = isset($parts[1]) ? strtoupper(trim($parts[1])) : $default_ordering;

			if (!in_array($order, ['ASC', 'DESC'])) {
				$order = $default_ordering;
			}

			// Làm sạch cột (chỉ giữ ký tự, số, dấu chấm, gạch dưới)
			$column = preg_replace('/[^a-zA-Z0-9_\.]/', '', $column);

			// Nếu có dạng table.field thì tách và thêm ``
			if (strpos($column, '.') !== false) {
				list($table, $col) = explode('.', $column, 2);
				$safeField = "`{$table}`.`{$col}`";
			} else {
				$safeField = "`{$column}`";
			}

			$tokenizedFields[] = "{$safeField} {$order}";
		}

		return $tokenizedFields;
	}

	function getOne($_pkey = "", $field = "*")
	{
		global $dbconn;

		// Bắt đầu đo thời gian
		$stime = microtime(true);

		// Escape khóa chính để tránh lỗi SQL injection
		$_pkey = addslashes($_pkey ?? '');

		$sql = "SELECT {$field} FROM {$this->tbl} WHERE {$this->pkey}='{$_pkey}'";
		$result = $dbconn->GetRow($sql);

		// Tính thời gian thực thi
		$time = microtime(true) - $stime;

		// Ghi log nếu class ObjQuery tồn tại
		if (class_exists('ObjQuery')) {
			ObjQuery::addQuery([
				'query' => $sql,
				'time'  => $time,
			]);
		}

		return !empty($result) ? $result : [];
	}

	function getByCond($cond = "", $field = "*")
	{
		global $dbconn, $_LANG_ID;

		$stime = microtime(true);
		$whereParts = [];

		// Multiple language
		if (defined('MULTIPLE_LANG') && MULTIPLE_LANG) {
			if ($this->checkColumnInTable('lang_id')) {
				$clsConfiguration = new Configuration();
				$SiteDefaultLanguage = $clsConfiguration->getValue('SiteDefaultLanguage', LANG_DEFAULT);

				if (!empty($_LANG_ID) && $_LANG_ID != $SiteDefaultLanguage) {
					$whereParts[] = "lang_id='{$_LANG_ID}'";
				} else {
					$whereParts[] = "lang_id='{$SiteDefaultLanguage}'";
				}
			}
		}

		// Điều kiện truyền vào
		if (!empty($cond)) {
			$whereParts[] = $cond;
		}

		// Ghép mệnh đề WHERE
		$where = "";
		if (!empty($whereParts)) {
			$where = " WHERE " . implode(" AND ", $whereParts);
		}

		$sql = "SELECT {$field} FROM {$this->tbl} {$where}";
		$result = $dbconn->GetRow($sql);

		$time = microtime(true) - $stime;

		if (class_exists('ObjQuery')) {
			ObjQuery::addQuery([
				'query' => $sql,
				'time'  => $time,
			]);
		}

		return !empty($result) ? $result : [];
	}

	function _array_to_string(array $datastore, string $paid = ','): string
	{
		global $dbconn;

		$setParts = [];
		foreach ($datastore as $key => $value) {
			// Bỏ qua key trống hoặc giá trị là mảng
			if ($key === '' || is_array($value)) {
				continue;
			}

			// Escape giá trị để chống SQL Injection
			$safeValue = $dbconn->qstr($value);

			// Kiểm tra nếu key chứa "OR" thì không thêm dấu nối
			if (stripos($key, 'OR') !== false) {
				$setParts[] = sprintf("%s=%s", $key, $safeValue);
			} else {
				$setParts[] = sprintf("%s=%s", $key, $safeValue);
			}
		}

		// Ghép chuỗi bằng ký tự nối (mặc định ",")
		return implode($paid, $setParts);
	}

	//Insert// Thêm mới bản ghi
	function insert($datastore = array()){
    global $dbconn, $_LANG_ID, $mod, $act;
    if (empty($datastore)) return false;
    // Xử lý MULTI-LANG
    if (defined('MULTIPLE_LANG') && MULTIPLE_LANG && $this->checkColumnInTable('lang_id')) {
            $clsConfiguration = new Configuration();
            $SiteDefaultLanguage = $clsConfiguration->getValue('SiteDefaultLanguage', LANG_DEFAULT);
            if ($_LANG_ID != $SiteDefaultLanguage && $_LANG_ID != '') {
                    $datastore['lang_id'] = $_LANG_ID;
            } else {
                    $datastore['lang_id'] = $SiteDefaultLanguage;
            }
    }
    if ($this->checkColumnInTable('spam_mod_page')) {
            $datastore['spam_mod_page'] = $mod;
    }
    if ($this->checkColumnInTable('spam_act_page')) {
            $datastore['spam_act_page'] = $act;
    }
    $fields       = array_keys($datastore);
    $placeholders = array_fill(0, count($fields), '?');
    $sql = "INSERT INTO `{$this->tbl}` (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";
    $values = array_values($datastore);
    try {
        $stmt   = $dbconn->Prepare($sql);           // Chuẩn bị Prepared Statement
        $result = $dbconn->Execute($stmt, $values); // Truyền mảng giá trị
        return ($result) ? 1 : 0;
    } catch (Exception $e) {
        error_log("INSERT Error [{$this->tbl}]: " . $e->getMessage());
        return false;
    }
}

	// Thêm bản ghi với chuỗi fields/values
	function insertOne($fields = "", $values = "")
	{
		global $dbconn, $_LANG_ID;
		if (defined('MULTIPLE_LANG') && MULTIPLE_LANG && $this->checkColumnInTable('lang_id')) {
			$clsConfiguration = new Configuration();
			$SiteDefaultLanguage = $clsConfiguration->getValue('SiteDefaultLanguage', LANG_DEFAULT);
			if ($_LANG_ID != $SiteDefaultLanguage && $_LANG_ID != '') {
				$fields .= ",lang_id";
				$values .= ",'{$_LANG_ID}'";
			} else {
				$fields .= ",lang_id";
				$values .= ",'{$SiteDefaultLanguage}'";
			}
		}
		$sql = "INSERT INTO {$this->tbl} ({$fields}) VALUES ({$values})";
		try {
			return $dbconn->Execute($sql) ? 1 : 0;
		} catch (Exception $e) {
			return false;
		}
	}

	// Cập nhật theo mảng dữ liệu
	function update($_pkey, $datastore = array())
	{
		global $dbconn;
		if ((int)$_pkey == 0 || empty($datastore)) return false;
		return $dbconn->autoExecute($this->tbl, $datastore, 'UPDATE', "{$this->pkey}='{$_pkey}'");
	}

	// Cập nhật 1 bản ghi với điều kiện
	function updateOne($_pkey = "", $set = "", $debug = false)
	{
		global $dbconn;
		if ($_pkey == 0 || empty($set)) return false;

		if (is_array($set)) {
			$sql = "UPDATE {$this->tbl} SET " . $this->_array_to_string($set) . " WHERE {$this->pkey}='{$_pkey}'";
		} else {
			$sql = "UPDATE {$this->tbl} SET {$set} WHERE {$this->pkey}='{$_pkey}'";
		}

		if ($debug) return $sql;

		try {
			return $dbconn->Execute($sql) ? 1 : 0;
		} catch (Exception $e) {
			return false;
		}
	}
	//Update by condition
	// Update theo điều kiện
	function updateByCond($cond = "", $set = "")
	{
		global $dbconn;

		$where = "";
		if (!empty($cond)) {
			$where = " WHERE {$cond}";
		}

		$sql = "UPDATE {$this->tbl} SET {$set}{$where}";
		try {
			return $dbconn->Execute($sql) ? 1 : 0;
		} catch (Exception $e) {
			return false;
		}
	}

	// Delete theo mảng điều kiện (key => value)
	function delete($datastore = array())
	{
		global $dbconn, $core;

		if (empty($datastore)) return false;

		$whereParts = [];
		foreach ($datastore as $key => $value) {
			$whereParts[] = "{$key}=" . $dbconn->qstr($value);
		}
		$where = implode(' AND ', $whereParts);

		// Lấy dữ liệu trước khi xóa (phục vụ log)
		$sqlSelect = "SELECT * FROM {$this->tbl} WHERE {$where}";
		$dataDelete = $dbconn->GetAll($sqlSelect);

		$sql = "DELETE FROM {$this->tbl} WHERE {$where}";

		try {
			if ($dbconn->Execute($sql)) {

				// Ghi log (giống deleteOne)
				if (!empty($dataDelete)) {
					$_loged_id = $core->_SESS->user_id;

					$clsLog = new Log();
					$clsLog->logAction(
						$this->tbl,
						'delete_database',
						$_loged_id,
						$dataDelete
					);
				}

				return 1;
			}

			return 0;
		} catch (Exception $e) {
			return false;
		}
	}

	// Delete theo khóa chính
	function deleteOne($_pkey = "")
	{
		global $dbconn, $clsISO, $core;
		#check vaidate parameter
		if ($_pkey == 0) return;
		$_loged_id = $core->_SESS->user_id;
		$dataDelete = $this->getOne($_pkey);

		$sql = "DELETE FROM " . $this->tbl . " WHERE {$this->pkey}='{$_pkey}'";
		try {
			if ($dbconn->Execute($sql)) {
				$clsLog = new Log();
				$clsLog->logAction($this->tbl, 'delete_database', $_loged_id, $dataDelete);
				return 1;
			}
			return 0;
		} catch (Exception $e) {
			trigger_error('Error: ' . $e->getMessage(), E_USER_ERROR);
		}
	}

	// Delete theo điều kiện tùy chọn
	function deleteByCond($cond = "")
	{
		global $dbconn, $core;

		$where = "";
		if (!empty($cond)) {
			$where = " WHERE {$cond}";
		}

		// Lấy dữ liệu trước khi xóa
		$sqlSelect = "SELECT * FROM {$this->tbl}{$where}";
		$dataDelete = $dbconn->GetAll($sqlSelect);

		$sql = "DELETE FROM {$this->tbl}{$where}";

		try {
			if ($dbconn->Execute($sql)) {

				// Ghi log
				if (!empty($dataDelete)) {
					$_loged_id = $core->_SESS->user_id;

					$clsLog = new Log();
					$clsLog->logAction(
						$this->tbl,
						'delete_database',
						$_loged_id,
						$dataDelete
					);
				}

				return 1;
			}

			return 0;
		} catch (Exception $e) {
			return false;
		}
	}

	// Đếm số lượng bản ghi theo điều kiện
	function countItem($cond = "")
	{
		global $dbconn, $_LANG_ID;

		$sql = "SELECT COUNT(*) AS totalitem FROM {$this->tbl}";
	
		$where = [];
		if (!empty($cond)) {
			$where[] = "({$cond})";
		}

		if (defined('MULTIPLE_LANG') && MULTIPLE_LANG && $this->checkColumnInTable('lang_id')) {
			$lang = ($_LANG_ID == "en") ? "" : $_LANG_ID;
			$where[] = "lang_id = " . $dbconn->qstr($lang);
		}

		if (!empty($where)) {
			$sql .= " WHERE " . implode(" AND ", $where);
		}

		$row = $dbconn->GetRow($sql);
		return !empty($row) ? (int)$row['totalitem'] : 0;
	}

	// Lấy giá trị MAX của 1 trường, thường dùng để tính id kế tiếp
	function maxItem($field, $cond = "")
	{
		global $dbconn;

		$sql = "SELECT MAX({$field}) AS total FROM {$this->tbl}";
		if (!empty($cond)) {
			$sql .= " WHERE {$cond}";
		}

		$row = $dbconn->GetRow($sql);
		if (empty($row['total'])) {
			return 1;
		}
		return ((int)$row['total'] + 1);
	}

	// Tính tổng 1 cột theo điều kiện
	function sumItem($field, $cond = "")
	{
		global $dbconn;

		$sql = "SELECT SUM({$field}) AS total FROM {$this->tbl}";
		if (!empty($cond)) {
			$sql .= " WHERE {$cond}";
		}

		$row = $dbconn->GetRow($sql);
		return !empty($row['total']) ? (float)$row['total'] : 0;
	}

	// Lấy giá trị của 1 field từ pkey
	function getByField($pkey, $field)
	{
		$row = $this->getOne($pkey);
		return isset($row[$field]) ? $row[$field] : null;
	}
}
class ObjTable
{
	function __construct() {}
	function set($field, $value)
	{
		$this->$field = $value;
	}
	function get($field)
	{
		return $this->$field;
	}
}
class ObjQuery
{
	public static $arrQuery	= array();

	public static function addQuery($query)
	{
		self::$arrQuery[] = $query;
	}
	public function renderHTML()
	{
		$html = '';
		if (!empty(self::$arrQuery)) {
			$html .= '<table class="tbl-grid table_ObjQuery hidden" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #DDD;">';
			for ($i = 0; $i < count(self::$arrQuery); $i++) {
				$html .= '<tr>
					<td style="border:1px solid #DDD; padding:2px;">' . ($i + 1) . '</td>
					<td style="border:1px solid #DDD; padding:2px;">' . (self::$arrQuery[$i]['query']) . '</td>
					<td style="border:1px solid #DDD; padding:2px;">' . (self::$arrQuery[$i]['time']) . '</td>
				</tr>';
			}
			$html .= '</table>';
		}
		return $html;
	}
}
class Query_Results
{
	private static $arrQuery	 = 	array();
	private static $arrResult	 = 	array();
	public static function countItem($query, $field)
	{
		global $dbconn;
		self::$arrResult = $dbconn->GetAll($query);
		return !empty(self::$arrResult) ? self::$arrResult[0][$field] : 0;
	}
}
