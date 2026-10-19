<?php
global $smarty,$clsISO,$core,$blog_id,$curl, $extLang;
#
$clsPage = new Page();$smarty->assign('clsPage',$clsPage);
$clsBlog = new Blog();$smarty->assign('clsBlog',$clsBlog);
$clsFeedback = new Feedback();$smarty->assign('clsFeedback',$clsFeedback);


$fullname = isset($_POST['fullname'])?addslashes($_POST['fullname']):'';
$email = isset($_POST['email'])?addslashes($_POST['email']):'';
$phone = isset($_POST['phone'])?addslashes($_POST['phone']):'';
$description = isset($_POST['description'])?addslashes($_POST['description']):'';
$input_check = isset($_POST['input_check'])?addslashes($_POST['input_check']):'';

$time_check=time() - 24*60*60;//1660086885
$user_ip_check=$_SERVER['REMOTE_ADDR'];
if(isset($_POST['QuickContact'])&&$_POST['QuickContact']=='QuickContact'){
    $checkSpam=$clsFeedback->getAll("is_trash=0 and user_ip='{$user_ip_check}' and reg_date > '{$time_check}' and target_id=0 and type='QuickContact'",$clsFeedback->pkey);
    if(count($checkSpam)>3){
        $check_spam =1;

    }
    if(!$clsISO->checkGoogleReCAPTCHA()){
        $check_spam =1;
    }

    $type='QuickContact';
    if(empty($input_check)&&empty($check_spam)){
        $max_id = $clsFeedback->getMaxId();
        $fx = "feedback_id,fullname,phone,email,type,description,user_ip,reg_date,feedback_store";
        $vx = "'$max_id','$fullname',$phone,'$email','$type','$description','".$_SERVER['REMOTE_ADDR']."','".time()."','".json_encode($_POST, JSON_UNESCAPED_UNICODE)."'";

        if($clsFeedback->insertOne($fx,$vx)) {
            $clsFeedback->sendMailQuickContact($max_id);
            header('location:'.$extLang.'/quick-contact/success.html');
            exit();
        }else{
            $errMsg=$core->get_Lang('Error Insert');
            $assign_list["errMsg"] = $errMsg;
            $link=$clsBlog->getLink($blog_id).'?message=ErrorInsert';
            header('location:'.$link);
            exit();
        }
    }else{
        $link=$clsBlog->getLink($blog_id).'?message=ErrorSubmitForm';
        header('location:'.$link);
        exit();
        $errMsg=$core->get_Lang('Error Submit Form');
        $assign_list["errMsg"] = $errMsg;
    }
}
#
?>