<?php

function default_startdate() {
    global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsConfiguration;
    global $core, $clsModule, $clsButtonNav, $oneSetting, $extLang,$clsISO,$package_id;
    $assign_list["clsModule"] = $clsModule;
    $clsUser = new User();
    $user_id = $core->_USER['user_id'];
    $user_group_id = $clsUser->getOneField('user_group_id', $user_id);
    #

    $type = isset($_GET['type']) ? $_GET['type'] : 'MONTH';
    $assign_list["type"] = $type;
    /**/
    if (isset($_POST['filter']) && $_POST['filter'] == 'filter') {
        $link = '';
      
        if (isset($_POST['type']) && !empty($_POST['type'])) {
            $link .= '&type=' . $_POST['type'];
        }
        
        header('location: ' . PCMS_URL . '/?mod=' . $mod.'&act='.$act . $link);
    }
    
}
function default_load_list_start_date() {
	 global $assign_list, $_CONFIG, $_SITE_ROOT, $mod, $_LANG_ID, $act, $menu_current, $current_page, $oneSetting, $clsISO;
    global $core, $clsModule, $clsButtonNav, $dbconn, $clsConfiguration;
	$user_id = $core->_USER['user_id'];
	
	$clsTourStartDate=new TourStartDate();$assign_list['clsTourStartDate']=$clsTourStartDate;
	
	$type = isset($_POST['type'])? ($_POST['type']) : 'MONTH';
	$assign_list['type']=$type;
	if($type=='DAY'){
		$begin_date = isset($_POST['begin_date'])? ($_POST['begin_date']) : '';
		$begin_date =$begin_date?$begin_date:date('m/d/Y');
		

		$begin_date_text =$clsISO->converTimeToText5(strtotime($begin_date));

		$assign_list['begin_date']=$begin_date;
		$assign_list['begin_date_text']=$begin_date_text;
		
		$begin_date_next=strtotime('+1 day',strtotime($begin_date));
		$begin_date_next=date('m/d/Y',$begin_date_next);


		$begin_date_prev=strtotime('-1 day',strtotime($begin_date));
		$begin_date_prev=date('m/d/Y',$begin_date_prev);

		$assign_list['begin_date_next']=$begin_date_next;
		$assign_list['begin_date_prev']=$begin_date_prev;
		
		
	}else{
		$begin_date = isset($_POST['begin_date'])? ($_POST['begin_date']) : '';
		$day = date('w');

		$week_start = date('m/d/Y', strtotime('-'.($day-1).' days'));
		$begin_date =$begin_date?$begin_date:$week_start;

		$begin_date_text =$clsISO->converTimeToText5(strtotime($begin_date));

		$assign_list['begin_date']=$begin_date;
		$assign_list['begin_date_text']=$begin_date_text;

		$today=date('m/d/Y');
		$today=strtotime($today);

		$list_date=array();

		for($i=0; $i<7; $i++){
			$new_date=strtotime('+'.$i.' day',strtotime($begin_date));
			$list_date[$i]['Value']=date($new_date);
			$list_date[$i]['Full_Date']=date('m/d/Y',$new_date);
			$list_date[$i]['Full_Date_2']=date('d/m/Y',$new_date);
			$list_date[$i]['Day_Month']=date('d/m',$new_date);
			$list_date[$i]['Day_Text']=$clsISO->getDayOfWeekShort($new_date);
			if($today >$new_date){
				$list_date[$i]['Day_Class']='pass_day';
			}else{
				$list_date[$i]['Day_Class']='going_day';
			}
		}


		$begin_date_next=strtotime('+7 day',strtotime($begin_date));
		$begin_date_next=date('m/d/Y',$begin_date_next);


		$begin_date_prev=strtotime('-7 day',strtotime($begin_date));
		$begin_date_prev=date('m/d/Y',$begin_date_prev);

		$assign_list['list_date']=$list_date;
		$assign_list['begin_date_next']=$begin_date_next;
		$assign_list['begin_date_prev']=$begin_date_prev;
	}
	
	$html = $core->build('load_list_start_date.tpl');
	echo $html; die;
}

?>