<link rel="stylesheet" href="{$URL_CSS}/chosen.css" type="text/css" media="all">
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript">
    var hotel_id = '{$pvalTable}';
</script>
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('hotels')}</a>
    <a>&raquo;</a>
    <a>{$core->get_Lang('edit')} #{$pvalTable}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>
            {$clsClassTable->getTitle($pvalTable)}
            {if $clsClassTable->getStar($pvalTable)}
                <img src="{$clsClassTable->getImageStar($clsClassTable->getStar($pvalTable))}" />
            {/if}
        </h2>
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <a href="{$DOMAIN_NAME}{$clsClassTable->getLinkPro($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> <strong>{$DOMAIN_NAME}{$clsClassTable->getLinkPro($pvalTable)}</strong></a> 
            </div>
        </div>
        <div class="wrap">
			<div class="group_buttons fr" style="margin-top:-40px">
            {assign var=lstHotelType value=$clsHotelStore->getListType()}
			{if $lstHotelType}
				{foreach from=$lstHotelType key=k item=v}
				<label class="lblCheckBox mr10 fl">
					<input type="checkbox" data="{$pvalTable}" _type="{$k}" class="changeToStore" {if $clsHotelStore->checkExist($pvalTable,$k)}checked="checked"{/if} /><br /> {$v}
				</label>
				{/foreach}
            {/if}
			</div>
		</div>
    </div>
    <div class="clearfix mb10"></div>
    {if $msg eq 'DupTripCode'}
    <div style="padding:15px; padding-top:0;">
        <div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; "><img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
            <strong>{$core->get_Lang('Warning')}:</strong> {$core->get_Lang('identicalnamehotels')}
        </div>
    </div>
    <div class="clearfix mb10"></div>
    {/if}
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="javascript:void(0);"><i class="iso-bassic"></i> {$core->get_Lang('basic')}</a></li>
				{if $pvalTable}
				{if $clsISO->getCheckActiveModulePackage($package_id,'hotel','hotel_room','customize')}
                <li class="tabchild"><a href="javascript:void(0);"><i class="fa fa-pie-chart"></i> {$core->get_Lang('roomrates')}</a></li>
				{/if}
				{if $clsISO->getCheckActiveModulePackage($package_id,'hotel','hotel_gallery','customize')}
                <li class="tabchild"><a href="javascript:void(0);"><i class="fa fa-picture-o"></i> {$core->get_Lang('Configuration')}</a></li>
				{/if}
				<li class="tabchild"><a href="javascript:void(0);"><i class="fa fa-fa-tag"></i> {$core->get_Lang('Seo Tool')}</a></li>
				{/if}
            </ul>
        </div>
        <div id="tab_content">
            <div class="tabbox">
                <div class="wrap">
					<div class="fl col_Left full_width_767">
						<div class="photobox image">
							{if $_isoman_use eq '1'}
								<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
								<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}">
								<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image" title="{$core->get_Lang('change')}"><i class="iso-edit"></i></a>
									{if $oneItem.image}
									<a pvalTable="{$pvalTable}" clsTable="Hotel" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
								{/if}
							{else}
								<img src="{$clsClassTable->getImage($pvalTable,180,156)}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
								<input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
								<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
									<i class="iso-edit"></i>
								</a> 
								<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
							{/if}
						</div>
                    </div>
					<div class="fr col_Right full_width_767">
                    	<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Name')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
								<input class="text_32 full-width border_aaa bold title_capitalize required" id="title" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('rating')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
								<label class="radio inline"><input type="radio" name="star_id" {if $oneItem.star_id eq '0' or $pvalTable eq '0'}checked="checked"{/if} value="0"> {$core->get_Lang('Un Rated')}</label> 
								{section name=star start=1 loop=6 step=1}
								<label class="radio inline"><input type="radio" name="star_id" {if $oneItem.star_id eq $smarty.section.star.index}checked="checked"{/if} value="{$smarty.section.star.index}">{$smarty.section.star.index} {$core->get_Lang('star')}</label>
								{/section}
                            </div>
                        </div>
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('location')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
                                {if $clsConfiguration->getValue('SiteModActive_continent') eq 1}
								<select class="slb required" style="font-size:14px;width:150px !important" name="iso-continent_id">
									{$clsContinent->makeSelectboxOption($continent_id)}
								</select>
								<select class="slb required" name="iso-country_id" id="slb_Country" style="font-size:14px;min-width:120px">                                	<option value="0"> -- {$core->get_Lang('selectcountry')} -- </option>
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
								<select class="slb" name="iso-country_id" id="slb_Country" style="font-size:14px;min-width:120px">
									{$clsCountry->makeSelectboxOption($country_id)}
								</select>
                                {/if}
                                {if $clsConfiguration->getValue('SiteActive_region') eq '1'}
								<select class="slb" name="iso-region_id" id="slb_Region" style="font-size:14px;min-width:120px"> 
									{$clsRegion->makeSelectboxOption($country_id,$region_id)}
								</select>
                                {/if}
                                <select class="slb required" name="iso-city_id" id="slb_City" style="font-size:14px;min-width:120px"> 
                                    {$clsCity->makeSelectboxOption($city_id,$country_id)}
                                </select>
                            </div>   
                        </div>
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Address')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
                                <input class="text mr10 required" name="iso-address" value="{$clsClassTable->getAddress($pvalTable)}" maxlength="255" type="text" style="width:auto; min-width:100%; max-width:500px;" />
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
                <div class="clearfix mb20"></div>
				<div class="wrap">
					{if $clsISO->getBrowser() eq 'computer'}
					<div id="v-nav">
						<ul>
                        	<li class="tabchildcol first current"><a href="javascript:void(0);">{$core->get_Lang('Price')}</a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('High light')}</a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Overview')}</a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('HotelPolicy')}</a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="#map">{$core->get_Lang('Maps')}</a> <span class="color_r">*</span></li>
							
							{if $listCustomField[0].hotel_customfield_id ne ''}
							{section name=i loop=$listCustomField}
							<li class="tabchildcol"><a href="javascript:void(0);">{$listCustomField[i].fieldname}</a>
								<div class="Site_Custom_Field_Tools" style="display:inline-block;margin-bottom:10px; float:right">
									<a title="{$core->get_Lang('edit')}" hotel_id="{$pvalTable}" data="{$listCustomField[i].hotel_customfield_id}" class="btnedit_customfield" href="javascript:void();"><i class="icon-pencil"></i></a>
									<a title="{$core->get_Lang('delete')}" hotel_id="{$pvalTable}" data="{$listCustomField[i].hotel_customfield_id}" class="btndelete_customfield" href="javascript:void();"><i class="icon-remove"></i></a>
									{if $smarty.section.i.first}
									{else}
									<a title="{$core->get_Lang('move')}" hotel_id="{$pvalTable}" data="{$listCustomField[i].hotel_customfield_id}" class="btnmove_customfield" direct="up" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>
									{/if}
									{if $smarty.section.i.last}
									{else}
									<a title="{$core->get_Lang('move')}" hotel_id="{$pvalTable}" data="{$listCustomField[i].hotel_customfield_id}" class="btnmove_customfield" direct="down" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>
									{/if}
								</div>
							</li>
							{/section}
							{/if}
							{if $clsConfiguration->getValue('SiteHasCustomField_Hotel')}
							<li><a class="iso-button-full ClickCustomField color_r" data-hotel_id="{$pvalTable}">
								<i class="fa fa-plus-circle"></i> <strong>{$core->get_Lang('addmoreinformation')}</strong>
							</a>
							</li>
							{/if}
						</ul>
						<div class="tab-content" style="display: block;">
							<div class="format-setting-wrap">
								<div class="format-setting-label border-bottom">
									<label>{$core->get_Lang('Average price')} ({$clsISO->getRate()})</label>
								</div>
								<div class="format-setting-content">
									<input type="text" class="text full priceFormat" name="price_avg" value="{$clsISO->formatPrice($oneItem.price_avg)}" style="width:150px" />
									<span>{$core->get_Lang('Average price')}</span>
								</div>
							</div>
						</div>
						<div class="tab-content" style="display: none;">
							{$clsForm->showInput('intro')}
							<div class="hr mv10"></div>
							<div class="row-span" style="display:none">
								<div class="fieldlabel">{$core->get_Lang('HotelVideo')}</div>
								<div class="fieldarea" style="width:84%">
									<input type="text" name="iso-video_url" value="{$oneItem.video_url}" class="text full"/>
									<br />
									<span class="mt5 notice" style="padding-left:0">Please use youtube or vimeo video</span>
								</div>
							</div>
						</div>
						<div class="tab-content" style="display: none;">
							{$clsForm->showInput('content')}
						</div>
						<div class="tab-content" style="display: none;">
							{$clsForm->showInput('hotel_booking_policy')}
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
													<input class="text full" name="iso-map_zoom" value="{$oneItem.map_zoom}" type="text" style="width:95% !important" />
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						{if $listCustomField[0].hotel_customfield_id ne ''}
						{section name=i loop=$listCustomField}
						<div class="tab-content" style="display: none;">
								<textarea style="width:100%;" cols="255" rows="25" class="Site_Custom_Field_Editor" id="Site_Custom_Field_{$listCustomField[i].hotel_customfield_id}_{$now}" name="Site_Custom_Field_value_{$listCustomField[i].hotel_customfield_id}" >{$listCustomField[i].fieldvalue}</textarea>
						</div>
						{/section}
						{literal}
						<script type="text/javascript">
							$().ready(function() {
								loadCustomField(pvalTable);
							});
						</script>
						{/literal}
						{/if}
					</div>
					{literal}
					<script type="text/javascript">
						$(document).on('click','.tabchildcol a[href="#map"]',function(){
							initialize();
						});
					</script>
					{/literal}
					{else}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Price')}</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<input type="text" class="text full priceFormat" name="price_avg" value="{$clsISO->formatPrice($oneItem.price_avg)}" style="width:150px" />
							<span>{$core->get_Lang('Average price')}</span>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('High light')}</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							{$clsForm->showInput('intro')}
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Overview')}</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							{$clsForm->showInput('content')}
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('HotelPolicy')}</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							{$clsForm->showInput('hotel_booking_policy')}
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Maps')}</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<div class="fieldlabel-full mb5">
								<i class="iso-pos"></i> <strong>{$core->get_Lang('Location on map')}</strong>
							</div>
							<div class="fieldarea-full" id="HotelMap_Area">
								<div class="row">
									<div class="col-sm-9">
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
												<input class="text full" name="iso-map_zoom" value="{$oneItem.map_zoom}" type="text" style="width:95% !important" />
											</div>
										</div>
									</div>
								</div>
							</div>
							{literal}
							<script type="text/javascript">
								$().ready(function() {
									initialize();
								});
							</script>
							{/literal}
						</div>
					</div>
					{if $listCustomField[0].hotel_customfield_id ne ''}
					{section name=i loop=$listCustomField}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$listCustomField[i].fieldname}</strong> <span class="color_r">*</span></div>
						<div class="fieldarea">
							<textarea style="width:100%;" cols="255" rows="25" class="Site_Custom_Field_Editor" id="Site_Custom_Field_{$listCustomField[i].hotel_customfield_id}_{$now}" name="Site_Custom_Field_value_{$listCustomField[i].hotel_customfield_id}" >{$listCustomField[i].fieldvalue}</textarea>
						</div>
					</div>
					{/section}
					{literal}
					<script type="text/javascript">
						$().ready(function() {
							loadCustomField(pvalTable);
						});
					</script>
					{/literal}
					{/if}
					{literal}
					<script type="text/javascript">
						$(document).on('click','.tabchildcol a[href="#map"]',function(){
							initialize();
						});
					</script>
					{/literal}
					{if $clsConfiguration->getValue('SiteHasCustomField_Hotel')}
					<div class="row-span"><a class="iso-button-full ClickCustomField color_r" data-hotel_id="{$pvalTable}">
						<i class="fa fa-plus-circle"></i> <strong>{$core->get_Lang('addmoreinformation')}</strong>
					</a>
					</div>
					{/if}
					{/if}	
					{if $clsConfiguration->getValue('SiteHasHotelFacility')}
					<div class="cleafix mb20"></div>
					<div class="h4">
						{$core->get_Lang('hotelfacilities')}</strong>
						<p class="checkall">{$core->get_Lang('Check/Uncheck All')} <input type="checkbox" rel="hotel_fa" id="all_check"></p>
					</div>
					<div class="clearfix mb10"></div>
					<div class="wrap" id="fT"><!-- HTML Apend --></div>
					{/if}
				</div>
			 </div>
			{if $pvalTable}
			{if $clsISO->getCheckActiveModulePackage($package_id,'hotel','hotel_room','customize')}
            <div class="tabbox" style="display:none">
				<div class="contextbar">
					<strong>{$core->get_Lang('infoaddhotelroom')}</strong>
					<input class="text_32 border_aaa bold title_capitalize span30" type="text" id="HotelRoomTitleNew" />
					<button type="button" class="btn btn-success start btnCreateNewRoom" hotel_id="{$pvalTable}">
						<i class="icon-plus icon-white"></i>
						<span>{$core->get_Lang('Create New')}</span>
					</button>
					<input type="hidden" name="submit" value="insert" />
				</div>
                <div class="clearfix mt20"></div>
                <table class="tbl-grid" cellpadding="0" width="100%">
                    <thead>
                        <tr>
                            <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                            <td class="gridheader"><strong>{$core->get_Lang('images')}</strong></td>
                            <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('RoomType')}</strong></td>
                            <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('numberguest')}</strong></td>
                            <td class="gridheader" style="text-align:center;"><strong>{$core->get_Lang('func')}</strong></td>
                        </tr>
                    </thead>
                    <tbody id="hotelRoomTable"></tbody>
                </table>
                <div class="pagination_box mt5"></div>
            </div>
			{/if}
			{if $clsISO->getCheckActiveModulePackage($package_id,'hotel','hotel_gallery','customize')}
            <div class="tabbox" style="display:none">
            	{literal}<script type="text/javascript">$().ready(function(){makeGlobalTab('globaltabs_media');});</script>{/literal}
                <div class="globaltabs" id="globaltabs_media_ul">
                    <ul>
                        <li><a submit="_NOT" href="javascript:void();"><i class="iso-gallery"></i> {$core->get_Lang('gallery')}</a></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <div class="tab_contentglobal">
                	{if $clsConfiguration->getValue('SiteHasGalleryImagesHotels')}
                    <div class="tabboxglobal tabboxchild_globaltabs_media">
                        <div id="HotelGalleryHolder"></div>
                    </div>
                    {/if}
               	 </div>
            </div>
			{/if}
			<div class="tabbox" style="display:none">
				{$core->getBlock('meta_box_detail')}
			</div>
			{/if}
        </div>
        <div class="cleafix"></div>
        <fieldset class="submit-buttons">
			{$saveBtn}{$saveList}
			<input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript">
	/* Language */
	var required_hotel_title = "{$core->get_Lang('required_hotel_title')}";
	var regions = "{$core->get_Lang('regions')}";
    var cities = "{$core->get_Lang('cities')}";
	/* Config */
    var pvalTable = "{$pvalTable}";
    var country_id = "{$oneItem.country_id}";
    var region_id = "{$oneItem.region_id}";
    var city_id = "{$oneItem.city_id}";
    var area_city_id = "{$oneItem.area_city_id}";
    var $Hotel_Area = '{$clsConfiguration->getValue("Hotel_Area")}';
    var $Hotel_Region = '{$clsConfiguration->getValue("Hotel_Region")}';
    var $Hotel_City = '{$clsConfiguration->getValue("Hotel_City")}';
    var image_type = 'hotel';
	var map_lo="{$oneItem.map_lo}";
	var map_la="{$oneItem.map_la}";
	var map_zoom = '{$oneItem.map_zoom}';
	var map_type = '{$oneItem.map_tyle}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/hotel/jquery.hotel.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/jquery.global.js?v={$upd_version}"></script>
{literal}
<style type="text/css">
.row-span .fieldlabel{width: 180px;padding:0px 10px;float:left;height:32px;line-height:32px;text-align:left;font-size:13px;}
.row-span .fieldarea{width: calc(100% - 180px);float:right;}
</style>
<script type="text/javascript">
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
		if(map_zoom=='0') map_zoom = 11;
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
		$('input[name=iso-address]').click(function(){
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
	});
</script>
{/literal}