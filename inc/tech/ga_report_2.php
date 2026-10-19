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

ini_set('display_errors',1);
error_reporting(E_ERROR & ~E_STRICT);//E_ALL
define("PCMS_DIR", $_SERVER['DOCUMENT_ROOT']);
#Common Directory
define("DIR_INCLUDES", 	PCMS_DIR."/inc");
define("DIR_LANG", 		PCMS_DIR."/lang");
define("DIR_LOGS", 		PCMS_DIR."/logs");
define("DIR_THEMES", 	PCMS_DIR."/themes");
define("DIR_TMP", 		PCMS_DIR."/tmp");
define("DIR_UPLOADS",	PCMS_DIR."/uploads");
define("DIR_CLASSES", 	PCMS_DIR."/classes");
define("DIR_COMMON", 	DIR_INCLUDES."/iso");
define("DIR_SMARTY", 	DIR_INCLUDES."/smarty");
define("DIR_ADODB", 	DIR_INCLUDES."/adodb");
define("DIR_PEAR", 		DIR_INCLUDES."/PEAR");
define("DIR_LIB", 		DIR_INCLUDES."/lib");
define("DIR_CONF", 		DIR_INCLUDES."/conf");
	ini_set('display_errors',1);
error_reporting(E_ALL & ~E_STRICT);//E_ALL
// composer require google/apiclient
require_once DIR_INCLUDES.'/ga_report/vendor/autoload.php';

// Start a session to persist credentials.
session_start();
//unset($_SESSION['access_token']);
//unset($_SESSION['refresh_token']);
$_SESSION['mainScript'] = basename($_SERVER['PHP_SELF']);   // Oauth2callback.php will return here.

$client = new Google_Client();
$service = new Google_Service_AnalyticsReporting($client); 

// Create the DateRange object.
$dateRange = new Google_Service_AnalyticsReporting_DateRange();
$dateRange->setStartDate("2016-01-01");
$dateRange->setEndDate("2017-06-30");

// Create the Metrics objects.
$sessions = new Google_Service_AnalyticsReporting_Metric();
$sessions->setExpression("ga:sessions");
$sessions->setAlias("ga:sessions");
$users = new Google_Service_AnalyticsReporting_Metric();
$users->setExpression("ga:users");
$users->setAlias("ga:users");
$metrics = array($sessions,$users);

// Create the Dimensions objects.
$date = new Google_Service_AnalyticsReporting_Dimension();
$date->setName("ga:date");
$pagePath = new Google_Service_AnalyticsReporting_Dimension();
$pagePath->setName("ga:pagePath");
$dimensions = array($date,$pagePath);

// Create the ReportRequest object.
$request = new Google_Service_AnalyticsReporting_ReportRequest();
$request->setViewId("81692014");
$request->setPageSize("10000");
$request->setDateRanges($dateRange);
$request->setDimensions($dimensions);
$request->setMetrics($metrics);

// Create the report
$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
$body->setReportRequests(array( $request));

$data =  BatchGet($service, $body);
showData($data->reports[0]);

// Loop though first give pages of data. 
$cnt = 0;   
while ($data->reports[0]->nextPageToken > 0 && $cnt < 5) {

	// There are more rows for this report. we apply the next page token to the page token of the orignal body.
	$body->reportRequests[0]->setPageToken($data->reports[0]->nextPageToken);
	$data = BatchGet($service, $body);
	showData($data->reports[0]);
	$cnt++;
	}

function showData($data)  {
	?> <pre><table><?php

	?><tr><?php // Header start row
	for($i = 0; $i < sizeof($data->columnHeader->dimensions);$i++)	{
		?> <td> <?php print_r($data->columnHeader->dimensions[$i]); ?> </td> <?php
	}
	for($i = 0; $i < sizeof($data->columnHeader->metricHeader->metricHeaderEntries);$i++)	{
		?> <td> <?php print_r($data->columnHeader->metricHeader->metricHeaderEntries[$i]->name); ?> </td> <?php
	}
	?><tr><?php  // Header row end
	
	// Display data
	for($i = 0; $i < sizeof($data->data->rows);$i++)	{

		?><tr><?php // Data row start
		// Dimensions
		for($d = 0; $d < sizeof($data->columnHeader->dimensions);$d++)	{
			?> <td> <?php print_r($data->data->rows[$i]->dimensions[$d]); ?> </td> <?php
		}
		// Metrics
		for($m = 0; $m < sizeof($data->columnHeader->metricHeader->metricHeaderEntries);$m++)	{
			?> <td> <?php print_r($data->data->rows[$i]->metrics[0]->values[$m]); ?> </td> <?php
		}
		?><tr><?php  // Header row end
	}
	?></table></pre><?php
}
function showText($data)
{
 ?> <pre> <?php print_r($data); ?> </pre> <?php
}

/**
* Returns the Analytics data. 
* Documentation https://developers.google.com/analyticsreporting/v4/reference/reports/batchGet
* Generation Note: This does not always build corectly.  Google needs to standardise things I need to figuer out which ones are wrong.
* @service Authenticated Analyticsreporting service.</param>  
* @body A valid Analyticsreporting v4 body.</param>
* @return GetReportsResponseResponse</returns>
*/
function BatchGet($service, $body)
{
	try
	{
		// Initial validation.
		if ($service == null)
			throw new Exception("service");
		if ($body == null)
			throw new Exception("body");

		// Make the request.
		return $service->reports->batchGet($body);
	}
	catch (Exception $ex)
	{
		throw new Exception("Request Reports.BatchGet failed.", $ex->getMessage());
	}
}


?>
