<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&cruise_id={$stringCruise}#isotab7">{$core->get_Lang('cruise')}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit Reviews')}:
        <i style="color:#F63">{$clsCruise->getTitle($cruise_id)}</i>;
        
        {else}{$core->get_Lang('Add New Reviews')}{/if}</h2>
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs" style="">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
                    <div class="fl span75">
                    <div class="row-span">
                        	<div class="fieldlabel ">{$core->get_Lang('Title')} <span class="requiredMask">*</span></div>
                            <div class="fieldarea">
                            	<input class="text full required" name="iso-title" value="{$clsClassTable->getOneField('title',$pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
                        <div class="row-span">
                        	<div class="fieldlabel ">{$core->get_Lang('Name')} <span class="requiredMask">*</span></div>
                            <div class="fieldarea">
                            	<input class="text full required" name="iso-fullname" value="{$clsClassTable->getOneField('fullname',$pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
                        <div class="row-span">
							<div class="fieldlabel ">{$core->get_Lang('email')}</div>
                            <div class="fieldarea">
                            	<input class="text full email" name="iso-email" value="{$clsClassTable->getOneField('email',$pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
                        <div class="row-span">
							<div class="fieldlabel ">{$core->get_Lang('Type')} <span class="requiredMask">*</span></div>
                            <div class="fieldarea">
                                <select name="iso-type" class="glSlBox required" style="width:40%">
                                    <option {if $oneItem.type eq 'Cruise'}selected="selected"{/if} value="Cruise">Cruise</option>
                                  
                                </select>
                            </div>
                        </div>
                        <div class="row-span">
							<div class="fieldlabel ">{$core->get_Lang('international')} <span class="requiredMask">*</span></div>
                            <div class="fieldarea">
                                <select name="iso-country_id" class="glSlBox required" style="width:40%">
                                    {section name=i loop=$listCountry}
                                    <option {if $oneItem.country_id eq $listCountry[i].country_id}selected="selected"{/if} value="{$listCountry[i].country_id}">{$clsCountry->getTitle($listCountry[i].country_id)}</option>
                                    {/section}
                                </select>
                            </div>
                        </div>
                        <div class="row-span">
							<div class="fieldlabel ">{$core->get_Lang('Select rate')} <span class="requiredMask">*</span></div>
                            <div class="fieldarea">
                                <select name="iso-rates" class="glSlBox required" style="width:20%">
                                    {$clsISO->makeSelectNumber2(11,$oneItem.rates,'star,stars')}
                                </select>
                            </div>
                        </div>
                        <div class="row-span">
							<div class="fieldlabel ">{$core->get_Lang('Review date')} <span class="requiredMask">*</span></div>
                            <div class="fieldarea">
                                <input value="{$clsISO->formatDate($oneItem.review_date,1)}" class="ext full span30 required showdate" name="review_date" type="text" autocomplete="off">
                                <img src="{$URL_IMAGES}/date-icon.gif" style="position:relative;top:6px;z-index:1;left:-25px;"/>
                            </div>
                        </div>
                        <div class="row-span">
							<div class="fieldlabel ">{$core->get_Lang('status')} <span class="requiredMask">*</span></div>
                            <div class="fieldarea">
                            <div class="vietiso_status_button"></div>
                            <script type="text/javascript">
                                var is_online = '{$clsClassTable->getOneField("is_online",$pvalTable)}';
                            </script>
                            {literal}
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('.vietiso_status_button').isoswitchvalue({
                                        _value:is_online,
                                        _selector:'iso-is_online'
                                    });
                                });
                            </script>
                            {/literal}
                            <span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
                            <span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
                            </div>
                        </div>
                        <div class="row-span">
							<div class="fieldlabel ">{$core->get_Lang('content')} <span class="requiredMask">*</span></div>
                        	<div class="fieldarea">{$clsForm->showInput('content')}</div>
                        </div>
                    </div>
                    {if 1 eq 2}
                    <div class="clearfix"><br /></div>
                    <div style="border:2px dashed #F90; padding:10px;">
                        <div class="row-span">
                            <div class="fieldlabel bold"><b class="color_r">* {$core->get_Lang('type')}</b></div>
                            <div class="fieldarea">
                                <select name="iso-type" class="glSlBox required chooseTypeReviews" style="width:20%">
                                    {$clsClassTable->getSelectByType($oneItem.type)}
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"><br /></div>
                        {$core->get_Lang('Check/Uncheck All')} <input type="checkbox" rel="cr_rw" id="all_check">
                        <div class="clearfix"><br /></div>
                        <div id="loadListChoose"></div>
                    </div>
                    {/if}
                </div>
        	</div>
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript">
	var $reviews_id = '{$pvalTable}';
</script>
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="{$URL_JS}/datepicker/jquery-ui.js"></script>
<link rel="stylesheet" href="{$URL_JS}/datepicker/jquery-ui.css?v={$upd_version}" type="text/css" media="all">
{literal}
<script>
$(".showdate").datepicker({dateFormat: "dd/mm/yy",	minDate:new Date()});
</script>
<style>
#ui-datepicker-div{z-index:999 !important;}
</style>
{/literal}
