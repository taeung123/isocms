<?php
global $assign_list, $core, $clsConfiguration, $dbconn, $_LANG_ID, $smarty;
global $clsISO;
#- Create message payment online
if ($clsISO->getVar('PAYMENT_GLOBAL')) {
    #- Create successful message paypal
    if ($clsConfiguration->getValue('Paypal_Status_Mode') && $clsConfiguration->countItem("setting='SiteMsg_SuccessPaypal'") == 0) {
        $clsConfiguration->updateValue('SiteMsg_SuccessPaypal', '<div>Dear Customers,</div>
<div>Thank for your payment us, please visit our client system for details about your payment:</div>
<div>&nbsp;</div>
<div>Your Transaction&nbsp;as follows</div>
<div>---</div>
<div>Card Holder: [%number_card%]</div>
<div>Card Type: [%type_card%]</div>
<div>Order Info: [%vpc_orderInfo%]</div>
<div>Amount: [%amount%]</div>
<div>Date: [%datetime%]</div>
<div>Status: [%status%]</div>
<div>---</div>
<div>
<div>Brgds</div>
</div>');
    } else if (!$clsConfiguration->getValue('Paypal_Status_Mode') && $clsConfiguration->countItem("setting='SiteMsg_SuccessPaypal'") > 0) {
        $clsConfiguration->deleteByCond("setting='SiteMsg_SuccessPaypal'");
    }
    #- Create successful message ONEPAY
    if (($clsConfiguration->getValue('ONEPAY_Status_Mode') || $clsConfiguration->getValue('ONEPAY_Visa_Status_Mode'))
        && $clsConfiguration->countItem("setting='SiteMsg_SuccessOnePay'") == 0
    ) {
        $clsConfiguration->updateValue('SiteMsg_SuccessOnePay', '<p>Dear Customers,&nbsp;</p>
<p>Thank for your payment us, please visit our client system for details about your payment:</p>
<p>Your Transaction&nbsp;as follows</p>
<p>---</p>
<p>Card Number: {$cardnumber}&nbsp;</p>
<p>Card Type: {$cardtype}&nbsp;</p>
<p>Transaction ID: {$transId}</p>
<p>Booking ID: {$bookingId}</p>
<p>Transaction Reference: {$transRef}</p>
<p>Amount: {$amount}</p>
<p>Date: {$datetime}</p>
<p>Status: <strong>{$status}</strong></p>
<p>Thank you for using our&nbsp;Product/Service. We look forward to serving you in the trip.&nbsp;</p>
<p>Yours faithfully,&nbsp;</p>');
    } else if (
        !$clsConfiguration->getValue('ONEPAY_Status_Mode') && !$clsConfiguration->getValue('ONEPAY_Visa_Status_Mode')
        && $clsConfiguration->countItem("setting='SiteMsg_SuccessOnePay'") > 0
    ) {
        $clsConfiguration->deleteByCond("setting='SiteMsg_SuccessPaypal'");
    }
}
#- End Create message payment online
$listMessage = $clsConfiguration->getAll("setting like 'SiteMsg_%_" . $_LANG_ID . "'");

$smarty->assign('listMessage', $listMessage);
#
