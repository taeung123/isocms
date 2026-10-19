<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
						{assign var= image_detail value='image_activities'}
						{$core->getBlock('box_detail_image_activities')}
						{elseif $currentstep=='generalinformation'}
						<h3 class="title_box">{$core->get_Lang('generalinformation')}</h3>
						
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Title')} <span class="required_red">*</span>
							{assign var= title_activities value='title_activities'}
							{assign var= help_first value=$title_activities}
							{if $CHECKHELP eq 1}
							<button data-key="{$title_activities}" data-label="{$core->get_Lang('Title')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<input class="text_32 full-width bold border_aaa required title_capitalize" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($title_activities)|html_entity_decode}</div>
						</div>
						{elseif $currentstep=='shortText'}
						<div class="inpt_tour">
							<h3 class="title_box">{$core->get_Lang('Short text')} 
								{assign var= shortText_activities value='shortText_activities'}
								{assign var= help_first value=$shortText_activities}
								{if $CHECKHELP eq 1}
								<button data-key="{$shortText_activities}" data-label="{$core->get_Lang('Short text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</h3>
							<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro" class="textarea_intro_editor" data-column="iso-intro" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.intro}</textarea>
							{literal}
							<script>
							$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
							</script>
							{/literal}
						</div>
						{elseif $currentstep=='longText'}
						<div class="inpt_tour">
							<h3 class="title_box">{$core->get_Lang('Long text')} 
								{assign var= longText_activities value='longText_activities'}
								{assign var= help_first value=$longText_activities}
								{if $CHECKHELP eq 1}
								<button data-key="{$longText_activities}" data-label="{$core->get_Lang('Long text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</h3>
							<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content" class="textarea_intro_editor" data-column="iso-content" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.content}</textarea>
							{literal}
							<script>
							$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
							</script>
							{/literal}
						</div>							
						{elseif $currentstep=='gmap'}
							<div class="inpt_tour">
								<h3 class="title_box">{$core->get_Lang('Gmap')}
								{assign var= gmap_activities value='gmap_activities'}
								{assign var= help_first value=$gmap_activities}
								{if $CHECKHELP eq 1}
								<button data-key="{$gmap_activities}" data-label="{$core->get_Lang('Gmap')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
								</h3>
								<div class="fieldlabel-full mb5">
									<i class="iso-pos"></i> <strong>{$core->get_Lang('Location on map')}</strong>
								</div>
								<div class="form_option_tour">
									<div class="inpt_tour">
										<div id="HotelMap_Area">
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
										{literal}
										<script type="text/javascript">
											$(document).on('click','.tabchildcol a[href="#map"]',function(){
												initialize();
											});
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
									</div>
								</div>						
							</div>						
						{elseif $currentstep=='banner'}
							{$core->getBlock('box_detail_activities_banner')}	
						{elseif $currentstep=='seo'}
						{$core->getBlock('box_detail_activities_seotool')}	
						{/if}
						<div class="btn_save_titile_table_code mt30">
							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$arrStep[$step].key}" data-prevstep="{$prevstep}" class="back_step js_save_back">{$core->get_Lang('Back')}</a>

							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$currentstep}" data-next_step="{$nextstep}" class="js_save_continue">{$core->get_Lang('Save &amp; Continue')}</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3 col_instruction">
				<div class="instruction_fill_data_box">
					<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
					<div class="content_box">{$clsConfiguration->getValue($help_first)|html_entity_decode}</div>
				</div>
			</div>
		</div>
	</div>
</form>
{literal}
<script>
if($('.textarea_intro_editor').length > 0){
	$('.textarea_intro_editor').each(function(){
		var $_this = $(this);
		var $editorID = $_this.attr('id');
		$('#'+$editorID).isoTextArea();
	});
}
	$('.toggle-row').click(function(){
		$(this).closest('tr').toggleClass('open_tr');
	});
</script>
{/literal}