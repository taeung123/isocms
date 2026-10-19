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

ini_set('display_errors', 1);
error_reporting(E_ERROR & ~E_STRICT);//E_ALL
define("PCMS_DIR", $_SERVER['DOCUMENT_ROOT']);
#Common Directory
define("DIR_INCLUDES", PCMS_DIR . "/inc");
define("DIR_LANG", PCMS_DIR . "/lang");
define("DIR_LOGS", PCMS_DIR . "/logs");
define("DIR_THEMES", PCMS_DIR . "/themes");
define("DIR_TMP", PCMS_DIR . "/tmp");
define("DIR_UPLOADS", PCMS_DIR . "/uploads");
define("DIR_CLASSES", PCMS_DIR . "/classes");
define("DIR_COMMON", DIR_INCLUDES . "/iso");
define("DIR_SMARTY", DIR_INCLUDES . "/smarty");
define("DIR_ADODB", DIR_INCLUDES . "/adodb");
define("DIR_PEAR", DIR_INCLUDES . "/PEAR");
define("DIR_LIB", DIR_INCLUDES . "/lib");
define("DIR_CONF", DIR_INCLUDES . "/conf");
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_STRICT);//E_ALL
// composer require google/apiclient
require_once DIR_INCLUDES . '/ga_report/vendor/autoload.php';


/**
 * Initializes an Analytics Reporting API V4 service object.
 *
 * @return An authorized Analytics Reporting API V4 service object.
 */
function initializeAnalytics()
{

    // Use the developers console and download your service account
    // credentials in JSON format. Place them in this directory or
    // change the key file location if necessary.
    $KEY_FILE_LOCATION = __DIR__ . '/client_secret_519255974073-cc0jsf6nvti8tck1jv0jvq93749in0k4.apps.googleusercontent.com.json';

    // Create and configure a new client object.
    $client = new Google_Client();
    $client->setApplicationName("Hello Analytics Reporting");
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
    $analytics = new Google_Service_AnalyticsReporting($client);

    return $analytics;
}


/**
 * Queries the Analytics Reporting API V4.
 *
 * @param service An authorized Analytics Reporting API V4 service object.
 * @return The Analytics Reporting API V4 response.
 */
function getReport($analytics)
{

    // Replace with your view ID, for example XXXX.
    $VIEW_ID = "187724265";

    // Create the DateRange object.
    $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    $dateRange->setStartDate("7daysAgo");
    $dateRange->setEndDate("today");

    // Create the Metrics object.
    $sessions = new Google_Service_AnalyticsReporting_Metric();
    $sessions->setExpression("ga:sessions");
    $sessions->setAlias("sessions");

    // Create the ReportRequest object.
    $request = new Google_Service_AnalyticsReporting_ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setMetrics(array($sessions));

    $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    $body->setReportRequests(array($request));
    return $analytics->reports->batchGet($body);
}


/**
 * Parses and prints the Analytics Reporting API V4 response.
 *
 * @param An Analytics Reporting API V4 response.
 */
function printResults($reports)
{
    for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
        $report = $reports[$reportIndex];
        $header = $report->getColumnHeader();
        $dimensionHeaders = $header->getDimensions();
        $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
        $rows = $report->getData()->getRows();

        for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
            $row = $rows[$rowIndex];
            $dimensions = $row->getDimensions();
            $metrics = $row->getMetrics();
            for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
            }

            for ($j = 0; $j < count($metrics); $j++) {
                $values = $metrics[$j]->getValues();
                for ($k = 0; $k < count($values); $k++) {
                    $entry = $metricHeaders[$k];
                    print($entry->getName() . ": " . $values[$k] . "\n");
                }
            }
        }
    }
}

$analytics = initializeAnalytics();
$response = getReport($analytics);
print_r($response);
die();
printResults($response);


?>
