<?php
// *************************************************************************
// *                                                                       *
// * ISOCMS - The Complete Content Management System Solution              *
// * Copyright (c) VietISO. All Rights Reserved,                           *
// * Version: 6.0.0                                                        *
// * BuildId: 3                                                            *
// * Build Date: 5 Dec 2014                                                *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * Email: support@vietiso.com                                            *
// * Website: http://www.vietiso.com                                       *
// *                                                                       *
// *************************************************************************
// *                                                                       *
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.  This software  or any other *
// * copies thereof may not be provided or otherwise made available to any *
// * other person.  No title to and  ownership of the  software is  hereby *
// * transferred.                                                          *
// *                                                                       *
// * You may not reverse  engineer, decompile, defeat  license  encryption *
// * mechanisms, or  disassemble this software product or software product *
// * license.  VietISO may terminate this license if you don't             *
// * comply with any of the terms and conditions set forth in our end user *
// * license agreement (EULA).  In such event,  licensee  agrees to return *
// * licensor  or destroy  all copies of software  upon termination of the *
// * license.                                                              *
// *                                                                       *
// * Please see the EULA file for the full End User License Agreement.     *
// *                                                                       *
// *************************************************************************
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL & ~E_STRICT);
#
define("IS_ADMIN_PAGE", 1);
define("_SITE_ROOT", 'ADMIN');
define('ABSPATH', $_SERVER['DOCUMENT_ROOT']);
#
require_once(ABSPATH . '/init.php');
require_once(DIR_INCLUDES . "/tinymce_config.php");
#
//Required Module
if (file_exists(DIR_INCLUDES . "/index.php")) {
	require_once(DIR_INCLUDES . "/index.php");
} else {
	echo ('ISOCMS not found!');
	die();
}
