<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}&act=cat">{$core->get_Lang('travelguidecat')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
	<!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable gt 0}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New TravelGuide Category')}{/if}</h2>
        <p>{$core->get_Lang('Please enter all required fields')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul><li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li></ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
					<div class="fl col_Left full_width_767">
						<div class="photobox image">
							{if $_isoman_use eq '1'}
							<img src="{$clsClassTable->getImage($pvalTable,600,400)}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$clsClassTable->getOneField('image',$pvalTable)}" />
							<a href="javascript:void()" title="{$core->get_Lang('edit')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$clsClassTable->getOneField('image',$pvalTable)}" isoman_name="image"><i class="iso-edit"></i></a>
							{if $oneItem.image}
							<a pvalTable="{$pvalTable}" clsTable="GuideCat" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
							{/if}
							{else}
							<img src="{$clsClassTable->getOneField('image',$pvalTable)}" alt="{$core->get_Lang('noimages')}" id="imgGuideCat_image" />
							<input type="hidden" name="image_src" value="{$clsClassTable->getOneField('image',$pvalTable)}" class="hidden_src" id="imgGuideCat_hidden" />
							<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgGuideCat">
								<i class="iso-edit"></i>
							</a> 
							<input type="file" style="display:none" id="imgGuideCat_file" g="imgGuideCat" class="editInlineImageFile" name="image" />
							{/if}
						</div>
					</div>
					<div class="fr col_Right full_width_767">
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Name')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
                                <input class="text_32 full-width border_aaa bold title_capitalize required" id="title" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong></div>
                            <div class="fieldarea">
                                <div class="vietiso_status_button"></div>
                                <script type="text/javascript">
                                    var is_online = '{$clsClassTable->getOneField("is_online",$pvalTable)}';
                                </script>
                                {literal}
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('.vietiso_status_button').isoswitchvalue({
                                            _value: is_online,
                                            _selector: 'iso-is_online'
                                        });
                                    });
                                </script>
                                {/literal}
                                <span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('Tours only be seen via the link in the admin page')}!</span>
                                <span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('Tours are available online at the list normality')}!</span>
                            </div>
                        </div>
					</div>
                </div>
				<div class="wrap">
					{if $clsISO->getBrowser() eq 'computer'}
					<div id="v-nav">
						<ul>
							<li class="tabchildcol first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('Intro')}</strong></a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Banner')}</strong></a> <span class="color_r">*</span></li>
						</ul>
						<div class="tab-content" style="display: block;">
							<div class="format-setting-wrap">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="tab-content" style="display: none;">
							<div class="format-setting-wrap">
								 <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Banner Size')} (1920x480)</strong></div>
                            <div class="fieldarea">
								<div class="photobox photoBanner image span100">
									{if $_isoman_use eq '1'}
									<img src="{$clsClassTable->getBanner($pvalTable,1920,480)}" alt="{$core->get_Lang('images_banner')}" id="isoman_show_banner" class="span100" />
									<input type="hidden" id="isoman_hidden_banner" name="isoman_url_banner" value="{$oneItem.banner}" />
									<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="banner" isoman_val="{$oneItem.banner}" isoman_name="banner"><i class="iso-edit"></i></a>
									{if $oneItem.banner}
									<a pvalTable="{$pvalTable}" clsTable="GuideCat" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-type="banner" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
									{/if}
									{else}
									<img src="{$clsClassTable->getBanner($pvalTable,1920,480)}" alt="{$core->get_Lang('noimages')}" id="imgTour_banner" class="span100" />
									<input type="hidden" name="banner_src" value="{$oneItem.banner}" class="hidden_src" id="imgTour_hidden" />
									<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
									<i class="iso-edit"></i>
									</a> 
									<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="banner" />
									{/if}
								</div>
								<div class="span100 mt10">
									<h3 class="mb10">{$core->get_Lang('Banner Link')}</h3>
									<input class="text_32 full-width border_aaa" type="text" name="iso-link_banner" value="{$oneItem.link_banner}" placeholder="{$DOMAIN_NAME}" />
								</div>
								<div class="span100 mt10">
									<h3 class="mb10">{$core->get_Lang('Banner Content')}</h3>
									{$clsForm->showInput('intro_banner')}
								</div>
							</div>
						</div>
							</div>
						</div>
					</div>
					{else}
					<div id="v-nav">
						<div class="row-span">
                            <div class="fieldlabel bold">{$core->get_Lang('Intro')}</div>
                            <div class="fieldarea">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="row-span">
                            <div class="fieldlabel bold">{$core->get_Lang('Banner')}</div>
                            <div class="fieldarea">
								<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Banner Size')} (1920x480)</strong></div>
                            <div class="fieldarea">
								<div class="photobox photoBanner image span100">
									{if $_isoman_use eq '1'}
									<img src="{$clsClassTable->getBanner($pvalTable,1920,480)}" alt="{$core->get_Lang('images_banner')}" id="isoman_show_banner" class="span100" />
									<input type="hidden" id="isoman_hidden_banner" name="isoman_url_banner" value="{$oneItem.banner}" />
									<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="banner" isoman_val="{$oneItem.banner}" isoman_name="banner"><i class="iso-edit"></i></a>
									{if $oneItem.banner}
									<a pvalTable="{$pvalTable}" clsTable="GuideCat" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-type="banner" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
									{/if}
									{else}
									<img src="{$clsClassTable->getBanner($pvalTable,1920,480)}" alt="{$core->get_Lang('noimages')}" id="imgTour_banner" class="span100" />
									<input type="hidden" name="banner_src" value="{$oneItem.banner}" class="hidden_src" id="imgTour_hidden" />
									<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
									<i class="iso-edit"></i>
									</a> 
									<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="banner" />
									{/if}
								</div>
								<div class="span100 mt10">
									<h3 class="mb10">{$core->get_Lang('Banner Link')}</h3>
									<input class="text_32 full-width border_aaa" type="text" name="iso-link_banner" value="{$oneItem.link_banner}" placeholder="{$DOMAIN_NAME}" />
								</div>
								<div class="span100 mt10">
									<h3 class="mb10">{$core->get_Lang('Banner Content')}</h3>
									{$clsForm->showInput('intro_banner')}
								</div>
							</div>
						</div>
							</div>
						</div>
					</div>
					{/if}
					
				</div>
        	</div>
        </div>
		<div class="clearfix"><br /></div>
		<fieldset class="submit-buttons">
			{$saveBtn} {$saveList}
			<input value="Update" name="submit" type="hidden">
		</fieldset>
    </form>
</div>
<script type="text/javascript">
	var $countCountry = '{$countCountry}';
	var $guidecat_id = '{$pvalTable}';
</script>
{literal}
<script type="text/javascript">
$().ready(function(){
	loadCountryContent($guidecat_id);
	/**/
	$(document).on('change', '.chk_SelectCountry', function(ev){
		var $_this = $(this);
		var adata = {
			'tp' : 'S',
			'guidecat_id' : $guidecat_id,
			'country_id' : $_this.val(),
			'flag' : $_this.is(':checked')?1:0
		};
		vietiso_loading(1);
		$.ajax({	
			type: "POST",
			url: path_ajax_script+'/?mod='+mod+'&act=SiteGuideCatStore',	
			data: adata,	
			dataType: "html",	
			success: function(html){
				vietiso_loading(0);
				loadCountryContent($guidecat_id);
			}	
		});	
	});
});
function loadCountryContent($guidecat_id){
	var adata = {
		'tp' : 'L',
		'guidecat_id' : $guidecat_id
	};
	$.ajax({	
		type: "POST",
		url: path_ajax_script+'/?mod='+mod+'&act=SiteGuideCatStore',	
		data: adata,	
		dataType: "html",	
		success: function(html){
			$('#pT').html(html);
			makeGlobalTab('globaltabs_optional');
			$('.Site_GuideCat_Content_Editor').each(function(){
				var $editorID = $(this).attr('id');
				$('#'+$editorID).isoTextAreaFix();
			});
		}	
	});
}
</script>
{/literal}