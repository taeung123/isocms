<div class="tabbox departureTab" style="display:none; float:left">
	<div class="wrap" style="margin-bottom:30px">
		<div class="fl span100">
			<div class="tabs_content" id="lstTabs">
				<div class="contentTab">
					{*<a style="vertical-align:middle" href="javascript:void(0);" id="clickAddPromotion" clsTable="Combo" type="Combo" target_id="{$pvalTable}" class="iso-button-primary fl mb10"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('Add New')}</a>*}
					<a style="vertical-align:middle" href="javascript:void(0);" id="clickInsertPromotionGroup" clsTable="Tour" type="Tour" target_id="{$pvalTable}" class="iso-button-primary fl mb10 clickInsertPromotionGroup"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('Join in Promotion Pro')}</a>
					<a style="vertical-align:middle;background-color: #91ccff !important;padding: 0 10px;" href="javascript:void(0);" id="clickInsertPromotion" clsTable="Tour" type="Tour" target_id="{$pvalTable}" class="iso-button-primary fl mb10 clickInsertPromotion"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('Add New Promotion Pro')}</a>
					 {*<div id="ListPromotion" style="border:2px dashed red; padding:15px 10px; float:left; width:100%"></div>*}
					 <div id="ListPromotionPro" style="border:2px dashed red; padding:15px 10px; float:left; width:100%"></div>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
	<script type="text/javascript">
	$(document).ready(function(){
		// loadPromotion($combo_id,'Combo');
		loadPromotionPro($combo_id,'Combo');
	});
	</script>
{/literal}