<?php

global $core, $_LANG_ID, $smarty, $clsISO;

$clsTour = new Tour;
$lstTourRecent = [];
if (isset($_COOKIE['recent_view_tour'])) {
    $recent_view_tour = json_decode($_COOKIE['recent_view_tour'], true);
    if (!empty($recent_view_tour)) {
        $ids = implode(',', array_map('intval', $recent_view_tour));
        $lstTourRecent = $clsTour->getAll("tour_id IN ($ids) and is_trash=0 and is_online = 1", "$clsTour->pkey, title, image");
    }
}

$smarty->assign("lstTourRecent", $lstTourRecent);
