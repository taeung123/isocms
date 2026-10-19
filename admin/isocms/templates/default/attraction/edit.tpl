<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>  
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Attraction')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
	<!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
    	<h2>
        	{if $pvalTable}{$core->get_Lang('editAttraction')}{else}{$core->get_Lang('addAttraction')}{/if}
        </h2>
        <p>{$core->get_Lang('Please enter all required fields')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
                {if $pvalTable}<li class="tabchild"><a href="#"><i class="iso-media"></i> {$core->get_Lang('seosdvanced')}</a></li>{/if}
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
                	 <div class="photobox fl mr20 image">
                     	{if $_isoman_use eq '1'}
						<img src="{$oneTable.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
						<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneTable.image}" />
						<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneTable.image}" isoman_name="image"><i class="iso-edit"></i></a>
						{if $oneTable.image}
						<a pvalTable="{$pvalTable}" clsTable="Attraction" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
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
                    <div class="fl span75">
                    	<div class="row-span">
                        	<div class="fieldlabel">{$core->get_Lang('title')} <font class="required">*</font></div>
                            <div class="fieldarea">
                            	<input class="text full required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>                        
						{if $clsConfiguration->getValue('SiteActive_city') eq '1'}
						<div class="row-span">
                            <div class="fieldlabel">{$core->get_Lang('Location')}<font class="required">*</font></div>
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
                                <select class="slb required full" name="iso-area_city_id" id="slb_AreaCity" style="font-size:14px;width:150px"> 
                                    {$clsAreaCity->makeSelectboxOption($area_city_id,$city_id)}
                                </select>
                            </div>
                        </div>
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
                        <div class="TEXT formelement row-span">
                        	<span class="notice"><strong style="font-size:16px;">{$core->get_Lang('intro')}</strong></span>
                        	{$clsForm->showInput('intro')}
                        </div>
                        <div class="TEXT formelement row-span">
                        	<span class="notice"><strong style="font-size:16px;">{$core->get_Lang('content')}</strong></span>
                        	{$clsForm->showInput('content')}
                        </div>
                        <div class="row-span">
                            <div class="fieldlabel-full">
                                <i class="iso-pos"></i> <strong>{$core->get_Lang('Location on map')}</strong>
                            </div>
                            <div class="clearfix" style="height:5px"></div>
                            <div class="fieldarea-full" style="width:100%">
                                <div class="searchmap">
                                    <div class="wrap">
                                        <input class="text full fl" id="search_location" type="text" />
                                        <a class="btn fr btn-success" id="searchMap">
                                            <i class="icon-white icon-search"></i>
                                            <span>{$core->get_Lang('search')}</span>
                                        </a>
                                    </div>
                                </div>
                                    <div style="width:100%; height:220px; position:relative">
                                        <div id="map_canvas" style="width:100%; height:220px; overflow:hidden">
                                        </div>
                                        <div class="map_sitebar" style="height:160px">
                                            <div class="row-field">
                                                <div class="row-heading notToogle">{$core->get_Lang('latitude')}</div>
                                                <div class="coltrols">
                                                    <input class="text full" name="iso-map_la" id="map_la" value="{$oneItem.map_la}" maxlength="255" type="text" style="width:95% !important" />
                                                </div>
                                            </div>
                                            <div class="row-field">
                                                <div class="row-heading notToogle">{$core->get_Lang('longitude')}</div>
                                                <div class="coltrols">
                                                    <input class="text full" name="iso-map_lo" id="map_lo" value="{$oneItem.map_lo}" maxlength="255" type="text" style="width:95% !important" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
        	</div>
            {if $pvalTable}
            <div class="tabbox" style="display:none">
               {$core->getBlock('meta_box_detail')}
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
<script type="text/javascript">
    var pvalTable = "{$pvalTable}";
    var country_id = "{$oneItem.country_id}";
	var region_id = "{$oneItem.region_id}";
    var city_id = "{$oneItem.city_id}";
	var area_city_id = "{$oneItem.area_city_id}";
	var $Hotel_Area = '{$clsConfiguration->getValue("Hotel_Area")}';
	var $Hotel_Region = '{$clsConfiguration->getValue("Hotel_Region")}';
	var $Hotel_City = '{$clsConfiguration->getValue("Hotel_City")}';
	var image_type = 'hotel';	
	var regions = "{$core->get_Lang('regions')}";
	var cities = "{$core->get_Lang('cities')}";
	var required_hotel_title = "{$core->get_Lang('required_hotel_title')}";
</script>

<script type="text/javascript">
	var map_lo="{$oneItem.map_lo}";
	var map_la="{$oneItem.map_la}";
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
				$getID('search_location').value = responses[0].formatted_address;
				$getID('map_la').value = marker.getPosition().lat(); 
				$getID('map_lo').value = marker.getPosition().lng();
				map.panTo(marker.getPosition());
		});
	}
	function initialize(){
		map_lo=map_lo!='' ? map_lo : '105.86727258378903'; 
		map_la=map_la!='' ? map_la : '20.988668210459167'; 
		/**/
		var mapOptions = {
			center: new google.maps.LatLng(map_la,map_lo),
			zoom:11,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}; 
		map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions); 
		var input = document.getElementById('search_location'); 
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
				map.setCenter(place.geometry.location); map.setZoom(17); 
			}
			geocode(place.geometry.location);
			marker.setPosition(place.geometry.location); 
		}); 
	} 
	/**/ 
	function showAddress(address){
		geocoder = new google.maps.Geocoder(); 
		geocoder.geocode({'address': address},function(results){
			marker.setMap(null); 
			map.setCenter(results[0].geometry.location); 
			marker = new google.maps.Marker({ map: map, position: results[0].geometry.location, title: address }); 
			$getID('lat_lng').value = results[0].geometry.location; marker.setDraggable (true); 
		});
	}; 
	/*End showAddress*/ 
	$(document).ready(function(){

		$('#searchMap').click(function(){
			var address=$('#search_location').val(); 
			showAddress(address); 
			return false; 
		});
	});
	function stopRKey(evt) { 
		var evt = (evt) ? evt : ((event) ? event : null); 
		var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
		if ((evt.keyCode == 13) && (node.type=="text")){
			return false;
		} 
	} 
	document.onkeypress = stopRKey;
</script>
{/literal}
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
<script type="text/javascript" src="{$URL_THEMES}/attraction/jquery.attraction.js?v={$upd_version}"></script>
{literal}
<script type="text/javascript">
$().ready(function(){
	$(".chosen-select").chosen({width:'100%'});
});
</script>
{/literal}