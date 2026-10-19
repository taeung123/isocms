<link rel="stylesheet" type="text/css" media="screen" href="{$URL_CSS}/tour_exhautive.css?v={$upd_version}">
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/tour/insert/{$tour_id}/itinerary/itinerary" title="{$core->get_Lang('Tour Itinerary')}">{$core->get_Lang('Tour Itinerary')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$core->get_Lang('edit')}">{$core->get_Lang('edit')} #{$pvalTable}</a>
    <!-- Back-->
    <a href="{$PCMS_URL}/tour/insert/{$tour_id}/itinerary/itinerary" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2 style="font-size:19px;">{$core->get_Lang('Edit')}: {$clsClassTable->getTitle($pvalTable)}</h2>
    </div>
    <div class="clearfix"></div>
    <div id="tab_content" style="width:100%; float: left">
        <div class="tabbox">
            <form id="frmEditTour" method="post" action="" enctype="multipart/form-data" class="validate-form">
                <input type="hidden" id="hid_tour_id" name="hid_tour_id" value="{$pvalTable}" />

                <div class="wrap">
                    {*<div class="fl full_width_767">
                        <div class="photobox mb10">
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
                        <h3 class="small text-center max_width_210">{$core->get_Lang('Image Size')} (WxH=204x134)</h3>
						<div class="wrap mt10 boxShowImages">
							<p class="text-center">
								<label>
									<input type="radio" class="margin_0" name="is_show_image" value="0" checked="checked" /> OFF
								</label>
								<label>
									<input type="radio" class="margin_0" name="is_show_image" value="1" {if $oneItem.is_show_image eq '1'}checked="checked"{/if}/> ON
								</label>
							</p>
						</div>
                    </div>*}
                    <div class="fr full_width_767">
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Name')} <span class="color_r">*</span></strong></div>
                            <div class="fieldarea">
                                <input class="text_32 full-width border_aaa bold title_capitalize required" id="title" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Meals')} <input type="checkbox" rel="fa_ge" id="all_check"></strong></div>
                            <div class="fieldarea">
								{assign var=ListMeal value=$clsTour->getListMeal()}
                               {foreach from=$ListMeal item=meal name=meal}
								<label style="margin-right:5px;"><input class="fa_ge" type="checkbox" {if $clsClassTable->checkMealExist($meal.meal,$pvalTable)}checked="checked"{/if} name="meal[]" value="{$meal.meal}"> {$meal}</label>
								{/foreach}
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Transport')} <input type="checkbox" rel="fa_tr" id="all_check"></strong></div>
                            <div class="fieldarea">
								{assign var=listTransport value=$clsTour->getListTransport()}
                              	{section name=i loop=$listTransport}
								<label style="margin-right:5px;"><input class="fa_tr" type="checkbox" {if $clsClassTable->checkTransportExist($listTransport[i].transport_id,$pvalTable)}checked="checked"{/if} name="transport[]" value="{$listTransport[i].transport_id}"> {$clsTransport->getTitle($listTransport[i].transport_id)}</label>
								{/section}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"><br /></div>
				<div id="v-nav">
					<ul>
						<li class="tabchildcol first current"><a href="javascript:void(0);">{$core->get_Lang('Itinerary')}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);">{$core->get_Lang('Condition')}</strong></a> <span class="color_r">*</span></li>
					</ul>
					<div class="tab-content" style="display: block;">
						{$clsForm->ShowInput('content')}
					</div>
					
					<div class="tab-content" style="display: none;">
						{$clsForm->ShowInput('intro')}
					</div>
				</div>
				{if _IS_DEPARTURE eq 1}
					{if $clsTourStore->checkExist($tour_id,DEPARTURE)}
					<div class="box_title_trip_code">
						<h2 class="title_box p-b-30">{$core->get_Lang('Price table')}</h2>
						<div class="form_option_tour">
							<div class="inpt_tour p-b-30">
								<div class="wrap" style="margin-bottom:30px;margin-top:30px">
									<div class="fl span100">
										<script type="text/javascript" src="{$URL_JS}/MultiDatesPicker/jquery-ui.multidatespicker.js"></script>
										<div class="tabs_content" id="lstTabs">
											<div class="contentTab">
												<input class="text_32 full-width border_aaa" style="width:100%; max-width:692px;" type="text" id="multiDate" placeholder="{$core->get_Lang('Click to select multiple days')}" />
												<button type="submit" is_agent=0 class="btn btn-primary clickToAddNewTourGroupStartDate"><i class="icon-ok icon-white"></i> <span>{$core->get_Lang('Add')}</span> </button>
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
												<div id="GroupStartDateHolder"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					{literal}
					<script type="text/javascript">
						$(document).ready(function(){
							loadListPriceTourGroupStartDate(tour_itinerary_id);
						});
					</script>
					{/literal}
					{else}
					<div class="box_title_trip_code">
						<h2 class="title_box p-b-30">{$core->get_Lang('Price table')}</h2>
						<div class="form_option_tour">
							<div class="inpt_tour p-b-30">
								<div id="TourPriceGroupNoDeparture"></div>
								<div class="row-span">
									<div class="fieldlabel" style="width:100px">{$core->get_Lang('Deposit')}</div>
									<div class="fieldarea" style="width:auto; float:left">
										<input type="text" class="text fontLarge deposit_tour_group" tour_id="{$tour_id}" value="{$clsTour->getOneField('deposit',$tour_id)}"/>(%)
									</div>
								</div>
							</div>
						</div>
					</div>
					{literal}
					<script type="text/javascript">
						$(document).ready(function(){
							loadTourPriceGroupNoDeparture(tour_itinerary_id);
						});
						$(document).on('change', '.deposit_tour_group', function(ev){
							var $_this = $(this);
							$.ajax({
								type: "POST",
								url: path_ajax_script+"/?mod="+mod+"&act=ajLoadTourPriceGroup&lang="+LANG_ID,
								data:{
									'tour_id':$_this.attr("tour_id"),
									"deposit":$_this.val(),
									'tp' : 'Save_Deposit'
								},
								dataType: "html",
								success: function(html){
									var htm = html.split('|||');
									$_this.val(htm[1]);
									vietiso_loading(2);
								}
							});
						});
					</script>
					{/literal}
				{/if}
			{else}
				<div class="box_title_trip_code">
					<h2 class="title_box p-b-30">{$core->get_Lang('Price table')}</h2>
					<div class="form_option_tour">
						<div class="inpt_tour p-b-30">
							<div class="all_grp_size">
								<div id="TourPriceGroupNoDeparture"></div>
								<div class="row-span">
									<div class="fieldlabel" style="width:100px">{$core->get_Lang('Deposit')}</div>
									<div class="fieldarea" style="width:auto; float:left">
										<input type="text" class="text fontLarge deposit_tour_group" tour_id="{$tour_id}" value="{$clsTour->getOneField('deposit',$tour_id)}"/>(%)
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				{literal}
					<script type="text/javascript">
						$(".chosen-select").chosen({
							max_selected_options: 10,
							width: '100%'
						});
			
						$(document).ready(function(){
			
							loadTourPriceGroupNoDeparture(tour_itinerary_id);
						});
						$(document).on('change', '.deposit_tour_group', function(ev){
							var $_this = $(this);
							$.ajax({
								type: "POST",
								url: path_ajax_script+"/?mod="+mod+"&act=ajLoadTourPriceGroup&lang="+LANG_ID,
								data:{
									'tour_id':$_this.attr("tour_id"),
									'tour_itinerary_id':$_this.attr("tour_itinerary_id"),
									"deposit":$_this.val(),
									'tp' : 'Save_Deposit'
								},
								dataType: "html",
								success: function(html){
									var htm = html.split('|||');
									$_this.val(htm[1]);
									vietiso_loading(2);
								}
							});
						});
					</script>
				{/literal}
			{/if}
			<script>
				var is_depart = '{$_IS_DEPARTURE}';
				var is_check_depart = '{$clsTourStore->checkExist($pvalTable,DEPARTURE)}';
			</script>
                <div class="clearfix"></div>
				<fieldset class="submit-buttons">
					 {$saveBtn}{if $pvalTable}{$saveList}{/if}
					<input value="Update" name="submit" type="hidden">
				</fieldset>
            </form>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    var path_ajax_datepicker = '{$URL_JS}/vietiso_datepicker/js?v={$upd_version}';
    var aj_search = 0;
	var tour_itinerary_id = '{$pvalTable}';
    var tour_id = '{$tour_id}';
    var $tour_id = '{$tour_id}';
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
    var $SiteHasCategoryGroup_Tours = '{$clsConfiguration->getValue("SiteHasCategoryGroup_Tours")}';
    var $SiteHasCustomContentField_Tours = '{$clsConfiguration->getValue("SiteHasCustomContentField_Tours")}';
    var $check_mod_continent = "{$core->checkAccess('continent')}";
    var $check_mod_country = "{$core->checkAccess('country')}";
</script>
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/tour_exhautive/jquery.tourexhautive.js?v={$upd_version}"></script>
{literal}

<style type="text/css">
	.avgRever .row-span{width:33.3%;float:left;clear:none}
	.dropdown-toggle .caret {
		margin-top: -4px;
	}
	#box_EditPhotosGallery{min-width:240px!important; }
	.tabbox .chosen-container-single .chosen-single {
		height: 32px !important;
		line-height: 32px !important;
		border-radius: 0 !important;
		margin-right: 5px !important;
	}
	.tabbox .btn-add {
		height: 32px !important;
		line-height: 32px !important;
	}

	#v-nav >ul >li {
		width: 100%;
	}
	#tab_content .col-right{width: calc(100% - 230px)}
	.row-span .fieldlabel{width: 180px;padding:0px 10px;float:left;height:32px;line-height:32px;text-align:left;font-size:13px;}
	.row-span .fieldarea{width: calc(100% - 180px);float:right;}
</style>
{/literal}
