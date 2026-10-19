<script type="text/javascript">
    var hotel_id = '{$pvalTable}';
</script>
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('area city')}</a>
    <a>&raquo;</a>
    <a>{$core->get_Lang('edit')} #{$pvalTable}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>
           <h2>{if $pvalTable}{$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Area Cities')}{/if}</h2>
        </h2>
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> <strong>{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</strong></a> 
            </div>
        </div>
    </div>
    <div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="javascript:void(0);"><i class="iso-bassic"></i> {$core->get_Lang('basic')}</a></li>
                {if $pvalTable}<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li>{/if}
            </ul>
        </div>
        <div id="tab_content">
            <div class="tabbox" style="display:block">
                <div class="wrap">
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
                            <img src="{$oneItem.image}" alt="Chưa có hình ảnh" id="imgTour_image" />
                            <input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
                            <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
                                <i class="iso-edit"></i>
                            </a> 
                            <input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
                            {/if}
                        </div>
					</div>
                    <div class="fl col_Right full_width_767">
                    	<div class="row-span" style="margin-bottom:10px; padding-bottom:10px;">
							 <div class="fieldlabel">{$core->get_Lang('Area City Name')} <span class="requiredMask">*</span> </strong></div>
							 <div class="fieldarea">
							 	<input style="border:2px solid #ccc;" class="text full required fontLarge" id="title" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
							 </div>
                        </div>
                        <div class="row-span">
                            <div class="fieldlabel">{$core->get_Lang('location')}<strong class="color_r">* </strong></div>
                            <div class="fieldarea">
                                {if $clsConfiguration->getValue('SiteModActive_continent') eq 1}
								<select class="slb required" style="font-size:14px;width:150px !important" name="iso-continent_id">
									{$clsContinent->makeSelectboxOption($continent_id)}
								</select>
								<select class="slb required full" name="iso-country_id" id="slb_Country" style="font-size:14px;width:150px">                                	<option value="0"> -- {$core->get_Lang('selectcountry')} -- </option>
								</select>
								<script type="text/javascript">
									var $continent_id = '{$continent_id}';
									var $country_id = '{$country_id}';
								</script>
								{literal}
								<script type="text/javascript">
									$(function(){
										/* Only load country when continent_id &gt 0 */
										if(parseInt($continent_id) > 0){
											loadCountry($continent_id, $country_id);
										}
									});
								</script>
								{/literal}
                                {else}
								<select class="slb full" name="iso-country_id" id="slb_Country" style="font-size:14px;width:150px">
									{$clsCountry->makeSelectboxOption($country_id)}
								</select>
                                {/if}
                                {if $clsConfiguration->getValue('SiteActive_region') eq '1'}
								<select class="slb full" name="iso-region_id" id="slb_Region" style="font-size:14px;width:150px"> 
									{$clsRegion->makeSelectboxOption($country_id,$region_id)}
								</select>
                                {/if}
                                <select class="slb required full" name="iso-city_id" id="slb_City" style="font-size:14px;width:150px"> 
                                    {$clsCity->makeSelectboxOption($city_id,$country_id)}
                                </select>
                            </div>   
                        </div>
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
                </div>
                <br class="clearfix" /><br class="clearfix" />
                <div class="row-span row-has-border mt20" style="width:100%">
					<div class="fieldlabel">{$core->get_Lang('description')}</div>
					<div class="fieldarea">{$clsForm->showInput('intro')}</div>
				</div>
                <div class="row-span row-has-border mt20" style="width:100%">
					<div class="fieldlabel">{$core->get_Lang('descriptionpagehotel')}</div>
					<div class="fieldarea">{$clsForm->showInput('intro_hotel')}</div>
				</div>
                <div class="row-span row-has-border" style="width:100%">
                    <div class="fieldlabel">{$core->get_Lang('overview')}</div>
                    <div class="fieldarea">{$clsForm->showInput('content')}</div>
                </div>
            </div>
            {if $pvalTable}
            <div class="tabbox" style="display:none">
            	{$core->getBlock('meta_box_detail')}
        	</div>
            {/if}
        </div>
        <br class="clearfix" />
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    var pvalTable = "{$pvalTable}";
    var country_id = "{$oneItem.country_id}";
	var region_id = "{$oneItem.region_id}";
    var city_id = "{$oneItem.city_id}";
    var map_lo = "{$oneItem.map_lo}";
    var map_la = "{$oneItem.map_la}";
	var $Hotel_Area = '{$clsConfiguration->getValue("Hotel_Area")}';
	var $Hotel_Region = '{$clsConfiguration->getValue("Hotel_Region")}';
	var image_type = 'hotel';
	
	var regions = "{$core->get_Lang('regions')}";
	var cities = "{$core->get_Lang('cities')}";
	var required_hotel_title = "{$core->get_Lang('required_hotel_title')}";
	var not_find_location = "{$core->get_Lang('Sorry but Google Maps could not find this location')}";
</script>
<script type="text/javascript" src="{$URL_THEMES}/area_city/jquery.hotel.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/jquery.global.js?v={$upd_version}"></script>