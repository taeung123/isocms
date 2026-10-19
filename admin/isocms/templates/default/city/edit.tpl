<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod=country" title="{$mod}">{$core->get_Lang('Country')}</a>
	<a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}{$pUrl}" title="{$core->get_Lang('cities')}">{$core->get_Lang('cities')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
{if $msg eq 'DuplicateCity'}
<div class="clearfix"><br /></div>
<div style="padding:15px; padding-top:0;">
    <div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; ">
        <img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" /> 
        <strong>{$core->get_Lang('Warning')}:</strong> {$core->get_Lang('identicalposts')}
    </div>
</div>
{/if}
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Cities')}{/if}</h2>
		<div class="permalinkbox mb20">
            <div class="wrap permalink_show">
                <a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> <strong>{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</strong></a>
            </div>
        </div>
        <p>{$core->get_Lang('Please enter all required fields')}</p>
    </div>
    <div class="clearfix"><br /></div>
    <div id="clienttabs">
        <ul>
            <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('basic')}</a></li>
			{if $core->checkActiveModule('hotel') && $clsISO->getCheckActiveModulePackage($package_id,'hotel','default','default')}
            <li><a href="javascript:void();"><i class="iso-bassic"></i> {$core->get_Lang('information')}</a></li>
			{/if}
            {if $pvalTable}<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li>{/if}
        </ul>
    </div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
		<div id="tab_content">
            <div class="tabbox" style="display:block">
            	<div class="fl col_Left full_width_767">
                    <div class="photobox fl image">
                        {if $_isoman_use eq '1'}
                        <img src="{$clsClassTable->getImage($pvalTable,600,400)}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
                        <input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
                        <a href="javascript:void()" title="{$core->get_Lang('edit')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
                        {if $oneItem.image}
                        <a pvalTable="{$pvalTable}" clsTable="City" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
                        {/if}
                        {else}
                        <img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
                        <input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
                        <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
                            <i class="iso-edit"></i>
                        </a> 
                        <input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
                        {/if}
                    </div>
					<div class="cleafix"></div>
					<h3 class="mt10">{$core->get_Lang('Image Size')} (WxH=600x400)</h3>
                </div>
                <div class="fl col_Right full_width_767">
                    <div class="span100">
                        <div class="row-span">
							 <div class="fieldlabel"><strong>{$core->get_Lang('City Name')}</strong> <span class="requiredMask">*</span></div>
							 <div class="fieldarea">
							 	<input class="text_32 full-width border_aaa bold required fontLarge title_capitalize" id="title" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
							 </div>
                        </div>
                    </div>
                    {if $lstContinent}
                    <div class="row-span">
                        <div class="fieldlabel"><strong>{$core->get_Lang('continents')}</strong> <span class="color_r">*</span></div>
                        <div class="fieldarea">
                            <select class="glSlBox required full" name="iso-continent_id" style="font-size:14px;font-weight:bold;padding:4px;">
                            	<option value="">-- {$core->get_Lang('Select Continent')} --</option>
                                {section name=i loop=$lstContinent}
                                <option {if $continent_id eq $lstContinent[i].continent_id}selected="selected"{/if} value="{$lstContinent[i].continent_id}">{$clsContinent->getTitle($lstContinent[i].continent_id)}</option>
                                {/section}
                            </select>
                        </div>
                    </div>
                    {/if}
                    {if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default') and $core->checkAccess('country')}
                    <div class="row-span" id="boxCountry">
                        <div class="fieldlabel"><strong>{$core->get_Lang('country')}</strong> <span class="color_r">*</span></div>
                        <div class="fieldarea">
                            <select class="glSlBox required full" id="country_id" name="iso-country_id" style="width:200px">
                                {$clsCountry->makeSelectboxOption($country_id,$continent_id)}
                            </select>
                        </div>
                    </div>
                    {/if}
                    <script type="text/javascript">
						var $country_id = '{$country_id}';
						var $area_id = '{$area_id}';
					</script>
                    {literal}
					<script type="text/javascript">
						$(function(){
							$("#country_id").change(function(){
								$_this = $(this);
							});
						});
                    </script>
                    {/literal}
                    {if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default') and $core->checkAccess('region')}
                    <div class="row-span" id="boxVungMien" {if !$clsRegion->checkExits($oneItem.country_id)}style="display:none"{/if}>
                        <div class="fieldlabel"><strong>{$core->get_Lang('regions')}</strong> <span class="color_r">*</span></div>
                        <div class="fieldarea">
                            <select class="glSlBox full" id="slb_RegionID" name="iso-region_id" style="width:200px">
                                {$clsRegion->makeSelectboxOption($oneItem.country_id,$oneItem.region_id)}
                            </select>
                        </div>
                    </div>
					<script type="text/javascript">
						var $country_id = '{$country_id}';
						var $continent_id = '{$continent_id}';
						var $region_id = '{$oneItem.region_id}';
					</script>
                    {literal}
					<script type="text/javascript">
						$(function(){
							loadSelectRegion($country_id,$region_id);
							$("#country_id").change(function(){
								$_this = $(this);
								loadSelectRegion($_this.val(),$region_id);
							});
						});
						function loadSelectRegion($country_id,$region_id){
							vietiso_loading(1);
                            $.ajax({
                                type: "POST",
                                url:path_ajax_script+'/index.php?mod=city&act=ajSelectRegion&lang='+LANG_ID,
                                data: {'country_id' : $country_id,'region_id' : $region_id},
                                dataType: "html",
                                success: function(html){
									vietiso_loading(0);
									if(html.indexOf('_NOT_REGION') >= 0) {
										$('#boxVungMien').hide();
									} else {
										$('#boxVungMien').show();
										$('#slb_RegionID').html(html);
									}
								}
                            });
						}
                    </script>
                    {/literal}
                    {else}
                    <input type="hidden" name="iso-region_id" value="0" />
                    {/if}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<div class="checkbox-switch">
								{if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}
								<input type="checkbox" checked value="1" name="is_online" class="input-checkbox" id="toolbar-active">
								{else}
								<input type="checkbox" value="1" name="is_online" class="input-checkbox" id="toolbar-active">
								{/if}
								<div class="checkbox-animate">
									<span class="checkbox-off">PRIVATE</span>
									<span class="checkbox-on">PUBLIC</span>
								</div>
							</div>	
							<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
							<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
						</div>
					</div>
                </div>
                <div class="wrap mt30">
					{if $clsISO->getBrowser() eq 'computer'}
					<div id="v-nav">
						<ul>
							<li class="tabchildcol first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('Short text')}</strong></a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Long text')}</strong></a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="#map"><strong>{$core->get_Lang('GMap')}</strong></a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Banner')}</strong></a> <span class="color_r">*</span></li>
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
							<div class="row-span">
								<div class="fieldlabel-full mb5">
									<i class="iso-pos"></i> <strong>{$core->get_Lang('Location on map')}</strong>
								</div>
								<div class="fieldarea-full" id="HotelMap_Area">
									<div class="row">
										<div class="col-xs-9">
											<div class="map_embed">
												<div class="map_search_box">
													<input class="text full fl" id="map-search-input" type="text" placeholder="Search by name..." />
												</div>
												<div id="map_canvas" style="width:100%; height:300px; overflow:hidden"></div>
											</div>
										</div>
										<div class="col-xs-3">
											<div class="format-setting-wrap mb10">
												<div class="format-setting-label">
													<label>{$core->get_Lang('latitude')}</label>
												</div>
												<div class="format-setting-content">
													<input class="text full" name="iso-map_la" id="map_la" value="{$oneItem.map_la}" type="text" style="width:95% !important" />
												</div>
											</div>
											<div class="format-setting-wrap mb10">
												<div class="format-setting-label">
													<label>{$core->get_Lang('longitude')}</label>
												</div>
												<div class="format-setting-content">
													<input class="text full" name="iso-map_lo" id="map_lo" value="{$oneItem.map_lo}" type="text" style="width:95% !important" />
												</div>
											</div>
											<div class="format-setting-wrap mb10">
												<div class="format-setting-label">
													<label>{$core->get_Lang('MapZoom')}</label>
												</div>
												<div class="format-setting-content">
													<input class="text full" name="iso-map_zoom" value="{if $oneItem.map_zoom}{$oneItem.map_zoom} {else}0{/if}" type="text" style="width:95% !important" />
												</div>
											</div>
											<div class="format-setting-wrap mb10">
												<div class="format-setting-label">
													<label>{$core->get_Lang('MapStyle')}</label>
												</div>
												<div class="format-setting-content">
													<input class="text full" name="iso-map_tyle" value="{$oneItem.map_tyle}" type="text" style="width:95% !important" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							{literal}
							<script type="text/javascript">
								$(document).on('click','.tabchildcol a[href="#map"]',function(){
									initialize();
								});
							</script>
							{/literal}	
						</div>
						<div class="tab-content" style="display: none;">
							{if $clsConfiguration->getValue('Video_Teaser_City')}
							<div class="video_teaser mb30">
								<div class="row-span">
									<div class="fieldlabel bold"><strong>{$core->get_Lang('Video Teaser')}</strong> <span class="color_r">*</span></div>
									<div class="fieldarea">
										<input type="hidden" id="isoman_hidden_video" value="{$oneItem.video_teaser}">
										<input type="text" id="isoman_url_video" name="iso-video_teaser" value="{$oneItem.video_teaser}" class="text_32 border_aaa" style="width:calc(100% - 45px) !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="video" isoman_val="{$oneItem.video_teaser}" isoman_name="video"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
										<div class="clearfix"></div>
										<span style="display:block; margin-top:5px; font-size:12px">
										({$core->get_Lang('ex: file.mp4, file.ogg, file.m4v..., frame width:&gt;=1600px, frame height:&lt;=500px')})
										</span>
									</div>
								</div>
							</div>
							{/if}
							<h3 style="margin-bottom:10px">{$core->get_Lang('Banner Size')} (1600x334)</h3>
							<div class="photobox photoBanner image span100">
								{if $_isoman_use eq '1'}
								<img src="{$clsClassTable->getBanner($pvalTable,1600,334)}" alt="{$core->get_Lang('images_banner')}" id="isoman_show_banner" class="span100" />
								<input type="hidden" id="isoman_hidden_banner" name="isoman_url_banner" value="{$oneItem.banner}" />
								<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="banner" isoman_val="{$oneItem.banner}" isoman_name="banner"><i class="iso-edit"></i></a>
								{if $oneItem.banner}
								<a pvalTable="{$pvalTable}" clsTable="City" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImageHtml" data-name_input="isoman_url_banner" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
								{/if}
								{else}
								<img src="{$clsClassTable->getBanner($pvalTable,1600,334)}" alt="{$core->get_Lang('noimages')}" id="imgTour_banner" class="span100" />
								<input type="hidden" name="banner_src" value="{$oneItem.banner}" class="hidden_src" id="imgTour_hidden" />
								<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
								<i class="iso-edit"></i>
								</a> 
								<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="banner" />
								{/if}
							</div>
							{if 1 eq 2}
							<div class="span100 mt10">
								<h3 class="mb10">{$core->get_Lang('Banner Link')}</h3>
								<input class="text_32 full-width border_aaa" type="text" name="iso-link_banner" value="{$oneItem.link_banner}" placeholder="{$DOMAIN_NAME}" />
							</div>
							<div class="span100 mt10">
								<h3 class="mb10">{$core->get_Lang('Banner Content')}</h3>
								{$clsForm->showInput('intro_banner')}
							</div>
							{/if}
						</div>
					</div>
					{else}
					<div id="v-nav">
						<div class="row-span">
							 <div class="fieldlabel"><strong>{$core->get_Lang('Short text')}</strong> <span class="requiredMask">*</span></div>
							 <div class="fieldarea">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="row-span">
							 <div class="fieldlabel"><strong>{$core->get_Lang('Long text')}</strong> <span class="requiredMask">*</span></div>
							 <div class="fieldarea">
								 {$clsForm->showInput('content')}
							</div>
						</div>
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('GMap')}</strong> <span class="requiredMask">*</span></div>
							<div class="fieldarea-full" id="HotelMap_Area">
								<div class="row">
									<div class="col-sm-9 mb10_767">
										<div class="map_embed">
											<div class="map_search_box">
												<input class="text full fl" id="map-search-input" type="text" placeholder="Search by name..." />
											</div>
											<div id="map_canvas" style="width:100%; height:300px; overflow:hidden"></div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="format-setting-wrap mb10">
											<div class="format-setting-label">
												<label>{$core->get_Lang('latitude')}</label>
											</div>
											<div class="format-setting-content">
												<input class="text full" name="iso-map_la" id="map_la" value="{$oneItem.map_la}" type="text" style="width:95% !important" />
											</div>
										</div>
										<div class="format-setting-wrap mb10">
											<div class="format-setting-label">
												<label>{$core->get_Lang('longitude')}</label>
											</div>
											<div class="format-setting-content">
												<input class="text full" name="iso-map_lo" id="map_lo" value="{$oneItem.map_lo}" type="text" style="width:95% !important" />
											</div>
										</div>
										<div class="format-setting-wrap mb10">
											<div class="format-setting-label">
												<label>{$core->get_Lang('MapZoom')}</label>
											</div>
											<div class="format-setting-content">
												<input class="text full" name="iso-map_zoom" value="{if $oneItem.map_zoom}{$oneItem.map_zoom} {else}0{/if}" type="text" style="width:95% !important" />
											</div>
										</div>
										<div class="format-setting-wrap mb10">
											<div class="format-setting-label">
												<label>{$core->get_Lang('MapStyle')}</label>
											</div>
											<div class="format-setting-content">
												<input class="text full" name="iso-map_tyle" value="{$oneItem.map_tyle}" type="text" style="width:95% !important" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						{literal}
						<script type="text/javascript">
							$(document).on('click','.tabchildcol a[href="#map"]',function(){
								initialize();
							});
						</script>
						{/literal}	
						<div class="row-span">
							 <div class="fieldlabel"><strong>{$core->get_Lang('Banner Size')} (1600x334)</strong> <span class="requiredMask">*</span></div>
							 <div class="fieldarea">
								<div class="photobox image photoBanner span100">
									{if $_isoman_use eq '1'}
									<img src="{$clsClassTable->getBanner($pvalTable,1600,334)}" alt="{$core->get_Lang('images_banner')}" id="isoman_show_banner" class="span100" />
									<input type="hidden" id="isoman_hidden_banner" name="isoman_url_banner" value="{$oneItem.banner}" />
									<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="banner" isoman_val="{$oneItem.banner}" isoman_name="banner"><i class="iso-edit"></i></a>
									{if $oneItem.banner}
									<a pvalTable="{$pvalTable}" clsTable="City" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImageHtml" data-name_input="isoman_url_banner" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
									{/if}
									{else}
									<img src="{$clsClassTable->getBanner($pvalTable,1600,334)}" alt="{$core->get_Lang('noimages')}" id="imgTour_banner" class="span100" />
									<input type="hidden" name="banner_src" value="{$oneItem.banner}" class="hidden_src" id="imgTour_hidden" />
									<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
									<i class="iso-edit"></i>
									</a> 
									<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="banner" />
									{/if}
								</div>
								 {if 1 eq 2}
								<div class="span100 mt10">
									<h3 class="mb10">{$core->get_Lang('Banner Link')}</h3>
									<input class="text_32 full-width border_aaa" type="text" name="iso-link_banner" value="{$oneItem.link_banner}" placeholder="{$DOMAIN_NAME}" />
								</div>
								<div class="span100 mt10">
									<h3 class="mb10">{$core->get_Lang('Banner Content')}</h3>
									{$clsForm->showInput('intro_banner')}
								</div>
								 {/if}
							</div>
						</div>
					</div>
					{/if}
            	</div>
			</div>
			{if $core->checkActiveModule('hotel') && $clsISO->getCheckActiveModulePackage($package_id,'hotel','default','default')}
            <div class="tabbox" style="display:none">
                <div class="row-span" style="display:none">
                    <span class="notice bold" style="font-size:16px; padding-left:0;">{$core->get_Lang('introtour')}</span>
                    <div class="clearfix" style="height:5px"></div>
                    <div class="fieldarea" style="width:100%">{$clsForm->showInput('intro_tour')}</div>
                </div>
                <div class="row-span">
                    <span class="notice bold" style="font-size:16px; padding-left:0;">{$core->get_Lang('introhotel')}</span>
                    <div class="clearfix" style="height:5px"></div>
                    <div class="fieldarea" style="width:100%">{$clsForm->showInput('intro_hotel')}</div>
                </div>
				<div class="row-span">
					<span class="notice bold" style="font-size:16px; padding-left:0;"><span class="requiredMask">*</span> {$core->get_Lang('Hotel Banner')} {$clsClassTable->getTitle($pvalTable)}</span>
					<div class="clearfix" style="height:5px"></div>
					<div class="photobox photoBanner span100 fl mr20 image">
					{if $_isoman_use eq '1'}
					<img src="{$oneItem.image_hotel}" alt="{$core->get_Lang('image_hotel')}" id="isoman_show_image_hotel" />
					<input type="hidden" id="isoman_hidden_image_hotel" name="isoman_url_image_hotel" value="{$oneItem.image_hotel}" />
					<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_hotel" isoman_val="{$oneItem.image_hotel}" isoman_name="image_hotel"><i class="iso-edit"></i></a>
					{if $oneItem.image_hotel}
					<a pvalTable="{$pvalTable}" clsTable="City" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImageHtml" data-name_input="isoman_url_image_hotel" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
					{/if}
					{else}
						<img src="{$oneItem.image_hotel}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
						<input type="hidden" name="image_src" value="{$oneItem.image_hotel}" class="hidden_src" id="imgTour_hidden" />
						<a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
							<i class="iso-edit"></i>
						</a> 
						<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
					{/if}
					</div>
				</div> 
			</div>
			{/if}
            {if $pvalTable}
            <div class="tabbox" style="display:none">
            	 {$core->getBlock('meta_box_detail')} 
        	</div>
            {/if}
            <div class="clearfix"></div>
    	</div>
        <br class="clearfix" />
        <fieldset class="submit-buttons">
            {$saveBtn} {$saveList}
            <input value="Update" name="submit" type="hidden" />
        </fieldset>
	</form>
</div>
<script type="text/javascript">
	var map_lo="{$oneItem.map_lo}";
	var map_la="{$oneItem.map_la}";
	var map_zoom = '{$oneItem.map_zoom}';
	var map_type = '{$oneItem.map_tyle}';
	var city_id="{$pvalTable}";
</script>
{literal}
<style>
	.searchmap{ background:#E9EFF3; padding:10px; margin:10px 0 0;}
	.row-span .fieldlabel{width: 150px;padding:0px 10px;float:left;height:32px;line-height:32px;text-align:left;font-size:13px;}
	.row-span .fieldarea{width: calc(100% - 150px);float:right;}
</style>
<script type="text/javascript">
	$(function(){
		initialize();
	});
	var geocoder=new google.maps.Geocoder();
	var map; 
	var marker;
	function $getID(id){
		return document.getElementById(id);
	}
	function geocode(position) {
		geocoder.geocode({
			latLng: position
		},function(responses) {
			$getID('map-search-input').value = responses[0].formatted_address;
			$getID('map_la').value = marker.getPosition().lat(); 
			$getID('map_lo').value = marker.getPosition().lng();
			map.panTo(marker.getPosition());
		});
	}
	function initialize(){
		map_lo=map_lo!='' ? map_lo : '105.86727258378903'; 
		map_la=map_la!='' ? map_la : '20.988668210459167';
		if(map_zoom=='') map_zoom = 11;
		if(map_type=='') map_type = 'roadmap';
		var mapOptions = {
			center: new google.maps.LatLng(map_la,map_lo),
			zoom: parseInt(map_zoom),
			mapTypeId: map_type
		}; 
		map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions); 
		var input = document.getElementById('map-search-input'); 
		var autocomplete = new google.maps.places.Autocomplete(input); 
		autocomplete.bindTo('bounds', map); 
		var location = new google.maps.LatLng (map_la,map_lo); 
		marker = new google.maps.Marker({ position:location}); 
		marker.setMap(map); 
		marker.setDraggable(true); 
		google.maps.event.addListener(marker, "dragend", function(event){ 
			var point = marker.getPosition(); 
			map.panTo(point); 
			geocode(point);
		}); 
		/**/ 
		google.maps.event.addListener(autocomplete, 'place_changed', function(){
			var place = autocomplete.getPlace();
			if(place.geometry.viewport){ 
				map.fitBounds(place.geometry.viewport); 
			}else{
				map.setCenter(place.geometry.location); map.setZoom(11); 
			}
			geocode(place.geometry.location);
			marker.setPosition(place.geometry.location); 
		});
		map.addListener('zoom_changed', function(){
			map_zoom = map.getZoom();
			$('input[name=iso-map_zoom]').val(map_zoom);
		});
		map.addListener('maptypeid_changed', function(e){
			map_tyle = map.getMapTypeId();
			$('input[name=iso-map_tyle]').val(map_tyle);
		});
	}
	function findLocation(address){
		geocoder = new google.maps.Geocoder(); 
		geocoder.geocode({'address': address},function(results,status){
			if (status == google.maps.GeocoderStatus.OK) {
				marker.setPosition(results[0].geometry.location);
				geocode(results[0].geometry.location);
			} else {
				alert("Sorry but Google Maps could not find this location.");
			}
		});
	};
	$(function(){
		$(document).on('keydown', '#map-search-input', function(ev){
			var _this = $(this);
			var _code = ev.keyCode;
			if (_code === 13 && $.trim(_this.val()) != '') {
				findLocation(_this.val()); 
				return false;
			}
		});
		$('input[name=title]').click(function(){
			$('.tabchildcol a[href="#map"]').trigger('click');
		}).blur(function(){
			$('.tabchildcol.current').trigger('click');
			}).keydown(function(ev){
				var _this = $(this);
				var _code = ev.keyCode;
				if (_code === 13 && $.trim(_this.val()) != '') {
					findLocation(_this.val());
					return false;
				}
			});
			$(document).on('click','#map-search-input',function(){
				initialize();
			});
	});
</script>
{/literal}