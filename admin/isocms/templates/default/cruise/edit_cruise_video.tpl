<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod=cruise">{$core->get_Lang('Cruise Management')}</a>
	<a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod=cruise_itinerary&cruise_id={$cruise_id}">{$core->get_Lang('Cruise Video Management')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('Back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$core->get_Lang('Cruise Video Management')}</h2>
    	{$core->get_Lang('Cruise Video Management Module by VietISO')}<br />
    </div>
<!--	<div class="infobox">
		<b>{$clsCruise->getTitle($cruise_id)}</b><br />
	</div>-->
	<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
		<fieldset>
			<legend>{if $pvalTable gt '0'}{$core->get_Lang('Edit Video')}{else}{$core->get_Lang('Add New Video')}{/if}</legend>
			<div class="row-span">
				<div class="fieldlabel text-right"><strong>{$core->get_Lang('Video Title')}</strong> <span class="color_r">*</span></div>
				<div class="fieldarea">
					<input class="text_32 full-width border_aaa fontLarge required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
				</div>		
			</div>
            <div class="row-span">
				<div class="fieldlabel text-right"><strong>{$core->get_Lang('Video Link')}</strong> <span class="color_r">*</span></div>
				<div class="fieldarea">
					<input class="text_32 full-width border_aaa required" name="iso-url" value="{$clsClassTable->getLink($pvalTable)}" maxlength="255" type="text" placeholder="https://www.youtube.com/watch?v=bFW_FnCwnuU" />
				</div>		
			</div>
			
		</fieldset>
		<div class="clearfix"><br /></div>
		<fieldset class="submit-buttons">
			 {$saveBtn}{$saveList}
			<input value="Update" name="submit" type="hidden">
		</fieldset>
	</form>
</div>	
<script type="text/javascript">
	var $cruise_video_id='{$pvalTable}';
	var $cruise_id = '{$clsClassTable->getOneField("cruise_id",$pvalTable)}';
</script>
{literal}
<script>
$(document).on("submit","form",function(){
	vietiso_loading(1);
});
</script>
{/literal}