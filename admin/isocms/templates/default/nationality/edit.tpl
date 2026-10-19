<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
  <!--  <a>&raquo;</a>
    <a href="{$PCMS_URL}/?mod=continent">{$core->get_Lang('Continent')}</a>-->
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Country')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}"> {if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
{if $msg eq 'DuplicateCountry'}
<div style="padding:15px; padding-top:0;">
	<div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; ">
    	<img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
		<strong>{$core->get_Lang('Warning')}:</strong> {$core->get_Lang('identicalposts')}
	</div>
</div>
<div class="clearfix"></div>
{/if}
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Country')}{/if}</h2>
    </div>
	<div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul>
            	<li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
				{*<li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('information')}</a></li>*} 
                {if $pvalTable}<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li>{/if}
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
            <div class="tabbox" style="display:block">
            	<div class="fl span25">
					{*<div class="photobox fl mr20 image">
                        {if $_isoman_use eq '1'}
                        <img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
                        <input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
                        <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
                        {if $oneItem.image}
                        <a pvalTable="{$pvalTable}" clsTable="Country" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
                        {/if}
                        {else}
                            <img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
                            <input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
                            <a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
                                <i class="iso-edit"></i>
                            </a> 
                            <input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
                        {/if}
                    </div>
                    <h3 class="span100 fl mt10">Image photo(340x340)</h3>*}
                    {if 1 eq 2}
                    <div class="photobox fl mr20 mt20 image_map">
                        {if $_isoman_use eq '1'}
                        <img src="{$oneItem.image_map}" alt="{$core->get_Lang('images')}" id="isoman_show_image_map" />
                        <input type="hidden" id="isoman_hidden_image_map" name="isoman_url_image_map" value="{$oneItem.image_map}" />
                        <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_map" isoman_val="{$oneItem.image_map}" isoman_name="image_map"><i class="iso-edit"></i></a>
                        {if $oneItem.image_map}
                        <a pvalTable="{$pvalTable}" clsTable="Country" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
                        {/if}
                        {else}
                            <img src="{$oneItem.image_map}" alt="{$core->get_Lang('noimages')}" id="imgTour_image_map" />
                            <input type="hidden" name="image_map_src" value="{$oneItem.image_map}" class="hidden_src" id="imgTour_hidden" />
                            <a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
                                <i class="iso-edit"></i>
                            </a> 
                            <input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image_map" />
                        {/if}
                    </div>
                    
                    <div class="span100 fl mt10">Image map(458x595)</div>
                    <div class="photobox fl mr20 mt20 image_tour">
                        {if $_isoman_use eq '1'}
                        <img src="{$oneItem.image_tour}" alt="{$core->get_Lang('images')}" id="isoman_show_image_tour" />
                        <input type="hidden" id="isoman_hidden_image_tour" name="isoman_url_image_tour" value="{$oneItem.image_tour}" />
                        <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_tour" isoman_val="{$oneItem.image_tour}" isoman_name="image_tour"><i class="iso-edit"></i></a>
                        {if $oneItem.image_tour}
                        <a pvalTable="{$pvalTable}" clsTable="Country" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
                        {/if}
                        {else}
                            <img src="{$oneItem.image_tour}" alt="{$core->get_Lang('noimages')}" id="imgTour_image_tour" />
                            <input type="hidden" name="image_tour_src" value="{$oneItem.image_tour}" class="hidden_src" id="imgTour_hidden" />
                            <a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
                                <i class="iso-edit"></i>
                            </a> 
                            <input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image_tour" />
                        {/if}
                    </div>
                    <div class="span100 fl mt10">Image tour(175x140)</div>
                    <div class="photobox fl mr20 mt20 image_hotel">
                        {if $_isoman_use eq '1'}
                        <img src="{$oneItem.image_hotel}" alt="{$core->get_Lang('images')}" id="isoman_show_image_hotel" />
                        <input type="hidden" id="isoman_hidden_image_hotel" name="isoman_url_image_hotel" value="{$oneItem.image_hotel}" />
                        <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image_hotel" isoman_val="{$oneItem.image_hotel}" isoman_name="image_hotel"><i class="iso-edit"></i></a>
                        {if $oneItem.image_hotel}
                        <a pvalTable="{$pvalTable}" clsTable="Country" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
                        {/if}
                        {else}
                            <img src="{$oneItem.image_hotel}" alt="{$core->get_Lang('noimages')}" id="imgTour_image_hotel" />
                            <input type="hidden" name="image_hotel_src" value="{$oneItem.image_hotel}" class="hidden_src" id="imgTour_hidden" />
                            <a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
                                <i class="iso-edit"></i>
                            </a> 
                            <input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image_hotel" />
                        {/if}
                    </div>
                    <div class="span100 fl mt10">Image hotel(175x140)</div>
                    {/if}
                </div>
                <div class="fl span75">
                    <div class="span100">
                        <div class="row-span" style="padding-bottom:10px;">
                             <div class="fieldlabel">{$core->get_Lang('Country Name')} <span class="requiredMask">*</span> </strong></div>
                             <div class="fieldarea">
                                <input style="border:2px solid #ccc;" class="text full required fontLarge" id="title" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                             </div>
                        </div>
                    </div>
                    {if $lstContinent && $clsConfiguration->getValue('SiteModActive_continent') and $core->checkAccess('continent')}
                    <div class="row-span" >
                        <div class="fieldlabel"><span class="requiredMask">*</span> {$core->get_Lang('selectcontinent')}</div>
                        <div class="fieldarea">
                            <select class="glSlBox required full" name="iso-continent_id">
                            	<option value="">-- {$core->get_Lang('Select Continent')} --</option>
                                {section name=i loop=$lstContinent}
                                <option {if $oneItem.continent_id eq $lstContinent[i].continent_id}selected="selected"{/if} value="{$lstContinent[i].continent_id}">{$clsContinent->getTitle($lstContinent[i].continent_id)}</option>
                                {/section}
                            </select>
                        </div>
                    </div>
                    {/if}
					{*<div class="row-span">
                        <div class="fieldlabel">{$core->get_Lang('Status')}</div>
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
                    </div>*}
                </div>
                <div class="cleafix mt40" style="margin-bottom:40px">&nbsp;</div>
                {*<div id="v-nav" style="margin-top:40px">
						<ul>
                        	<li class="tabchildcol first current"><a href="javascript:void(0);">{$core->get_Lang('Descriptions')}</a></li>
                            <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Content')}</a></li>
							<li class="tabchildcol"><a href="#map">{$core->get_Lang('Maps')}</a></li>
                            <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('bannercover')}</a></li>
							<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('intro banner')}</a></li>
							<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Fun Facts')}</a></li>
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
									<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGBM_QUAg8Oi-dI_Bopn6JVe4jrgVUcWw&libraries=places"></script>
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
                        	<h3 style="margin-bottom:10px">{$core->get_Lang('Image Size')} (1920x480)</h3>
                            <div class="photobox span100">
                                {if $_isoman_use eq '1'}
                                <img src="{$oneItem.banner}" alt="{$core->get_Lang('images_banner')}" id="isoman_show_banner" class="span100" />
                                <input type="hidden" id="isoman_hidden_banner" name="isoman_url_banner" value="{$oneItem.banner}" />
                                <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="banner" isoman_val="{$oneItem.banner}" isoman_name="banner"><i class="iso-edit"></i></a>
                                {if $oneItem.banner}
                                <a pvalTable="{$pvalTable}" clsTable="Country" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
                                {/if}
                                {else}
                                <img src="{$oneItem.banner}" alt="{$core->get_Lang('noimages')}" id="imgTour_banner" class="span100" />
                                <input type="hidden" name="banner_src" value="{$oneItem.banner}" class="hidden_src" id="imgTour_hidden" />
                                <a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTour">
                                    <i class="iso-edit"></i>
                                </a> 
                                <input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="banner" />
                                {/if}
                            </div>
						</div>
						<div class="tab-content" style="display: none;">
							{$clsForm->showInput('intro_banner')}
						</div>
						<div class="tab-content" style="display: none;">
							{$clsForm->showInput('intro_fastfact')}
						</div>
						
				</div>*}
                
			</div>
			{*<div class="tabbox" style="display:none">
				<div class="row-span" style="display:none">
					<span class="notice bold" style="font-size:16px; padding-left:0;"><span class="requiredMask">*</span> {$core->get_Lang('tourinformation')} {$clsClassTable->getTitle($pvalTable)}</span>
					<div class="clearfix" style="height:5px"></div>
					{$clsForm->showInput('intro_tour')}
				</div>
				<div class="row-span">
					<span class="notice bold" style="font-size:16px; padding-left:0;"><span class="requiredMask">*</span> {$core->get_Lang('hotelinformation')} {$clsClassTable->getTitle($pvalTable)}</span>
					<div class="clearfix" style="height:5px"></div>
					{$clsForm->showInput('intro_hotel')}
				</div>
				<div class="row-span" style="display:none">
					<span class="notice bold" style="font-size:16px; padding-left:0;"><span class="requiredMask">*</span> {$core->get_Lang('guideinformation')} {$clsClassTable->getTitle($pvalTable)}</span>
					<div class="clearfix" style="height:5px"></div>
					{$clsForm->showInput('intro_guide')}
				</div>
			</div>*}
            {if $pvalTable}
			<div class="tabbox" style="display:none">
                <div class="row-field">
                    <div class="row-heading">{$core->get_Lang('Meta Title')}:</div>
                    <div class="coltrols">
                        <input class="text full" name="config_value_title" value="{$clsISO->getPageTitle($pvalTable,Country)}" maxlength="255" type="text" />
                        <div class="clearfix mt5"></div>
                        <i>{$core->get_Lang('notetitlemeta')}</i>
                    </div>
                </div>
                <div class="row-field">
                    <div class="row-heading">{$core->get_Lang('Meta Description')}:</div>
                    <div class="coltrols">
                        <textarea name="config_value_intro" class="text full" style="height:60px">{$clsISO->getPageDescription($pvalTable,Country)}</textarea>
                        <div class="clearfix mt5"></div>
                        <i>{$core->get_Lang('noteintrometa')}</i>
                    </div>
                </div>
                <div class="row-field">
                    <div class="row-heading">{$core->get_Lang('Meta Keyword')}:</div>
                    <div class="coltrols">
                        <textarea name="config_value_keyword" class="text full" style="height:60px">{$clsISO->getPageKeyword($pvalTable,Country)}</textarea>
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
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript">
	var map_lo="{$clsClassTable->getOneField('map_lo',$pvalTable)}";
	var map_la="{$clsClassTable->getOneField('map_la',$pvalTable)}";
	var map_zoom = "{$clsClassTable->getOneField('map_zoom',$pvalTable)}";
	var map_type  = "{$clsClassTable->getOneField('map_type',$pvalTable)}";
	var country_id="{$pvalTable}";
</script>
{literal}
<style>
	.searchmap{ background:#E9EFF3; padding:10px; margin:10px 0 0;}
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
			$(document).on('click','#map-search-input',function(){
				initialize();
			});
	});
</script>
{/literal}