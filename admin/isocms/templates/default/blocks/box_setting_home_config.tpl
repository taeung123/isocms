<div class="iso_box_setting">
    <div class="iso_box_head">
        <div class="iso_box_head d-flex justify-content-between">
            <div class="iso_box_title">
                <h1> {$core->get_Lang('Home Config')} </h1>
                <span>{$core->get_Lang('Enter full fields in the required fields')}</span>
             </div>
        </div>
    </div>
    <div class="iso_box_body">
        <form id="forums" method="post" class="filterForm" action="">
            <div class="d-flex flex-column">
                <div class="iso_home_config_item active">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Attractive tour")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitleAttractiveTour value = TitleAttractiveTour_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitleAttractiveTour)}" name="iso-{$TitleAttractiveTour}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroAttractiveTour value = IntroAttractiveTour_|cat:$_LANG_ID}
						        <textarea style="width:100%" class="textarea_intro_editor_simple " name="iso-{$IntroAttractiveTour}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroAttractiveTour)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {if $package_id !=1}
                {if $_LANG_ID ne 'vn'}
                <div class="iso_home_config_item">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Outstanding Travel Styles")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitleCatTour value = TitleCatTour_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitleCatTour)}" name="iso-{$TitleCatTour}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroCatTour value = IntroCatTour_|cat:$_LANG_ID}
						        <textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroCatTour}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroCatTour)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
                <div class="iso_home_config_item">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Favorite destination")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitleFavoriteDestination value = TitleFavoriteDestination_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitleFavoriteDestination)}" name="iso-{$TitleFavoriteDestination}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroFavoriteDestination value = IntroFavoriteDestination_|cat:$_LANG_ID}
						        <textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroFavoriteDestination}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroFavoriteDestination)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {if $_LANG_ID eq 'vn'} 
                <div class="iso_home_config_item">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Tour Inbound")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitleTourInbound value = TitleTourInbound_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitleTourInbound)}" name="iso-{$TitleTourInbound}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroTourInbound value = IntroTourInbound_|cat:$_LANG_ID}
                                <textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroTourInbound}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroTourInbound)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iso_home_config_item">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Tour Outbound")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitleTourOutbound value = TitleTourOutbound_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitleTourOutbound)}" name="iso-{$TitleTourOutbound}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroTourOutbound value = IntroTourOutbound_|cat:$_LANG_ID}
                                <textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroTourOutbound}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroTourOutbound)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {/if}
                {/if}
                <div class="iso_home_config_item">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Testimonials Box")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitleTestimonialsHome value = TitleTestimonialsHome_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitleTestimonialsHome)}" name="iso-{$TitleTestimonialsHome}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroTestimonialsHome value = IntroTestimonialsHome_|cat:$_LANG_ID}
                                <textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroTestimonialsHome}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroTestimonialsHome)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iso_home_config_item">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Self-sufficient travel")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitleSufficient value = TitleSufficient_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitleSufficient)}" name="iso-{$TitleSufficient}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroSufficient value = IntroSufficient_|cat:$_LANG_ID}
						        <textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroSufficient}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroSufficient)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iso_home_config_item">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Travel inspiration")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitleTravelInspiration value = TitleTravelInspiration_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitleTravelInspiration)}" name="iso-{$TitleTravelInspiration}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroTravelInspiration value = IntroTravelInspiration_|cat:$_LANG_ID}
						        <textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroTravelInspiration}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroTravelInspiration)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iso_home_config_item">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Partner")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitlePartner value = TitlePartner_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitlePartner)}" name="iso-{$TitlePartner}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroPartner value = IntroPartner_|cat:$_LANG_ID}
						        <textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroPartner}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroPartner)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iso_home_config_item">
                    <div class="iso_config_title d-flex justify-content-between align-items-center">
                        <span>{$core->get_Lang("Press news")}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                    <div class="iso_config_content">
                        <div class="row">
                            <div class="col-12">
                                <p class="iso_title">{$core->get_Lang('Title')}</p>
                                {assign var = TitlePressNews value = TitlePressNews_|cat:$_LANG_ID}
                                <input type="text" class="full-width" value="{$clsConfiguration->getValue($TitlePressNews)}" name="iso-{$TitlePressNews}"/>
                            </div>
                            <div class="col-12 iso_box_intro">
                                <p class="iso_title">{$core->get_Lang('Short description')}</p>
                                {assign var = IntroPressNews value = IntroPressNews_|cat:$_LANG_ID}
						        <textarea style="width:100%" class="textarea_intro_editor_simple" name="iso-{$IntroPressNews}" id="{$clsISO->getUniqid()}" cols="255" rows="2">{$clsConfiguration->getValue($IntroPressNews)}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iso_box_submit">
                    <button type="submit" name="button" class="iso_setting_submit">
                        <i class="icon-ok icon-white"></i>
                        <span>{$core->get_Lang('Save')}</span>
                    </button>
                </div>
                <input value="{$action}" name="submit" type="hidden">
            </div>
		</form>
    </div>
</div>

<script type="text/javascript">
	var $type = 'WhyUsHomePage';
	var $target_id = '0';
</script>

{literal}
<script>
    $(function(){
        $(document).on('click', '.iso_config_title', function(){
            $('.iso_home_config_item').removeClass('active');
            $(this).parents('.iso_home_config_item').addClass('active');
        });
    })
</script> 
{/literal}