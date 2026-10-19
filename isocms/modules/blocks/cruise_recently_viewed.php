<?php
/*======================================================================*\
|| #################################################################### ||
|| # The database configurations of the ISOCMS                        # ||
|| # ISOCMS By VietISO (support@vietiso.com)        			      # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2024 VietISO JSC.             # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
global $core, $_LANG_ID, $smarty;

$clsCruise = new Cruise;
$lstCruiseRecent = [];
if (isset($_COOKIE['recent_view_cruise'])) {
    $recent_view_cruise = json_decode($_COOKIE['recent_view_cruise'], true);
    if (!empty($recent_view_cruise)) {
        $ids = implode(',', array_map('intval', $recent_view_cruise));
        $lstCruiseRecent = $clsCruise->getAll("cruise_id IN ($ids) and is_trash=0 and is_online = 1", "$clsCruise->pkey, title, image");
    }
}

$smarty->assign("lstCruiseRecent", $lstCruiseRecent);
