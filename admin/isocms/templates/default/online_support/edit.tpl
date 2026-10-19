<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>
<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('onlinesupport')}</a>
    <a>&raquo;</a>
	<a href="{$curl}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('edit')}{else}{$core->get_Lang('add')}{/if} {$core->get_Lang('onlinesupport')}</h2>
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="wrap">
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('type')}</strong><span class="color_r">*</span></div>
                <div class="fieldarea">
                    <select name="iso-type" class="slb required" style="padding:4px">
                        {$clsClassTable->makeSelectbox($oneItem.type)}
                    </select>
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('title')}</strong><span class="color_r">*</span></div>
                <div class="fieldarea">
                    <input class="text full span50 required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('nick')}</strong><span class="color_r">*</span></div>
                <div class="fieldarea">
                    <input class="text full span50 required" name="iso-nick" value="{$clsClassTable->getNick($pvalTable)}" maxlength="255" type="text">
                </div>
            </div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('status')}</strong></div>
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
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
{literal}
<script>$(".showdate").datepicker({dateFormat: "dd/mm/yy",	minDate:new Date()});</script>
<style>#ui-datepicker-div{z-index:999 !important;}</style>
{/literal}
<script type="text/javascript">
var $type = '_PROMOTION';
var $SiteHasTags_Promotion = "{$clsConfiguration->getValue('SiteHasTags_Promotion')}";
</script>
<script type="text/javascript" src="{$URL_THEMES}/promotion/jquery.promotion.js?v={$upd_version}"></script>