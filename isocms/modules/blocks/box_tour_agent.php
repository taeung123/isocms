<?php

global $smarty, $clsISO, $core;

$assign_list["clsISO"] = $clsISO;
$assign_list["core"] = $core;

foreach ($assign_list as $key => $val) {
    $smarty->assign($key, $val);
}