<div class="breadcrumb">
	<strong>Bạn đang ở:</strong>
	<a href="{$PCMS_URL}" title="Trang chủ">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="Cài đặt">{$core->get_Lang('Installation')}</a>
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('Come back')}</a>
</div>
<div class="page-tour_setting">
	<div class="page-title  d-flex" onclick="location.href='{$PCMS_URL}/?&mod={$mod}&act={$act}'">
		<div class="title">
			<h1>{$core->get_Lang('Home Config')}</h1>
			<p>{$core->get_Lang('Enter full fields in the required fields')}</p>
		</div>
	</div>
	<div class="container-fluid">
		<form id="forums" method="post" class="filterForm" action="">

			<fieldset>
				<legend>{$core->get_Lang("Attractive tour")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitleAttractiveTour value = TitleAttractiveTour_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleAttractiveTour)}" name="iso-{$TitleAttractiveTour}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroAttractiveTour value = IntroAttractiveTour_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroAttractiveTour}" id="IntroAttractiveTour" cols="255" rows="2">{$clsConfiguration->getValue($IntroAttractiveTour)}</textarea>
					</div>
				</div>
			</fieldset>
            {if $package_id !=1}
			{if $_LANG_ID ne 'vn'}
			<fieldset>
				<legend>{$core->get_Lang("Outstanding Travel Styles")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitleCatTour value = TitleCatTour_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleCatTour)}" name="iso-{$TitleCatTour}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroCatTour value = IntroCatTour_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroCatTour}" id="IntroCatTour" cols="255" rows="2">{$clsConfiguration->getValue($IntroCatTour)}</textarea>
					</div>
				</div>
			</fieldset>
			{/if}
			<fieldset>
				<legend>{$core->get_Lang("Favorite destination")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitleFavoriteDestination value = TitleFavoriteDestination_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleFavoriteDestination)}" name="iso-{$TitleFavoriteDestination}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroFavoriteDestination value = IntroFavoriteDestination_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroFavoriteDestination}" id="IntroFavoriteDestination" cols="255" rows="2">{$clsConfiguration->getValue($IntroFavoriteDestination)}</textarea>
					</div>
				</div>
			</fieldset>
			{if $_LANG_ID eq 'vn'}
			<fieldset>
				<legend>{$core->get_Lang("Tour Inbound")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitleTourInbound value = TitleTourInbound_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleTourInbound)}" name="iso-{$TitleTourInbound}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroTourInbound value = IntroTourInbound_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroTourInbound}" id="IntroTourInbound" cols="255" rows="2">{$clsConfiguration->getValue($IntroTourInbound)}</textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>{$core->get_Lang("Tour Outbound")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitleTourOutbound value = TitleTourOutbound_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleTourOutbound)}" name="iso-{$TitleTourOutbound}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroTourOutbound value = IntroTourOutbound_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroTourOutbound}" id="IntroTourOutbound" cols="255" rows="2">{$clsConfiguration->getValue($IntroTourOutbound)}</textarea>
					</div>
				</div>
			</fieldset>
			{/if}
			{/if}
			<fieldset>
				<legend>{$core->get_Lang("Testimonials Box")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitleTestimonialsHome value = TitleTestimonialsHome_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleTestimonialsHome)}" name="iso-{$TitleTestimonialsHome}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroTestimonialsHome value = IntroTestimonialsHome_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroTestimonialsHome}" id="IntroTestimonialsHome" cols="255" rows="2">{$clsConfiguration->getValue($IntroTestimonialsHome)}</textarea>
					</div>
				</div>
			</fieldset>
            <fieldset>
				<legend>{$core->get_Lang("Self-sufficient travel")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitleSufficient value = TitleSufficient_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleSufficient)}" name="iso-{$TitleSufficient}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroSufficient value = IntroSufficient_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroSufficient}" id="IntroSufficient" cols="255" rows="2">{$clsConfiguration->getValue($IntroSufficient)}</textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>{$core->get_Lang("Travel inspiration")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitleTravelInspiration value = TitleTravelInspiration_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleTravelInspiration)}" name="iso-{$TitleTravelInspiration}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroTravelInspiration value = IntroTravelInspiration_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroTravelInspiration}" id="IntroTravelInspiration" cols="255" rows="2">{$clsConfiguration->getValue($IntroTravelInspiration)}</textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>{$core->get_Lang("Partner")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitlePartner value = TitlePartner_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitlePartner)}" name="iso-{$TitlePartner}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroPartner value = IntroPartner_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroPartner}" id="IntroPartner" cols="255" rows="2">{$clsConfiguration->getValue($IntroPartner)}</textarea>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>{$core->get_Lang("Press news")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var = TitlePressNews value = TitlePressNews_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitlePressNews)}" name="iso-{$TitlePressNews}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Short description')}</div>
					<div class="fieldarea">
						{assign var = IntroPressNews value = IntroPressNews_|cat:$_LANG_ID}
						<textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroPressNews}" id="IntroPressNews" cols="255" rows="2">{$clsConfiguration->getValue($IntroPressNews)}</textarea>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<legend>{$core->get_Lang("Banner Home")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title search tours')}</div>
					{assign var=TitleSearchTours value=TitleSearchTours_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleSearchTours)}" name="iso-{$TitleSearchTours}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title search cruises')}</div>
					{assign var=TitleSearchCruises value=TitleSearchCruises_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleSearchCruises)}" name="iso-{$TitleSearchCruises}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title search hotels')}</div>
					{assign var=TitleSearchHotels value=TitleSearchHotels_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleSearchHotels)}" name="iso-{$TitleSearchHotels}"/>
					</div>
				</div>
			</fieldset>

					<fieldset>
				<legend>{$core->get_Lang("Box featured destinations")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Country/city featured')}</div>
					{assign var=ShowFeaturedDestinations value=ShowFeaturedDestinations_|cat:$_LANG_ID}
					<div class="fieldarea">
						<select class="text_32" name="iso-{$ShowFeaturedDestinations}">
							<option value="1" {if $clsConfiguration->getValue($ShowFeaturedDestinations)==1}selected{/if}>{$core->get_Lang('Show Country')}</option>
							<option value="2" {if $clsConfiguration->getValue($ShowFeaturedDestinations)==2}selected{/if}>{$core->get_Lang('Show City')}</option>
						</select>
					</div>
				</div>
			</fieldset>


			<fieldset>
				<legend>{$core->get_Lang("Box subscribe")}</legend>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Title')}</div>
					{assign var=TitleSubscribe value=TitleSubscribe_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($TitleSubscribe)}" name="iso-{$TitleSubscribe}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Description')}</div>
					{assign var=DescriptionSubscribe value=DescriptionSubscribe_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($DescriptionSubscribe)}" name="iso-{$DescriptionSubscribe}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel">{$core->get_Lang('Note')}</div>
					{assign var=NoteSubscribe value=NoteSubscribe_|cat:$_LANG_ID}
					<div class="fieldarea">
						<input type="text" class="text_32 full-width border_aaa" value="{$clsConfiguration->getValue($NoteSubscribe)}" name="iso-{$NoteSubscribe}"/>
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel width100_767">{$core->get_Lang('Image')}</div>
					<div class="fieldarea">
						<span style="display:block">Width x Height: 640x316</span>
						<img id="isoman_show_image_Fx" width="200" height="150" src="{$clsConfiguration->getValue('ImageSubscribe')}"/>
						<input type="hidden" id="isoman_hidden_image_Fx"
								value="{$clsConfiguration->getValue('ImageSubscribe')}">
						<input type="hidden" style="width:70% !important;float:left;margin-left:4px;height:35px"
								id="isoman_url_image_Fx" name="iso-ImageSubscribe"
								value="{$clsConfiguration->getValue('ImageSubscribe')}"><a
								style="float:left; margin-left:4px; margin-top:4px;" href="#" class="ajOpenDialog"
								isoman_for_id="image_Fx" isoman_val="{$clsConfiguration->getValue('ImageSubscribe')}"
								isoman_name="image"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
					</div>
				</div>
			</fieldset>
			
			<fieldset class="submit-buttons">
				{$saveBtn}
				<input value="UpdateConfiguration" name="submit" type="hidden">
			</fieldset>
		</form>
	</div>
</div>
<script type="text/javascript">
	var $type = 'WhyUsHomePage';
	var $target_id = '0';
</script>