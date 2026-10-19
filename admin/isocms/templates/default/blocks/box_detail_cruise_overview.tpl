<div class="box_title_trip_code box_page_overview">
    <div class="form_title_and_trip_code">
		<div class="overview_box congratulations">
			<h2>{$core->get_Lang('Congratulations')}!</h2>
			<p class="text">Bây giờ bạn có thể bắt đầu bán trải nghiệm của mình</p>
			<div class="toggle_opt btn_online action_tour">
                <div class="box_status_switch" >
					{if $oneItem.is_online ne 1}
						<span class="txt_status_switch private">{$core->get_Lang('Private')}</span>
					{else}
						<span class="txt_status_switch public">{$core->get_Lang('Public')}</span>
					{/if}
					<label class="switch_public switch" data-clstable="Cruise" data-pkey="{$clsClassTable->pkey}" data-sourse_id="{$pvalTable}">
					  <input type="checkbox" name="is_online" value="1" {if $oneItem.is_online eq 1}checked{/if}>
					  <span class="slider round"></span>
					</label>
				</div>
			</div>
		</div>
		<div class="overview_box tour_info_re infomation_recommendations" id="tour_info_re">
			<h2>{$core->get_Lang('Cruise infomation recommendations')}</h2>
			<p class="text">Đề xuất này là tùy chọn và có thể tăng chất lượng trải nghiệm của bạn.</p>
			<div class="box_content_overview link_caution_up in">
				<ul class="list_link d-flex flex-wrap justify-content-between"></ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="overview_box_2 tour_info_re" id="tour_info_re">
					<h2 class="d-flex justify-content-between">{$core->get_Lang('Cabin')}
						<a class="link_open" data-step="cabin" data-panel="overview" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable}/cabin/cabin"><i class="ico ico-view_link ico-view_link_head"></i></a>
					</h2>
					<div class="body_show">
					{if $listCabin}
						{foreach from=$listCabin item=cabin}
							{assign var=title_cabin value=$clsCruiseCabin->getTitle($cabin.cruise_cabin_id)}
							<div class="box_item_overview">
								<div class="box_image_cabin">
									<a href="javascript:void(0)" class="edit_cabin" 
									data-cabin_id="{$cabin.cruise_cabin_id}" 
									data-cruise_id="{$pvalTable}" 
									title="{$title_cabin}">
									<img src="{$clsCruiseCabin->getImage($cabin.cruise_cabin_id,68,52)}" 
											alt="{$title_cabin}" width="68" height="52"/>
									</a>
								</div>
								<div class="box_name_services"> 
									<p class="txt_name_services">
										<a href="javascript:void(0)" class="edit_cabin" 
										data-cabin_id="{$cabin.cruise_cabin_id}" 
										data-cruise_id="{$pvalTable}" 
										title="{$title_cabin}">{$title_cabin}</a>
									</p> 
									<p class="txt_info">
										{assign var=check_first value=1}
										{if $cabin.cabin_size gt 0}
											{assign var=check_first value=0}
											<span>{$cabin.cabin_size}m<sup>2</sup></span> 
										{/if}
										{if $cabin.bed_size ne ""}
											{if $check_first eq 0}| {/if}
											<span>{$cabin.bed_size}</span> 
											{assign var=check_first value=0}
										{/if}
										{if $cabin.extra_bed eq 1}
											{if $check_first eq 0}| {/if}
											<span>{$core->get_Lang('Extra bed available')}</span> 
										{/if}
									</p> 
								</div>
								<div class="box_statusCabin">
									<a href="javascript:void(0);" class="SiteClickPublic" 
									clsTable="CruiseCabin" pkey="cruise_cabin_id" 
									sourse_id="{$cabin.cruise_cabin_id}" 
									rel="{$cabin.is_online}" 
									title="{$core->get_Lang('Click to change status')}">
										{if $cabin.is_online eq '1'}
											<i class="fa fa-check-circle green"></i>
										{else}
											<i class="fa fa-minus-circle red"></i>
										{/if}
									</a>
								</div>
							</div>
						{/foreach}
					{else}
						<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
					{/if}

					</div>
				</div>
				<div class="overview_box_2 tour_itinerary" id="tour_itinerary">
					<h2 class="headeing d-flex justify-content-between align-items-center">
						<span>{$core->get_Lang('Intinerary')}</span> 
						<a class="link_open" data-step="itinerary" data-panel="itinerary" data-route="{$PCMS_URL}/tour/edit/{$pvalTable}/itinerary/itinerary"><i class="ico ico-view_link ico-view_link_head"></i></a>
					</h2>
					<div class="body_show">
						{if $listCruiseItinerary}
							{foreach from=$listCruiseItinerary item=itinerary}
								{assign var=title_Itinerary value=$clsCruiseItinerary->getNumberDay($itinerary.cruise_itinerary_id)}
								{assign var=city_Itinerary value=$clsCruiseItinerary->getAllCityAround($itinerary.cruise_itinerary_id)}
								<div class="box_item_overview">
									<div class="box_name_services"> 
										<p class="txt_name_services">
											<a href="{$PCMS_URL}/?mod=cruise&act=edit_itinerary&cruise_itinerary_id={$core->encryptID($itinerary.cruise_itinerary_id|default:0)}&cruise_id={$pvalTable|default:0}&fromid={$act|default:''}" 
											title="{$title_Itinerary}">{$title_Itinerary}</a>
										</p> 
										<p class="txt_info">                                        
											{assign var=cityAround value=$clsCruiseItinerary->getAllCityAround($itinerary.cruise_itinerary_id,0,", ")}
											{assign var=meal value=$clsCruiseItinerary->getListMealItineraryDay($itinerary.cruise_itinerary_id)}                                            
											{$cityAround} {if $meal neq ''}{if $cityAround neq ''} | {/if}{$meal}{/if}
										</p> 
									</div>
									<div class="box_statusCabin">
										{assign var=isOnline value=$clsCruiseItinerary->getOneField('is_online', $itinerary.cruise_itinerary_id)}
										<a href="javascript:void(0);" class="SiteClickPublic" 
										clsTable="CruiseItinerary" pkey="cruise_itinerary_id" 
										sourse_id="{$itinerary.cruise_itinerary_id}" 
										rel="{$isOnline}" 
										title="{$core->get_Lang('Click to change status')}">
											{if $isOnline eq '1'}
												<i class="fa fa-check-circle green"></i>
											{else}
												<i class="fa fa-minus-circle red"></i>
											{/if}
										</a>
									</div>
								</div>
							{/foreach}
						{else}
							<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
						{/if}
					</div>
				</div>
				<div class="overview_box_2 tour_itinerary" id="tour_itinerary">
					<h2 class="headeing d-flex justify-content-between align-items-center">
						<span>{$core->get_Lang('reviewcruise')}</span> 
						<a class="link_open" data-step="basic" data-panel="overview" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable}/overview/basic"><i class="ico ico-view_link ico-view_link_head"></i></a>
					</h2>
					<div class="body_show">
						<div class="box_rate_score d-flex justify-content-between align-items-center"> 
							<label for="" class="lbl_rate_score">{$core->get_Lang('Food/Drink')}</label> 
							<div class="box_right_rate d-flex flex-wrap justify-content-between align-items-center"> 
								<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="{$reviewCruise.food_drink}" aria-valuemin="0" aria-valuemax="100" style="width: {$reviewCruise.food_drink}%"></div> </div> 
							<span>{$reviewCruise.food_drink}%</span> 
							</div> 
               			</div>
						<div class="box_rate_score d-flex justify-content-between align-items-center"> 
							<label for="" class="lbl_rate_score">{$core->get_Lang('Cruise quality')}</label> 
							<div class="box_right_rate d-flex flex-wrap justify-content-between align-items-center"> 
								<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="{$reviewCruise.cruise_quality}" aria-valuemin="0" aria-valuemax="100" style="width: {$reviewCruise.cruise_quality}%"></div> </div> 
							<span>{$reviewCruise.cruise_quality}%</span> 
							</div> 
               			</div>
						<div class="box_rate_score d-flex justify-content-between align-items-center"> 
							<label for="" class="lbl_rate_score">{$core->get_Lang('Cabin quality')}</label> 
							<div class="box_right_rate d-flex flex-wrap justify-content-between align-items-center"> 
								<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="{$reviewCruise.cabin_quality}" aria-valuemin="0" aria-valuemax="100" style="width: {$reviewCruise.cabin_quality}%"></div> </div> 
							<span>{$reviewCruise.cabin_quality}%</span> 
							</div> 
               			</div>
						<div class="box_rate_score d-flex justify-content-between align-items-center"> 
							<label for="" class="lbl_rate_score">{$core->get_Lang('Staff quality')}</label> 
							<div class="box_right_rate d-flex flex-wrap justify-content-between align-items-center"> 
								<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="{$reviewCruise.staff_quality}" aria-valuemin="0" aria-valuemax="100" style="width: {$reviewCruise.staff_quality}%"></div> </div> 
							<span>{$reviewCruise.staff_quality}%</span> 
							</div> 
               			</div>
						<div class="box_rate_score d-flex justify-content-between align-items-center"> 
							<label for="" class="lbl_rate_score">{$core->get_Lang('Entertainment')}</label> 
							<div class="box_right_rate d-flex flex-wrap justify-content-between align-items-center"> 
								<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="{$reviewCruise.entertainment}" aria-valuemin="0" aria-valuemax="100" style="width: {$reviewCruise.entertainment}%"></div> </div> 
							<span>{$reviewCruise.entertainment}%</span> 
							</div> 
               			</div>
						<div class="box_rate_score d-flex justify-content-between align-items-center"> 
							<label for="" class="lbl_rate_score">{$core->get_Lang('Worthy')}</label> 
							<div class="box_right_rate d-flex flex-wrap justify-content-between align-items-center"> 
								<div class="progress"> <div class="progress-bar" role="progressbar" aria-valuenow="{$reviewCruise.worth_the_money}" aria-valuemin="0" aria-valuemax="100" style="width: {$reviewCruise.worth_the_money}%"></div> </div> 
							<span>{$reviewCruise.worth_the_money}%</span> 
							</div> 
               			</div>
                	</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="overview_box_2 tour_info_re" id="tour_info_re">
					<h2 class="title_head_dropdown d-flex justify-content-between"><span>{$core->get_Lang('Image')} - {$core->get_Lang('Video')}</span>
					<a data-toggle="collapse" data-parent="" href="#image_video"><i class="fa fa-angle-up" aria-hidden="true"></i></a></h2>
					
					<div class="body_show panel-collapse collapse in" id="image_video" aria-expanded="true">
						<div class="box-item">
							<h3 class="box-title d-flex justify-content-between align-items-center">
								<span>{$core->get_Lang('Image cover')}</span>
								<a class="link_open" data-panel="overview" data-step="image" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable}/overview/image">
									<i class="ico ico-view_link"></i>
								</a>
							</h3>
							{if $oneItem.image}
							<div class="photo">
								<img src="{$clsClassTable->getImage($oneItem.cruise_id,253,168)}" alt="{$clsTour->getTitle($oneItem.cruise_id)}" width="253" height="168">
							</div>
							{else}
							<p class="text">{$core->get_Lang('Cannot display images')}</p>
							{/if}
						</div>
						<div class="box-item">
							<h3 class="box-title d-flex justify-content-between align-items-center">
								<span>{$core->get_Lang('File cruise')}</span>
								<a class="link_open" data-panel="overview" data-step="image" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable|default:0}/overview/image">
									<i class="ico ico-view_link"></i>
								</a>
							</h3>
							{if isset($oneItem.file_programme) && $oneItem.file_programme ne '' }
							<p class="text">
								<a href="{$DOMAIN_NAME}{$oneItem.file_programme}" title="{$file_name}" download>{$file_name}</a>
							</ul>
							{else}
							<p class="text">{$core->get_Lang('No File selected')}</p>
							{/if}
						</div>
						<div class="box-item">
							<h3 class="box-title d-flex justify-content-between align-items-center">
								<span>{$core->get_Lang('Gallery')}</span>
								<a class="link_open" data-panel="libraryimage" data-step="libraryimage" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable|default:0}/libraryimage/libraryimage">
									<i class="ico ico-view_link"></i>
								</a>
							</h3>
							<div id="holder_gallery" class="list-unstyled gallery"></div>
						</div>
                        <div class="box-item">
							<h3 class="box-title d-flex justify-content-between align-items-center">
								<span>{$core->get_Lang('Videos')}</span>
								<a class="link_open" data-panel="video" data-step="video" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable|default:0}/video/video">
									<i class="ico ico-view_link"></i>
								</a>
							</h3>
							<p class="text">{$core->get_Lang('Cannot display video')}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="overview_box_2 description_tour" id="description_tour">
					<h2 class="title_head_dropdown d-flex justify-content-between"><span>{$core->get_Lang('Information/Description')}</span>
					<a data-toggle="collapse" data-parent="" href="#InformationDescription"><i class="fa fa-angle-up" aria-hidden="true"></i></a></h2>
					
					<div class="body_show panel-collapse collapse in" id="InformationDescription" aria-expanded="true">
						<div class="panel-group" id="description">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title d-flex justify-content-between align-items-center">
										<a {if $oneItem.about ne ''}class="success"{/if} data-toggle="collapse" data-parent="#description" href="#about">{$core->get_Lang('About')}</a>
										<a class="link_open" data-panel="overview" data-step="about" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable|default:0}/overview/about"><i class="ico ico-view_link"></i></a>
									</h4>
								</div>
								<div class="panel-collapse collapse in" id="about" aria-expanded="true">
									<div class="panel-body">
										{if $oneItem.about}
											{$oneItem.about|html_entity_decode}
										{else}
											<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
										{/if}
									</div>
								</div>
							</div>
							{*<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title d-flex justify-content-between align-items-center">
										<a class="collapsed {if $oneItem.thingAbout ne ''}success{/if}" data-toggle="collapse" data-parent="#description" href="#thingAbout">{$core->get_Lang('Things about')}</a>
										<a class="link_open" data-panel="overview" data-step="thingAbout" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable|default:0}/overview/thingAbout"><i class="ico ico-view_link"></i></a>
									</h4>
								</div>
								<div class="panel-collapse collapse" id="thingAbout" aria-expanded="true">
									<div class="panel-body">
										{if $oneItem.thingAbout}
											{$oneItem.thingAbout|html_entity_decode}
										{else}
											<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
										{/if}
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title d-flex justify-content-between align-items-center">
										<a class="collapsed {if $oneItem.important_notes ne ''}success{/if}" data-toggle="collapse" data-parent="#description" href="#importantNotes">{$core->get_Lang('Important Notes')}</a>
										<a class="link_open" data-panel="overview" data-step="importantNotes" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable|default:0}/overview/importantNotes"><i class="ico ico-view_link"></i></a>
									</h4>
								</div>
								<div class="panel-collapse collapse" id="importantNotes" aria-expanded="true">
									<div class="panel-body">
										{if $oneItem.important_notes}
											{$oneItem.important_notes|html_entity_decode}
										{else}
											<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
										{/if}
									</div>
								</div>
							</div>*}
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title d-flex justify-content-between align-items-center">
										<a class="collapsed {if $oneItem.inclusion ne ''}success{/if}" data-toggle="collapse" data-parent="#description" href="#inclusion">{$core->get_Lang('Inclusions')}</a>
										<a class="link_open" data-panel="overview" data-step="inclusion" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable|default:0}/overview/inclusion"><i class="ico ico-view_link"></i></a>
									</h4>
								</div>
								<div class="panel-collapse collapse" id="inclusion" aria-expanded="false">
									<div class="panel-body">
										{if $oneItem.inclusion}
											{$oneItem.inclusion|html_entity_decode}
										{else}
											<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
										{/if}
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title d-flex justify-content-between align-items-center">
										<a class="collapsed {if $oneItem.cruise_policy ne ''}success{/if}" data-toggle="collapse" data-parent="#description" href="#cruisePolicy">{$core->get_Lang('Cruise Policy')}</a>
										<a class="link_open" data-panel="overview" data-step="cruisePolicy" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable|default:0}/overview/cruisePolicy"><i class="ico ico-view_link"></i></a>
									</h4>
								</div>
								<div class="panel-collapse collapse" id="cruisePolicy" aria-expanded="false">
									<div class="panel-body">
										{if $oneItem.cruise_policy}
											{$oneItem.cruise_policy|html_entity_decode}
										{else}
											<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
										{/if}
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title d-flex justify-content-between align-items-center">
										<a class="collapsed {if $oneItem.exclusion ne ''}success{/if}" data-toggle="collapse" data-parent="#description" href="#exclusion">{$core->get_Lang('Exclusion')}</a>
										<a class="link_open" data-panel="overview" data-step="exclusion" data-route="{$PCMS_URL}/cruise/insert/{$pvalTable|default:0}/overview/exclusion"><i class="ico ico-view_link"></i></a>
									</h4>
								</div>
								<div class="panel-collapse collapse" id="exclusion" aria-expanded="false">
									<div class="panel-body">
										{if $oneItem.exclusion}
											{$oneItem.exclusion|html_entity_decode}
										{else}
											<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
										{/if}
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title d-flex justify-content-between align-items-center">
										<a class="collapsed {if $oneItem.booking_policy ne ''}success{/if}" data-toggle="collapse" data-parent="#description" href="#bookingPolicy">{$core->get_Lang('Booking Policy')}</a>
										<a class="link_open" data-panel="overview" data-step="bookingPolicy" data-route="{$PCMS_URL}/admin/cruise/insert/{$pvalTable|default:0}/overview/bookingPolicy"><i class="ico ico-view_link"></i></a>
									</h4>
								</div>
								<div class="panel-collapse collapse" id="bookingPolicy" aria-expanded="false">
									<div class="panel-body">
										{if $oneItem.booking_policy}
											{$oneItem.booking_policy|html_entity_decode}
										{else}
											<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
										{/if}
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title d-flex justify-content-between align-items-center">
										<a class="collapsed {if $oneItem.child_policy ne ''}success{/if}" data-toggle="collapse" data-parent="#description" href="#childPolicy">{$core->get_Lang('Child Policy')}</a>
										<a class="link_open" data-panel="overview" data-step="childPolicy" data-route="{$PCMS}/admin/cruise/insert/{$pvalTable|default:0}/overview/childPolicy"><i class="ico ico-view_link"></i></a>
									</h4>
								</div>
								<div class="panel-collapse collapse" id="childPolicy" aria-expanded="false">
									<div class="panel-body">
										{if $oneItem.child_policy}
											{$oneItem.child_policy|html_entity_decode}
										{else}
											<p class="text_caution_option text_bold m-0 t_red">{$core->get_Lang('No data')}</p>
										{/if}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">
    var pcsm_ovv = '{$PCMS}';
	var pvalTable_ovv = {$pvalTable};
	var list_check_target = {$list_check_target};
	var txtConfigPrice = '{$core->get_Lang("Config Price")}';
</script>
{literal}
<script type="text/javascript">
    $(function () {
		loadListDestination({/literal}{$pvalTable}{literal},"overview");
        $("#tour_info_re").hide();
        jQuery.each( list_check_target, function( i, val ) {
			
            if(val['status'] == 1){}
			else if(val['status'] == 0){
				if(val['target'] == 'promotion'){
					$(".link_caution_up .list_link").append('<li><a href="'+pcsm_ovv+'/admin/?mod=discount" data-type="promotion">'+val['name']+' <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>');
				}else{
					if(val['panel'] == 'configprice'){
						$(".link_caution_up .list_link").append('<li><a href="'+pcsm_ovv+'/admin/cruise/insert/'+pvalTable_ovv+'/'+val['panel']+'/'+val['key']+'">'+txtConfigPrice+": "+val['name']+' <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>');
					}else{
						$(".link_caution_up .list_link").append('<li><a href="'+pcsm_ovv+'/admin/cruise/insert/'+pvalTable_ovv+'/'+val['panel']+'/'+val['key']+'">'+val['name']+' <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>');
					}
					
				}
                
                $("#tour_info_re").show();
            }else{
                $("#tour_info_re").hide();
            }
        });
        $(document).on('click', '.extend', function (ev) {
            var _this = $(this);
            _this.addClass('unextend').removeClass('extend').find('.fa-plus').addClass('fa-minus').removeClass('fa-plus');
            _this.closest('.box_notice').find('.box_title_action').addClass('open');
            _this.closest('.box_notice').find('.box_content_overview').addClass('in');
        });
        $(document).on('click', '.unextend', function (ev) {
            var _this = $(this);
            _this.addClass('extend').removeClass('unextend').find('.fa-minus').addClass('fa-plus').removeClass('fa-minus');
            _this.closest('.box_notice').find('.box_title_action').removeClass('open');
            _this.closest('.box_notice').find('.box_content_overview').removeClass('in');
        });
		loadGallery(pvalTable_ovv, {"clsTable":"CruiseImage"});
    });
	function loadGallery($table_id, options){
		var $_adata = options || {};
		$_adata['tp'] = 'L';
		$_adata['table_id'] = table_id;
		$.post(path_ajax_script + '/index.php?mod=home&act=ajOpenGallery', $_adata, function(html){
			$('#holder_gallery').html(html);
		});
	}

</script>
{/literal}