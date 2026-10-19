<?php
/*======================================================================*\
|| #################################################################### ||
|| # The Classes configurations of the ISOCMS                         # ||
|| # ISOCMS 6.0.0 By Luong Tien Dung (luongtiendung@gmail.com)        # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
class Log extends dbBasic
{
	function __construct()
	{
		$this->pkey = "log_id";
		$this->tbl = DB_PREFIX . "log";
	}
	function insertAction($type = '', $pkeyTable = 0, $pvalTable = 0, $title = '', $intro = '')
	{
		global $core;
		$f = "type,pkeyTable,pvalTable,title,intro,reg_date,user_id";
		$v = "'$type','$pkeyTable','$pvalTable','" . addslashes($title) . "','" . addslashes($intro) . "','" . time() . "','" . $core->_SESS->user_id . "'";
		$this->insertOne($f, $v);
		return 1;
	}
	function getActionByType($type = '', $pkeyTable = 0, $pvalTable = 0)
	{
		$all = $this->getAll("type='$type' and pkeyTable='$pkeyTable' and pvalTable='$pvalTable'");
		return $all;
	}
	function getFieldTable($field = '', $log_id = 0)
	{
		$one = $this->getOne($log_id);
		$intro = $one['intro'];
		$un_intro = unserialize($intro);
		return $un_intro[$field];
	}

	/**
	 * Summary of logAction
	 * @param mixed $logFileName: Tên file ghi log
	 * @param mixed $type: Loại log
	 * @param mixed $user_id: Người thực hiện thao tác xóa
	 * @param mixed $details: Thông tin xóa
	 * @return void
	 */

	function logAction($logFileName = '', $type = '', $user_id = 0, $details = '')
	{
		// Tạo thư mục theo ngày với định dạng Y-m-d
		$logDir = 'logs/' . $type . '/' . date("Y-m-d");
		if (!is_dir($logDir)) {
			mkdir($logDir, 0777, true);
		}

		// Đường dẫn đến file log
		$logFile = "$logDir/$logFileName.json";

		// Tạo dữ liệu log
		$logEntry = [
			'timestamp' => date("Y-m-d H:i:s"),
			'type' => $type,
			'user_id' => $user_id,
			'details' => $details
		];


		// Kiểm tra nếu file log tồn tại, nếu không thì khởi tạo mảng log trống
		$logs = file_exists($logFile) ? json_decode(file_get_contents($logFile), true) : [];

		// Thêm log mới vào mảng log
		$logs[] = $logEntry;

		// Ghi lại log vào file JSON
		$check = file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
	}
}
