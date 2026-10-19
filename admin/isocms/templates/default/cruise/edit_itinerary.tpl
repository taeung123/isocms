<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('cruise')}</a>
	<a>&raquo;</a>
    <a href="{$PCMS_URL}/cruise/insert/{$cruise_id}/itinerary/itinerary">{$core->get_Lang('cruiseitinerary')}</a>
    <a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{if $pvalTable}{$core->get_Lang('Edit Itinerary')}{else} {$core->get_Lang('Add Itinerary')}{/if}</h2>
    	<p>{$core->get_Lang('systemmanagementcruiseitinerary')}</p>
    </div>
	<a href="{$PCMS_URL}/cruise/insert/{$cruise_id}/itinerary/itinerary" title="{$core->get_Lang('Back to itinerary list')}" class="back fr">{$core->get_Lang('Back to itinerary list')}</a>
	<div class="clearfix mt10 mb20"></div>
	<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
		<input class="text full fontLarge" name="iso-title_search" value="{$clsClassTable->getTitleSearch($pvalTable)}" maxlength="255" type="hidden" />
		<input class="text full fontLarge" name="iso-star_number" value="{$clsCruise->getOneField('star_number',$cruise_id)}" maxlength="255" type="hidden" />
		<input class="text full fontLarge" name="iso-listCruiseFaActivities" value="{$clsCruise->getOneField('listCruiseFaActivities',$cruise_id)}" maxlength="255" type="hidden" />
    	<div id="tab_content" class="border_top_aaa">
        	<div class="tabbox">
            	<div class="wrap">
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('duration')}</strong> <span  class="color_r">*</span></div>
						<div class="fieldarea">
							<label class="mr10">{$core->get_Lang('numberday')}:</label>
							<select class="slb mr10 required w100" name="iso-number_day">
								<option value="">{$core->get_Lang('Select')}</option>
								{$clsISO->makeSelectNumber2(30,$oneItem.number_day,'day,days')}
							</select>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span class="color_r">*</span></div>
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
					</div>
					{if $pvalTable}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Destinations')}</strong></div>
						<div class="fieldarea">
							<div class="tabbox">
								<div class="row-span">{$core->get_Lang('infodestinationadmin')}</div>
								<div class="clear"><br /></div>
								<div class="row-span">
									{if $clsISO->getCheckActiveModulePackage($package_id,'continent','default ','default')}
									<select class="slb slb_50 span20 mr5 fl" name="chauluc_id" id="slb_Chauluc" style="width:150px !important;">
										{$clsContinent->makeSelectboxOption()}
									</select>
									{/if}
									{if $clsISO->getCheckActiveModulePackage($package_id,'country','default ','default')}
									<select class="slb slb_50 mr5 fl" name="country_id" id="slb_Country" style="width:150px !important;">
										<option value="0">-- {$core->get_Lang('selectcountry')} --</option>
									</select>
									{/if}
									{if $clsISO->getCheckActiveModulePackage($package_id,'region','default ','default')}
									<select class="slb slb_50 mr5 fl" id="slb_RegionID" name="region_id" style="width:150px !important;">
										<option value="0">-- {$core->get_Lang('selectregion')} --</option>
									</select>
									{/if}
									<select class="slb slb_50 mr10 fl" id="slb_CityID" name="city_id" style="width:150px !important">
										<option value="0">-- {$core->get_Lang('selectcity')} --</option>
									</select>
									<select class="slb slb_50 mr10 fl" id="slb_placetogoID" name="placetogo_id" style="width:150px !important;">
										<option value="0">{$core->get_Lang('selectplacetogo')}</option>
									</select>
									<button class="fl btn-add ajQuickAddDestination" type="button">{$core->get_Lang('adddestination')}</button>
								</div>
								<div class="clear"><br /></div>
								<div class="row-span">
									<div style="padding-left:10px">
										<ul class="list-group" id="lstDestination" style="width:500px;"></ul>
										<div class="clearfix mt10"></div>
										{*<span class="notice" style="padding:0;color:#0565c9">(<span class="requiredMask">*</span> ) {$core->get_Lang('infoless1destination')}</span>*}
									</div>
								</div>
								<div class="clearfix"><br /><br /></div>
								<div class="row-bottom">
									<div class="row-buttons">
										<input type="hidden" name="submit" value="Update" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('Itinerary')}</strong> <span  class="color_r">*</span></div>
						<div class="fieldarea">
							<div class="hastable m_w560" style="margin-bottom:10px; position:relative">
								<table class="tbl-grid" cellspacing="0">
								   <tr>
									  <td class="gridheader" style="width:50px"><strong>{$core->get_Lang('day')}</strong></td>
									  <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
									  <td class="gridheader" style="text-align:center;width:60px"><strong>{$core->get_Lang('func')}</strong></td>
								   </tr>
								   <tbody id="tblCruiseItineraryDay" data-number_day="{$oneItem.number_day}"></tbody>
								</table>
								<a style="vertical-align:middle;margin-right:0; position:absolute; right:-15px; bottom:10px" href="javascript:void(0);" class="color_f00 fr clickToAddItineraryDay"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;{$core->get_Lang('add')}</a>
							</div>
						</div>
					</div>
                    {if $clsISO->getCheckActiveModulePackage($package_id,'cruise','edit_cabin','default')}
					<div class="row-span">
						<div class="fieldlabel"><strong>{$core->get_Lang('PriceTable')}</strong> <span  class="color_r">*</span></div>
						<div class="fieldarea">
							<div id="tblCruisePrice"></div>
						</div>
					</div>
					{/if}
					{/if}
                </div>
                <div class="clearfix"></div>
				{if $pvalTable}
				{if $clsISO->getBrowser() eq 'computer'}
                <div id="v-nav" style="margin-top:30px;">
					<ul>
						<li class="first current"><a href="javascript:void(0);">{$core->get_Lang('About')}</a></li>
						{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','service','default')}
						<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('servicecruises')}</a></li>
						{/if}
					</ul>
					<div class="tab-content" style="display: block;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('intro')}</div>
						</div>
					</div>
					{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','service','default')}
					<div class="tab-content" style="display: none;">
						<div class="row-span row-has-border mt20" style="width:100%">
						<div class="service_left">
							<h4>{$core->get_Lang('servicecruises')}</h4>
						</div>
						<div class="service_right">
							<table class="tbl-grid" cellpadding="0" width="100%">
								<tr>
									<td class="gridheader"><input rel="fa_sv" id="all_check" type="checkbox" /></td>
									<td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
									<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
									<td class="gridheader" style="width:15%;text-align:right">
										<strong>{$core->get_Lang('price')} ({$clsISO->getRate()})</strong>
									</td>
								</tr>
								{section name=i loop=$lstService}
								<tr class="{cycle values="row1,row2"}">
									<td class="index"><input class="fa_sv" type="checkbox" {if $clsISO->checkContainer($oneItem.listService,$lstService[i].cruise_service_id)}checked="checked"{/if} name="listService[]" value="{$lstService[i].cruise_service_id}" /></td>
									<td class="index"> {$smarty.section.i.index+1}</td>
									<td>{$clsCruiseService->getTitle($lstService[i].cruise_service_id)}</td>
									<td style="text-align:right; white-space:nowrap">
										<strong class="format_price" style="font-size:13px">
											{$clsCruiseService->getPrice($lstService[i].cruise_service_id)} {$clsISO->getRate()}
										</strong>
									</td>
								</tr>
								{/section}
							</table>
						</div>
						</div>
					</div>
					{/if}
					{*<div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('cancellation')}</div>
						</div>
					</div>*} 
				</div>
				{else}
				<div class="row-span">
					<div class="fieldlabel"> 
						<strong>{$core->get_Lang('About')}</strong>
					</div>
					<div class="fieldarea">
						{$clsForm->showInput('intro')}
					</div>
				</div>
                {if $clsISO->getCheckActiveModulePackage($package_id,'cruise','service','default')}
				<div class="row-span">
					<div class="fieldlabel"> 
						<strong>{$core->get_Lang('servicecruises')}</strong>
					</div>
					<div class="fieldarea">
						<table class="tbl-grid" cellpadding="0" width="100%">
							<tr>
								<td class="gridheader"><input rel="fa_sv" id="all_check" type="checkbox" /></td>
								<td class="gridheader hiden767"><strong>{$core->get_Lang('index')}</strong></td>
								<td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
								<td class="gridheader" style="width:15%;text-align:right">
									<strong>{$core->get_Lang('price')} ({$clsISO->getRate()})</strong>
								</td>
							</tr>
							{section name=i loop=$lstService}
							<tr class="{cycle values="row1,row2"}">
								<td class="index"><input class="fa_sv" type="checkbox" {if $clsISO->checkContainer($oneItem.listService,$lstService[i].cruise_service_id)}checked="checked"{/if} name="listService[]" value="{$lstService[i].cruise_service_id}" /></td>
								<td class="index hiden767"> {$smarty.section.i.index+1}</td>
								<td>{$clsCruiseService->getTitle($lstService[i].cruise_service_id)}</td>
								<td style="text-align:right; white-space:nowrap">
									<strong class="format_price" style="font-size:13px">
										{$clsCruiseService->getPrice($lstService[i].cruise_service_id)} {$clsISO->getRate()}
									</strong>
								</td>
							</tr>
							{/section}
						</table>
					</div>
				</div>
				{/if}
				{/if}
				{/if}
            </div>
        </div>
        <div class="clearfix"></div>
		<fieldset class="submit-buttons">
			 {$saveBtn}{if $pvalTable}{$saveList}{/if}
			<input value="Update" name="submit" type="hidden">
		</fieldset>
	</form>
</div>	
<script type="text/javascript">
	var $cruise_id = '{$cruise_id}';
	var $cruise_itinerary_id='{$pvalTable}';
	var $cruise_cabin_id='{$listCabin[0].cruise_cabin_id}';
	
</script>
{literal}
<style type="text/css">
.fc-row .fc-highlight-skeleton {
    z-index:0 !important;
}
.calc80{width:calc(100% - 80px)}
</style>
<script type="text/javascript">
	var st_timezone = {"timezone_string":""};
	var st_params = {"locale":"en","text_refresh":"Refresh"};
	
	$(document).on('change', 'select[name=iso-number_day]', function(ev){
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script+"/?mod=cruise&act=loadPriceDayItinerary",
		data:{
			'cruise_id':$cruise_id,
			"number_day":$_this.val(),
		},
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			var htm = html.split('|||');
			$('input[name=trip_price]').val(htm[1]);
		}
	}); 
});
</script>
{/literal}
<script type="text/javascript" src="{$URL_THEMES}/cruise/jquery.cruise.js?v={$upd_version}"></script>  
<link rel="stylesheet" type="text/css" href="{$URL_JS}/fullcalendar/fullcalendar.min.css" />
<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/moment-timezone-with-data-2010-2020.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/date.js"></script>
<script type="text/javascript" src="{$URL_JS}/fullcalendar/customcruise.js"></script>
<script type="text/javascript" src="{$URL_JS}/jquery.global.js?v={$upd_version}"></script>