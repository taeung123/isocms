<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}">{$core->get_Lang('country')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('travelguide')}</a>
    <a>&raquo;</a>
    <a href="{$curl}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
	<!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
    	<h2>
        	{if $pvalTable}{$core->get_Lang('edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('addtravelguide')}{/if}
        </h2>
        <p>{$core->get_Lang('Please enter all required fields')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('basic')}</a></li>
                {if $pvalTable}<li class="tabchild"><a href="#"><i class="iso-media"></i> {$core->get_Lang('seosdvanced')}</a></li>{/if}
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
                    <div class="fl col_Left full_width_767">
                        <div class="photobox image">
                            {if $_isoman_use eq '1'}
                            <img src="{$oneTable.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
                            <input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneTable.image}" />
                            <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneTable.image}" isoman_name="image"><i class="iso-edit"></i></a>
                            {if $oneTable.image}
                            <a pvalTable="{$pvalTable}" clsTable="Guide" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
                            {/if}
                            {else}
                            <img src="{$oneTable.image}" alt="{$core->get_Lang('noimages')}" id="imgTestimonial_image" />
                            <input type="hidden" name="image_src" value="{$oneTable.image}" class="hidden_src" id="imgTestimonial_hidden" />
                            <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTestimonial">
                            <i class="iso-edit"></i>
                            </a>
                            <input type="file" style="display:none" id="imgTestimonial_file" g="imgTestimonial" class="editInlineImageFile" name="image" />
                            {/if}
                        </div>
                        <div class="cleafix"></div>
                        <h3 class="mt10" style="margin-top:10px">{$core->get_Lang('Image Size')} (WxH:565x377)</h3>
                    </div>
                    <div class="fl col_Right full_width_767">
                    	<div class="row-span">
                        	<div class="fieldlabel"><strong>{$core->get_Lang('title')}</strong> <font class="color_r">*</font></div>
                            <div class="fieldarea">
                            	<input class="text full required" id="search_location" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" placeholder="{$core->get_Lang('Enter title')}..."/>
                            </div>
                        </div>
                        {if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
                        <div class="row-span">
                        	<div class="fieldlabel"><strong>{$core->get_Lang('category')}</strong> <font class="color_r">*</font></div>
                            <div class="fieldarea">
                                <select name="cat_id" class="glSlBox required" style="max-width:300px">
                                     {$clsGuideCat->makeSelectboxOption(0,$cat_id)}
                                </select>
                            </div>
                        </div>
                        {/if}
						{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Location')}</strong></div>
                            <div class="fieldarea">
								{if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}
                                <select class="slb full" name="iso-country_id" id="slb_Country" style="font-size:14px;width:150px">
									{$clsCountry->makeSelectboxOption($country_id)}
								</select>
								{/if}
                                <select class="slb full" name="iso-city_id" id="slb_City" style="font-size:14px;width:150px"> 
                                    {$clsCity->makeSelectboxOption($city_id,$country_id)}
                                </select>
                            </div>
                        </div>
						{/if}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <font class="color_r">*</font></div>
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
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Publish date')}</strong></div>
                            <div class="fieldarea">
                                <input value="{$clsISO->formatTimeMonth($oneTable.publish_date)}" class="ext full required showdate" name="publish_date" type="text" autocomplete="off" style="width:220px" />
							</div>
						</div>
                    </div>
				</div>
				<div class="wrap">
					{if $clsISO->getBrowser() eq 'computer'}
					<div id="v-nav" style="margin-top:40px">
						<ul>
							<li class="tabchildcol first current"><a href="javascript:void(0);">{$core->get_Lang('Short text')}</a></li>
							<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Long text')}</a></li>
							<li class="tabchildcol"><a href="#map">{$core->get_Lang('Maps')}</a></li>
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
													<input class="text full" name="iso-map_la" id="map_la" value="{$oneTable.map_la}" type="text" style="width:95% !important" />
												</div>
											</div>
											<div class="format-setting-wrap mb10">
												<div class="format-setting-label">
													<label>{$core->get_Lang('longitude')}</label>
												</div>
												<div class="format-setting-content">
													<input class="text full" name="iso-map_lo" id="map_lo" value="{$oneTable.map_lo}" type="text" style="width:95% !important" />
												</div>
											</div>
											<div class="format-setting-wrap mb10">
												<div class="format-setting-label">
													<label>{$core->get_Lang('MapZoom')}</label>
												</div>
												<div class="format-setting-content">
													<input class="text full" name="iso-map_zoom" value="{if $oneTable.map_zoom}{$oneTable.map_zoom} {else}0{/if}" type="text" style="width:95% !important" />
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
					</div>
					{else}
					<div id="v-nav" style="margin-top:40px">
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Short text')}</strong> <font class="color_r">*</font></div>
                            <div class="fieldarea">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Long text')}</strong> <font class="color_r">*</font></div>
                            <div class="fieldarea">
								 {$clsForm->showInput('content')}
							</div>
						</div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Location on map')}</strong> <font class="color_r">*</font></div>
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
												<input class="text full" name="iso-map_la" id="map_la" value="{$oneTable.map_la}" type="text" style="width:95% !important" />
											</div>
										</div>
										<div class="format-setting-wrap mb10">
											<div class="format-setting-label">
												<label>{$core->get_Lang('longitude')}</label>
											</div>
											<div class="format-setting-content">
												<input class="text full" name="iso-map_lo" id="map_lo" value="{$oneTable.map_lo}" type="text" style="width:95% !important" />
											</div>
										</div>
										<div class="format-setting-wrap mb10">
											<div class="format-setting-label">
												<label>{$core->get_Lang('MapZoom')}</label>
											</div>
											<div class="format-setting-content">
												<input class="text full" name="iso-map_zoom" value="{if $oneTable.map_zoom}{$oneTable.map_zoom} {else}0{/if}" type="text" style="width:95% !important" />
											</div>
										</div>
										{if 1 eq 2}
										<div class="format-setting-wrap mb10">
											<div class="format-setting-label">
												<label>{$core->get_Lang('MapStyle')}</label>
											</div>
											<div class="format-setting-content">
												<input class="text full" name="iso-map_tyle" value="{$oneItem.map_tyle}" type="text" style="width:95% !important" />
											</div>
										</div>
										{/if}
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
					</div>
					{/if}
				</div>
            </div>
            {if $pvalTable}
            <div class="tabbox" style="display:none">
                {$core->getBlock('meta_box_detail')}
            </div>
            {/if}
			<div class="clearfix"><br /></div>
			<fieldset class="submit-buttons">
				{$saveBtn} {$saveList}
				<input value="Update" name="submit" type="hidden">
			</fieldset>
		</div>
	</form>
</div>
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
<script type="text/javascript">
	var map_lo="{$oneTable.map_lo}";
	var map_la="{$oneTable.map_la}";
	var map_zoom = '{$oneTable.map_zoom}';
	var guide_id="{$pvalTable}";
</script>
{literal}
<style type="text/css">
.chosen-container-single .chosen-single {
    height: 32px !important;
    line-height: 32px !important;
    border-radius: 0 !important;
    margin-right: 5px !important;
}
.chosen-container-single .chosen-single div b {
    background-position:0 6px;
}
.chosen-container-active.chosen-with-drop .chosen-single div b {
    background-position: -18px 6px;
}
</style>
<script type="text/javascript">
$().ready(function(){
	$("#slb_City").chosen({width:'150px'});  
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
				$('#slb_City').html(html).chosen({width:'150px'});
				$('#slb_City').trigger("chosen:updated");
			}
		});
	});
});
</script>
{/literal}
{literal}
<script>
$(".showdate").datepicker({dateFormat: "dd/mm/yy",changeMonth: true,changeYear: true});
</script>
{/literal}
{literal}
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
		if(map_zoom=='' || map_zoom==0) map_zoom = 11;
		map_type = 'roadmap';
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
		$('input[name=iso-title222]').click(function(){
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