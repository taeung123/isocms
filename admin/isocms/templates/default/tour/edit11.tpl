<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('tours')}">{$core->get_Lang('tours')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$core->get_Lang('edit')}">{$core->get_Lang('edit')} #{$pvalTable}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2 style="font-size:19px;">{$clsClassTable->getTitle($pvalTable)}{if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}<strong style="color:#F00; font-size:12px;" title="{$core->get_Lang('Tour is in Private Mode')}!">[P]</strong>{/if} <a class="btn btn-success fileinput-button" target="_blank" href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}"><i class="icon-eye-open icon-white"></i></a></h2>
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> <strong>{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</strong></a>
            </div>
        </div> 
    </div>
    <div class="clearfix"><br /></div>
    {if $msg eq 'DupTripCode'}
    <div style="padding:15px; padding-top:0;">
        <div style="padding:10px; background:red; color:#fff; font-size:14px; text-align:center; "><img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" />
            <strong>{$core->get_Lang('Warning')}:</strong> {$core->get_Lang('identicaltripcode')}
        </div>
    </div>
    <div class="clearfix"></div>
    {/if} {if $clsClassTable->getErrorMsg($pvalTable) ne ''}
    <br/>
    <div style="padding:15px; padding-top:0;display:none">
        <div style="padding:10px; border:3px dashed red; "><img src="{$URL_IMAGES}/warning-20.png" title="" align="absmiddle" /> {$core->get_Lang('Warning')}: {$clsClassTable->getErrorMsg($pvalTable)}
        </div>
    </div>
    <div class="clearfix"></div>
    {/if}
    <div class="clearfix"></div>
    <div id="clienttabs" class="tour_tabs">
        <ul>
            <li><a href="javascript:void(0);"><i class="iso-bassic"></i> {$core->get_Lang('basic')}</a></li>
            <li><a href="javascript:void(0);"><i class="fa fa-car" aria-hidden="true"></i> {$core->get_Lang('itinerary')}</a></li>
            {if $clsConfiguration->getValue('SiteHasDestinationTours')}
            <li class="maps"><a href="javascript:void(0);"><i class="fa fa-map-marker"></i> {$core->get_Lang('destinations')}</a></li>
            {/if} {if $clsConfiguration->getValue('SiteHasGeneralPriceSystem') || $clsConfiguration->getValue('SiteHasPriceTableTours')}
            <li><a href="javascript:void(0);"><i class="fa fa-money"></i> {$core->get_Lang('pricetables')}</a></li>
            {/if}
            <li><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Configuration')}</a></li>
            {if $_LANG_ID ne 'vn'}
			{if $clsTourStore->checkExist($pvalTable,DEPARTURE)}
            <li><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Departure date')}</a></li>
			{/if}
            {/if}
			{if $clsTourStore->checkExist($pvalTable,PROMOTION)}
            <li><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Promotion')}</a></li>
			{/if}
        </ul>
    </div>
    <div id="tab_content" style="width:100%; float: left">
        <div class="tabbox">
            <form id="frmEditTour" method="post" action="" enctype="multipart/form-data" class="validate-form">
                <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" />
              
                <div class="wrap">
                    <div class="photobox fl">
                        {if $_isoman_use eq '1'}
                        <img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
                        <input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
                        <a href="javascript:void(0)" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a> 
                        {if $oneItem.image}
                        <a pvalTable="{$pvalTable}" clsTable="Tour" href="javascript:void(0)" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" g="imgItem" style="margin-left:25px;line-height:27px;background:red;color:#fff;text-align:center; text-decoration:none">X</a> 
                        {/if} 
                        {else}
                        <img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
                        <input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
                        <a href="javascript:void(0)" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour"><i class="iso-edit"></i></a>
                        <input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" /> 
                        {/if}
                    </div>
                    <div class="fr" style="width:78%">
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Name')}*</strong></div>
                            <div class="fieldarea">
                                <input class="text full required" id="title" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>
                        {if 1 eq 2}
                        <div class="row-span" >
                            <div class="fieldlabel"><strong>{$core->get_Lang('rating')}*</strong></div>
                            <div class="fieldarea">
                                <label class="radio inline"><input type="radio" name="star_id" {if $oneItem.star_id eq '0' or $pvalTable eq '0'}checked="checked"{/if} value="0"> {$core->get_Lang('Un Rated')}</label> {section name=star start=1 loop=6 step=1}
                                <label class="radio inline"><input type="radio" name="star_id" {if $oneItem.star_id eq $smarty.section.star.index}checked="checked"{/if} value="{$smarty.section.star.index}">{$smarty.section.star.index} {$core->get_Lang('star')}</label> {/section}
                            </div>
                        </div>
                        {/if}
                        <!-- Enable TOUR_GROUP -->
                        {if $clsConfiguration->getValue('SiteHasGroup_Tours') eq '1'}
                        <div class="row-span">
                            <div class="fieldlabel bold"><strong>{$core->get_Lang('tourgroup')}*</strong></div>
                            <div class="fieldarea">
                                <select name="iso-tour_group_id" class="slbHighlight required slb full" id="slb_TourGroup" tp="multiple" style="width:260px;">
                                    {$clsTourGroup->makeSelectboxOption($tour_group_id)}
                                </select>
                            </div>
                        </div>
                        {/if}
                        <!-- Enable TOUR_CATEGORY -->
                        {if $clsConfiguration->getValue('SiteHasCat_Tours')}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('tourcategory')}*</strong></div>
                            <div class="fieldarea">
                                <div id="slb_ContainerTourCategory">
                                    <select name="cat_id[]" id="cat_id" class="slb full required chosen-select" multiple style="width:250px">
										{assign var = selected value = $oneItem.list_cat_id}
										{$clsTourCategory->makeSelectboxOption($oneItem.tour_group_id, $selected, 1)}
										{$selected}
									</select>
                                </div>
                            </div>
                        </div>
                        {/if}
                        <!--////////////////tagssss///////////////-->
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Tour tags')}</strong></div>
                            <div class="fieldarea">
                                <div id="slb_ContainerTourTag">
                                    <select name="tag_id[]" id="tag_id" class="slb full chosen-select" multiple style="width:250px">
										{assign var = selected value = $oneItem.list_tag_id}
										{$clsTag->makeSelectboxOption($selected)}
										{$selected}
									</select>
                                </div>
                            </div>
                        </div>
                        <!-- Enable TOUR_DEPARTTURE_POINT -->
                        {if $clsConfiguration->getValue('SiteHasDeparturePoint_Tours')}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('departurepoint')}*</strong></div>
                            <div class="fieldarea">
                                <select class="required slb full" name="iso-departure_point_id" style="font-weight:bold;font-size:13px;width:300px;">
                                	{$clsCity->getSelectDeparturePoint($tour_group_id,$oneItem.departure_point_id)}
                                </select>
                                <em>{$core->get_Lang('ex')}: Ha Noi, Ho Chi Minh City, Da Nang</em>
                            </div>
                        </div>
                        {/if}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Trip code')}</strong></div>
                            <div class="fieldarea"><input class="text full span50 fontLarge" name="iso-trip_code" value="{$clsClassTable->getTripCode($pvalTable)}" maxlength="255" type="text" style="width:300"></div>
                        </div>
                        <div class="clearfix"><br /></div>
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Duration')}*</strong></div>
                            <div class="fieldarea">
                                <label class="mr10"><input type="radio" name="iso-duration_type" value="0" {if $oneItem.duration_type ne '1'}checked="checked"{/if}/> {$core->get_Lang('numberday')}:</label>
                                <select class="slb mr10 span10" name="iso-number_day" {if $oneItem.duration_type eq '1'}disabled="disabled" {/if}>
                                    <option value="">{$core->get_Lang('Select')}</option>
                                    {$clsISO->makeSelectNumber2(30,$oneItem.number_day)}
                                </select>
                                <label class="mr10">/ {$core->get_Lang('numbernight')}:</label>
                                <select class="slb mr10 span10" name="iso-number_night" {if $oneItem.duration_type eq '1'}disabled="disabled" {/if}>
                                    <option value="">{$core->get_Lang('Select')}</option>
                                    {$clsISO->makeSelectNumber2(30,$oneItem.number_night)}
                                </select>
                                <br/>
                                <div class="cleafix" style="margin-top:10px"></div>
                                <label class="mr10"><input type="radio" name="iso-duration_type" {if $oneItem.duration_type eq '1'}checked="checked"{/if} value="1" /> / {$core->get_Lang('Option')}:</label>
                                <input type="text" class="text" {if $oneItem.duration_type ne '1'}disabled="disabled" {/if} name="iso-duration_custom" value="{$clsClassTable->getOneField('duration_custom',$pvalTable)}" /> {literal}
                                <script type="text/javascript">
                                    $("input[name='iso-duration_type']").live("click", function() {
                                        if ($("input[name='iso-duration_type']:checked").val() == 1) {
                                            $("select[name='iso-number_day']").attr("disabled", "disabled");
                                            $("select[name='iso-number_day']").val('0');
                                            $("select[name='iso-number_night']").attr("disabled", "disabled");
                                            $("select[name='iso-number_night']").val('0');
                                            $("input[name='iso-duration_custom']").removeAttr("disabled");
                                        } else {
                                            $("input[name='iso-duration_custom']").attr("disabled", "disabled");
                                            $("input[name='iso-duration_custom']").val('0');
                                            $("select[name='iso-number_day']").removeAttr("disabled");
                                            $("select[name='iso-number_night']").removeAttr("disabled");
                                        }
                                    });
                                </script>
                                {/literal}
                            </div>
                        </div>
                        <div class="clearfix"><br /></div>
                        {if $core->checkAccess('TOUR-PUBLIC') eq 0}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong></div>
                            <div class="fieldarea">
                                <div class="vietiso_status_button"></div>
                                <script type="text/javascript">
                                    var is_online = '{$clsClassTable->getOneField("is_online",$pvalTable)}';
                                </script>
                                {literal}
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('.vietiso_status_button').isoswitchvalue({
                                            _value: is_online,
                                            _selector: 'iso-is_online'
                                        });
                                    });
                                </script>
                                {/literal}
                                <span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('Tours only be seen via the link in the admin page')}!</span>
                                <span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('Tours are available online at the list normality')}!</span>
                            </div>
                        </div>
                        {else}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Status')}</strong></div>
                            <div class="fieldarea">
                                <div class="vietiso_status_button off" style="cursor:auto;"><span class="on" style="cursor:auto;">PUBLIC</span><span class="off" style="cursor:auto;">PRIVATE</span></div>
                                <span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}> {$core->get_Lang('Tours only be seen via the link in the admin page')}.<a class="btn btn-primary fileinput-button" href="{$DOMAIN_NAME}/index.php?mod=tour&act=detail&tour_id={$pvalTable}&preview=1" target="_blank">{$core->get_Lang('View')} <img src="{$URL_IMAGES}/go-16.png" align="absmiddle"></a></span>
                            </div>
                        </div>
                        {/if} {if $core->checkAccess('TOUR-BOOKABLE') eq 1}
                        <div class="row-span">
                            <div class="fieldlabel">{$core->get_Lang('alloweddeparture')}?</div>
                            <div class="fieldarea">
                                <select name="iso-book_other_date" style="font-weight:bold; width:160px; padding:4px;">
                                   <option value="0">{$core->get_Lang('notallowed')}</option>
                                   <option value="1" {if $clsClassTable->getOneField("book_other_date",$pvalTable) eq 1}selected="selected"{/if}>{$core->get_Lang('allowed')}</option>
                                </select>
                                <em>{$core->get_Lang('Allow: Users can book a tour outside of the intended date of departure')}</em>
                            </div>
                        </div>
                        {/if}
                    </div>
                </div>
                <div class="clearfix"><br /></div>
                <div id="v-nav">
                    <ul>
                        <li class="tabchildcol first current"><a href="javascript:void(0);">{$core->get_Lang('Overview')}</a></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Trip Inclusion')}</a></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Trip Exclusion')}</a></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Stay')}</a></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Meal')}</a></li>
                        <li class="tabchildcol"><a href="#map">{$core->get_Lang('Activity')}</a></li>
                        <li class="tabchildcol"><a href="#map">{$core->get_Lang('Things To Carry')}</a></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Advisory')}</a></li>
                        <li class="tabchildcol"><a href="#map">{$core->get_Lang('Cancellation Policy')}</a></li>
                        <li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Refund Policy')}</a></li>
                        <li class="tabchildcol"><a href="#map">{$core->get_Lang('Confirmation Policy')}</a></li>
                    </ul>
                    <div class="tab-content" style="display: block;">
                        {$clsForm->ShowInput('overview')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('inclusion')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('exclusion')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('stay')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('meal')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('activity')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('thing_to_carry')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('advisory')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('cancellation_policy')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('refund_policy')}
                    </div>
                    <div class="tab-content" style="display: none;">
                        {$clsForm->ShowInput('confirmation_policy')}
                    </div>
                </div>
                {if $clsConfiguration->getValue('SiteHasCustomContentField_Tours') eq '1'}
                <div class="SiteCustomFieldContaciner">
                    <!-- HTML_APPEND_HERE -->
                </div>
                <a class="iso-button-full ClickCustomField" data-tour_id="{$pvalTable}">
                    <i class="fa fa-plus-circle"></i> <strong>{$core->get_Lang('addmoreinformation')}</strong>
                </a>
                {/if}

                

                <div class="clearfix"><br /><br /></div>
                <div class="row-bottom">
                    <div class="row-buttons">
                        <div class="clear"></div>
                        <button type="submit" class="btn-update" id="SaveTourStep1" name="submit" value="Update">
                      	<i class="iso-update"></i> {$core->get_Lang('Save')}
                      </button>
                        <input type="hidden" name="UpdateStep1" value="UpdateStep1" />
                        <input type="hidden" name="is_set" value="{$smarty.get.is_set}" />
                    </div>
                </div>
            </form>
        </div>
        <div class="tabbox" style="display:none">
            <form method="post" action="">
                <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" /> {literal}
                <script type="text/javascript">
                    $().ready(function() {
                        makeGlobalTab('globaltabs_program');
                    });
                </script>
                {/literal}
                <div class="tab_contentglobal">
                    {if $clsConfiguration->getValue('SiteHasItineraryTours')}
                    <div class="tabboxchild_globaltabs_program">
                        <div class="row-span row-has-border">
                            <div class="row-span-help">{$core->get_Lang('introitinerary')}</div>
                            <div class="clearfix"><br /></div>
                            <div class="wrap text-line-button">
                                <p>{$core->get_Lang('infoaddday')} </p>
                                <a style="vertical-align:middle" href="javascript:void(0);" id="clickToAddItinerary" class="iso-button-primary fl"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('add')}</a>
                            </div>
                            <div class="hastable" style="margin-bottom:10px">
                                <table class="full-width tbl-grid" cellspacing="0">
                                    <tr>
										<td class="gridheader"><strong>{$core->get_Lang('No.')}</strong></td>
                                        <td class="gridheader"><strong>{$core->get_Lang('day')}</strong></td>
                                        <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                                        <td class="gridheader" style="text-align:right"><strong>{$core->get_Lang('Meals')}</strong></td>
                                        <td class="gridheader" style="text-align:right; width:15%"><strong>{$core->get_Lang('update')}</strong></td>
										{if 1 eq 2}
                                        <td class="gridheader" colspan="4" style="width:4%">{$core->get_Lang('move')}</td>
										{/if}
                                        <td class="gridheader"><strong>{$core->get_Lang('func')}</strong></td>
                                    </tr>
                                    <tbody id="tblTourItinerary"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {/if}
                </div>
            </form>
        </div>

        {if $clsConfiguration->getValue('SiteHasDestinationTours')}
        <div class="tabbox" style="display:none;">
			<div class="col-md-6">
            <div class="row-span">{$core->get_Lang('infodestinationadmin')}</div>
            <div class="clear"><br /></div>
            <div class="row-span">
                {if $clsConfiguration->getValue('SiteModActive_continent') and $core->checkAccess('continent')}
                <select class="slb span20 mr5 fl" name="chauluc_id" id="slb_Chauluc" style="width:120px !important;">
					{$clsContinent->makeSelectboxOption()}
				</select> {/if} {if $clsConfiguration->getValue('SiteModActive_country') and $core->checkAccess('country')} {if $clsConfiguration->getValue('SiteHasGroup_Tours') && $clsClassTable->getOneField('tour_group_id',$pvalTable) eq '2'}
                <input type="hidden" id="Hid_Country" name="country_id" value="1" /> {else}
                <select class="slb mr5 fl" name="country_id" id="slb_Country" style="width:120px !important;">
                   <option value="0">-- {$core->get_Lang('selectcountry')} --</option>
                 </select> {/if} {/if} {if $clsConfiguration->getValue('SiteActive_region')}
                <select class="slb mr5 fl" id="slb_RegionID" name="region_id" style="width:120px !important;">
                	<option value="0">-- {$core->get_Lang('selectregion')} --</option>
                </select> {/if} {if $clsConfiguration->getValue('SiteActive_city')}
                <select class="slb mr10 fl" id="slb_CityID" name="city_id" style="width:120px !important;">
                	<option value="0">-- {$core->get_Lang('selectcity')} --</option>
                </select> {/if}
				<select class="slb mr10 fl" id="slb_placetogoID" name="placetogo_id" style="width:120px !important;">
                	<option value="0">-- {$core->get_Lang('selectplacetogo')} --</option>
                </select>
                <button class="fl btn-add ajQuickAddDestination" type="button">{$core->get_Lang('adddestination')}</button>
            </div>
            <div class="clear"><br /></div>
            <div class="row-span">
                <div style="padding-left:10px">
                    <ul class="list-group" id="lstDestination" style="width:500px;"></ul>
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
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGBM_QUAg8Oi-dI_Bopn6JVe4jrgVUcWw&libraries=places"></script>
			<div class="col-md-6">
			{$core->getBlock('Lbox_map_tour')}
			 <div class="clearfix"><br /><br /></div>
			 <form method="post" action="">
			<div class="row-bottom">
			<label>MapZoom</label>
			<input type="text" width="255" name="iso-map_zoom" value="{$clsClassTable->getOneField("map_zoom",$pvalTable)}" style="line-height:26px"/>
				<div class="row-buttons">
					<div class="clear"></div>
					<button type="submit" class="btn-update" id="SaveTourStep10" name="submit" value="Update" style="margin-top:0">
					<i class="iso-update"></i> {$core->get_Lang('Save')}
				  </button>
					<input type="hidden" name="UpdateStep10" value="UpdateStep10" />
				</div>
			</div>
			</form>
			</div>
        </div>
		
        {/if} {if $clsConfiguration->getValue('SiteHasGeneralPriceSystem') or $clsConfiguration->getValue('SiteHasPriceTableTours')}
        <div class="tabbox" style="display:none">
            <form method="post" action="">
                {literal}
                <style>
                    label.error {
                        display: none !important;
                    }
                </style>
                <script type="text/javascript">
                    $().ready(function() {
                        makeGlobalTab('globaltabs_optional');
                    });
                </script>
                {/literal}

                <div class="tab_contentglobal" id="contentglobal_has_datepicker">
                    {if $clsConfiguration->getValue('SiteHasPriceTableTours')}
                    <div class="tabboxglobal tabboxchild_globaltabs_optional">
                        {if $_LANG_ID eq 'vn'}

                        <div class="fieldlabel" style="text-align:left;line-height:24px; margin-bottom:10px; font-weight:bold">{$core->get_Lang('Product pricing')}</div>
                        <div id="tblTourPriceNewVersion1" class="tblTourPriceNewVersion span100">
                            <!-- HTML Price Static -->
                        </div>
                        <div class="fieldarea">
                            {if $clsClassTable->getOneField('cat_id',$pvalTable) eq '1'}
                            <label style="text-align:left; line-height:24px; padding-right:0; font-size:13px; width:180px;">{$core->get_Lang('Advertised price')}</label> {$clsConfiguration->getValue('Currency')} <input type="text" name="trip_price" id="total" value="{$clsISO->formatNumberToEasyRead($clsClassTable->getOneField('trip_price',$pvalTable))}" class="text full fontLarge" style="width:166px;" /> {$clsISO->getRate()}
                            <div class="cleafix mb20"></div>

                            <label style="text-align:left; line-height:24px; padding-right:0; font-size:13px; width:217px;">{$core->get_Lang('Mô tả giá:')}</label>

                            <input type="text" name="intro_trip_price" value="{$clsClassTable->getOneField('intro_trip_price',$pvalTable)}" class="text full fontLarge" style="width:100%; font-size:13px; font-weight:normal" /> {else}
                            <label style="text-align:left; line-height:24px; padding-right:0; font-size:13px; width:110px;">{$core->get_Lang('Advertised price')}</label>
                            <input type="text" name="trip_price" id="advertisedPriceFormatted" value="{$clsClassTable->getOneField('trip_price',$pvalTable)}" class="text full fontLarge" style="width:320px;" /> (.000 VND) {/if}

                        </div>
                        {else}
                        <div class="priceTableEn mb20">
                            <div class="fieldlabel" style="text-align:left;line-height:24px; margin-bottom:10px; font-weight:bold">{$core->get_Lang('Product pricing')}</div>
                            <div style="display:inline-block; vertical-align:top">
                                <select name="service_ID" id="service_ID" class="form-control">
                                        <option value="1">{$core->get_Lang('By Person')}</option>
                                </select>
                            </div>
                            <div id="priceTable" style="display:inline-block">
                                <div id="tblTourPriceNewVersion2" class="tblTourPriceNewVersion span100">
                                    <!-- HTML Price Static -->
                                </div>
                            </div>
                            <div id="priceOption" style="display:none">
                                <label class="control-label" for="price_ID">{$core->get_Lang('Price')}</label>
                                <input type="text" name="trip_price" id="trip_price" value="{$clsISO->formatNumberToEasyRead($clsClassTable->getOneField('trip_price',$pvalTable))}" class="text ful span20 fontLarge" /> {$clsProperty->getOneField('property_code',$clsConfiguration->getValue('Currency'))}
                            </div>
                        </div>
                        {/if}
                        <div class="fieldarea" style="margin-top:20px">
                            <label style="text-align:left; line-height:24px; padding-right:0; font-size:13px; width:110px;">{$core->get_Lang('Deposit')}</label>
                            <span style="display:inline-block; width:40px">(%)</span><input type="text" name="iso-deposit" value="{$clsClassTable->getOneField('deposit',$pvalTable)}" class="text full fontLarge priceTourFormat" style="width:320px;" />
                        </div>
                    </div>
                    {/if}

                    <div class="clearfix"></div>
                    <div class="row-bottom">
                        <div class="row-buttons">
                            <div class="clear"></div>
                            <button type="submit" id="SaveTourStep4" class="btn-update" name="button" value="Update">
                                <i class="iso-update"></i> {$core->get_Lang('Submit')}
                            </button>

                            <input type="hidden" name="UpdateStep4" value="UpdateStep4" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {/if}
        <div class="tabbox" style="display:none">
            {literal}
            <script type="text/javascript">
                $().ready(function() {
                    makeGlobalTab('globaltabs_config');
                });
            </script>
            {/literal}
            <div class="globaltabs" id="globaltabs_config_ul">
                <ul>
                    <!--<li><a href="javascript:void(0);"><i class="iso-gallery"></i> {$core->get_Lang('Add On Services')}</a></li>-->
                    {if $clsConfiguration->getValue('SiteHasExtensionTours')}
                    <li><a href="javascript:void(0);"><i class="iso-gallery"></i> {$core->get_Lang('Related Tours')}</a></li>
                    {/if} {if $clsConfiguration->getValue('SiteHasGalleryImagesTours')}
                    <li><a href="javascript:void(0);"><i class="iso-price"></i> {$core->get_Lang('gallery')}</a></li>
                    {/if}
                    <li><a href="javascript:void(0);"><i class="iso-price"></i> {$core->get_Lang('seotool')}</a></li>
                    {assign var=tourcat_id value=$clsClassTable->getOneField("cat_id",$pvalTable)} {if $tourcat_id eq '1'}
                    <li><a href="javascript:void(0);"><i class="iso-price"></i> {$core->get_Lang('transport')}</a></li>
                    {/if}
                </ul>
            </div>
            <div class="clearfix"></div>
            <div class="tab_contentglobal">
                {if 1 eq 2}
                <div class="tabboxchild_globaltabs_config">
                    <div class="accordion_in acc_active">
                        <div class="acc_head">
                            <div class="acc_icon_expand"></div>
                            <h2 style="font-size:20px; margin-bottom:10px">{$core->get_Lang('Add On Services')}</h2>
                        </div>
                        <div class="acc_content">
                            <div class="row-span-help">{$core->get_Lang('infotourextension')}</div>
                            <form class="mt30" method="post" action="">
                                <table width="100%" class="tbl-grid" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                                        <td class="gridheader"></td>
                                        <td class="gridheader text-left"><strong>{$core->get_Lang('nameofservice')}</strong></td>
                                        <td class="gridheader" style="text-align:right; width:8%"><strong>{$core->get_Lang('pricefrom')}</strong></td>
                                        <td class="gridheader" style="width:12%"><strong>{$core->get_Lang('update')}</strong></td>
                                        <td class="gridheader"><strong>{$core->get_Lang('func')}</strong></td>
                                    </tr>
                                    {section name=i loop=$lstTourService}
                                    <tr class="{cycle values=" row1,row2 "}">
                                        <td class="index">{$smarty.section.i.iteration}</td>
                                        <td class="index">
                                            {if $clsTourService->getImageUrl($lstTourService[i].tourservice_id)}
                                            <img src="{$clsTourService->getImageUrl($lstTourService[i].tourservice_id)}" width="40" /> {/if}
                                        </td>
                                        <td>{$clsTourService->getTitle($lstTourService[i].tourservice_id)}</td>
                                        <td style="text-align:right; white-space:nowrap">
                                            <strong class="format_price">
                                            	{$clsTourService->getPrice($lstTourService[i].tourservice_id)} {$clsISO->getRate()}
                                            </strong>

                                        </td>
                                        <td style="text-align:right">
                                            <font color="red">{$clsTourService->getOneField('upd_date',$lstTourService[i].tourservice_id)|date_format:"%m-%d-%Y %H:%M"}</font>
                                        </td>
                                        <td class="text-center"><input type="checkbox" name="list_service_id[]" {$lstTourService[i].check} value="{$lstTourService[i].tourservice_id}" /></td>
                                    </tr>
                                    {/section}
                                </table>
                                <div class="clearfix"><br /><br /></div>
                                <div class="row-bottom">
                                    <div class="row-buttons">
                                        <div class="clear"></div>
                                        <button type="submit" id="SaveTourStep5" class="btn-update" name="button" value="Update">
                                            <i class="iso-update"></i> {$core->get_Lang('Submit')}
                                        </button>
                                        <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" />
                                        <input type="hidden" name="UpdateStep5" value="UpdateStep5" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {/if}
                <!-- End tabs inner -->
                {if $clsConfiguration->getValue('SiteHasExtensionTours')}
                <div class="tabboxchild_globaltabs_config">
                    <div class="accordion_in acc_active">
                        <div class="acc_head">
                            <div class="acc_icon_expand"></div>
                            <h2 style="font-size:20px; margin-bottom:10px">{$core->get_Lang('tourextension')}</h2>
                        </div>
                        <div class="acc_content">
                            <div class="row-span-help">{$core->get_Lang('infotourextension')}</div>
                            <div class="infobox">{$core->get_Lang('notetourextension')}</div>
                            <div class="filterbox mt40">
                                <div class="wrap">
                                    <div class="searchbox">
                                        <input id="searchkey" placeholder="{$core->get_Lang('searchtour')}" type="text" class="text" style="width:240px" />
                                        <a class="btn btn-success" href="javascript:void(0);">
                                            <i class="icon-search icon-white"></i> <span></span>
                                        </a>
                                        <div class="autosugget" id="autosugget">
                                            <ul class="HTML_sugget"></ul>
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
                                        <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('travelstyles')}</strong></td>
                                        {/if}
                                        <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('pricefrom')}</strong></td>
                                        <td class="gridheader" style="width:2%"><strong>{$core->get_Lang('delete')}</strong></td>
                                    </tr>
                                    <tbody id="tblTourExtension"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {/if} {if $clsConfiguration->getValue('SiteHasGalleryImagesTours')}
                <div class="tabboxchild_globaltabs_config" style="display:none">
                    <div id="TourGalleryHolder"></div>
                </div>
                {/if}
                <div class="tabboxchild_globaltabs_config" style="display:none">
                    <form method="post" action="" enctype="multipart/form-data">
                        <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" />
                        <input type="hidden" name="UpdateStep6" value="UpdateStep6" />
                        <div class="row-span row-has-border">
                            <span class="notice-full">{$core->get_Lang('notetitlemeta')}</span>
                            <div class="fieldlabel" style="text-align:right;">{$core->get_Lang('Meta title')}</div>
                            <div class="fieldarea"><textarea class="textarea span90 fontLarge" rows="1" style="resize:none" name="config_value_title">{$clsISO->getPageTitle($pvalTable,Tour)}</textarea></div>
                        </div>
                        <div class="row-span row-has-border">
                            <span class="notice-full">{$core->get_Lang('noteintrometa')}</span>
                            <div class="fieldlabel" style="text-align:right;">{$core->get_Lang('Meta description')}</div>
                            <div class="fieldarea"><textarea class="textarea span90" rows="3" style="resize:none" name="config_value_intro">{$clsISO->getPageDescription($pvalTable,Tour)}</textarea></div>
                        </div>
                        <div class="row-span row-has-border">
                            <span class="notice-full">{$core->get_Lang('notekeywordmeta')}</span>
                            <div class="fieldlabel" style="text-align:right;">{$core->get_Lang('Meta keyword')}</div>
                            <div class="fieldarea">
                                <textarea class="textarea span90" rows="3" style="resize:none" name="config_value_keyword">{$clsISO->getPageKeyword($pvalTable,Tour)}</textarea>
                                <br style="clear:both" />
                                <br style="clear:both" />
                                <table>
                                    <tr>
                                        <td style="background:#CCC">{$core->get_Lang('Meta Robots Index')}</td>
                                        <td>
                                            <select name="meta_index">
                                                <option value="0">{$core->get_Lang('Index')}</option>
                                                <option value="1" {if $oneMeta.meta_index eq 1}selected="selected"{/if}>{$core->get_Lang('NoIndex')}</option>
                                            </select>
                                        </td>
                                        <td style="background:#CCC">{$core->get_Lang('Meta Robots Follow')}</td>
                                        <td>
                                            <select name="meta_follow">
                                                <option value="0">{$core->get_Lang('Follow')}</option>
                                                <option value="1" {if $oneMeta.meta_follow eq 1}selected="selected"{/if}>{$core->get_Lang('NoFollow')}</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row-bottom">
                            <div class="row-buttons">
                                <div class="clear"></div>
                                <button type="submit" id="SaveTourStep6" class="btn-update" name="button" value="Insert">
                                    <i class="iso-update"></i> {$core->get_Lang('Submit')}
                                </button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>
					
					
					
					<div class="g" style="width:600px">
					<div data-hveid="70" data-ved="0ahUKEwj2yJPhpLPVAhUGqo8KHbVWCFk4ChAVCEYoBjAG">
						<div class="rc">
							<h3 class="r"><a href="" onMouseDown="" data-href="">{$clsClassTable->getTitle($pvalTable)}</a></h3>
							<div class="s">
								<div>
									<div class="f kv _SWb" style="white-space:nowrap">
									<cite class="_Rm bc">
									<div class="breadcrumb hidden-xs" style="background:none !important">
									<a href="{$DOMAIN_NAME}"><span class="reb">{$DOMAIN_NAME}</span> ›</a> 
									<a href="{$curl}" title="{$core->get_Lang('Tour')}">
										<span class="reb">{$core->get_Lang('Tour')}</span> ›
									 </a> 

								   	<a href="{$clsTourCategory->getLink($tourcat_id)}" title="{$clsTourCategory->getTitle($tourcat_id)}">
										<span class="reb">{$clsTourCategory->getTitle($tourcat_id)}</span> ›
									</a>
									<a title="{$clsTour->getTitle($tour_id)}">
										<span class="reb">{$clsClassTable->getTitle($pvalTable)}</span> 
									</a>
								</div>
								</cite>
									</div>
									<div class="slp f">
										<g-review-stars><span class="_ayg" aria-label="Được đánh giá 4,5 trên 5,"><span style="width:59px"></span></span></g-review-stars>
										Xếp hạng: 4,4 - ‎37 đánh giá - ‎US$&nbsp;256,00</div>
									<span class="st">{$clsClassTable->getIntro($pvalTable)|strip_tags|truncate:300}</span></div>
							</div>
						</div>
					</div>
				</div>
                </div>
                <div class="tabboxchild_globaltabs_config" style="display:none">
                    <div class="accordion_in acc_active">
                        <div class="acc_head">
                            <div class="acc_icon_expand"></div>
                            <h2 style="font-size:20px; margin-bottom:10px">{$core->get_Lang('transporttour')}</h2>
                        </div>
                        <div class="acc_content">
                            <form class="mt30" method="post" action="">
                                <table width="100%" class="tbl-grid" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="gridheader"><strong>{$core->get_Lang('index')}</strong></td>
                                        <td class="gridheader"></td>
                                        <td class="gridheader text-left"><strong>{$core->get_Lang('nametranports')}</strong></td>
                                        <td class="gridheader"><strong>{$core->get_Lang('func')}</strong></td>
                                    </tr>
                                    {section name=i loop=$lstTourTransport}
                                    <tr class="{cycle values=" row1,row2 "}">
                                        <td class="index">{$smarty.section.i.iteration}</td>
                                        <td class="index">
                                            {if $clsTourTransport->getImageUrl($lstTourTransport[i].tourtransport_id)}
                                            <img src="{$clsTourTransport->getImageUrl($lstTourTransport[i].tourtransport_id)}" width="40" /> {/if}
                                        </td>
                                        <td>{$clsTourTransport->getTitle($lstTourTransport[i].tourtransport_id)}</td>
                                        <td class="text-center"><input type="checkbox" name="list_transport_id[]" {$lstTourTransport[i].check} value="{$lstTourTransport[i].tourtransport_id}" /></td>
                                    </tr>
                                    {/section}
                                </table>
                                <div class="clearfix"><br /><br /></div>
                                <div class="row-bottom">
                                    <div class="row-buttons">
                                        <div class="clear"></div>
                                        <button type="submit" id="SaveTourStep5" class="btn-update" name="button" value="Update">
                                            <i class="iso-update"></i> {$core->get_Lang('Submit')}
                                        </button>
                                        <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" />
                                        <input type="hidden" name="UpdateStep8" value="UpdateStep8" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {if $_LANG_ID ne 'vn'}
		{if $clsTourStore->checkExist($pvalTable,DEPARTURE)}
        <div class="tabbox departureTab" style="display:none; float:left">
            <div class="row-span-help">{$core->get_Lang('introitinerary')}</div>
            <div class="clearfix"><br /></div>
            <div class="wrap" style="margin-bottom:30px">
                <div class="fl span100">
					<script type="text/javascript" src="{$URL_JS}/MultiDatesPicker/jquery-ui.multidatespicker.js"></script>
					<div class="globaldeparturetabs" id="tabsk">
						<li class="first"><a href="javascript:void(0);" class="current">{$core->get_Lang('Traveller')}</a></li> 
						{if _IS_AGENT eq '1'}
						<li class="agent"><a href="javascript:void(0);" rel="nofollow">{$core->get_Lang('Travel Agent')}</a></li>
						{/if}
					</div>
					<div class="tabs_content" id="lstTabs">
						<div class="contentTab">
							<input style="width:100%; max-width:725px;" type="text" id="multiDate" placeholder="{$core->get_Lang('Click to select multiple days')}" />
							<button type="submit" is_agent=0 class="btn btn-primary clickToAddNewTourStartDate"><i class="icon-ok icon-white"></i> <span>{$core->get_Lang('Add')}</span> </button>
							{literal}
							<script type="text/javascript">
								$("#multiDate").multiDatesPicker({
									numberOfMonths: 3,
									dayNames: $.datepicker.regional["en"].dayNames,
									monthNamesShort: $.datepicker.regional["en"].monthNamesShort,
									monthNames: $.datepicker.regional["en"].monthNames
		
								});
							</script>
							<style type="text/css">
								.ui-state-highlight .ui-state-default {
									background: #743620 !important;
									color: #fff !important;
								}
							</style>
							{/literal}
							 <div id="StartDateHolder" style="border:2px dashed red; padding:15px 10px; float:left; width:100%"></div>
						</div>
						{if _IS_AGENT eq '1'}
						<div class="contentTab" style="display:none">
							<input style="width:100%; max-width:725px;" type="text" id="multiDateAgent" placeholder="{$core->get_Lang('Click to select multiple days')}" />
							<button type="submit" is_agent=1 class="btn btn-primary clickToAddNewTourStartDateAgent"><i class="icon-ok icon-white"></i> <span>{$core->get_Lang('Add')}</span> </button>
							{literal}
							<script type="text/javascript">
								$("#multiDateAgent").multiDatesPicker({
									numberOfMonths: 3,
									dayNames: $.datepicker.regional["en"].dayNames,
									monthNamesShort: $.datepicker.regional["en"].monthNamesShort,
									monthNames: $.datepicker.regional["en"].monthNames
		
								});
							</script>
							<style type="text/css">
								.ui-state-highlight .ui-state-default {
									background: #743620 !important;
									color: #fff !important;
								}
							</style>
							{/literal}
							 <div id="StartDateHolderAgent" style="border:2px dashed red; padding:15px 10px; float:left; width:100%; margin-top:20px"></div>
						</div>
						{/if}
					</div>
                </div>
            </div>
        </div>
		{/if}
        {/if}
		{if $clsTourStore->checkExist($pvalTable,PROMOTION)}
		<div class="tabbox departureTab" style="display:none; float:left">
            <div class="row-span-help">{$core->get_Lang('introitinerary')}</div>
            <div class="clearfix"><br /></div>
            <div class="wrap" style="margin-bottom:30px">
                <div class="fl span100">
					<div class="tabs_content" id="lstTabs">
						<div class="contentTab">
							<a style="vertical-align:middle" href="javascript:void(0);" id="clickToAddDay" class="iso-button-primary fl mb10"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add New</a>
							 <div id="ListHotPromotion" style="border:2px dashed red; padding:15px 10px; float:left; width:100%"></div>
						</div>
					</div>
                </div>
            </div>
        </div>
		{/if}
    </div>
</div>
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
<link rel="stylesheet" href="{$URL_JS}/vietiso_datepicker/css/datepicker.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
<script type="text/javascript">
    var path_ajax_datepicker = '{$URL_JS}/vietiso_datepicker/js';
    var aj_search = 0;
    var tour_id = '{$pvalTable}';
    var $tour_id = '{$pvalTable}';
    var $tour_type_id = '{$tour_type_id}';
    var $listcatID = '{$oneItem.list_cat_id}';
    var $tourgroup_ID = '{$oneItem.tour_group_id}';
    var country = "{$core->get_Lang('country')}";
    var regions = "{$core->get_Lang('regions')}";
    var cities = "{$core->get_Lang('cities')}";
    var area = "{$core->get_Lang('Area')}";
    var attractions = "{$core->get_Lang('attractions')}";
    var continents = "{$core->get_Lang('continents')}";
    var required_country = "{$core->get_Lang('required_country')}";
    var identicaltour = "{$core->get_Lang('Error. Please enter a different name and try again tour')}";
    var existedtour = "{$core->get_Lang('This Tour has existed. Please enter a different name and try again tour')}";
    var required_client = "{$core->get_Lang('This tour is not a client type and age choose to participate. Please choose in the table above')}";
    var $SiteModActive_country = "{$clsConfiguration->getValue('SiteModActive_country')}";
    var $SiteModActive_continent = "{$clsConfiguration->getValue('SiteModActive_continent')}";
    var $SiteActive_region = "{$clsConfiguration->getValue('SiteActive_region')}";
    var $SiteActive_city = "{$clsConfiguration->getValue('SiteActive_city')}";
    var $SiteHasPriceTableTours = "{$clsConfiguration->getValue('SiteHasPriceTableTours')}";
    var $SitePriceTableType_Tours = '{$clsConfiguration->getValue("SitePriceTableType_Tours")}';
    var $SiteHasStartDate_Tours = "{$clsConfiguration->getValue('SiteHasStartDate_Tours')}";
    var $SiteHasExtensionTours = "{$clsConfiguration->getValue('SiteHasExtensionTours')}";
    var $SiteHasGalleryImagesTours = "{$clsConfiguration->getValue('SiteHasGalleryImagesTours')}";
    var $SiteHasDestinationTours = "{$clsConfiguration->getValue('SiteHasDestinationTours')}";
    var $SiteHasItineraryTours = "{$clsConfiguration->getValue('SiteHasItineraryTours')}";
    var $SiteHasHotel_Tours = "{$clsConfiguration->getValue('SiteHasHotel_Tours')}";
    var $SiteHasStore_Tours = "{$clsConfiguration->getValue('SiteHasStore_Tours')}";
    var $SiteHasGroup_Tours = '{$clsConfiguration->getValue("SiteHasGroup_Tours")}';
    var $SiteHasCustomContentField_Tours = '{$clsConfiguration->getValue("SiteHasCustomContentField_Tours")}';
    var $check_mod_continent = "{$core->checkAccess('continent')}";
    var $check_mod_country = "{$core->checkAccess('country')}";
</script>

<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/tour/jquery.tour.js?v={$upd_version}"></script>
{literal}
<style type="text/css">
.avgRever .row-span{width:33.3%;float:left;clear:none}
    .dropdown-toggle .caret {
        margin-top: -4px;
    }
#box_EditPhotosGallery{min-width:240px!important; }
.btn-group .dropdown-toggle .caret{margin-top:-4px !important;margin-left:2px;}
.tabbox .chosen-container-single .chosen-single {
    height: 28px !important;
    line-height: 28px !important;
    border-radius: 0 !important;
    margin-right: 5px !important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	
});
</script>
{/literal}