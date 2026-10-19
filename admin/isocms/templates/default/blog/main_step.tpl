<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='image'}
						{assign var= image_detail value='image_blog'}
						{$core->getBlock('box_detail_image')}
						{elseif $currentstep=='generalinformation'}
						{assign var=blog_title value=$clsClassTable->getTitle($pvalTable)|default:''}
{assign var=blog_slug value=$oneItem.slug|default:''}

{assign var=default_blog_slug value="new-blog-`$pvalTable`"}
{assign var=default_blog_title value="New Blog `{$pvalTable}`"}

{assign var=is_new_blog value=false}

{if $blog_slug eq ''
	|| $blog_slug eq $default_blog_slug
	|| $blog_title eq ''
	|| $blog_title eq $default_blog_title
}
	{assign var=is_new_blog value=true}
{/if}
						<h3 class="title_box">{$core->get_Lang('generalinformation')}</h3>
<div
	id="blog_general_information"
	data-is-new="{if $is_new_blog}1{else}0{/if}"
>
	<div class="inpt_tour">
		<label for="blog_title">
			{$core->get_Lang('title')}
			<span class="required_red">*</span>

			{assign var=title_blog value='title_blog'}
			{assign var=help_first value=$title_blog}

			{if $CHECKHELP eq 1}
				<button
					data-key="{$title_blog}"
					data-label="{$core->get_Lang('title')|escape:'html'}"
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
			id="blog_title"
			value="{if $is_new_blog}{else}{$blog_title|escape:'html'}{/if}"
			maxlength="255"
			type="text"
			placeholder="{$core->get_Lang('New title')|escape:'html'}"
			autocomplete="off"
			onclick="loadHelp(this)"
		>

		<div class="text_help" hidden>
			{$clsConfiguration->getValue($title_blog)|html_entity_decode}
		</div>
	</div>

	<div class="inpt_tour blog_url_group">
		<label for="blog_slug">
			{$core->get_Lang('URL')}
		</label>

		<p class="blog_url_note">
			{$core->get_Lang(
				'You should NOT change your URL frequently unless absolutely necessary. Changing your URL can have a negative impact on your SEO.'
			)}
		</p>

		{if !$is_new_blog}
			<label
				class="blog_change_url_label"
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
			class="input_text_form blog_slug_input"
			type="text"
			id="blog_slug"
			name="slug"
			value="{if $is_new_blog}{else}{$blog_slug|escape:'html'}{/if}"
			data-original-slug="{$blog_slug|escape:'html'}"
			placeholder="{$core->get_Lang('URL slug')|escape:'html'}"
			autocomplete="off"
			spellcheck="false"
			{if !$is_new_blog}readonly{/if}
		>

		<input
			type="hidden"
			id="original_slug"
			name="original_slug"
			value="{$blog_slug|escape:'html'}"
		>
	</div>
</div>
						{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('category')} <span class="required_red">*</span>
								{assign var= category_blog value='category_blog'}
								{if $CHECKHELP eq 1}
								<button data-key="{$category_blog}" data-label="{$core->get_Lang('category')}"
									type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
									class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</label>
							<div class="fieldarea">
								<select class="glSlBox border_aaa required" name="iso-cat_id" style="width:250px"
									onClick="loadHelp(this)">
									{$clsBlogCategory->makeSelectboxOption($oneItem.cat_id)}
								</select>
								<div class="text_help" hidden="">
									{$clsConfiguration->getValue($category_blog)|html_entity_decode}</div>
							</div>
						</div>
						{/if}
						{if $clsISO->getCheckActiveModulePackage($package_id,'$mod','country','customize')}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Country')}
								{assign var= country_blog value='country_blog'}
								{if $CHECKHELP eq 1}
								<button data-key="{$country_blog}" data-label="{$core->get_Lang('Country')}"
									type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
									class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</label>
							{assign var=lst_country value=$clsISO->getArrayByTextSlash($oneItem.list_country_id)}
							<select name="list_country[]" id="list_country" class="full-width chosen-select"
								multiple="multiple" onClick="loadHelp(this)">
								{foreach from=$lstCountry key=key item=item}
								<option {if $clsISO->checkItemInArray($item.country_id, $lst_country)} selected {/if}
									value="{$item.country_id}">{$item.title}</option>
								{/foreach}
							</select>
							<div class="text_help" hidden="">
								{$clsConfiguration->getValue($country_blog)|html_entity_decode}
							</div>
						</div>
						{/if}
						{if $clsISO->getCheckActiveModulePackage($package_id,'$mod','tag','customize')}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Tags')}
								{assign var= tag_blog value='tag_blog'}
								{if $CHECKHELP eq 1}
								<button data-key="{$tag_blog}" data-label="{$core->get_Lang('Tags')}" type="button"
									title="Thêm mô tả" onclick="open_texthelp(this, event)"
									class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</label>
							<input type="text" name="list_tag_id" id="tags-input"
								value="{$clsTag->getTagsListText($classTable,$pvalTable)}" data-role="tagsinput"
								placeholder="{$core->get_Lang('Add new tag')}" onClick="loadHelp(this)" />
							<div class="text_help" hidden="">{$clsConfiguration->getValue($tag_blog)|html_entity_decode}
							</div>

							{literal}
							<script type="text/javascript">
								$('#tags-input').tagsinput({
									allowDuplicates: true,
									confirmKeys: [13, 188]
								});
								$('.bootstrap-tagsinput').click(function (e) {
									loadHelp(this);
								});
								$('.bootstrap-tagsinput input[type=text]').keypress(function (e) {
									var keyCode = e.which || e.keyCode;
									if (keyCode == '13') {
										e.preventDefault();
									}
								});
							</script>
							{/literal}
						</div>
						{/if}
						{if $clsConfiguration->getValue('SiteHasAuthor_Blogs')}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Author')}
								{assign var= author_blog value='author_blog'}
								{if $CHECKHELP eq 1}
								<button data-key="{$author_blog}" data-label="{$core->get_Lang('Author')}" type="button"
									title="Thêm mô tả" onclick="open_texthelp(this, event)"
									class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</label>
							<input class="text_32 full-width border_aaa" name="iso-author"
								value="{$clsClassTable->getAuthor($pvalTable)}" type="text"
								placeholder="{$core->get_Lang('Author')}" onClick="loadHelp(this)">
							<div class="text_help" hidden="">
								{$clsConfiguration->getValue($author_blog)|html_entity_decode}</div>
						</div>
						{/if}
						{if $clsConfiguration->getValue('SiteHasPublishDate_Blogs')}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Publish date')}
								{assign var= publish_date_blog value='publish_date_blog'}
								{if $CHECKHELP eq 1}
								<button data-key="{$publish_date_blog}" data-label="{$core->get_Lang('Publish date')}"
									type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
									class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</label></br>
							<input value="{$clsISO->formatTimeMonth($oneItem.publish_date)}" class="ext full showdate "
								name="publish_date" type="text" autocomplete="off" style="width:220px"
								onClick="loadHelp(this),showDatepicker(this)" />
							<div class="text_help" hidden="">
								{$clsConfiguration->getValue($publish_date_blog)|html_entity_decode}</div>
							{literal}
							<script>
								$(".showdate").datepicker({ dateFormat: "dd/mm/yy" });
							</script>
							{/literal}
						</div>
						{/if}

						{elseif $currentstep=='shortText'}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Short text')}
								{assign var= short_text_blog value='short_text_blog'}
								{assign var= help_first value=$short_text_blog}
								{if $CHECKHELP eq 1}
								<button data-key="{$short_text_blog}" data-label="{$core->get_Lang('Short text')}"
									type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
									class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</label></br>
							<textarea style="width:100%" table_id="{$pvalTable}" name="iso-intro"
								class="textarea_intro_editor" data-column="iso-intro"
								id="textarea_intro_editor_overview_{$now}" cols="255"
								rows="2">{$oneItem.intro}</textarea>
							<div class="text_help" hidden="">
								{$clsConfiguration->getValue($short_text_blog)|html_entity_decode}</div>
							{literal}
							<script>
								$(".showdate").datepicker({ dateFormat: "dd/mm/yy" });
							</script>
							{/literal}
						</div>
						{elseif $currentstep=='longText'}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Long text')}
								{assign var= long_text_blog value='long_text_blog'}
								{assign var= help_first value=$long_text_blog}
								{if $CHECKHELP eq 1}
								<button data-key="{$long_text_blog}" data-label="{$core->get_Lang('Long text')}"
									type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
									class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</label></br>
							<textarea style="width:100%" table_id="{$pvalTable}" name="iso-content"
								class="textarea_intro_editor" data-column="iso-content"
								id="textarea_intro_editor_overview_{$now}" cols="255"
								rows="2">{$oneItem.content}</textarea>
							<div class="text_help" hidden="">
								{$clsConfiguration->getValue($long_text_blog)|html_entity_decode}</div>
							{literal}
							<script>
								$(".showdate").datepicker({ dateFormat: "dd/mm/yy" });
							</script>
							{/literal}
						</div>
						{elseif $currentstep=='destination'}
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('infodestinationadmin')}
								{assign var= destination_blog value='destination_blog'}
								{assign var= help_first value=$destination_blog}
								{if $CHECKHELP eq 1}
								<button data-key="{$destination_blog}"
									data-label="{$core->get_Lang('infodestinationadmin')}" type="button"
									title="Thêm mô tả" onclick="open_texthelp(this, event)"
									class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
							</label></br>
							<div class="fieldarea">
								{if $clsISO->getCheckActiveModulePackage($package_id,'continent','default','default')
								and $core->checkAccess('continent')}
								<select class="slb form-control-new mr5" name="chauluc_id" style="width:160px"
									id="slb_Chauluc" onClick="loadHelp(this)">
									{$clsContinent->makeSelectboxOption()}
								</select>
								{/if}
								<select class="slb form-control-new mr5" name="country_id" id="slb_Country"
									style="width:160px !important;">
									<option value="0">-- {$core->get_Lang('selectcountry')} --</option>
								</select>
								{if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
								<select class="slb form-control-new mr5" id="slb_RegionID" name="region_id"
									style="width:160px !important;">
									<option value="0">-- {$core->get_Lang('selectregion')} --</option>
								</select>
								{/if}
								{if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
								<select class="slb form-control-new mr10" id="slb_CityID" name="city_id"
									style="width:160px !important;">
									<option value="0">-- {$core->get_Lang('selectcity')} --</option>
								</select>
								{/if}
								<button class="btn-add ajQuickAddDestination"
									type="button">{$core->get_Lang('adddestination')}</button>
								{literal}
								<script>loadCountry();</script>
								{/literal}
							</div>
							<div class="clear"><br></div>
							<div class="row-span">
								<div style="padding-left:10px">
									<ul class="list-group" id="lstDestination"></ul>
									<div class="clearfix mt10"></div>
									<span class="notice" style="padding:0;color:#0565c9">(<span
											class="requiredMask">*</span> )
										{$core->get_Lang('infoless1destination')}</span>
								</div>
							</div>
							<script>
								loadListDestination({$oneItem.blog_id});
							</script>
						</div>
						{elseif $currentstep=='tourRelated'}
						<h3 class="title_box mb0">{$core->get_Lang('TourRelated')}
							{assign var= tour_related_blog value='tour_related_blog'}
							{assign var= help_first value=$tour_related_blog}
							{if $CHECKHELP eq 1}
							<button data-key="{$tour_related_blog}" data-label="{$core->get_Lang('TourRelated')}"
								type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
								class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
						</h3>
						<div class="filterbox mt40">
							<div class="wrap">
								<div class="searchbox">
									<input id="searchkeyTour" placeholder="{$core->get_Lang('searchTour')}" type="text"
										class="text" style="width:240px" onKeyPress="searchRelateTour(this,'Tour')"
										onChange="searchRelateTour(this,'Tour')" />
									<a class="btn btn-success btn-main" href="javascript:void();">
										<i class="icon-search icon-white"></i> <span></span>
									</a>
									<div class="autosugget" id="autosuggetTour">
										<ul class="HTML_suggetTour"></ul>
										<div class="clearfix"></div>
										<a class="close_Div">{$core->get_Lang('close')}</a>
									</div>
								</div>
							</div>
						</div>
						<div class="hastable" style="margin-bottom:10px">
							<table class="tbl-grid" cellspacing="0">
								<thead>
									<tr>
										<th class="gridheader"><strong>{$core->get_Lang('index')}</strong></th>
										<th class="gridheader" style="text-align:left">
											<strong>{$core->get_Lang('nameoftrips')}</strong>
										</th>
										<th class="gridheader" style="text-align:left">
											<strong>{$core->get_Lang('duration')}</strong>
										</th>
										{if $clsConfiguration->getValue('SiteHasCat_Tours')}
										<th class="gridheader" style="text-align:left; width:12%">
											<strong>{$core->get_Lang('travelstyles')}</strong>
										</th>
										{/if}
										<th class="gridheader" style="text-align:left">
											<strong>{$core->get_Lang('pricefrom')}</strong>
										</th>
										<th class="gridheader" colspan="4" style="width:4%">
											<strong>{$core->get_Lang('move')}</strong>
										</th>
										<th class="gridheader" style="width:2%">
											<strong>{$core->get_Lang('delete')}</strong>
										</th>
									</tr>
								</thead>
								<tbody id="tblTourExtension"></tbody>
							</table>
						</div>
						{elseif $currentstep=='hotelRelated'}
						<h3 class="title_box mb0">{$core->get_Lang('HotelRelated')}
							{assign var= hotel_related_blog value='hotel_related_blog'}
							{assign var= help_first value=$hotel_related_blog}
							{if $CHECKHELP eq 1}
							<button data-key="{$hotel_related_blog}" data-label="{$core->get_Lang('HotelRelated')}"
								type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
								class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
						</h3>
						<div class="filterbox mt40">
							<div class="wrap">
								<div class="searchbox">
									<input id="searchkeyHotel" placeholder="{$core->get_Lang('searchHotel')}"
										type="text" class="text" style="width:240px"
										onKeyPress="searchRelateTour(this,'Hotel')"
										onChange="searchRelateTour(this,'Hotel')" />
									<a class="btn btn-success btn-main" href="javascript:void();">
										<i class="icon-search icon-white"></i> <span></span>
									</a>
									<div class="autosugget" id="autosuggetHotel">
										<ul class="HTML_suggetHotel"></ul>
										<div class="clearfix"></div>
										<a class="close_Div">{$core->get_Lang('close')}</a>
									</div>
								</div>
							</div>
						</div>
						<div class="hastable" style="margin-bottom:10px">
							<table class="tbl-grid" cellspacing="0">
								<thead>
									<tr>
										<th class="gridheader"><strong>{$core->get_Lang('index')}</strong></th>
										<th class="gridheader" style="text-align:left">
											<strong>{$core->get_Lang('nameofhotel')}</strong>
										</th>
										<th class="gridheader" colspan="4" style="width:4%">
											<strong>{$core->get_Lang('move')}</strong>
										</th>
										<th class="gridheader" style="width:2%">
											<strong>{$core->get_Lang('delete')}</strong>
										</th>
									</tr>
								</thead>

								<tbody id="tblHotelExtension"></tbody>
								<script>
									loadHotelExtension({$oneItem.blog_id});
								</script>
							</table>
						</div>
						{elseif $currentstep=='cruiseRelated'}
						<h3 class="title_box mb0">{$core->get_Lang('CruiseRelated')}
							{assign var= cruise_related_blog value='cruise_related_blog'}
							{assign var= help_first value=$cruise_related_blog}
							{if $CHECKHELP eq 1}
							<button data-key="{$cruise_related_blog}" data-label="{$core->get_Lang('CruiseRelated')}"
								type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)"
								class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
							{/if}
						</h3>
						<div class="filterbox mt40">
							<div class="wrap">
								<div class="searchbox">
									<input id="searchkeyCruise" placeholder="{$core->get_Lang('searchCruise')}"
										type="text" class="text" style="width:240px"
										onKeyPress="searchRelateTour(this,'Cruise')"
										onChange="searchRelateTour(this,'Cruise')" />
									<a class="btn btn-success btn-main" href="javascript:void();">
										<i class="icon-search icon-white"></i> <span></span>
									</a>
									<div class="autosugget" id="autosuggetCruise">
										<ul class="HTML_suggetCruise"></ul>
										<div class="clearfix"></div>
										<a class="close_Div">{$core->get_Lang('close')}</a>
									</div>
								</div>
							</div>
						</div>
						<div class="hastable" style="margin-bottom:10px">
							<table class="tbl-grid" cellspacing="0">
								<thead>
									<tr>
										<th class="gridheader"><strong>{$core->get_Lang('index')}</strong></th>
										<th class="gridheader" style="text-align:left">
											<strong>{$core->get_Lang('nameofcruises')}</strong>
										</th>
										{if $clsConfiguration->getValue('SiteHasCruisesCategory')}
										<th class="gridheader" style="text-align:left; width:12%">
											<strong>{$core->get_Lang('cruisescategory')}</strong>
										</th>
										{/if}
										<th class="gridheader" colspan="4" style="width:4%">
											<strong>{$core->get_Lang('move')}</strong>
										</th>
										<th class="gridheader" style="width:2%">
											<strong>{$core->get_Lang('delete')}</strong>
										</th>
									</tr>
								</thead>
								<tbody id="tblCruiseExtension"></tbody>
							</table>
						</div>
						{elseif $currentstep=='seo'}
						{$core->getBlock('box_detail_blog_seotool')}
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
			<div class="col-xs-12 col-sm-12 col-md-3 col_instruction">
				<div class="instruction_fill_data_box">
					<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i>
						{$core->get_Lang('Instructions')}</p>
					<div class="content_box">{$clsConfiguration->getValue($help_first|default:'')|html_entity_decode}</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
	var blog_id = $blog_id = '{$oneItem.blog_id}';
	var list_check_target = {$list_check_target};
</script>
{literal}
<style>
	.bootstrap-tagsinput {
		width: 100%;
		padding: 0 6px;
		border: 1px solid #aaa !important
	}
.blog_url_group {
	margin-top: 28px;
}

.blog_url_note {
	max-width: 720px;
	margin: 0 0 14px;
	color: #344054;
	font-size: 13px;
	line-height: 21px;
}

.blog_change_url_label {
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

.blog_change_url_label input {
	width: 15px;
	height: 15px;
	margin: 0;
	cursor: pointer;
}

#blog_title,
.blog_slug_input {
	width: 100%;
	background: #fff;
	color: #101828;
}

.blog_slug_input.is-readonly,
.blog_slug_input[readonly] {
	background: #f2f4f7;
	color: #667085;
	cursor: not-allowed;
	opacity: 1;
}
	.bootstrap-tagsinput span {
		font-size: 14px
	}

	.fill_data_box .bootstrap-tagsinput input {
		border: 0
	}
</style>
<script>

(function () {
	'use strict';

	function makeBlogSlugFromTitle(value) {
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

	function sanitizeBlogSlugTyping(value) {
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

	function normalizeBlogSlugOnBlur(value) {
		value = sanitizeBlogSlugTyping(value)
			.replace(/^-+/, '')
			.replace(/-+$/, '')
			.replace(/^\.+/, '');

		/*
		 * Chỉ giữ tối đa một phần mở rộng .html.
		 */
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

	function initBlogSlug() {
		var wrapper = document.getElementById(
			'blog_general_information'
		);

		var titleInput = document.getElementById(
			'blog_title'
		);

		var slugInput = document.getElementById(
			'blog_slug'
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

		/*
		 * BLOG MỚI:
		 * Title và URL trắng.
		 * Nhập Title sẽ sinh slug.
		 */
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
						makeBlogSlugFromTitle(
							titleInput.value
						);
				}
			);
		} else {
			/*
			 * BLOG EDIT:
			 * sửa Title không đổi URL.
			 */
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

		/*
		 * Cho phép gõ dấu - và .html.
		 * Không xóa dấu - cuối ngay khi đang nhập.
		 */
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
					sanitizeBlogSlugTyping(
						slugInput.value
					);
			}
		);

		/*
		 * Chỉ chuẩn hóa khi rời input.
		 */
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
					normalizeBlogSlugOnBlur(
						slugInput.value
					);
			}
		);
	}

	if (document.readyState === 'loading') {
		document.addEventListener(
			'DOMContentLoaded',
			initBlogSlug
		);
	} else {
		initBlogSlug();
	}

	window.initBlogSlug = initBlogSlug;
})();
	loadTourExtension(blog_id);
	loadCruiseExtension(blog_id);
	if ($('.textarea_intro_editor').length > 0) {
		$('.textarea_intro_editor').each(function () {
			var $_this = $(this);
			var $editorID = $_this.attr('id');
			$('#' + $editorID).isoTextArea();
		});
	}
	$('.toggle-row').click(function () {
		$(this).closest('tr').toggleClass('open_tr');
	});
	$.each(list_check_target, function (i, val) {
		if (val.status == 1) {
			$('#step_' + val.key).closest('li').removeAttr('class').addClass("check_success");
		} else {
			$('#step_' + val.key).closest('li').removeAttr('class').addClass("check_caution");
		}
	});
</script>
{/literal}