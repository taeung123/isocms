<?php

global $core, $smarty, $mod, $act,
       $PCMS_URL, $curl,
       $title_page, $PAGE_NAME,
       $description_page,
       $global_schema_markup;

$schema_dir = DIR_TEMPLATES . '/default/blocks/schema/';


$schema_mod = !empty($mod) ? basename($mod) : '';
$schema_act = !empty($act) ? basename($act) : 'default';


/*
 *  Nếu chưa tạo mod,act thì lấy theo schema mặc định
 */
$schema_file = 'blocks/schema/component/root/default';


/*
 * Nếu chưa tạo act thì lấy theo mod mặc định
 * blocks/schema/component/{mod}.tpl
 */
if (!empty($schema_mod)) {

    $component_path = 'component/' . $schema_mod . '.tpl';

    if (is_file($schema_dir . $component_path)) {
        $schema_file = 'blocks/schema/component/' . $schema_mod;
    }


    /*
     * Đầy đủ mod, act
     * blocks/schema/{mod}/{act}.tpl
     */
    $schema_path = $schema_mod . '/' . $schema_act . '.tpl';

    if (is_file($schema_dir . $schema_path)) {
        $schema_file = 'blocks/schema/' . $schema_mod . '/' . $schema_act;
    }
}

// var_dump($mod, $act);
/*
 * Schema variables
 */
if(empty($curl)) {
    $curl = $_SERVER['REQUEST_URI'];
}
$assign_list["curl"] = $curl;
$schema_url = rtrim((string)($PCMS_URL ?? ''), '/') . (string)($curl ?? '');

$schema_name = !empty($title_page)
    ? $title_page
    : $PAGE_NAME;

$schema_desc = !empty($description_page)
    ? $description_page
    : $PAGE_NAME;


/*
 * Assign
 */
$smarty->assign(array(
    'schema_file' => $schema_file,
    'schema_url'  => $schema_url,
    'schema_name' => $schema_name,
    'schema_desc' => $schema_desc
));

?>