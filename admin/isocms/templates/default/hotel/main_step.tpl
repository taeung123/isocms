<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="box_main_step_content">
        <div class="row d-flex full-height">
            <div class="col-md-9">
                <div class="fill_data_box">
                    <div class="form_title_and_table_code">
                        {assign var=hotel_title value=$clsClassTable->getTitle($pvalTable)|default:''}
                        {assign var=hotel_slug value=$oneItem.slug|default:''}

                        {assign var=default_hotel_slug value="new-hotel-`$pvalTable`"}
                        {assign var=default_hotel_title value="New Hotel `{$pvalTable}`"}

                        {assign var=is_new_hotel value=false}

                        {if $hotel_slug eq ''
                            || $hotel_slug eq $default_hotel_slug
                            || $hotel_title eq ''
                            || $hotel_title eq $default_hotel_title
                        }
                            {assign var=is_new_hotel value=true}
                        {/if}
                        {if $currentstep=='name'}
                            <h3 class="title_box">{$core->get_Lang('Name and Hotel Rating')}</h3>
                            <div
		id="hotel_general_information"
		data-is-new="{if $is_new_hotel}1{else}0{/if}"
	>
		<div class="inpt_tour">
			<label for="title">
				{$core->get_Lang('Title')}
				<span class="required_red">*</span>

				{assign var=title_hotel value='title_hotel'}
				{assign var=help_first value=$title_hotel}

				{if $CHECKHELP eq 1}
					<button
						data-key="{$title_hotel}"
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
				type="text"
				id="title"
				name="title"
				value="{if $is_new_hotel}{else}{$hotel_title|escape:'html'}{/if}"
				placeholder="{$core->get_Lang('New title')|escape:'html'}"
				autocomplete="off"
				onclick="loadHelp(this)"
			>

			<div class="text_help" hidden>
				{$clsConfiguration->getValue($title_hotel)|html_entity_decode}
			</div>
		</div>

		{* URL / SLUG *}
		<div class="inpt_tour hotel_url_group">
			<label for="hotel_slug">
				{$core->get_Lang('URL')}
			</label>

			<p class="hotel_url_note">
				{$core->get_Lang(
					'You should NOT change your URL frequently unless absolutely necessary. Changing your URL can have a negative impact on your SEO.'
				)}
			</p>

			{if !$is_new_hotel}
				<label
					class="hotel_change_url_label"
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
				class="input_text_form hotel_slug_input"
				type="text"
				id="hotel_slug"
				name="slug"
				value="{if $is_new_hotel}{else}{$hotel_slug|escape:'html'}{/if}"
				data-original-slug="{$hotel_slug|escape:'html'}"
				placeholder="{$core->get_Lang('URL slug')|escape:'html'}"
				autocomplete="off"
				spellcheck="false"
				{if !$is_new_hotel}readonly{/if}
			>

			<input
				type="hidden"
				id="original_slug"
				name="original_slug"
				value="{$hotel_slug|escape:'html'}"
			>
		</div>
	</div>
                            <div class="inpt_tour">
                                <label>{$core->get_Lang('Rating')} <span class="required_red">*</span>
                                    {assign var= rate_hotel value='rate_hotel'}
                                    {if $CHECKHELP eq 1}
                                        <button data-key="{$rate_hotel}" data-label="{$core->get_Lang('Rating')}"
                                                type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                                class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i>
                                        </button>
                                    {/if}
                                </label>
                                <div class="fieldarea" onClick="loadHelp(this)">
                                    <label class="radio inline version-xs text_normal"><input type="radio"
                                                                                              name="star_id"
                                                                                              {if $oneItem.star_id eq '1' or $pvalTable eq '1'}checked="checked"{/if}
                                                                                              value="1"> {$core->get_Lang('Un Rated')}
                                    </label>
                                    {section name=star start=2 loop=7 step=1}
                                        <label class="radio inline version-xs text_normal"><input type="radio"
                                                                                                  name="star_id"
                                                                                                  {if $oneItem.star_id eq $smarty.section.star.index}checked="checked"{/if}
                                                                                                  value="{$smarty.section.star.index}">{$smarty.section.star.index} {$core->get_Lang('star')}
                                        </label>
                                    {/section}
                                    <div class="text_help"
                                         hidden="">{$clsConfiguration->getValue($star_cruise)|html_entity_decode}</div>
                                </div>
                            </div>
                            <div class="inpt_tour">
                                <label>{$core->get_Lang('Type hotel')}</label>
                                <select name="type_hotel_id" id="type_hotel_id" class="form-control">
                                    {$clsISO->getSelectPropertyType('TypeHotel',$oneItem.list_TypeHotel)}
                                </select>
                            </div>
                            <div class="inpt_tour">
                                <label>{$core->get_Lang('Taxes & Fees')}</label>
                                <div class="fieldarea">
                                    <label class="radio inline version-xs text_normal">
                                        <input type="radio" name="includes_taxes_fees" id="includes_taxes_fees" value="1" {if $oneItem.includes_taxes_fees == 1}checked="checked"{/if}>
                                        {$core->get_Lang('Include')}
                                    </label>
                                    <label class="radio inline version-xs text_normal">
                                    <input type="radio" name="includes_taxes_fees" id=includes_taxes_fees" value="0" {if $oneItem.includes_taxes_fees == 0}checked="checked"{/if}>
                                    {$core->get_Lang('Not Include')}
                                    </label>
                                </div>
                            </div>
                            <div class="inpt_tour">
                                <label>{$core->get_Lang('Tags hotel')}</label>
                                <select id="tags_hotel" name="tags_hotel[]" class="chosen-select tags_hotel"
                                        multiple="multiple">
                                    {$clsISO->getSelectPropertyTypeHotel('TagsHotel',$oneItem.tags_hotel)}
                                </select>
                            </div>
                            <div class="inpt_tour">
                                <label for="title">{$core->get_Lang('reviewhotel')}
                                    {assign var= review_hotel value='review_hotel'}
                                    {if $CHECKHELP eq 1}
                                        <button data-key="{$review_hotel}"
                                                data-label="{$core->get_Lang('reviewcruise')}" type="button"
                                                title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                                class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i>
                                        </button>
                                    {/if}
                                </label>
                                <div class="fieldarea" onClick="loadHelp(this)">
                                    <div class="text_help"
                                         hidden="">{$clsConfiguration->getValue($review_hotel)|html_entity_decode}</div>
                                    <div style="width: 100%; margin-right: 20px; float: left;">
                                        <div class="bold"
                                             style="margin:0 0 1.33em">{$core->get_Lang('Score breakdown')}</div>
                                        <div class="row-span">
                                            <div class="fieldlabel span30">{$core->get_Lang('Location')}</div>
                                            <div class="fieldarea span50 fl"><input
                                                        class="text full span90 fontLarge price-In" name="staff"
                                                        value="{$clsISO->formatNumberToEasyRead($clsReviewsHotel->getValueByField($pvalTable,'staff'))}"
                                                        maxlength="255" type="text"/> %
                                            </div>
                                        </div>
                                        <div class="row-span">
                                            <div class="fieldlabel span30">{$core->get_Lang('Facilities')}</div>
                                            <div class="fieldarea span50 fl"><input
                                                        class="text full span90 fontLarge price-In" name="amenities"
                                                        value="{$clsISO->formatNumberToEasyRead($clsReviewsHotel->getValueByField($pvalTable,'amenities'))}"
                                                        maxlength="255" type="text"/> %
                                            </div>
                                        </div>
                                        <div class="row-span">
                                            <div class="fieldlabel span30">{$core->get_Lang('Value for money')}</div>
                                            <div class="fieldarea span50 fl"><input
                                                        class="text full span90 fontLarge price-In" name="clean"
                                                        value="{$clsISO->formatNumberToEasyRead($clsReviewsHotel->getValueByField($pvalTable,'clean'))}"
                                                        maxlength="255" type="text"/> %
                                            </div>
                                        </div>
                                        <div class="row-span">
                                            <div class="fieldlabel span30">{$core->get_Lang('Service')}</div>
                                            <div class="fieldarea span50 fl"><input
                                                        class="text full span90 fontLarge price-In" name="place"
                                                        value="{$clsISO->formatNumberToEasyRead($clsReviewsHotel->getValueByField($pvalTable,'place'))}"
                                                        maxlength="255" type="text"/> %
                                            </div>
                                        </div>
                                        <div class="row-span">
                                            <div class="fieldlabel span30">{$core->get_Lang('Cleanliness')}</div>
                                            <div class="fieldarea span50 fl"><input
                                                        class="text full span90 fontLarge price-In" name="food_drink"
                                                        value="{$clsISO->formatNumberToEasyRead($clsReviewsHotel->getValueByField($pvalTable,'food_drink'))}"
                                                        maxlength="255" type="text"/> %
                                            </div>
                                        </div>
                                        <div class="row-span">
                                            <div class="fieldlabel span30">{$core->get_Lang('Comfort')}</div>
                                            <div class="fieldarea span50 fl"><input
                                                        class="text full span90 fontLarge price-In" name="worthy"
                                                        value="{$clsISO->formatNumberToEasyRead($clsReviewsHotel->getValueByField($pvalTable,'worthy'))}"
                                                        maxlength="255" type="text"/> %
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {elseif $currentstep=='location'}
                            <h3 class="title_box">{$core->get_Lang('Location')}</h3>
                            <div class="inpt_tour">
                                <label for="title">{$core->get_Lang('Location')} <span class="required_red">*</span>
                                    {assign var= location_hotel value='location_hotel'}
                                    {assign var= help_first value=$location_hotel}
                                    {if $CHECKHELP eq 1}
                                        <button data-key="{$location_hotel}" data-label="{$core->get_Lang('Location')}"
                                                type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                                class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i>
                                        </button>
                                    {/if}
                                </label>
                                <div class="fieldarea" onClick="loadHelp(this)">
                                    <div class="text_help"
                                         hidden="">{$clsConfiguration->getValue($location_hotel)|html_entity_decode}</div>
                                    <div class="d-flex" style="gap:5px">
                                        {if $clsISO->getCheckActiveModulePackage($package_id,'continent','default','default') && $core->checkAccess('continent')}
                                            <select class="slb required"
                                                    style="font-size:14px;width:150px !important; height: 50px"
                                                    name="iso-continent_id" continent_id="{$continent_id}">
                                                {$clsContinent->makeSelectboxOption($oneItem.continent_id)}
                                            </select>
                                            <select class="slb required" name="iso-country_id" id="slb_Country"
                                                    style="font-size:14px;min-width:150px; height: 50px">
                                                <option value="0">-- {$core->get_Lang('selectcountry')} --</option>
                                            </select>
                                        {literal}
                                            <script type="text/javascript">
                                                $(function () {
                                                    loadCountry(continent_id, country_id);
                                                });
                                            </script>
                                        {/literal}
                                        {else}
                                            <select class="slb" name="iso-country_id" id="slb_Country"
                                                    style="font-size:14px;min-width:150px; height: 50px">
                                                {$clsCountry->makeSelectboxOption($oneItem.country_id)}
                                            </select>
                                        {/if}
                                        {if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
                                            <select class="slb" name="iso-region_id" id="slb_Region"
                                                    style="font-size:14px;min-width:150px; height: 50px">
                                                {$clsRegion->makeSelectboxOption($oneItem.country_id,$oneItem.region_id)}
                                            </select>
                                        {/if}
                                        <div id="slb_city_Id_Container" class="form-group">
                                            <select class="slb required iso-selectbox" name="iso-city_id"
                                                    id="slb_City" {$oneItem.country_id}
                                                    style="font-size:14px;min-width:120px">
                                                {$clsCity->makeSelectboxOption($oneItem.city_id,$oneItem.country_id)}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="inpt_tour">
                                <label for="title">{$core->get_Lang('Address')} <span class="required_red">*</span>
                                    {assign var= address_hotel value='address_hotel'}
                                    {if $CHECKHELP eq 1}
                                        <button data-key="{$address_hotel}" data-label="{$core->get_Lang('Address')}"
                                                type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                                class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i>
                                        </button>
                                    {/if}
                                </label>
                                <input class="text mr10 required" name="iso-address"
                                       value="{$clsClassTable->getAddress($pvalTable)}" maxlength="255" type="text"
                                       style="width:auto; min-width:100%; max-width:500px;" onClick="loadHelp(this)"/>
                                <div class="text_help"
                                     hidden="">{$clsConfiguration->getValue($address_hotel)|html_entity_decode}</div>
                            </div>
                        {elseif $currentstep=='image'}
                            {$core->getBlock('box_detail_image')}
                        {elseif $currentstep=='gallery'}
                            {$core->getBlock('box_detail_image-gallery')}
                        {elseif $currentstep=='seo'}
                            {$core->getBlock('box_detail_seotool')}
                        {elseif $currentstep=='overview'}
                            <h3 class="title_box mb05">{$core->get_Lang('Overview hotel')}
                                {assign var= overview_hotel value='overview_hotel'}
                                {assign var= help_first value=$overview_hotel}
                                {if $CHECKHELP eq 1}
                                    <button data-key="{$overview_hotel}"
                                            data-label="{$core->get_Lang('Overview hotel')}" type="button"
                                            title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                            class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                                {/if}
                            </h3>
                            <p class="intro_box mb40">{$core->get_Lang('introoverviewhotel')}</p>
                            <div class="inpt_tour">
                                <textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor"
                                          data-column="{$currentstep}" id="textarea_intro_editor_overview_{$now}"
                                          cols="255" rows="2">{$oneItem.overview}</textarea>
                            </div>
                        {elseif $currentstep=='checkin'}
                            <h3 class="title_box mb05">{$core->get_Lang('Check-in/ Check-out')}
                                {assign var= check_in_out_hotel value='check_in_out_hotel'}
                                {assign var= help_first value=$check_in_out_hotel}
                                {if $CHECKHELP eq 1}
                                    <button data-key="{$check_in_out_hotel}"
                                            data-label="{$core->get_Lang('Check-in/ Check-out')}" type="button"
                                            title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                            class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                                {/if}
                            </h3>
                            <p class="intro_box mb40">{$core->get_Lang('introcheckinhotel')}</p>
                            <div class="inpt_tour">
                                <label class="full-width">{$core->get_Lang('Time check in')}</label>
                                <div class="form-group pick_duration">
                                    <span class="minus" data-step="1">-</span>
                                    <input type="number"
                                           value="{$clsClassTable->getTimeCheckInOut($pvalTable,'hour_in')}" min="0"
                                           max="24" class="input_number find_select" name="hour_in">
                                    <span class="plus" data-step="1">+</span>
                                </div>
                                <label class="label_duration ">{$core->get_Lang('Hours')}</label>
                                <div class="form-group pick_duration pick_night">
                                    <span class="minus" data-step="5">-</span>
                                    <input type="number"
                                           value="{$clsClassTable->getTimeCheckInOut($pvalTable,'minute_in')}" min="0"
                                           max="60" class="input_number find_select" name="minute_in">
                                    <span class="plus" data-step="5">+</span>
                                </div>
                                <label class="label_duration">{$core->get_Lang('Minute')}</label>
                            </div>
                            <div class="inpt_tour">
                                <label class="full-width">{$core->get_Lang('Time check out')}</label>
                                <div class="form-group pick_duration">
                                    <span class="minus" data-step="1">-</span>
                                    <input type="number"
                                           value="{$clsClassTable->getTimeCheckInOut($pvalTable,'hour_out')}" min="0"
                                           max="24" class="input_number find_select" name="hour_out">
                                    <span class="plus" data-step="1">+</span>
                                </div>
                                <label class="label_duration ">{$core->get_Lang('Hours')}</label>
                                <div class="form-group pick_duration pick_night">
                                    <span class="minus" data-step="5">-</span>
                                    <input type="number"
                                           value="{$clsClassTable->getTimeCheckInOut($pvalTable,'minute_out')}" min="0"
                                           max="60" class="input_number find_select" name="minute_out">
                                    <span class="plus" data-step="5">+</span>
                                </div>
                                <label class="label_duration">{$core->get_Lang('Minute')}</label>
                            </div>
                        {literal}
                            <script>
                                $(document).ready(function () {
                                    $('.minus').click(function () {
                                        var $input = $(this).parent().find('input');
                                        var step = parseInt($(this).data('step'));
                                        var count = parseInt($input.val()) - step;
                                        count = count < 1 ? 0 : count;
                                        count = count < 10 ? '0' + count : count;
                                        $input.val(count);
                                        $input.change();
                                        return false;
                                    });
                                    $('.plus').click(function () {
                                        var $input = $(this).parent().find('input');
                                        var step = parseInt($(this).data('step'));
                                        var count = parseInt($input.val()) + step;
                                        count = count > 60 ? 60 : count;
                                        count = count < 10 ? '0' + count : count;
                                        $input.val(count);
                                        $input.change();
                                        return false;
                                    });
                                });
                            </script>
                            <style>
                                input[type=number]::-webkit-inner-spin-button,
                                input[type=number]::-webkit-outer-spin-button {
                                    -webkit-appearance: none;
                                }
                            </style>
                        {/literal}
                        {elseif $currentstep=='booking_policy'}
                            <h3 class="title_box mb05">{$core->get_Lang('Booking Policy')}
                                {assign var= booking_policy_hotel value='booking_policy_hotel'}
                                {assign var= help_first value=$booking_policy_hotel}
                                {if $CHECKHELP eq 1}
                                    <button data-key="{$booking_policy_hotel}"
                                            data-label="{$core->get_Lang('Booking Policy')}" type="button"
                                            title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                            class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                                {/if}
                            </h3>
                            <p class="intro_box mb40">{$core->get_Lang('introhotelbookingpolicy')}</p>
                            <div class="inpt_tour">
                                <textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor"
                                          data-column="{$currentstep}" id="textarea_intro_editor_booking_policy_{$now}"
                                          cols="255" rows="2">{$oneItem.booking_policy}</textarea>
                            </div>
                        {elseif $currentstep=='child_policy'}
                            <h3 class="title_box mb05">{$core->get_Lang('Children and bed policy')}
                                {assign var= child_policy_hotel value='child_policy_hotel'}
                                {assign var= help_first value=$child_policy_hotel}
                                {if $CHECKHELP eq 1}
                                    <button data-key="{$child_policy_hotel}"
                                            data-label="{$core->get_Lang('Children and bed policy')}" type="button"
                                            title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                            class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                                {/if}
                            </h3>
                            <p class="intro_box mb40">{$core->get_Lang('introchildpolicyhotel')}</p>
                            <div class="inpt_tour">
                                <textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor"
                                          data-column="{$currentstep}" id="textarea_intro_editor_child_policy_{$now}"
                                          cols="255" rows="2">{$oneItem.child_policy}</textarea>
                            </div>
                        {elseif $currentstep=='cancellation_policy'}
                            <h3 class="title_box mb05">{$core->get_Lang('Cancellation Policy')}
                                {assign var= cancellation_policy_hotel value='cancellation_policy_hotel'}
                                {assign var= help_first value=$cancellation_policy_hotel}
                                {if $CHECKHELP eq 1}
                                    <button data-key="{$cancellation_policy_hotel}"
                                            data-label="{$core->get_Lang('Cancellation Policy')}" type="button"
                                            title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                            class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                                {/if}
                            </h3>
                            <p class="intro_box mb40">{$core->get_Lang('introcancellationpolicyhotel')}</p>
                            <div class="inpt_tour">
                                <textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor"
                                          data-column="{$currentstep}"
                                          id="textarea_intro_editor_cancellation_policy_{$now}" cols="255"
                                          rows="2">{$oneItem.cancellation_policy}</textarea>
                            </div>
                        {elseif $currentstep=='other_policy'}
                            <h3 class="title_box mb05">{$core->get_Lang('Other Rule')}
                                {assign var= other_policy_hotel value='other_policy_hotel'}
                                {assign var= help_first value=$other_policy_hotel}
                                {if $CHECKHELP eq 1}
                                    <button data-key="{$other_policy_hotel}"
                                            data-label="{$core->get_Lang('Other Rule')}" type="button"
                                            title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                            class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                                {/if}
                            </h3>
                            <p class="intro_box mb40">{$core->get_Lang('introotherpolicyhotel')}</p>
                            <div class="inpt_tour">
                                <textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor"
                                          data-column="{$currentstep}" id="textarea_intro_editor_other_policy_{$now}"
                                          cols="255" rows="2">{$oneItem.other_policy}</textarea>
                            </div>
                        {elseif $currentstep=='room'}
                            <h3 class="title_box mb05">{$core->get_Lang('List Room')}
                                {assign var= list_room_hotel value='list_room_hotel'}
                                {assign var= help_first value=$list_room_hotel}
                                {if $CHECKHELP eq 1}
                                    <button data-key="{$list_room_hotel}" data-label="{$core->get_Lang('List Room')}"
                                            type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
                                            class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
                                {/if}
                            </h3>
                            <p class="intro_box mb40">{$core->get_Lang('introhotelroom')}</p>
                            <div class="inpt_tour">
                                {$core->getBlock('box_detail_hotel_room')}
                            </div>
                            <script type="text/javascript" src="{$URL_JS}/repeater.js?v={$upd_version}"></script>
                        {elseif $currentstep=='edit_room'}
                            <h3 class="title_box mb05">{$core->get_Lang('Add/Edit Room')}
                            </h3>
                            <p class="intro_box mb40">{$core->get_Lang('introhotelroom')}</p>
                            <div class="inpt_tour">
                                {$core->getBlock('box_detail_hotel_edit_room')}
                            </div>
                        {elseif $currentstep=='room_facilities'}
                            <h3 class="title_box mb05">{$core->get_Lang('Room facilities')}</h3>
                            <p class="intro_box mb40">{$core->get_Lang('introroomfacilities')}</p>
                            <div class="inpt_tour">
                                {$core->getBlock('box_detail_room_facilities')}
                            </div>
                        {elseif $currentstep=='hotel_facilities'}
                            <h3 class="title_box mb05">{$core->get_Lang('Hotel facilities')}</h3>
                            <p class="intro_box mb40">{$core->get_Lang('introhotelfacilities')}</p>
                            <div class="inpt_tour">
                                {$core->getBlock('box_detail_hotel_facilities')}
                            </div>
                        {elseif $arrStep[$step].panel == 'price_table' && $currentstep=='room-'|cat:$step_id}
                            {$clsISO->getBlock('box_detail_hotel_price_config')}
                        {/if}
                        <div class="btn_save_titile_table_code mt30">
                            <a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}"
                               data-currentstep="{$arrStep[$step].key}" data-prevstep="{$prevstep}"
                               class="back_step js_save_back">{$core->get_Lang('Back')}</a>

                            <a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}"
                               data-currentstep="{$currentstep}" data-next_step="{$nextstep}"
                               class="js_save_continue">{$core->get_Lang('Save &amp; Continue')}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col_instruction">
                <div class="instruction_fill_data_box">
                    <p class="title_box"><i class="fa fa-question-circle text-red "
                                            aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
                    <div class="content_box">{$clsConfiguration->getValue($help_first|default:'')|html_entity_decode}</div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var errorExistRoomName = "{$core->get_Lang('Room Name exist')}";
    var list_check_target = {$list_check_target};
</script>
{literal}
    <script>
        if ($('.textarea_intro_editor').length > 0) {
            $('.textarea_intro_editor').each(function () {
                var $_this = $(this);
                var $editorID = $_this.attr('id');
                $('#' + $editorID).isoTextAreaFull();
            });
        }
        $.each(list_check_target, function (i, val) {
            if (val.status == 1) {
                $('#step_' + val.key).closest('li').removeAttr('class').addClass("check_success");
            } else {
                $('#step_' + val.key).closest('li').removeAttr('class').addClass("check_caution");
            }
        });

    </script>
{/literal}
{literal}
<script>
(function () {
	'use strict';

	function makeHotelSlug(value) {
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

	function initHotelSlug() {
		var wrapper = document.getElementById(
			'hotel_general_information'
		);

		var titleInput = document.getElementById('title');
		var slugInput = document.getElementById('hotel_slug');
		var changeUrlInput = document.getElementById('change_url');

		if (
			!wrapper ||
			!titleInput ||
			!slugInput ||
			!changeUrlInput
		) {
			return;
		}

		/*
		 * Ngăn bind sự kiện nhiều lần khi step được tải AJAX.
		 */
		if (wrapper.getAttribute('data-slug-initialized') === '1') {
			return;
		}

		wrapper.setAttribute('data-slug-initialized', '1');

		var isNew =
			wrapper.getAttribute('data-is-new') === '1';

		var originalSlug =
			slugInput.getAttribute('data-original-slug') || '';

		/*
		 * HOTEL MỚI:
		 * nhập Title sẽ tự sinh URL.
		 */
		if (isNew) {
			titleInput.value = '';
			slugInput.value = '';

			titleInput.readOnly = false;
			slugInput.readOnly = false;

			slugInput.classList.remove('is-readonly');

			titleInput.addEventListener('input', function () {
				slugInput.value = makeHotelSlug(
					titleInput.value
				);
			});

			/*
			 * Cho phép người dùng chỉnh slug thủ công.
			 */
			slugInput.addEventListener('input', function () {
				slugInput.value = makeHotelSlug(
					slugInput.value
				);
			});

			return;
		}

		/*
		 * HOTEL EDIT:
		 * sửa Title không làm thay đổi URL.
		 */
		slugInput.readOnly = true;
		slugInput.classList.add('is-readonly');

		changeUrlInput.addEventListener('change', function () {
			if (changeUrlInput.checked) {
				slugInput.readOnly = false;
				slugInput.classList.remove('is-readonly');
				slugInput.focus();
				return;
			}

			slugInput.value = originalSlug;
			slugInput.readOnly = true;
			slugInput.classList.add('is-readonly');
		});



        
	}

	/*
	 * Step Hotel được tải AJAX nên không chỉ dựa vào
	 * DOMContentLoaded.
	 */
	if (document.readyState === 'loading') {
		document.addEventListener(
			'DOMContentLoaded',
			initHotelSlug
		);
	} else {
		initHotelSlug();
	}

	/*
	 * Cho phép JS tải step gọi lại:
	 * window.initHotelSlug();
	 */
	window.initHotelSlug = initHotelSlug;
})();
</script>

<style>
.hotel_url_group {
	margin-top: 28px;
}

.hotel_url_note {
	max-width: 720px;
	margin: 0 0 14px;
	font-size: 13px;
	line-height: 21px;
	color: #344054;
}

.hotel_change_url_label {
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

.hotel_change_url_label input {
	width: 15px;
	height: 15px;
	margin: 0;
	cursor: pointer;
}

.hotel_slug_input,
#title {
	width: 100%;
	background: #fff;
	color: #101828;
}

.hotel_slug_input.is-readonly,
.hotel_slug_input[readonly] {
	background: #f2f4f7;
	color: #667085;
	cursor: not-allowed;
	opacity: 1;
}
</style>
{/literal}