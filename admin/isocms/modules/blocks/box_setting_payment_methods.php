<?php
global $smarty, $core, $clsConfiguration, $clsISO;
$clsConfiguration = new Configuration();
$smarty->assign('clsConfiguration', $clsConfiguration);

if (isset($_POST['Hid_Pay1']) && $_POST['Hid_Pay1'] = 'Hid_Pay1') {
    foreach ($_POST as $key => $val) {
        $tmp = explode('-', $key);
        if ($tmp[0] == 'iso') {
            $clsConfiguration->updateValue($tmp[1], $val);
        }
    }

    if (isset($_POST['SitePay_CashStatus_Mode'])) {
        $clsConfiguration->updateValue('SitePay_CashStatus_Mode', $_POST['SitePay_CashStatus_Mode']);
    } else {
        $clsConfiguration->updateValue('SitePay_CashStatus_Mode', 0);
    }
    #-update hash onepay
    redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
}
if (isset($_POST['Hid_Pay2']) && $_POST['Hid_Pay2'] = 'Hid_Pay2') {
    foreach ($_POST as $key => $val) {
        $tmp = explode('-', $key);
        if ($tmp[0] == 'iso') {
            $clsConfiguration->updateValue($tmp[1], $val);
        }
    }
    if (isset($_POST['SitePay_Bank_Mode'])) {
        $clsConfiguration->updateValue('SitePay_Bank_Mode', $_POST['SitePay_Bank_Mode']);
    } else {
        $clsConfiguration->updateValue('SitePay_Bank_Mode', 0);
    }
    #-update hash onepay
    redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
}
if (isset($_POST['Hid_Pay3']) && $_POST['Hid_Pay3'] = 'Hid_Pay3') {
    foreach ($_POST as $key => $val) {
        $tmp = explode('-', $key);
        if ($tmp[0] == 'iso') {
            $clsConfiguration->updateValue($tmp[1], $val);
        }
    }
    #Paypal Mode

    if (isset($_POST['Paypal_Status_Mode'])) {
        $clsConfiguration->updateValue('Paypal_Status_Mode', $_POST['Paypal_Status_Mode']);
    } else {
        $clsConfiguration->updateValue('Paypal_Status_Mode', 0);
    }

    if (isset($_POST['Paypal_Test_Mode'])) {
        $clsConfiguration->updateValue('Paypal_Test_Mode', $_POST['Paypal_Test_Mode']);
    } else {
        $clsConfiguration->updateValue('Paypal_Test_Mode', 0);
    }
    #-update hash onepay
    redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
}
if (isset($_POST['Hid_Pay4']) && $_POST['Hid_Pay4'] = 'Hid_Pay4') {
    foreach ($_POST as $key => $val) {
        $tmp = explode('-', $key);
        if ($tmp[0] == 'iso') {
            $clsConfiguration->updateValue($tmp[1], $val);
        }
    }
    #ONEPAY Status Mode

    if (isset($_POST['ONEPAY_Status_Mode'])) {
        $clsConfiguration->updateValue('ONEPAY_Status_Mode', $_POST['ONEPAY_Status_Mode']);
    } else {
        $clsConfiguration->updateValue('ONEPAY_Status_Mode', 0);
    }

    if (isset($_POST['ONEPAY_Test_Mode'])) {
        $clsConfiguration->updateValue('ONEPAY_Test_Mode', $_POST['ONEPAY_Test_Mode']);
    } else {
        $clsConfiguration->updateValue('ONEPAY_Test_Mode', 0);
    }

    #-update hash onepay
    redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
}
if (isset($_POST['Hid_Pay5']) && $_POST['Hid_Pay5'] = 'Hid_Pay5') {
    foreach ($_POST as $key => $val) {
        $tmp = explode('-', $key);
        if ($tmp[0] == 'iso') {
            $clsConfiguration->updateValue($tmp[1], $val);
        }
    }

    if (isset($_POST['ONEPAY_Visa_Status_Mode'])) {
        $clsConfiguration->updateValue('ONEPAY_Visa_Status_Mode', $_POST['ONEPAY_Visa_Status_Mode']);
    } else {
        $clsConfiguration->updateValue('ONEPAY_Visa_Status_Mode', 0);
    }
    #ONEPAY Mode
    if (isset($_POST['ONEPAY_Visa_Test_Mode'])) {
        $clsConfiguration->updateValue('ONEPAY_Visa_Test_Mode', $_POST['ONEPAY_Visa_Test_Mode']);
    } else {
        $clsConfiguration->updateValue('ONEPAY_Visa_Test_Mode', 0);
    }
    #-update hash onepay
    redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
}
if (isset($_POST['Hid_Pay7']) && $_POST['Hid_Pay7'] = 'Hid_Pay7') {

    ///print_r($_POST);die('xxxxx');

    foreach ($_POST as $key => $val) {
        $tmp = explode('-', $key);
        if ($tmp[0] == 'iso') {
            //print_r($tmp[1].'xxxx'.$val);
            $clsConfiguration->updateValue($tmp[1], $val);
        }
    }
    #Paypal Mode

    if (isset($_POST['VTCPay_Status_Mode'])) {
        $clsConfiguration->updateValue('VTCPay_Status_Mode', $_POST['VTCPay_Status_Mode']);
    } else {
        $clsConfiguration->updateValue('VTCPay_Status_Mode', 0);
    }

    if (isset($_POST['VTCPay_Test_Mode'])) {
        $clsConfiguration->updateValue('VTCPay_Test_Mode', $_POST['VTCPay_Test_Mode']);
    } else {
        $clsConfiguration->updateValue('VTCPay_Test_Mode', 0);
    }
    #-update hash onepay
    redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
}
if (isset($_POST['Hid_Pay8']) && $_POST['Hid_Pay8'] = 'Hid_Pay8') {

    ///print_r($_POST);die('xxxxx');

    foreach ($_POST as $key => $val) {
        $tmp = explode('-', $key);
        if ($tmp[0] == 'iso') {
            //print_r($tmp[1].'xxxx'.$val);
            $clsConfiguration->updateValue($tmp[1], $val);
        }
    }
    #Paypal Mode

    if (isset($_POST['VNPay_Status_Mode'])) {
        $clsConfiguration->updateValue('VNPay_Status_Mode', $_POST['VNPay_Status_Mode']);
    } else {
        $clsConfiguration->updateValue('VNPay_Status_Mode', 0);
    }

    if (isset($_POST['VNPay_Test_Mode'])) {
        $clsConfiguration->updateValue('VNPay_Test_Mode', $_POST['VNPay_Test_Mode']);
    } else {
        $clsConfiguration->updateValue('VNPay_Test_Mode', 0);
    }
    #-update hash onepay
    redirect(PCMS_URL . '?mod=setting&act=pay&message=updateSuccess');
}
