<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang($mod)}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$core->get_Lang('setting')}">{$core->get_Lang('setting')}</a>
</div>
<div class="clearfix"></div>
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
				<div class="form-group">
					<label class="col-form-label" for="config_value_title">{$core->get_Lang('Meta Title')}</label>
					<input class="form-control required" name="iso-SiteMetaTitle" id="config_value_title" value="{$clsConfiguration->getValue('SiteMetaTitle')}" maxlength="255" type="text">
				</div>
				<div class="form-group">
					<label class="col-form-label" for="config_value_intro">{$core->get_Lang('Meta Description')}</label>
					<textarea name="iso-SiteMetaDescription" id="config_value_intro" class="form-control" >{$clsConfiguration->getValue('SiteMetaDescription')}</textarea>
				</div>
				<div class="form-group inpt_tour">
					<label class="col-form-label">{$core->get_Lang('Meta Image')}</label>
					<div class="row">
						<div class="col-md-5 col-sm-12">
							<div class="filedrop-picker">
								<div class="filedrop" onclick="file_explorer(this,event);" ondrop="file_drop(this,event)" toId="selectFile" hiddenId="isoman_hidden_image_seo" data-options='{ldelim}"openFrom":"seo","clsTable":"Configuration", "table_id":"{$meta_id}","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim}' ondragover="return false">
									<h3>Kéo ảnh vào đây để tải lên</h3>
									<p>Kích thước (WxH=500x261)<br>
									Các loại tệp được hỗ trợ là: .png,.jpg,.jpeg</p>
									<button type="button" class="btn btn-upload">{$core->get_Lang('From computer')}</button>
								</div>
								<input type="hidden" name="iso-ImageShareSocial" value="{$meta_id}">
								<input class="hidden" id="selectFile" type="file" data-options='{ldelim}"seo":"image","clsTable":"Configuration", "table_id":"{$meta_id}","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim}'>
								<div class="clearfix mt-half"></div>
								<a table_id="{$meta_id}" isoman_multiple="0" isoman_callback='isoman_callback({ldelim}"openFrom":"seo", "clsTable":"Configuration", "table_id":"{$meta_id}","toField":"image","toId":"isoman_show_image_seo","hiddenId":"isoman_hidden_image_seo"{rdelim})' class="btn btn-upload-choice ajOpenDialog" isoman_for_id="image_seo" isoman_name="image">{$clsISO->makeIcon('folder-o', $core->get_Lang('From library'))}</a>
							</div>
						</div>
						<div class="col-xs-12 col-md-4">
							<div class="aspect-ratio aspect-ratio--square aspect-ratio--square--full aspect-ratio--interactive">
								<input type="hidden" id="isoman_hidden_image_seo" name="iso-ImageShareSocial" value="{$clsConfiguration->getValue('ImageShareSocial')}" />
								<img class="aspect-ratio__content radius-3" id="isoman_show_image_seo" src="{$clsConfiguration->getValue('ImageShareSocial')}" width="250px" height="170px" />
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-form-label" for="config_value_twitter_site">{$core->get_Lang('twitter:site')}</label>
					<input class="form-control" name="iso-SiteTwitterSite" id="config_value_twitter_site" value="{$clsConfiguration->getValue('SiteTwitterSite')}" type="text">
				</div>
				<div class="form-group">
					<label class="col-form-label" for="config_value_twitter_creator">{$core->get_Lang('twitter:creator')}</label>
					<input class="form-control" name="iso-SiteTwitterCreator" id="config_value_twitter_creator" value="{$clsConfiguration->getValue('SiteTwitterCreator')}" type="text">
				</div>
				<fieldset class="submit-buttons">
					{$saveBtn}
					<input value="UpdateConfiguration" name="submit" type="hidden">
				</fieldset>
				
			</form>
		</div>
	</div>
</div>
{literal}
<style>
	.isoman_img_pop{ width:100px; height:35px; border:1px solid #ccc; padding:1px;}
</style>
{/literal}
