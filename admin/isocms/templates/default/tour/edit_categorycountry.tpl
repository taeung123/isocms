<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/?mod={$mod}&act=category_country">{$core->get_Lang('Travel Styles by Country')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
	<!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{if $pvalTable}{$core->get_Lang('Edit Travel Styles by Country')}{else}{$core->get_Lang('Add Travel Styles by Country')}{/if} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {if $pvalTable}{$core->get_Lang('Edit Travel Styles by Country')}{else}{$core->get_Lang('Add Travel Styles by Country')}{/if} trong hệ thống isoCMS">i</div>
			</h2>
			<p>{$core->get_Lang('Please enter all required fields')}</p>
		</div>
    </div>
	<div class="container-fluid">
		<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
			<div id="clienttabs">
				<ul>
					<li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
					{if $pvalTable}<li class="tabchild" style="display:none"><a href="#"><i class="iso-media"></i> {$core->get_Lang('seosdvanced')}</a></li>{/if}
				</ul>
			</div>
			<div class="clearfix"></div>
			<div id="tab_content">
				<div class="tabbox" style="display:block">
					<div class="wrap">
						<div class="fl col_Left full_width_767">
							<div class="photobox mb10 image">
								{if $_isoman_use eq '1'}
								<img src="{$oneTable.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
								<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneTable.image}" />
								<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneTable.image}" isoman_name="image"><i class="iso-edit"></i></a>
								{if $oneTable.image}
								<a pvalTable="{$pvalTable}" clsTable="Category_Country" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
								{/if}
								{else}
								<img src="{$oneTable.image}" alt="{$core->get_Lang('noimages')}" id="imgTestimonial_image" />
								<input type="hidden" name="image_src" value="{$oneTable.image}" class="hidden_src" id="imgTestimonial_hidden" />
								<a href="javascript:void()" title="{$_lang->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTestimonial">
									<i class="iso-edit"></i>
								</a> 
								<input type="file" style="display:none" id="imgTestimonial_file" g="imgTestimonial" class="editInlineImageFile" name="image" />
								{/if}
							</div>
							<h3 style="margin-bottom:5px">{$core->get_Lang('Image Size')} <span class="text-small">(WxH=532x355)</span></h3>
						</div>
						<div class="fl col_Right full_width_767">
							{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
							<div class="row-span">
								<div class="fieldlabel" {$country_id|var_dump}><strong>{$core->get_Lang('Travel Styles')} <font class="color_r">*</font></strong></div>
								<div class="fieldarea">
									<select name="cat_id" class="glSlBox required">
										 {$clsTourCategory->makeSelectboxOptionCountry($country_id,$cat_id)}
									</select>
								</div>
							</div>
							{/if}
							 <div class="row-span">
								<div class="fieldlabel"><strong>{$core->get_Lang('Destination')}<span class="color_r">*</span></strong></div>
								<div class="fieldarea">
								   <select class="slb full glSlBox" name="iso-country_id" id="slb_Country">
										{$clsCountry->makeSelectboxOption($country_id)}
									</select>
								</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel"><strong>{$core->get_Lang('status')} <font class="color_r">*</font></strong></div>
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
					</div>
					<div class="wrap mt20">
						{if $clsISO->getBrowser() eq 'computer'}
						<div id="v-nav">
							<ul>
								<li class="tabchildcol first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('Long text')}</strong></a></li>
								{if 1 eq 2}
								<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('bannercover')}</strong></a></li>
								{/if}
							</ul>
							<div class="tab-content" style="display: block;">
								<div class="format-setting-wrap">
									 {$clsForm->showInput('content')}
								</div>
							</div>
							<div class="tab-content" style="display: none;">
								<h3 style="margin-bottom:10px">{$core->get_Lang('Banner Size')} (1600x460)</h3>
								<div class="photobox photoBanner span100">
									{if $_isoman_use eq '1'}
									<img src="{$clsClassTable->getBannerImage($pvalTable,1600,460)}" alt="{$core->get_Lang('images')}" id="isoman_show_image_banner" class="span100"/>
									<input type="hidden" id="isoman_hidden_image_banner" name="isoman_url_image_banner" value="{$oneTable.image_banner}" />
									<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_banner" isoman_val="{$oneTable.image_banner}" isoman_name="image_banner"><i class="iso-edit"></i></a>
									{if $oneTable.image_banner}
									<a pvalTable="{$pvalTable}" clsTable="Category_Country" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image_banner" g="imgItem">X</a>
									{/if}
									{else}
									<img src="{$clsClassTable->getBannerImage($pvalTable,1600,460)}" alt="{$core->get_Lang('noimages')}" id="imgTour_image_banner" class="span100"/>
									<input type="hidden" name="image_banner_src" value="{$oneTable.image_banner}" class="hidden_src" id="imgTour_hidden" />
									<a href="javascript:void()" title="{$_lang->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
										<i class="iso-edit"></i>
									</a> 
									<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image_banner" />
									{/if}
								</div>
								<div class="span100 mt10">
									<h3 class="mb10">{$core->get_Lang('Banner Link')}</h3>
									<input class="text_32 full-width border_aaa" type="text" name="iso-link_banner" value="{$oneTable.link_banner}" placeholder="{$DOMAIN_NAME}" />
								</div>
								<div class="span100 mt10">
									<h3 class="mb10">{$core->get_Lang('Banner Content')}</h3>
									{$clsForm->showInput('intro_banner')}
								</div>
							</div>
						</div>
						{else}
						<div id="v-nav">
							<div class="row-span">
								<div class="fieldlabel"><strong>{$core->get_Lang('Short text')} <font class="color_r">*</font></strong></div>
								<div class="fieldarea">
									 {$clsForm->showInput('intro')}
								</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel"><strong>{$core->get_Lang('Long text')} <font class="color_r">*</font></strong></div>
								<div class="fieldarea">
									 {$clsForm->showInput('content')}
								</div>
							</div>
							<div class="row-span">
								<div class="fieldlabel"><strong>{$core->get_Lang('Banner Size')} (1600x460)<font class="color_r">*</font></strong></div>
								<div class="fieldarea">
									<div class="photobox photoBanner span100">
										{if $_isoman_use eq '1'}
										<img src="{$clsClassTable->getBannerImage($pvalTable,1600,460)}" alt="{$core->get_Lang('images')}" id="isoman_show_image_banner" class="span100"/>
										<input type="hidden" id="isoman_hidden_image_banner" name="isoman_url_image_banner" value="{$oneTable.image_banner}" />
										<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_banner" isoman_val="{$oneTable.image_banner}" isoman_name="image_banner"><i class="iso-edit"></i></a>
										{if $oneTable.image_banner}
										<a pvalTable="{$pvalTable}" clsTable="Category_Country" href="javascript:void()" title="{$core->get_Lang('delete')}" data-name_input="isoman_url_image_banner" class="photobox_edit deleteItemImage" g="imgItem">X</a>
										{/if}
										{else}
										<img src="{$clsClassTable->getBannerImage($pvalTable,1600,460)}" alt="{$core->get_Lang('noimages')}" id="imgTour_image_banner" class="span100"/>
										<input type="hidden" name="image_banner_src" value="{$oneTable.image_banner}" class="hidden_src" id="imgTour_hidden" />
										<a href="javascript:void()" title="{$_lang->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
											<i class="iso-edit"></i>
										</a> 
										<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image_banner" />
										{/if}
									</div>
									<div class="span100 mt10">
										<h3 class="mb10">{$core->get_Lang('Banner Link')}</h3>
										<input class="text_32 full-width border_aaa" type="text" name="iso-link_banner" value="{$oneTable.link_banner}" placeholder="{$DOMAIN_NAME}" />
									</div>
									<div class="span100 mt10">
										<h3 class="mb10">{$core->get_Lang('Banner Content')}</h3>
										{$clsForm->showInput('intro_banner')}
									</div>
								</div>
							</div>
						</div>
						{/if}
					</div>
				</div>
				{if $pvalTable}
				<div class="tabbox" style="display:none">
					<div class="row-field">
						<div class="row-heading">{$core->get_Lang('Meta Title')}:</div>
						<div class="coltrols">
							<input class="text full" name="config_value_title" value="{$clsISO->getPageTitle($pvalTable,Category_Country)}" maxlength="255" type="text">
							<div class="clearfix mt5"></div>
							<i>{$core->get_Lang('notetitlemeta')}</i>
						</div>
					</div>
					<div class="row-field">
						<div class="row-heading">{$core->get_Lang('Meta Description')}:</div>
						<div class="coltrols">
							<textarea name="config_value_intro" class="text full" style="height:60px">{$clsISO->getPageDescription($pvalTable,Category_Country)}</textarea>
							<div class="clearfix mt5"></div>
							<i>{$core->get_Lang('noteintrometa')}</i>
						</div>
					</div>
					<div class="row-field">
						<div class="row-heading">{$core->get_Lang('Meta Keyword')}:</div>
						<div class="coltrols">
							<textarea name="config_value_keyword" class="text full" style="height:60px">{$clsISO->getPageKeyword($pvalTable,Category_Country)}</textarea>
							<div class="clearfix mt5"></div>
							<i>{$core->get_Lang('notekeywordmeta')}</i>
							<br style="clear:both" />
							<br style="clear:both" />
							<table>
								<tr>
									<td style="background:#CCC">{$core->get_Lang('Meta Robots Index')}</td>
									<td>
										<select name="meta_index">
											<option value="0">{$core->get_Lang('Index')}</option>
											<option value="1" {if $oneMeta.meta_index eq 1}selected="selected"{/if}>{$core->get_Lang('NoIndex')}</option>
										</select>
									</td>
									<td style="background:#CCC">{$core->get_Lang('Meta Robots Follow')}</td>
									<td>
										<select name="meta_follow">
											<option value="0">{$core->get_Lang('Follow')}</option>
											<option value="1" {if $oneMeta.meta_follow eq 1}selected="selected"{/if}>{$core->get_Lang('NoFollow')}</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				{/if}
			</div>
			<div class="clearfix"><br /></div>
			<fieldset class="submit-buttons">
				{$saveBtn} {$saveList}
				<input value="Update" name="submit" type="hidden">
			</fieldset>
		</form>
	</div>
</div>
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
{literal}
<script type="text/javascript">
$().ready(function(){
	$(".chosen-select").chosen({width:'100%'});
	
	$('select[name=iso-country_id]').change(function() {
            var $_this = $(this);
            $('select[name=iso-city_id]').html('<option value="">'+loading+'</option>');
            $.ajax({
                type: "POST",
                url: path_ajax_script+'/index.php?mod=guide&act=loadCity',
                data: {"country_id": $_this.val()},
                dataType: "html",
                success: function(html) {
                    $('select[name=iso-city_id]').html(html);
                }
            });
        });
});
</script>
{/literal}