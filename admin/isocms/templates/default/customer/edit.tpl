<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')} : </strong>
	<a href="{$PCMS_URL}" title="Trang chủ">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('Customer')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$act}">{if $pvalTable}{$core->get_Lang('Edit')}{else}{$core->get_Lang('Add new')}{/if}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('addnew')} {$core->get_Lang('Customer')}?{/if}</h2>
    </div>
    <div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div class="wrap">
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Full Name')}</strong> <span class="color_r">* </span></div>
                <div class="fieldarea">
                    <input class="text_32 full-width border_aaa bold required fontLarge" style="padding:5px" name="iso-full_name" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                </div>
            </div>
			<div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Email')}</strong> <span class="color_r">* </span></div>
                <div class="fieldarea">
                    <input class="text_32 span30 border_aaa bold required fontLarge" style="padding:5px" name="iso-email" value="{$clsClassTable->getEmail($pvalTable)}" maxlength="255" type="text">
                </div>
            </div>
			<div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Package Demo')}</strong> <span class="color_r">* </span></div>
                <div class="fieldarea">
					<select name="iso-package_id" id="slb_select">
						{section name=i loop=$listPackage}
							<option {if $oneItem.package_id eq $listPackage[i].package_id} selected {/if} value="{$listPackage[i].package_id}">
							{$clsPackage->getTitle($listPackage[i].package_id)}
							</option>
						{/section}
					</select>
                </div>
            </div>
			<div class="row-span">
				<div class="fieldlabel"><strong>{$core->get_Lang('Expired date')}</strong></div>
				<div class="fieldarea">
					<input value="{$clsISO->formatTimeMonth($oneItem.expired_date)}" placeholder="{$clsISO->formatTimeMonth($now_day)}" class="ext full required showdate" name="expired_date" type="text" autocomplete="off" style="width:220px" />
				</div>
			</div>
            <div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('status')}</strong></div>
                <div class="fieldarea">
					<div class="checkbox-switch">
						{if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}
						<input type="checkbox" checked value="1" name="is_online" class="input-checkbox" id="toolbar-active">
						{else}
						<input type="checkbox" value="1" name="is_online" class="input-checkbox" id="toolbar-active">
						{/if}
						<div class="checkbox-animate">
							<span class="checkbox-off">PRIVATE</span>
							<span class="checkbox-on">PUBLIC</span>
						</div>
					</div>	
					<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
					<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
				</div>
			</div>
			<div class="row-span">
                <div class="fieldlabel bold"><strong>{$core->get_Lang('Link Demo')}</strong> </div>
                <div class="fieldarea">
                    <div class="span75 fl" style="margin-right: 10px;">
						<input id="myLinkDemo" class="text_32 full-width border_aaa" style="padding:5px"  value="{$clsClassTable->getLinkDemo($pvalTable)}" maxlength="255" type="text"></div>
					<div class="span20 fl">
						<button type="button" onclick="myFunction()" onmouseout="outFunc()" class="text_32 border_aaa">
						Copy Link
						</button>
					</div>
                </div>
            </div>
			{literal}
			<style>
				#myLinkDemo{border: 0!important; background: #EEE}
				.package_item input{margin:0 5px 0 0}
			</style>
			<script>
				function myFunction() {
				  var copyText = document.getElementById("myLinkDemo");
				  copyText.select();
				  copyText.setSelectionRange(0, 99999);
				  document.execCommand("copy");
				  alert("Copied the url: " + copyText.value);
				}
			</script>
			{/literal}
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden" />
        </fieldset>
    </form>
</div>
{literal}
<script>
$(".showdate").datepicker({dateFormat: "dd/mm/yy",minDate: "+0D", maxDate: "+10Y",});
</script>
{/literal}
{literal}
<script type="text/javascript">
$('.changeToStore').live('change',function(){
	var $_this = $(this);
	var type= $_this.attr('_type');
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajUpdateCustomerType',
		data:{'_type' : $_this.attr('_type'),'customer_id': $_this.attr('data'),'val' : $_this.is(':checked')?1:0},
		dataType:'html',
		success: function(html){
		}
	});
});
</script>
{/literal}