{*<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>*}
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Blog')}</a>
	<a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New')}{/if}</h2>
        {if $pvalTable}
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <strong><a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</a></strong>
			</div>
		</div>
        {/if}
	</div>
    <div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
				{if $pvalTable} 
				{assign var=blog_destination_check value=$clsISO->getCheckActiveModulePackage($package_id,$mod,'blog_destination','customize')}
				{if $blog_destination_check}
				<li><a href="javascript:void();"><i class="fa fa-map-marker"></i> {$core->get_Lang('destinations')}</a></li>
				{/if}
				{assign var=blog_tour_related_check value=$clsISO->getCheckActiveModulePackage($package_id,$mod,'blog_tour_related','customize')}
				{if $blog_tour_related_check}
				<li><a href="javascript:void();"><i class="fa fa-globe"></i> {$core->get_Lang('TourRelated')}</a></li>
				{/if}
				{assign var=blog_hotel_related_check value=$clsISO->getCheckActiveModulePackage($package_id,$mod,'blog_hotel_related','customize')}
				{if $blog_hotel_related_check}
				<li><a href="javascript:void();"><i class="fa fa-globe"></i> {$core->get_Lang('HotelRelated')}</a></li>
				{/if}
				{assign var=blog_cruise_related_check value=$clsISO->getCheckActiveModulePackage($package_id,$mod,'blog_cruise_related','customize')}
				{if $blog_cruise_related_check}
				<li><a href="javascript:void();"><i class="fa fa-ship"></i> {$core->get_Lang('CruiseRelated')}</a></li>
				{/if}
				<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li> 
				{/if}   
			</ul>
		</div>
        <div class="clearfix"></div>
        <div id="tab_content">
            <div class="tabbox" style="display:block">
                <div class="wrap">
                    <div class="fl col_Left">
                        <div class="photobox image">
                            {if $_isoman_use eq '1'}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
							<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
							{if $oneItem.image}
							<a pvalTable="{$pvalTable}" clsTable="Country" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a>
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
					</div>
                    <div class="fl col_Right">
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('title')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
                                <input class="text_32 full-width border_aaa bold title_capitalize required" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
							</div>
						</div>
						{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
                        <div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('category')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
                                <select class="span12 required slb" name="iso-cat_id" style="width: 200px;">
                                    {$clsBlogCategory->makeSelectboxOption($blogcat_id)}
								</select>
							</div>
						</div>
                        {/if}
						{if $clsISO->getCheckActiveModulePackage($package_id,'$mod','tag','customize')}
						<div class="row-span">
							<div class="fieldlabel bold">{$core->get_Lang('Tags')}</div>
							<div class="fieldarea">
								<input type="text" name="list_tag_id" id="tags-input" value="{$clsTag->getTagsListText($classTable,$pvalTable)}" data-role="tagsinput" placeholder="{$core->get_Lang('Add new tag')}" />
							</div>
						</div>
						{literal}
						<script type="text/javascript">
							$('#tags-input').tagsinput({
								allowDuplicates: true,
								confirmKeys: [13, 188]
							});
							$('.bootstrap-tagsinput input[type=text]').keypress(function(e){
								var keyCode = e.which || e.keyCode;
								if (keyCode == '13') {
								  e.preventDefault();
								}
							});
						</script>
						<style>
							.bootstrap-tagsinput{width: 100%}
							.bootstrap-tagsinput span{font-size: 14px}
						</style>
						{/literal}
						{/if}
                        {if $clsConfiguration->getValue('SiteHasAuthor_Blogs')}
                        <div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Author')}</strong></div>
                            <div class="fieldarea">
                                <input class="text full required fontLarge" name="iso-author" value="{$clsClassTable->getAuthor($pvalTable)}" maxlength="255" type="text">
							</div>
						</div>
						{/if}
						{if $clsConfiguration->getValue('SiteHasPublishDate_Blogs')}
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Publish date')}</strong></div>
                            <div class="fieldarea">
                                <input value="{$clsISO->formatTimeMonth($oneItem.publish_date)}" class="ext full required showdate" name="publish_date" type="text" autocomplete="off" style="width:220px" />
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
					</div>
					
					<div class="clearfix mb20"></div>
					<div class="wrap">
						<div id="v-nav">
							<ul>
								<li class="tabchildcol first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('Short text')}</strong></a> <span class="color_r">*</span></li>
								<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Long text')}</strong></a> <span class="color_r">*</span></li>
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
						</div>
					</div>
				</div>
			</div>
			{if $pvalTable}
			{if $blog_destination_check}
            <div class="tabbox" style="display:none;">
				<div class="row-span">{$core->get_Lang('infodestinationadmin')}</div>
				<div class="clear"><br /></div>
				<div class="row-span">
					{if $clsISO->getCheckActiveModulePackage($package_id,'continent','default','default') and $core->checkAccess('continent')}
					<select class="slb form-control-new span20 mr5 fl" name="chauluc_id" id="slb_Chauluc" style="width:160px !important;">
						{$clsContinent->makeSelectboxOption()}
					</select>
					{/if}
                    <select class="slb form-control-new mr5 fl" name="country_id" id="slb_Country" style="width:160px !important;">
                        <option value="0">-- {$core->get_Lang('selectcountry')} --</option>
					</select>
                    {if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
                    <select class="slb form-control-new mr5 fl" id="slb_RegionID" name="region_id" style="width:160px !important;">
                        <option value="0">-- {$core->get_Lang('selectregion')} --</option>
					</select>
                    {/if}
                    {if $clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}
                    <select class="slb form-control-new mr10 fl" id="slb_CityID" name="city_id" style="width:160px !important;">
                        <option value="0">-- {$core->get_Lang('selectcity')} --</option>
					</select>
                    {/if}
                    <button class="fl btn-add ajQuickAddDestination" type="button">{$core->get_Lang('adddestination')}</button>
				</div>
				<div class="clear"><br /></div>
				<div class="row-span">
					<div style="padding-left:10px">
						<ul class="list-group" id="lstDestination"></ul>
						<div class="clearfix mt10"></div>
						<span class="notice" style="padding:0;color:#0565c9">(<span class="requiredMask">*</span> ) {$core->get_Lang('infoless1destination')}</span>
					</div>
				</div>
				<div class="clearfix"><br /><br /></div>
				<div class="row-bottom">
					<div class="row-buttons">
						<input type="hidden" name="submit" value="Update" />
					</div>
				</div>
			</div>
			{/if}
			{if $blog_tour_related_check}
			<div class="tabbox" style="display:none">
				<div class="clearfix"></div>
				<div class="tab_contentglobal">
					<div class="tabboxglobal tabboxchild_globaltabs_media">
						<div class="acc_head">
							<div class="acc_icon_expand"></div>
							<h2 style="font-size:20px; margin-bottom:10px">{$core->get_Lang('TourRelated')}</h2>
						</div>
						<div class="acc_content">
							<div class="row-span-help">{$core->get_Lang('infoTourRelated')}</div>
							<div class="infobox">{$core->get_Lang('noteTourRelated')}</div>
							<div class="filterbox mt40">
								<div class="wrap">
									<div class="searchbox">
										<input id="searchkeyTour" placeholder="{$core->get_Lang('searchTour')}" type="text" class="text" style="width:240px" />
										<a class="btn btn-success" href="javascript:void();">
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
									<tr>
										<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
										<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameoftrips')}</strong></td>
										<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('duration')}</strong></td>
										{if $clsConfiguration->getValue('SiteHasCat_Tours')}
										<td class="gridheader" style="text-align:left; width:12%"><strong>{$core->get_Lang('travelstyles')}</strong></td>
										{/if}
										<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('pricefrom')}</strong></td>
										<td class="gridheader" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></td>
										<td class="gridheader" style="width:2%"><strong>{$core->get_Lang('delete')}</strong></td>
									</tr>
									<tbody id="tblTourExtension"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			{/if}
			{if $blog_hotel_related_check}
			<div class="tabbox" style="display:none">
				<div class="clearfix"></div>
				<div class="tab_contentglobal">
					<div class="tabboxglobal tabboxchild_globaltabs_media">
						<div class="acc_head">
							<div class="acc_icon_expand"></div>
							<h2 style="font-size:20px; margin-bottom:10px">{$core->get_Lang('HotelRelated')}</h2>
						</div>
						<div class="acc_content">
							<div class="row-span-help">{$core->get_Lang('infoHotelRelated')}</div>
							<div class="infobox">{$core->get_Lang('noteHotelRelated')}</div>
							<div class="filterbox mt40">
								<div class="wrap">
									<div class="searchbox">
										<input id="searchkeyHotel" placeholder="{$core->get_Lang('searchHotel')}" type="text" class="text" style="width:240px" />
										<a class="btn btn-success" href="javascript:void();">
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
									<tr>
										<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
										<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameofhotel')}</strong></td>
										<td class="gridheader" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></td>
										<td class="gridheader" style="width:2%"><strong>{$core->get_Lang('delete')}</strong></td>
									</tr>
									<tbody id="tblHotelExtension"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			{/if}
			{if $blog_cruise_related_check}
			<div class="tabbox" style="display:none">
				<div class="clearfix"></div>
				<div class="tab_contentglobal">
					<div class="tabboxglobal tabboxchild_globaltabs_media">
						<div class="acc_head">
							<div class="acc_icon_expand"></div>
							<h2 style="font-size:20px; margin-bottom:10px">{$core->get_Lang('CruiseRelated')}</h2>
						</div>
						<div class="acc_content">
							<div class="row-span-help">{$core->get_Lang('infoCruiseRelated')}</div>
							<div class="infobox">{$core->get_Lang('noteCruiseRelated')}</div>
							<div class="filterbox mt40">
								<div class="wrap">
									<div class="searchbox">
										<input id="searchkeyCruise" placeholder="{$core->get_Lang('searchCruise')}" type="text" class="text" style="width:240px" />
										<a class="btn btn-success" href="javascript:void();">
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
									<tr>
										<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
										<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameofcruises')}</strong></td>
										{if $clsConfiguration->getValue('SiteHasCruisesCategory')}
										<td class="gridheader" style="text-align:left; width:12%"><strong>{$core->get_Lang('cruisescategory')}</strong></td>
										{/if}
										<td class="gridheader" colspan="4" style="width:4%"><strong>{$core->get_Lang('move')}</strong></td>
										<td class="gridheader" style="width:2%"><strong>{$core->get_Lang('delete')}</strong></td>
									</tr>
									<tbody id="tblCruiseExtension"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			{/if}
			<div class="tabbox" style="display:none">
				 {$core->getBlock('meta_box_detail')}
			</div>
			{/if}
		</div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden" />
		</fieldset>
	</form>
</div>
{literal}
<script>
$(".showdate").datepicker({dateFormat: "dd/mm/yy"});
</script>
{/literal}
<script type="text/javascript">
	var blog_id = '{$pvalTable}';
	var $blog_id = '{$pvalTable}';
	var $type = 'BLOG';
	var $SiteHasDestinationBlog=1;
	var $SiteHasTags_Blogs = "{$clsConfiguration->getValue('SiteHasTags_Blogs')}";
	var $SiteModActive_country = "{$clsConfiguration->getValue('SiteModActive_country')}";
	var $SiteModActive_continent = "{$clsConfiguration->getValue('SiteModActive_continent')}";
	var $SiteActive_region = "{$clsConfiguration->getValue('SiteActive_region')}";
	var $SiteActive_city = "{$clsConfiguration->getValue('SiteActive_city')}";
	var $Selectavalue= "{$core->get_Lang('Selectavalue')}";
	var $Selectafewvalues= "{$core->get_Lang('Selectafewvalues')}";
	var $Nomatchingresults= "{$core->get_Lang('Nomatchingresults')}";
	var $SiteHasTourExtension = "{$clsConfiguration->getValue('SiteHasTourExtension')}";
	var $SiteHasCruiseExtension = "{$clsConfiguration->getValue('SiteHasCruiseExtension')}";
	var $SiteHasHotelExtension = "{$clsConfiguration->getValue('SiteHasHotelExtension')}";
</script>
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/blog/jquery.blog.js?v={$upd_version}"></script>