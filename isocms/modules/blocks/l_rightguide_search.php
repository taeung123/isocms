<?php
global $smarty, $clsISO, $core;
#
$clsCountry = new Country();
$smarty->assign('clsCountry', $clsCountry);
#

$lstCountry = $clsCountry->getAll('is_trash = 0 AND is_online=1', 'country_id, title');
$smarty->assign('lstCountry', $lstCountry);
