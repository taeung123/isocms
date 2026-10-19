{literal}
<style>
	#clienttabs > ul > li > a{ padding:0px 10px !important;}
</style>
{/literal}
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('settings')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2><i class="fa fa-wrench"></i> {$core->get_Lang('settings')}</h2>
		<p>{$core->get_Lang('systemmanagementsettings')}</p>
    </div>
    <div class="clearfix"></div>
    <form id="forums" method="post" class="filterForm" action="">
		<fieldset>
			<legend>{$core->get_Lang('Chiết khấu')}%</legend>
			<div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('Dành cho Đại lý du lịch')}</div>
				<div class="fieldarea">
                	<input class="text_32 border_aaa bold" type="text" value="{$clsISO->processFloatNumber($clsConfiguration->getValue('DiscountAgent'))}" name="iso-DiscountAgent" />(%)
				</div>
			</div>
			<div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('Dành cho Cộng tác viên')}</div>
				<div class="fieldarea">
                	<input class="text_32 border_aaa bold" type="text" value="{$clsConfiguration->getValue('DiscountCTV')}" name="iso-DiscountCTV" />(%)
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend>{$core->get_Lang('Tại sao chọn chúng tôi cho doanh nghiệp của bạn?')}</legend>
			<div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('intro')}</div>
				<div class="fieldarea">
                	{assign var = Site_WhyAgent value = Site_WhyAgent_|cat:$_LANG_ID}
					<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$Site_WhyAgent}" id="{$Site_WhyAgent}" cols="255" rows="2">{$clsConfiguration->getValue($Site_WhyAgent)}</textarea>
				</div>
			</div>
			<div class="box_why">
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentTitle_box_1 value = Site_WhyAgentTitle_box_1_|cat:$_LANG_ID}
						<input type="text" name="iso-{$Site_WhyAgentTitle_box_1}" value="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_1)}" class="text full" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Icon')}</div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_Site_WhyAgentIcon_box_1" src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_1')}" style="width:32px" height="32px" />
						<input type="text" name="isoman_url_Site_WhyAgentIcon_box_1" id="isoman_hidden_Site_WhyAgentIcon_box_1" value="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_1')}" class="text_32 border_aaa ml10" style="width:calc(100% - 80px) !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="Site_WhyAgentIcon_box_1" isoman_val="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_1')}" isoman_name="Site_WhyAgentIcon_box_1"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentIntro_box_1 value = Site_WhyAgentIntro_box_1_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$Site_WhyAgentIntro_box_1}" id="{$Site_WhyAgentIntro_box_1}" cols="255" rows="2">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_1)}</textarea>
					</div>
				</div>
			</div>
			<div class="box_why">
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentTitle_box_2 value = Site_WhyAgentTitle_box_2_|cat:$_LANG_ID}
						<input type="text" name="iso-{$Site_WhyAgentTitle_box_2}" value="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_2)}" class="text full" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Icon')}</div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_Site_WhyAgentIcon_box_2" src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_2')}" style="width:32px" height="32px" />
						<input type="text" name="isoman_url_Site_WhyAgentIcon_box_2" id="isoman_hidden_Site_WhyAgentIcon_box_2" value="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_2')}" class="text_32 border_aaa ml10" style="width:calc(100% - 80px) !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="Site_WhyAgentIcon_box_2" isoman_val="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_2')}" isoman_name="Site_WhyAgentIcon_box_2"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentIntro_box_2 value = Site_WhyAgentIntro_box_2_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$Site_WhyAgentIntro_box_2}" id="{$Site_WhyAgentIntro_box_2}" cols="255" rows="2">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_2)}</textarea>
					</div>
				</div>
			</div>
			<div class="box_why">
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentTitle_box_3 value = Site_WhyAgentTitle_box_3_|cat:$_LANG_ID}
						<input type="text" name="iso-{$Site_WhyAgentTitle_box_3}" value="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_3)}" class="text full" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Icon')}</div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_Site_WhyAgentIcon_box_3" src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_3')}" style="width:32px" height="32px" />
						<input type="text" name="isoman_url_Site_WhyAgentIcon_box_3" id="isoman_hidden_Site_WhyAgentIcon_box_3" value="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_3')}" class="text_32 border_aaa ml10" style="width:calc(100% - 80px) !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="Site_WhyAgentIcon_box_3" isoman_val="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_3')}" isoman_name="Site_WhyAgentIcon_box_3"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentIntro_box_3 value = Site_WhyAgentIntro_box_3_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$Site_WhyAgentIntro_box_3}" id="{$Site_WhyAgentIntro_box_3}" cols="255" rows="2">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_3)}</textarea>
					</div>
				</div>
			</div>
			
		</fieldset>
		<fieldset>
			<legend>{$core->get_Lang('Lựa chọn hình thức liên kết')}</legend>
			<div class="row-span">
				<div class="fieldlabel">{$core->get_Lang('intro')}</div>
				<div class="fieldarea">
                	{assign var = Site_WhyAgent2 value = Site_WhyAgent2_|cat:$_LANG_ID}
					<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$Site_WhyAgent2}" id="{$Site_WhyAgent2}" cols="255" rows="2">{$clsConfiguration->getValue($Site_WhyAgent2)}</textarea>
				</div>
			</div>
			<div class="box_why">
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentTitle_box_4 value = Site_WhyAgentTitle_box_4_|cat:$_LANG_ID}
						<input type="text" name="iso-{$Site_WhyAgentTitle_box_4}" value="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_4)}" class="text full" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Icon')}</div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_Site_WhyAgentIcon_box_4" src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_4')}" style="width:32px" height="32px" />
						<input type="text" name="isoman_url_Site_WhyAgentIcon_box_4" id="isoman_hidden_Site_WhyAgentIcon_box_4" value="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_4')}" class="text_32 border_aaa ml10" style="width:calc(100% - 80px) !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="Site_WhyAgentIcon_box_4" isoman_val="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_4')}" isoman_name="Site_WhyAgentIcon_box_4"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentIntro_box_4 value = Site_WhyAgentIntro_box_4_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$Site_WhyAgentIntro_box_4}" id="{$Site_WhyAgentIntro_box_4}" cols="255" rows="2">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_4)}</textarea>
					</div>
				</div>
			</div>
			<div class="box_why">
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentTitle_box_5 value = Site_WhyAgentTitle_box_5_|cat:$_LANG_ID}
						<input type="text" name="iso-{$Site_WhyAgentTitle_box_5}" value="{$clsConfiguration->getValue($Site_WhyAgentTitle_box_5)}" class="text full" />
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Icon')}</div>
					<div class="fieldarea">
						<img class="isoman_img_pop" id="isoman_show_Site_WhyAgentIcon_box_5" src="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_5')}" style="width:32px" height="32px" />
						<input type="text" name="isoman_url_Site_WhyAgentIcon_box_5" id="isoman_hidden_Site_WhyAgentIcon_box_5" value="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_5')}" class="text_32 border_aaa ml10" style="width:calc(100% - 80px) !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="Site_WhyAgentIcon_box_5" isoman_val="{$clsConfiguration->getValue('Site_WhyAgentIcon_box_5')}" isoman_name="Site_WhyAgentIcon_box_5"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = Site_WhyAgentIntro_box_5 value = Site_WhyAgentIntro_box_5_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$Site_WhyAgentIntro_box_5}" id="{$Site_WhyAgentIntro_box_5}" cols="255" rows="2">{$clsConfiguration->getValue($Site_WhyAgentIntro_box_5)}</textarea>
					</div>
				</div>
			</div>
		</fieldset>
		<fieldset class="submit-buttons">
			{$saveBtn}
			<input value="Update" name="submit" type="hidden">
		</fieldset>
	</form>
</div>
<script type="text/javascript">
	var $type = 'WhyUsHomePage';
	var $target_id = '0';
</script>
{literal}
<script type="text/javascript">
	$(function(){
		if($('.textarea_intro_editor_simple').length > 0){
			$('.textarea_intro_editor_simple').each(function(){
				var $_this = $(this);
				var $editorID = $_this.attr('id');
				$('#'+$editorID).isoTextAreaFix();
			});
		}
	});
</script>
{/literal}