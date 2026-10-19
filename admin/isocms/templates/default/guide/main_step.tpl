<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
						{assign var= image_detail value='image_guide'}
						{$core->getBlock('box_detail_image')}
						{elseif $currentstep=='basic'}
						<h3 class="title_box">{$core->get_Lang('Basic')}</h3>
						{assign var=guide_title value=$clsClassTable->getTitle($pvalTable)|default:''}
{assign var=guide_slug value=$oneItem.slug|default:''}

{assign var=default_guide_slug value="new-guide-`$pvalTable`"}
{assign var=default_guide_title value="New Guide `{$pvalTable}`"}

{assign var=is_new_guide value=false}

{if $guide_slug eq ''
	|| $guide_slug eq $default_guide_slug
	|| $guide_title eq ''
	|| $guide_title eq $default_guide_title
}
	{assign var=is_new_guide value=true}
{/if}
				<div
	id="guide_general_information"
	data-is-new="{if $is_new_guide}1{else}0{/if}"
>
	<div class="inpt_tour">
		<label for="guide_title">
			{$core->get_Lang('Title')}
			<span class="required_red">*</span>

			{assign var=title_guide value='title_guide'}
			{assign var=help_first value=$title_guide}

			{if $CHECKHELP eq 1}
				<button
					data-key="{$title_guide}"
					data-label="{$core->get_Lang('Title')|escape:'html'}"
					type="button"
					title="Thêm mô tả"
					onclick="open_texthelp(this, event)"
					class="btn btn-xs btn-default"
				>
					<i class="fa fa-plus-circle"></i>
				</button>
			{/if}
		</label>

		<input
			class="input_text_form input-title required"
			data-table_id="{$pvalTable}"
			name="title"
			id="guide_title"
			value="{if $is_new_guide}{else}{$guide_title|escape:'html'}{/if}"
			maxlength="255"
			type="text"
			placeholder="{$core->get_Lang('New title')|escape:'html'}"
			autocomplete="off"
			onclick="loadHelp(this)"
		>

		<div class="text_help" hidden>
			{$clsConfiguration->getValue($title_guide)|html_entity_decode}
		</div>
	</div>

	<div class="inpt_tour guide_url_group">
		<label for="guide_slug">
			{$core->get_Lang('URL')}
		</label>

		<p class="guide_url_note">
			{$core->get_Lang(
				'You should NOT change your URL frequently unless absolutely necessary. Changing your URL can have a negative impact on your SEO.'
			)}
		</p>

		{if !$is_new_guide}
			<label
				class="guide_change_url_label"
				for="change_url"
			>
				<input
					type="checkbox"
					id="change_url"
					name="change_url"
					value="1"
				>

				<strong>
					{$core->get_Lang('Change URL')}
				</strong>
			</label>
		{else}
			<input
				type="hidden"
				id="change_url"
				name="change_url"
				value="1"
			>
		{/if}

		<input
			class="input_text_form guide_slug_input"
			type="text"
			id="guide_slug"
			name="slug"
			value="{if $is_new_guide}{else}{$guide_slug|escape:'html'}{/if}"
			data-original-slug="{$guide_slug|escape:'html'}"
			placeholder="{$core->get_Lang('URL slug')|escape:'html'}"
			autocomplete="off"
			spellcheck="false"
			{if !$is_new_guide}readonly{/if}
		>

		<input
			type="hidden"
			id="original_slug"
			name="original_slug"
			value="{$guide_slug|escape:'html'}"
		>
	</div>
</div>
						{if $clsISO->getCheckActiveModulePackage($package_id,'guide','cat','default')}
                        <div class="inpt_tour">
								<label for="title">{$core->get_Lang('category')} <span class="required_red">*</span>
								{assign var= category_guide value='category_guide'}
								{if $CHECKHELP eq 1}
								<button data-key="{$category_guide}" data-label="{$core->get_Lang('category')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
								</label>
								<div class="fieldarea">
									<select class="glSlBox border_aaa required" name="cat_id" style="width:250px" onClick="loadHelp(this)">
										{$clsGuideCat->makeSelectboxOption(0,$oneItem.cat_id)}
									</select>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($category_guide)|html_entity_decode}</div>
								</div>
						</div>
                        {/if}
                        {if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
                        	<div class="inpt_tour">
								<label for="title">{$core->get_Lang('Location')}
								{assign var= location_guide value='location_guide'}
								{if $CHECKHELP eq 1}
								<button data-key="{$location_guide}" data-label="{$core->get_Lang('Location')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
								</label>
								<div class="fieldarea">
									{if $clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}
										{*<select class="glSlBox border_aaa" id="slb_Country" name="iso-country_id" style="width:250px" onClick="loadHelp(this)">
											{$clsCountry->makeSelectboxOption($oneItem.country_id)}
										</select>*}
										{assign var=lst_country value=$clsISO->getArrayByTextSlash($oneItem.list_country_id)}
										<select name="list_country[]" id="list_country" class="full-width chosen-select"
												multiple="multiple" onClick="loadHelp(this)">
											{foreach from=$lstCountry key=key item=item}
												<option {if $clsISO->checkItemInArray($item.country_id, $lst_country)} selected {/if}
														value="{$item.country_id}">{$item.title}</option>
											{/foreach}
										</select>
									{/if}
									{*<select class="glSlBox border_aaa" id="slb_City" name="iso-city_id" style="width:250px" onClick="loadHelp(this)">
										{$clsCity->makeSelectboxOption($oneItem.city_id,$oneItem.country_id)}
									</select>
									<div class="text_help" hidden="">{$clsConfiguration->getValue($location_guide)|html_entity_decode}</div>*}
								</div>
								{*{literal}
								<script type="text/javascript">
									$().ready(function(){
										$('#slb_Country').change(function() {
											var $_this = $(this);
											$('#slb_City').html('<option value="">'+loading+'</option>');
											$.ajax({
												type: "POST",
												url: path_ajax_script+'/index.php?mod=guide&act=loadCity',
												data: {"country_id": $_this.val()},
												dataType: "html",
												success: function(html) {
													$('#slb_City').html(html).chosen({width:'250px'});
													$('#slb_City').trigger("chosen:updated");
												}
											});
										});
									});
								</script>
								{/literal}*}
							</div>
						{/if}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Publish date')}
							{assign var= publish_date_guide value='publish_date_guide'}
							{if $CHECKHELP eq 1}
							<button data-key="{$publish_date_guide}" data-label="{$core->get_Lang('Publish date')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
							</label>
							<div class="fieldarea">
								<input class="text_32 border_aaa showdate" name="publish_date" value="{$clsISO->formatTimeMonth($oneItem.publish_date)}" maxlength="255" type="text" onClick="loadHelp(this)" />
								<div class="text_help" hidden="">{$clsConfiguration->getValue($publish_date_guide)|html_entity_decode}</div>							
							</div>
							{literal}
								<script>
								$(".showdate").datepicker({dateFormat: "dd/mm/yy",changeMonth: true,changeYear: true});
								</script>
							{/literal}
						</div>
						
						{elseif $currentstep=='shortText'}
						<div class="inpt_tour">
							<h3 class="title_box">{$core->get_Lang('Short text')} 
								{assign var= shortText_guide value='shortText_guide'}
								{assign var= help_first value=$shortText_guide}
								{if $CHECKHELP eq 1}
								<button data-key="{$shortText_guide}" data-label="{$core->get_Lang('Short text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</h3>
							<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro" class="textarea_intro_editor" data-column="iso-intro" id="textarea_intro_editor_overview_{$currentstep}_{$now}" cols="255" rows="2">{$oneItem.intro}</textarea>
							{literal}
							<script>
							$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
							</script>
							{/literal}
						</div>
						{elseif $currentstep=='longText'}
						<div class="inpt_tour">
							<h3 class="title_box">{$core->get_Lang('Long text')} 
								{assign var= longText_guide value='longText_guide'}
								{assign var= help_first value=$longText_guide}
								{if $CHECKHELP eq 1}
								<button data-key="{$longText_guide}" data-label="{$core->get_Lang('Long text')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</h3>
							<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content" class="textarea_intro_editor" data-column="iso-content" id="textarea_editor_overview_{$currentstep}_{$now}" cols="255" rows="2">{$oneItem.content}</textarea>
							{literal}
							<script>
							$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
							</script>
							{/literal}
						</div>							
						{elseif $currentstep=='gmap'}
							<div class="inpt_tour">
								<h3 class="title_box">{$core->get_Lang('Gmap')}
								{assign var= gmap_guide value='gmap_guide'}
								{assign var= help_first value=$gmap_guide}
								{if $CHECKHELP eq 1}
								<button data-key="{$gmap_guide}" data-label="{$core->get_Lang('Gmap')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
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
						
						{elseif $currentstep=='seo'}
							{$core->getBlock('box_detail_guide_seotool')}			
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
					<div class="content_box">{$clsConfiguration->getValue($help_first|default:'')|html_entity_decode}</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	var list_check_target = {$list_check_target};
</script>
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
	$.each( list_check_target, function( i, val ) {
		if(val.status == 1){
			$('#step_'+val.key).closest('li').removeAttr('class').addClass("check_success");
		}else{
			$('#step_'+val.key).closest('li').removeAttr('class').addClass("check_caution");
		}
	});
</script>
{/literal}
{literal}
<script>
(function () {
	'use strict';

	function makeGuideSlugFromTitle(value) {
		value = String(value || '');

		if (typeof value.normalize === 'function') {
			value = value
				.normalize('NFD')
				.replace(/[\u0300-\u036f]/g, '');
		}

		return value
			.replace(/[đĐ]/g, 'd')
			.toLowerCase()
			.trim()
			.replace(/&/g, ' and ')
			.replace(/['’"`]/g, '')
			.replace(/[^a-z0-9]+/g, '-')
			.replace(/-{2,}/g, '-')
			.replace(/^-+|-+$/g, '');
	}

	function sanitizeGuideSlugTyping(value) {
		value = String(value || '');

		if (typeof value.normalize === 'function') {
			value = value
				.normalize('NFD')
				.replace(/[\u0300-\u036f]/g, '');
		}

		return value
			.replace(/[đĐ]/g, 'd')
			.toLowerCase()
			.replace(/\s+/g, '-')
			.replace(/[^a-z0-9.-]/g, '')
			.replace(/-{2,}/g, '-')
			.replace(/\.{2,}/g, '.');
	}

	function normalizeGuideSlugOnBlur(value) {
		value = sanitizeGuideSlugTyping(value)
			.replace(/^-+/, '')
			.replace(/-+$/, '')
			.replace(/^\.+/, '');

		var hasHtml = /\.html$/i.test(value);

		if (hasHtml) {
			var base = value.replace(/\.html$/i, '');

			base = base
				.replace(/\./g, '-')
				.replace(/-{2,}/g, '-')
				.replace(/^-+|-+$/g, '');

			value = base ? base + '.html' : '';
		} else {
			value = value
				.replace(/\./g, '-')
				.replace(/-{2,}/g, '-')
				.replace(/^-+|-+$/g, '');
		}

		return value;
	}

	function initGuideSlug() {
		var wrapper = document.getElementById(
			'guide_general_information'
		);

		var titleInput = document.getElementById(
			'guide_title'
		);

		var slugInput = document.getElementById(
			'guide_slug'
		);

		var changeUrlInput = document.getElementById(
			'change_url'
		);

		if (
			!wrapper ||
			!titleInput ||
			!slugInput ||
			!changeUrlInput
		) {
			return;
		}

		if (
			wrapper.getAttribute(
				'data-slug-initialized'
			) === '1'
		) {
			return;
		}

		wrapper.setAttribute(
			'data-slug-initialized',
			'1'
		);

		var isNew =
			wrapper.getAttribute('data-is-new') === '1';

		var originalSlug =
			slugInput.getAttribute(
				'data-original-slug'
			) || '';

		if (isNew) {
			titleInput.value = '';
			slugInput.value = '';

			titleInput.readOnly = false;
			slugInput.readOnly = false;

			slugInput.classList.remove(
				'is-readonly'
			);

			titleInput.addEventListener(
				'input',
				function () {
					slugInput.value =
						makeGuideSlugFromTitle(
							titleInput.value
						);
				}
			);
		} else {
			slugInput.readOnly = true;
			slugInput.classList.add('is-readonly');

			changeUrlInput.addEventListener(
				'change',
				function () {
					if (changeUrlInput.checked) {
						slugInput.readOnly = false;

						slugInput.classList.remove(
							'is-readonly'
						);

						slugInput.focus();
						return;
					}

					slugInput.value = originalSlug;
					slugInput.readOnly = true;

					slugInput.classList.add(
						'is-readonly'
					);
				}
			);
		}

		slugInput.addEventListener(
			'input',
			function () {
				if (
					!isNew &&
					!changeUrlInput.checked
				) {
					slugInput.value = originalSlug;
					return;
				}

				slugInput.value =
					sanitizeGuideSlugTyping(
						slugInput.value
					);
			}
		);

		slugInput.addEventListener(
			'blur',
			function () {
				if (
					!isNew &&
					!changeUrlInput.checked
				) {
					return;
				}

				slugInput.value =
					normalizeGuideSlugOnBlur(
						slugInput.value
					);
			}
		);
	}

	if (document.readyState === 'loading') {
		document.addEventListener(
			'DOMContentLoaded',
			initGuideSlug
		);
	} else {
		initGuideSlug();
	}

	window.initGuideSlug = initGuideSlug;
})();
</script>

<style>
.guide_url_group {
	margin-top: 28px;
}

.guide_url_note {
	max-width: 720px;
	margin: 0 0 14px;
	color: #344054;
	font-size: 13px;
	line-height: 21px;
}

.guide_change_url_label {
	display: inline-flex;
	align-items: center;
	gap: 7px;
	margin: 0 0 10px;
	padding: 8px 11px;
	border: 1px solid #d0d5dd;
	border-radius: 4px;
	background: #fff;
	cursor: pointer;
	user-select: none;
}

.guide_change_url_label input {
	width: 15px;
	height: 15px;
	margin: 0;
	cursor: pointer;
}

#guide_title,
.guide_slug_input {
	width: 100%;
	background: #fff;
	color: #101828;
}

.guide_slug_input.is-readonly,
.guide_slug_input[readonly] {
	background: #f2f4f7;
	color: #667085;
	cursor: not-allowed;
	opacity: 1;
}
</style>
{/literal}