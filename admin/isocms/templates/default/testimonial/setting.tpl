<div class="page-tour_setting">
	{$core->getBlock('header_title_module_setting')}
	<div class="container-fluid container-fluid-2 d-flex">
		<div class="menu_setting_box">
			<ul class="ul_menu_setting">
				<li class="current">
					<a href="http://isocms.com/admin/?mod={$mod}&act={$act}">
						<span class="text">Cài đặt module</span>
					</a>
				</li>
			</ul>
		</div>
		<div class="content_setting_box">
			<div class="page_detail-title d-flex">
				<div class="title">
					<h2>{$core->get_Lang('setting')}</h2>
				<p>{$core->get_Lang('systemmanagementsetting')}</p>
				</div>
			</div>
			<form method="post" action="" enctype="multipart/form-data">
			<h3 class="title_box">{$core->get_Lang('intropage')}</h3>
				{assign var=site_mod_intro value='site_'|cat:$mod|cat:'_intro_'|cat:$_LANG_ID}
				<textarea id="textarea_intro_editor{$now}" class="textarea_intro_editor" name="iso-{$site_mod_intro}" style="width:100%">{$clsConfiguration->getValue($site_mod_intro)}</textarea>
				<div class="clearfix"></br></div>
				{$core->getBlock('meta_box_module_blog')}
				<fieldset class="submit-buttons">
					{$saveBtn}
					<input value="UpdateConfiguration" name="submit" type="hidden">
				</fieldset>
			</form>
		</div>
		
	</div>
</div>