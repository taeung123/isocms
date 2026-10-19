<?php
global $dbconn,$mod, $act,$smarty, $core,$extLang,$_lang,$clsISO,$lang_sql;
#
$clsCountryEx = new Country();
$smarty->assign('clsCountryEx',$clsCountryEx);
$clsTour = new Tour();
$smarty->assign('clsTour',$clsTour);

$country_id = !empty($country_id)? $country_id : '1';
$smarty->assign('country_id',$country_id);
#
$clsCity = new City();
$smarty->assign('clsCity',$clsCity);

$clsCityStore = new CityStore();
$smarty->assign('clsCityStore',$clsCityStore);


//$lstDeparturePoint = $clsCityStore->getAll("is_trash=0 and type='DEPARTUREPOINT' and city_id IN (SELECT city_id FROM ".DB_PREFIX."city WHERE is_trash =0 and is_online=1) order by order_no ASC", $clsCityStore->pkey.',city_id');



$sql_departure_point="SELECT ".DB_PREFIX."city.city_id,".DB_PREFIX."city.title FROM ".DB_PREFIX."city INNER JOIN ".DB_PREFIX."citystore ON ".DB_PREFIX."city.city_id = ".DB_PREFIX."citystore.city_id AND ".DB_PREFIX."citystore.type='DEPARTUREPOINT' AND ".DB_PREFIX."citystore.lang_id='$lang_sql' ORDER BY
         ".DB_PREFIX."citystore.order_no ASC";

$lstDeparturePoint=$dbconn->getAll($sql_departure_point);
$smarty->assign('lstDeparturePoint',$lstDeparturePoint); 
unset($lstDeparturePoint);
#-- Create Duration
$cond = "is_trash=0 and is_online=1";
$LISTALL = $clsTour->getAll($cond,$clsTour->pkey.",number_day,number_night");
$TMP = '';
$DURATION_HTML = '<option value="0">'.$core->get_Lang('Tour length').'</option>';
if(is_array($LISTALL) && count($LISTALL) > 0){
    for ($i=0; $i<count($LISTALL); $i++) {
        $TMP .= $clsTour->getSelectTripDuration($LISTALL[$i][$clsTour->pkey],$LISTALL[$i]).'|';
    }
    $TMP = array_unique(explode('|', $TMP));
    if(is_array($TMP) && count($TMP) > 0){
        sort($TMP,SORT_NUMERIC);
        foreach($TMP as $key=>$val){
            if($val!='' && $val!='n/a'){
                $DURATION_HTML .= '<option value="'.$clsTour->convertDuration($val).'" '.($duration==$clsTour->convertDuration($val)?'selected="selected"':'').'>'.$val.'</option>';
            }
        }
    }
    unset($LISTALL);
}
$smarty->assign('DURATION_HTML',$DURATION_HTML);
#
if(isset($_POST['Hid_Search']) &&  $_POST['Hid_Search']=='Hid_Search'){
    $link= $clsISO->getLink('search_tour');
	unset($_POST['Hid_Search']);
	$link .= "?key={$_POST['key']}";
    if (!empty($_POST["departure_point_id"])) {
        $link .= "&departure_point_id={$_POST['departure_point_id']}";
    }
    if (!empty($_POST["duration_id"])) {
        $link .= "&duration_id={$_POST['duration_id']}";
    }
    //print_r($link); die();
    header('location:'.$link);
    exit();
}
?>