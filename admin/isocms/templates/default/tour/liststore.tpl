<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('tours')}</a>
    <a>&raquo;</a>
    <a>{$core->get_Lang('list')} {$clsClassTable->getTitle($type)}</a>
    <!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
	<div class="page-title">
        <h2>{$clsClassTable->getTitle($type)} <a style="vertical-align:top; margin-left:10px" class="btn btn-success iso-corner-all fileinput-button" title="{$core->get_Lang('add')}" href="/admin/index.php?mod={$mod}&act=listtour{$pUrl}" > <i class="icon-plus icon-white"></i> <span>{$core->get_Lang('add')} {$clsClassTable->getTitle($type)}</span></a></h2>
        <p>{$core->get_Lang('systemmanagement')} {$clsClassTable->getTitle($type)}</p>
    </div>
    <div id="isotabs">
		 <ul>
            <li class="tabchild"><a><i class="iso-option"></i> {$core->get_Lang('searchfilter')}</a></li>
        </ul>
	</div>
    <div id="isotabs_content">
		<div class="isotabbox">
			<form id="forums" method="post" class="filterForm" action="">
				<div class="searchbox wrap" style="float:none">
					<table class="form" cellpadding="3" cellspacing="3">
						<tr>
							{if $clsConfiguration->getValue("SiteHasGroup_Tours")}
							<td class="fieldlabel">{$core->get_Lang('tourgroup')}</td>
							<td class="fieldarea">
								<select class="slb" onchange="_reload()" id="slb_TourGroup" tp="Url" name="tour_group_id" style="width:200px">
									{$clsTourGroup->makeSelectboxOption($tour_group_id)}
								</select>
							</td>
							{/if}
							{if $clsConfiguration->getValue('SiteHasDeparturePoint_Tours') eq '1'}
							<td class="fieldlabel">{$core->get_Lang('departurepoint')}</td>
							<td class="fieldarea">
								<select onchange="_reload()" name="departure_point_id" class="slb" id="slb_Departure_Point" style="width:200px;">
									<option value="0">-- {$core->get_Lang('Departure point')} --</option>
								</select>
							</td>
							{/if}
						</tr>
						<tr>
                        	{if $clsConfiguration->getValue('SiteHasCat_Tours')}
							<td class="fieldlabel">{$core->get_Lang('tourcategory')}</td>
							<td class="fieldarea">
								<select onchange="_reload()" name="cat_id" class="slb" id="slb_Category" style="width:200px;">
									{$clsTourCat->makeSelectboxOption($tour_group_id, $cat_id)}
								</select>
							</td>
							{/if}
							<td class="fieldlabel">{$core->get_Lang('numberday')}</td>
							<td class="fieldarea">
								<select onchange="_reload()" name="number_day" class="slb" style="width:200px;">
									 <option value="0">-- {$core->get_Lang('Number days')} --</option>
									 {$clsISO->makeSelectNumber2(30,$number_day)}
								</select>
							</td>
						</tr>
						<tr>
							{if $clsConfiguration->getValue('SiteHasPriceRange_Tours') eq '1'}
							<td class="fieldlabel">{$core->get_Lang('pricerange')}</td>
							<td class="fieldarea">
								<select onchange="_reload()" name="price_range_id" class="slb" style="width:200px;">
									 {$clsPriceRange->getSelectByPrice($tour_group_id,$price_range_id)}
								</select>
							</td>
							{/if}
							<td class="fieldlabel">{$core->get_Lang('Search')}</td>
							<td class="fieldarea">
								<input style="width:190px" type="text" class="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
							</td>
						</tr>
					</table>
				</div>
				<div class="mt10"></div>
				<center>
					<div class="group_buttons">
						<a class="btn btn-success" href="javascript:void();" id="searchbtn" >
							<i class="icon-search icon-white"></i> <span>{$core->get_Lang('Search')}</span>
						</a>
						<input type="hidden" name="filter" value="filter" />
						<input type="hidden" name="tour_type_id" value="{$tour_type_id}" />
						<input id="list_selected_chkitem" style="display:none" value="0" />
					</div>
				</center>
            </form>
		</div>
	</div>
	<br class="clearfix" />
    <div class="hastable">
        <table cellspacing="0" class="tbl-grid">
            <tr>
                <td class="gridheader"><strong>{$core->get_Lang('id')}</strong></td>
                <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('nameoftrips')}</strong></td>
                <td class="gridheader" style="text-align:right"><strong>{$core->get_Lang('duration')}</strong></td>
                <td class="gridheader" style="text-align:right"><strong>{$core->get_Lang('priceold')}</strong></td>
                <td class="gridheader" style="text-align:right"><strong>{$core->get_Lang('pricefrom')}</strong></td>
                <!--<td class="gridheader" style="text-align:center; width:3%" colspan="4"><b>{$core->get_Lang('move')}</b></td>-->
                <td class="gridheader" style="width:5% "><strong>{$core->get_Lang('func')}</strong></td>
            </tr>
            {if $allItem[0].tour_id ne ''}
			<tbody id="SortAble">
				{section name=i loop=$allItem}
				<tr style="cursor:move" id="order_{$allItem[i].tour_id}" class="{cycle values="row1,row2"}">
                <td class="index">{$allItem[i].tour_id}</td>
                <td>
                    <strong class="title">{if $clsTour->getOneField('is_online',$allItem[i].tour_id) eq 0}<span style="color:#F90">[PRIVATE]</span>{/if} {$clsTour->getTitle($allItem[i].tour_id)}</strong>
					{if $clsTour->getOneField('is_trash',$allItem[i].tour_id) eq '1'}<span class="fr" style="color:#CCC">{$core->get_Lang('intrash')}</span>{/if}
                </td>
                <td class="text-right" style="white-space:nowrap">{$clsTour->getTripDuration($allItem[i].tour_id)}</td>
                <td style="text-align:right; white-space:nowrap">
                    <strong class="format_price">{$clsISO->getRateSign()}  {$clsISO->formatNumberToEasyRead($clsTour->getOneField('trip_old_price',$allItem[i].tour_id))}</strong>
                </td>
                <td style="text-align:right; white-space:nowrap">
                    <strong class="format_price">{$clsISO->getRateSign()}  {$clsISO->formatNumberToEasyRead($clsTour->getOneField('trip_price',$allItem[i].tour_id))}</strong>
                </td>
				{if 1 eq 2}
               	<td style="vertical-align:middle;text-align:center">
                    {if !$smarty.section.i.first}<a title="{$core->get_Lang('movetop')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=move&direct=movetop&tour_store_id={$allItem[i].tour_store_id}{$pUrl}"><i class="icon-circle-arrow-up"></i></a>{/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.last}<a title="{$core->get_Lang('movebottom')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=move&direct=movebottom&tour_store_id={$allItem[i].tour_store_id}{$pUrl}"><i class="icon-circle-arrow-down"></i></a>{/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.first}
                    <a title="{$core->get_Lang('moveup')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=move&direct=moveup&tour_store_id={$allItem[i].tour_store_id}{$pUrl}"><i class="icon-arrow-up"></i></a>
                    {/if}
                </td>
                <td style="vertical-align: middle;text-align:center">
                    {if !$smarty.section.i.last}
                    <a title="{$core->get_Lang('movedown')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=move&direct=movedown&tour_store_id={$allItem[i].tour_store_id}{$pUrl}"><i class="icon-arrow-down"></i></a>
                    {/if}
                </td>
				{/if}
                <td><a class="iso-cancel-action confirm_delete" title="{$core->get_Lang('delete')}" href="{$PCMS_URL}/?mod={$mod}&act={$act}&action=Delete&tour_store_id={$allItem[i].tour_store_id}{$pUrl}"><i class="icon-upload icon-white"></i> {$core->get_Lang('delete')}</a></td>
            </tr>
            {/section}
            {else}<tr><td colspan="15">{$core->get_Lang('nodata')}!</td></tr>{/if}
        </table>
        <div style="border:1px solid #ccc; padding:5px; margin-top:10px;">
        <strong>{$core->get_Lang('warning')}</strong>:  
        <img src="{$URL_IMAGES}/warning-20.png" align="absmiddle" /> {$core->get_Lang('incorrectlyformatted')}.
        </div>
    </div>
    <div class="wrap mt20">
        <form method="post" action="" enctype="multipart/form-data">
        	<div class="page-title bold">{$core->get_Lang('OnPage description')}</div>
            <table class="form" cellpadding="3" cellspacing="3">
                <tr>
                    <td class="fieldarea" colspan="2">
                    	{assign var=siteTourType value=SiteTourType_$type}
                        {assign var=siteTourTypeLang value=$siteTourType|cat:"_"|cat:$_LANG_ID}
                        <textarea id="{$siteTourTypeLang}{$now}" class="textarea_intro_editor" name="iso-{$siteTourTypeLang}" style="width:100%">{$clsConfiguration->getValue($siteTourTypeLang)}</textarea>
                    </td>
                </tr>
            </table>
            <div class="clearfix mt10"></div>
            <fieldset class="submit-buttons">
                {$saveBtn}
                <input value="UpdateTourTypeIntro" name="submit" type="hidden">
            </fieldset>
        </form>
	</div>
</div>
<script type="text/javascript">
	var $boxID = "";
	var $type = '{$type}';
	var $tour_group_id = '{$tour_group_id}';
	var $tour_type_id = '{$tour_type_id}';
	var $cat_id = '{$cat_id}';
	var $city_id= '{$city_id}';
	var $departure_point_id= '{$departure_point_id}';
</script>
<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.js"></script>

{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		opacity: 0.8,
		cursor: 'move',
		start: function(){
			vietiso_loading(1);
		},
		stop: function(){
			vietiso_loading(0);
		},
		update: function(){
			var type = $type;
			var order = $(this).sortable("serialize")+'&update=update'+'&type='+type;
			$.post(path_ajax_script+"/index.php?mod=tour&act=ajUpdPosSortHotTour", order, 
			
			function(html){
				vietiso_loading(1);
				vietiso_loading(0);
			});
		}
	});
</script>
{/literal}