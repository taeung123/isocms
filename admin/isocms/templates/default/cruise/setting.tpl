<div class="page_container page-tour_setting">
	{$core->getBlock('header_title_module_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		{$core->getBlock('menu_cruise_setting')}
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('Module Setting')}</h2>
				</div>
			</div>
			<form method="post" action="" enctype="multipart/form-data">
				<div class="inpt_tour">
                    <h4 class="mb10">{$core->get_Lang('Booking Includes')}</h4>
					<textarea style="width:100%" table_id="{$pvalTable}" name="iso-{"site_cruise_include_$_LANG_ID"}" class="textarea_intro_editor" data-column="iso-intro" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$clsConfiguration->getValue("site_cruise_include_$_LANG_ID")}</textarea>
				</div>
				<div class="clearfix mt10"></div>
				<fieldset class="submit-buttons">
					{$saveBtn}
					<input value="UpdateConfiguration" name="submit" type="hidden">
				</fieldset>
			</form>
		</div>
	</div>
</div>