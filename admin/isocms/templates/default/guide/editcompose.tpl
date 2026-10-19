<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Travel Guide Category by Cities')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
	<!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
    	<h2>{if $pvalTable}{$core->get_Lang('Edit Travel Guide Category by Cities')}{else}{$core->get_Lang('Add Travel Guide Category by Cities')}{/if}</h2>
        <p>{$core->get_Lang('Chức năng quản lý miêu tả cho nhóm dữ liệu thuộc thành phố, điểm đến thuộc TravelGuide trong hệ thống isoCMS')}</p>
		<p>{$core->get_Lang('This function is intended to manage Travel guide category introduction')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
            </ul>
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
                    <div class="fl col_Right full_width_767">
                    	{if $clsConfiguration->getValue('SiteActiveCat_guide') eq 1}
                        <div class="row-span">
                        	<div class="fieldlabel"><strong>{$core->get_Lang('Category')} <font class="color_r">*</font></strong></div>
                            <div class="fieldarea">
                                <select name="cat_id" class="glSlBox required" style="max-width:305px">
                                     {$clsGuideCat->makeSelectboxOption(0,$cat_id)}
                                </select>
                            </div>
                        </div>
                        {/if}
                    	 <div class="row-span">
                        	<div class="fieldlabel"><strong>{$core->get_Lang('Destination')} <font class="color_r">*</font></strong></div>
							 {if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}
                            <div class="fieldarea">
                               <select class="slb full" name="iso-country_id" id="slb_Country" style="font-size:14px;width:150px">
									{$clsCountry->makeSelectboxOption($country_id)}
								</select>
	
								{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
								<select class="slb" name="iso-region_id" id="slb_Region" style="font-size:14px;min-width:120px"> 
									{$clsRegion->makeSelectboxOption($country_id,$region_id)}
								</select>
                                {/if}
                                <select class="slb full" name="iso-city_id" id="slb_City" style="font-size:14px;width:150px"> 
                                    {$clsCity->makeSelectboxOption($city_id,$country_id)}
                                </select>
                            </div>
							 {/if}
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
				<div class="wrap">
					{if $clsISO->getBrowser() eq 'computer'}
					<div id="v-nav" style="margin-top:40px">
						<ul>
							<li class="tabchildcol first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('Short text')}</strong></a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Long text')}</strong></a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Banner')}</a></strong> <span class="color_r">*</span></li>
						</ul>
						<div class="tab-content" style="display: block;">
							<div class="format-setting-wrap">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="tab-content" style="display: none;">
							<div class="format-setting-wrap">
								 {$clsForm->showInput('content')}
							</div>
						</div>
						<div class="tab-content" style="display: none;">
							<h3 style="margin-bottom:10px">{$core->get_Lang('Banner Size')} (1920x480)</h3>
                            <div class="photobox photoBanner span100">
                                {if $_isoman_use eq '1'}
                                <img src="{$clsClassTable->getBannerImage($pvalTable,1920,480)}" alt="{$core->get_Lang('images_banner')}" id="isoman_show_banner" class="span100" />
								<input type="hidden" id="isoman_hidden_banner" name="isoman_url_banner" value="{$clsClassTable->getOneField('banner',$pvalTable)}" />
								<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="banner" isoman_val="{$oneItem.banner}" isoman_name="banner"><i class="iso-edit"></i></a>
		 
							{else}
								<img src="{$clsClassTable->getBannerImage($pvalTable,1920,480)}" alt="{$core->get_Lang('noimages')}" id="imgTour_banner" class="span100" />
								<input type="hidden" name="banner_src" value="{$clsClassTable->getOneField('banner',$pvalTable)}" class="hidden_src" id="imgTour_hidden" />
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
					{else}
					<div id="v-nav" style="margin-top:40px">
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Short text')}</strong></div>
                            <div class="fieldarea">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Long text')}</strong></div>
                            <div class="fieldarea">
								 {$clsForm->showInput('content')}
							</div>
						</div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Banner Size')} (1920x480)</strong></div>
                            <div class="fieldarea">
								<div class="photobox photoBanner span100">
									{if $_isoman_use eq '1'}
									<img src="{$clsClassTable->getBannerImage($pvalTable,1920,480)}" alt="{$core->get_Lang('images_banner')}" id="isoman_show_banner" class="span100" />
									<input type="hidden" id="isoman_hidden_banner" name="isoman_url_banner" value="{$clsClassTable->getOneField('banner',$pvalTable)}" />
									<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="banner" isoman_val="{$oneItem.banner}" isoman_name="banner"><i class="iso-edit"></i></a>
								
									{else}
									<img src="{$clsClassTable->getBannerImage($pvalTable,1920,480)}" alt="{$core->get_Lang('noimages')}" id="imgTour_banner" class="span100" />
									<input type="hidden" name="banner_src" value="{$clsClassTable->getOneField('banner',$pvalTable)}" class="hidden_src" id="imgTour_hidden" />
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
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
<script type="text/javascript">
var $Hotel_Region="{$clsConfiguration->getValue('SiteActive_region')}";
</script>
{literal}
<style type="text/css">
#v-nav >ul {float: left;width: 180px;}
#v-nav >ul >li {width: 100%;}
#v-nav >div.tab-content {margin-left: 180px;}

</style>
<script type="text/javascript">
$().ready(function(){
	$(".chosen-select").chosen({width:'100%'});
	$(document).on('change', 'select[name=iso-country_id]', function(ev){
		var $_this = $(this);
		var title = $_this.find('option:selected').attr('title');
		if($Hotel_Region=='1'){
			loadRegion($_this.val(),0);
		}
		loadCity($_this.val(),0,0);
	});
	if($Hotel_Region=='1'){
		$(document).on('change', 'select[name=iso-region_id]', function(ev){
			var $_this = $(this);
			var $country_id = $('select[name=iso-country_id]').val();
			if($country_id==undefined){
				$country_id = 0;
			}
			loadCity($country_id, $_this.val(),0);
		});
	}
});
function loadRegion($country_id, $region_id) {
    $('#slb_Region').html('<option value="0">'+loading+'</option>');
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=guide&act=loadRegion&lang='+LANG_ID,
        data: {"country_id": $country_id,'region_id': $region_id},
        dataType: "html",
        success: function(html) {
			if(html.indexOf('EMPTY') >= 0){
				$('#slb_Region').hide();
			}else{
				$('#slb_Region').html(html).show();
			} 
        }
    });
}
function loadCity($country_id, $region_id, $city_id) {
	$('#slb_City').html('<option value="0">'+loading+'</option>');
	if(parseInt($Hotel_Region)>0) {var $region_id = $region_id;} else {var $region_id = 0;}
    $.ajax({
        type: "POST",
        url: path_ajax_script + '/?mod=guide&act=loadCity&lang='+LANG_ID,
        data: {
			"country_id": $country_id,
			"region_id": $region_id,
			'city_id': $city_id
		},
        dataType: "html",
        success: function(html) {
			$('#slb_City').html(html);
        }
    });
}
</script>
{/literal}