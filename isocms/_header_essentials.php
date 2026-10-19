<?
global $clsISO, $extLang, $_LANG_ID, $core, $smarty;
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL & ~E_STRICT);

$lstMenu = [
    [
        "id" => 1,
        "title" => $core->get_Lang('Explore'),
        "link" => $extLang,
        "file_key" => "header_destinations",
        "icon" => '<i class="fa-sharp-duotone fa-thin fa-grid-2"></i>',
        "file_build" => "header/header_destinations.tpl",
    ],
    [
        "id" => 3,
        "title" => $core->get_Lang('Tours'),
        "link" => $clsISO->getLink('search_tour'),
        "file_key" => "",
        "file_build" => "",
    ],
    [
        "id" => 3,
        "title" => $core->get_Lang('Blog'),
        "link" => $clsISO->getLink('blog'),
        "file_key" => "",
        "file_build" => "",
    ],
    [
        "id" => 4,
        "title" => $core->get_Lang('News'),
        "link" => $clsISO->getLink('news'),
        "file_key" => "",
        "file_build" => "",
    ],
    [
        "id" => 5,
        "title" => $core->get_Lang('Contact us'),
        "link" => $clsISO->getLink('contact'),
        "file_key" => "",
        "file_build" => "",
    ],
    [
        "id" => 6,
        "title" => $core->get_Lang('Tailor made'),
        "link" => $clsISO->getLink('tailor'),
        "file_key" => "",
        "file_build" => "",
    ],
];

$smarty->assign("lstMenu", $lstMenu);
