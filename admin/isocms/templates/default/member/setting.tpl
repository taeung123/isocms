<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('contact')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$mod}">{$core->get_Lang('settingcontact')}</a>
</div>
<div class="clearfix"></div>
<div class="page_container page-tour_setting">
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
				<h3 class="title_box">{$core->get_Lang('box right member intro 1')}</h3>
				{assign var=site_member_intro value=site_member_intro_|cat:$_LANG_ID}
				<textarea id="textarea_intro_editor{$now}" class="textarea_intro_editor" name="iso-{$site_member_intro}" style="width:100%">{$clsConfiguration->getValue($site_member_intro)}</textarea>
				<div class="clearfix"></br></div>
				
				<h3 class="title_box">{$core->get_Lang('box right member intro 2')}</h3>
				{assign var=site_member_intro2 value=site_member_intro2_|cat:$_LANG_ID}
				<textarea id="textarea_intro_editor2{$now}" class="textarea_intro_editor" name="iso-{$site_member_intro2}" style="width:100%">{$clsConfiguration->getValue($site_member_intro2)}</textarea>
				<div class="clearfix"></br></div>
				{$core->getBlock('setting_module_background_member')}
				<fieldset class="submit-buttons">
					{$saveBtn}
					<input value="UpdateConfiguration" name="submit" type="hidden">
				</fieldset>
			</form>
		</div>
		
	</div>
</div>
<script type="text/javascript" src="{$PCMS_URL}/editor/tiny_mce/tiny_mce.js"></script>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").datepicker();
	});
</script>
{/literal}