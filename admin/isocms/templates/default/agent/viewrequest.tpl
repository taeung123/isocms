<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&agent_id={$core->encryptID($agent_id)}" title="{$mod}">{$core->get_Lang('profilemanagement')} #{$pvalTable}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('View Request')}
        </h2>
    </div>
    <div class="clearfix"></div>
    <div class="bookingItem">
        <div class="bookingTop">
            <div class="row">
                <div class="col-sm-1">
                    <div class="pic_hotel">
                        <img src="{$clsDownload->getImage($oneTable.target_id,193,129)}" class="static" width="90" height="60" alt="{$oneDownload.title}" style="height: 60px; width: 90px;">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="detail_hotel_booking">
                        <p class="content_blue">
                            <b>
                                <a class="hotelLinks" href="{$clsDownload->getLink($oneTable.target_id)}" title="{$oneDownload.title}">{$oneDownload.title}</a>
                            </b>
                        </p>
                        <div class="clear">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="allbox">
            {assign var=feedback_store value = $clsISO->getArrayFromString($oneTable.feedback_store)}
            <div class="date_hotel_booking mb10">
                <p>
                    <span class="date_hotel_on">{$core->get_Lang('Request on')}</span>
                    <span class="date_hotel">{$clsISO->converTimeToText($oneTable.reg_date)}</span>
                </p>
            </div>
            <div class="row">
                <div class="allbox_left col-sm-6">
                    <p class="booking_left">
                        {$core->get_Lang('Request ID')}
                    </p>
                    <p class="booking_right">
                        {$oneTable.feedback_code}
                    </p>
                    <div class="clear"></div>
                    <p class="booking_left">
                        {$core->get_Lang('Departure time')}:
                    </p>
                    <p class="booking_right">
                        <span>{$feedback_store.departure}</span>
                    </p>
                    <div class="clear"></div>
                </div>
                <div class="allbox_right col-sm-4">
                    <p>
                        <span class="money_hotel">{$clsISO->getRate()} {$clsDownload->getTripPrice($oneTable.target_id)}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <form id="newitem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="row-field">
            <div class="row-heading">{$core->get_Lang('detail request')} {$oneTable.booking_code}:</div>
            <div class="coltrols">{$oneTable.feedback_html}</div>
        </div>
        <div class="row-field">
            <div class="row-heading">{$core->get_Lang('note')} :</div>
            <div class="coltrols">{$clsForm->showInput('note')}</div>
        </div>
        <div class="coltrols">
            <label for="is_process"><input type="radio" name="is_process" value="1" {if $oneTable.is_process eq '1'}checked="checked"{/if} /> {$core->get_Lang('tickhereifaccept')}!</label>
        </div>
        <div class="coltrols">
            <label for="is_process"><input type="radio" name="is_process" value="2" {if $oneTable.is_process eq '2'}checked="checked"{/if} /> {$core->get_Lang('tickhereifrefuse')}!</label>
        </div>

        <fieldset class="submit-buttons">
            <legend>{$core->get_Lang('accept')}</legend>
            {$saveBtn} {$resetBtn}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
{literal}
    <style type="text/css">
        td{ font-size:13px !important}
        .hidden { display:none !important}
    </style>
{/literal}
{literal}
    <style type="text/css">
        .form-group{margin-bottom:10px;}
        .form-group label{width:150px; text-align:right; display: inline-block; line-height:32px}
        .form-group .col-right{width:300px;display: inline-block}
        .form-group input{width:100%; padding:0 10px; line-height:32px}
        .bookingItem {
            width: 100%;
            margin-top: 20px;
            position: relative;
        }
        .bookingItem .col-sm-3{width:25%;float:left}
        .bookingItem .col-sm-9{width:75%;float:left}
        #tab_content .col-sm-9{width:75%;float:left}
        .bookingItem .col-sm-2{width:16.6%; display:inline-block; float:left}
        .bookingItem .col-sm-4{width:33.3%; display:inline-block; float:left}
        #tab_content .col-sm-6{width:50%;float:left}
        .bookingItem .col-sm-8{width:66.6%; display:inline-block; float:left}
        .col-sm-1{width:8.3%; display:inline-block; float:left}
        .col-sm-6{width:50%;float:left}
        .col-sm-8{width:66.6%; display:inline-block; float:left}
        .allbox_right {
            text-align: right;
            position: relative;
        }
        .money_hotel {
            font-size: 16px;
            color: #000;
            font-weight: 700;
        }
        .date_hotel_booking{text-align:right}
        .allbox {
            width: 100%;
            padding: 12px 12px 16px;
            margin-top: 10px;
            background-color: #fcfcfc;
            border: 1px solid #ebebeb;
            height: auto;
        }
        .allbox p, .detail_hotel_booking p {
            margin-bottom: 0;
            margin-top: 0;
        }
        .address {
            font-size: 13px;
            color: #666;
        }
        .booking_left {
            text-align: right;
            width: 40%;
            margin-top: 5px;
            font-weight: 700;
            color: #000;
        }
        .booking_right {
            text-align: left;
            width: 55%;
            margin-left: 4%;
            color: #666;
        }
        .booking_left,
        .booking_right {
            position: relative;
            float: left;
            font-size: 13px;
            white-space: normal;
        }
        .text_conditions, .text_conditions span {
            font-size: 11px;
            color: #36B66F;
        }
        .allbox .manage_booking, .buttonconnect, .css3button, .css3button1 {
            border: 1px solid #2ca4fb;
            background-color: #2ca4fb;
        }
        .allbox .manage_booking, .button_loginemail, .buttonconnect, .css3button, .css3button1, .css3buttoncancel, .submit_reviews {
            color: #fff;
            cursor: pointer;
            text-align: center;
        }
        .allbox .manage_booking, .allbox .submit_reviews, .button_loginemail, .buttonconnect, .css3button, .css3button1, .css3buttoncancel {
            border-radius: 7px;
            -webkit-border-radius: 7px;
            -moz-border-radius: 7px;
        }
        .allbox .manage_booking {
            padding: 5px 15px;
        }
        .rate-1{padding:0}
        .rate-1, .rate-1 span {
            display: inline-block;
            width: 77px;
            height: 13px;
            background: url(/isocms/templates/default/skin/images/rate-1.png) repeat-x 0 -13px;
        }
        .rate-1 span {
            display: inline-block;
            background-position: 0 0;
        }
    </style>
{/literal}