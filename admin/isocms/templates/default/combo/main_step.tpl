<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex full-height">
			<div class="col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">
						{if $currentstep=='name'}
						<h3 class="title_box">{$core->get_Lang('Name and Combo code')}</h3>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Title')} <span class="required_red">*</span></label>
							<input class="input_text_form input-title" data-table_id="{$pvalTable}" type="text" id="title" name="title" value="{$clsClassTable->getTitle($pvalTable)}" placeholder="{$core->get_Lang('New title')}">
						</div>
						<div class="inpt_tour">
							<label for="table_code">{$core->get_Lang('Combo code')} <span class="required_red">*</span></label>
							<p class="not_text_tour">{$core->get_Lang('Add your combo code')}</p>
							<input class="input_text_form input_code span50" data-table_id="{$pvalTable}" type="text" id="table_code" name="table_code" value="{$clsClassTable->getCode($pvalTable)}" placeholder="{$core->get_Lang('Combo Code')}">
						</div>
						{elseif $currentstep=='location'}
						<h3 class="title_box">{$core->get_Lang('Location')}</h3>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Location')} <span class="required_red">*</span></label>
							<div class="fieldarea">
                                {if $clsISO->getCheckActiveModulePackage($package_id,'continent','default','default') && $core->checkAccess('continent')}
								<select class="slb required" style="font-size:14px;width:150px !important" name="iso-continent_id">
									{$clsContinent->makeSelectboxOption($continent_id)}
								</select>
								<select class="slb required" name="iso-country_id" id="slb_Country" style="font-size:14px;min-width:120px">                                	
									<option value="0">-- {$core->get_Lang('selectcountry')} --</option>
								</select>
								{literal}
								<script type="text/javascript">
									$(function(){
										loadCountry(continent_id,country_id);
									});
								</script>
								{/literal}
                                {else}
								<select class="slb" name="iso-country_id" id="slb_Country" style="font-size:14px;min-width:120px">
									{$clsCountry->makeSelectboxOption($country_id)}
								</select>
                                {/if}
                                {if $clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}
								<select class="slb" name="iso-region_id" id="slb_Region" style="font-size:14px;min-width:120px"> 
									{$clsRegion->makeSelectboxOption($country_id,$region_id)}
								</select>
                                {/if}
                                <select class="slb required" name="iso-city_id" id="slb_City" style="font-size:14px;min-width:120px"> 
                                    {$clsCity->makeSelectboxOption($city_id,$country_id)}
                                </select>
                            </div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Address')} <span class="required_red">*</span></label>
							<input class="text mr10 required" name="iso-address" value="{$clsClassTable->getAddress($pvalTable)}" maxlength="255" type="text" style="width:auto; min-width:100%; max-width:500px;" />
						</div>
						{elseif $currentstep=='image'}
						{$core->getBlock('box_detail_image')}
						{elseif $currentstep=='gallery'}
						{$core->getBlock('box_detail_image-gallery')}
						{elseif $currentstep=='hotel'}
						{$core->getBlock('box_detail_combo_hotel_destination')}
						{elseif $currentstep=='addon_service'}
						{$core->getBlock('box_detail_addon_service')}
						{elseif $currentstep=='combo_related'}
						{$core->getBlock('box_detail_related')}
						{elseif $currentstep=='price'}
						{$core->getBlock('box_detail_combo_price-table')}
						{elseif $currentstep=='time_apply'}
						<h3 class="title_box">{$core->get_Lang('Thời gian hiệu lực')}</h3>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Booking Date')}</label>
							<p class="text">{$core->get_Lang('Thời gian khách du lịch có thể booking')}</p>
							<div class="form-input-date">
								<i class="ico ico-calendar"></i>
								<input type="text" class="from_date" id="booking_date_from" name="booking_date_from" palceholder="Từ ngày" value="{$booking_date_from|date_format:"%d/%m/%Y"}"/>
								<input type="text" class="to_date" id="booking_date_to" name="booking_date_to" palceholder="Đến ngày" value="{$booking_date_to|date_format:"%d/%m/%Y"}"/>
							</div>
						</div>
						<div class="inpt_tour">
							<label for="title">{$core->get_Lang('Khởi hành từ - đến')}</label>
							<p class="text">{$core->get_Lang('Khởi hành trong khoảng thời gian nhất định')}</p>
							<div class="form-input-date">
								<i class="ico ico-calendar"></i>
								<input type="text" class="from_date" id="travel_date_from" name="travel_date_from" palceholder="Từ ngày" value="{$travel_date_from|date_format:"%d/%m/%Y"}"/>
								<input type="text" class="to_date" id="travel_date_to" name="travel_date_to" palceholder="Đến ngày" value="{$travel_date_to|date_format:"%d/%m/%Y"}"/>
							</div>
						</div>
						{literal}
						<script>

						  $(function() {
							$( "#booking_date_from" ).datepicker({               
							  dateFormat: 'dd/mm/yy',
							  numberOfMonths: 2,
							  autoclose: true,
							 minDate: "+0D", maxDate: "+1Y",
									
							  onClose: function( dateStr ) {
								  var date = $(this).datepicker('getDate'); 
									if(date){ 
										date.setDate(date.getDate() + 1); 
									} 
								$( "#booking_date_to" ).datepicker('option', {minDate: date}).datepicker('setDate', date);
								$( "#booking_date_to" ).datepicker( "show" );
							  }
							});
							$( "#booking_date_to" ).datepicker({               
							  dateFormat: 'dd/mm/yy',
							  numberOfMonths: 2,
							  minDate: new Date(), maxDate: "+1Y",
							  autoclose: true,
							});
							$( "#travel_date_from" ).datepicker({               
								  dateFormat: 'dd/mm/yy',
								  numberOfMonths: 2,
								  autoclose: true,
								  minDate: "+0D", maxDate: "+1Y",
								  onClose: function( dateStr ) {
									   var date = $(this).datepicker('getDate'); 
									if(date){ 
										date.setDate(date.getDate() + 1); 
									} 
									$( "#travel_date_to" ).datepicker('option', {minDate: date}).datepicker('setDate', date);
									$( "#travel_date_to" ).datepicker( "show" );
								  }
								});
								$( "#travel_date_to" ).datepicker({               
								  dateFormat: 'dd/mm/yy',
								  numberOfMonths: 2,
								  minDate: new Date(), maxDate: "+1Y",
								  autoclose: true,
							});
						  });
						</script>
						{/literal}
						{elseif $currentstep=='seo'}
						{$core->getBlock('box_detail_seotool')}
						{elseif $currentstep=='overview'}
						<h3 class="title_box mb05">{$core->get_Lang('Overview hotel')}</h3>
						<p class="intro_box mb40">{$core->get_Lang('introoverviewhotel')}</p>
						<div class="inpt_tour">
							<textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor" data-column="{$currentstep}" id="textarea_intro_editor_overview_{$now}" cols="255" rows="2">{$oneItem.overview}</textarea>
						</div>
						{elseif $currentstep=='itinerary'}
						
						<h3 class="title_box mb05">{$core->get_Lang('Combo Itinerary')}</h3>
						<p class="intro_box mb40">{$core->get_Lang('introcomboitinerary')}</p>
						<div class="inpt_tour">
							<div class="form-group pick_duration">
								<span class="minus">-</span>
								<input type="text" id="rooms" value="{$oneItem.number_day}" class="input_number find_select" name="number_day">
								<span class="plus">+</span>
							</div>
							<label class="label_duration ">{$core->get_Lang('Days')}</label>
							<div class="form-group pick_duration pick_night">
								<span class="minus">-</span>
								<input type="text" id="rooms" value="{$oneItem.number_night}" class="input_number find_select" name="number_night">
								<span class="plus">+</span>
							</div>
							<label class="label_duration">{$core->get_Lang('Nights')}</label>
						</div>
						{literal}
						<script>
							$(document).ready(function() {
								$('.minus').click(function () {
									var $input = $(this).parent().find('input');
									var count = parseInt($input.val()) - 1;
									count = count < 1 ? 0 : count;
									$input.val(count);
									$input.change();
									return false;
								});
								$('.plus').click(function () {
									var $input = $(this).parent().find('input');
									$input.val(parseInt($input.val()) + 1);
									$input.change();
									return false;
								});
							});
						</script>
						{/literal}
						
						
						{*{$core->getBlock('box_detail_combo_itinerary')}*}
						{elseif $currentstep=='highlight'}
						<h3 class="title_box mb05">{$core->get_Lang('Highlight')}</h3>
						<p class="intro_box mb40">{$core->get_Lang('introhotelhighlight')}</p>
						<div class="inpt_tour">
							<textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor" data-column="{$currentstep}" id="textarea_intro_editor_highlight_{$now}" cols="255" rows="2">{$oneItem.highlight}</textarea>
						</div>
						{elseif $currentstep=='inclusion'}
						<h3 class="title_box mb05">{$core->get_Lang('Inclusion Combo')}</h3>
						<p class="intro_box mb40">{$core->get_Lang('introinclusioncombo')}</p>
						<div class="inpt_tour">
							<textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor" data-column="{$currentstep}" id="textarea_intro_editor_inclusion_{$now}" cols="255" rows="2">{$oneItem.inclusion}</textarea>
						</div>
						{elseif $currentstep=='note'}
						<h3 class="title_box mb05">{$core->get_Lang('Special notes')}</h3>
						<p class="intro_box mb40">{$core->get_Lang('intronotecombo')}</p>
						<div class="inpt_tour">
							<textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor" data-column="{$currentstep}" id="textarea_intro_editor_note_{$now}" cols="255" rows="2">{$oneItem.note}</textarea>
						</div>
						{elseif $currentstep=='condition_apply'}
						<h3 class="title_box mb05">{$core->get_Lang('Conditions apply')}</h3>
						<p class="intro_box mb40">{$core->get_Lang('introcondition_apply_combo')}</p>
						<div class="inpt_tour">
							<textarea style="width:100%" table_id="{$pvalTable}" class="textarea_intro_editor" data-column="{$currentstep}" id="textarea_intro_editor_condition_apply_{$now}" cols="255" rows="2">{$oneItem.condition_apply}</textarea>
						</div>
						{else}
						{/if}
						<div class="btn_save_titile_table_code">
							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$arrStep[$step].key}" data-prevstep="{$prevstep}" class="back_step js_save_back">{$core->get_Lang('Back')}</a>

							<a data-table_id="{$pvalTable}" data-panel="{$arrStep[$step].panel}" data-currentstep="{$currentstep}" data-next_step="{$nextstep}" class="js_save_continue">{$core->get_Lang('Save &amp; Continue')}</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="instruction_fill_data_box">
					<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
					{if $currentstep=='name'}
					<div class="content_box">
						<p class="mb20">Tiêu đề: Là phần được hiển thị ở đầu combo, hãy nhập một tiêu đề thu hút và hấp dẫn nhiều du khách quan tâm.</p>
						<p class="mb0">Mã combo: Nhập mã combo để phân biệt với các combo khác</p>
					</div>
					{elseif $currentstep=='itinerary'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Combo Itinerary')}: {$core->get_Lang('instructioncomboitinerary')}</p>
					</div>
					{elseif $currentstep=='image'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Image cover')}: {$core->get_Lang('instructioncomboimagecover')}</p>
					</div>
					{elseif $currentstep=='highlight'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Highlight')}: {$core->get_Lang('instructioncombohighlight')}</p>
					</div>
					{elseif $currentstep=='inclusion'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Inclusion Combo')}: {$core->get_Lang('instructioncomboinclusion')}</p>
					</div>
					{elseif $currentstep=='note'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Special notes')}: {$core->get_Lang('instructioncombonote')}</p>
					</div>
					{elseif $currentstep=='condition_apply'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Conditions apply')}: {$core->get_Lang('instructioncomboconditionapply')}</p>
					</div>
					{elseif $currentstep=='time_apply'}
					<div class="content_box">
						<p class="mb20">{$core->get_Lang('Booking Date')}: {$core->get_Lang('instructioncombobookingdate')}</p>
						<p class="mb0">{$core->get_Lang('Khởi hành từ - đến')}: {$core->get_Lang('instructioncombotraveldate')}</p>
					</div>
					{elseif $currentstep=='hotel'}
					<div class="content_box">
						<p class="mb20">{$core->get_Lang('Destination')}: {$core->get_Lang('instructioncombodestination')}</p>
						<p class="mb0">{$core->get_Lang('Hotel')}: {$core->get_Lang('instructioncombohotel')}</p>
					</div>
					{elseif $currentstep=='addon_service'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Addon Services')}: {$core->get_Lang('instructioncomboaddonservice')}</p>
					</div>
					{elseif $currentstep=='combo_related'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Combo related')}: {$core->get_Lang('instructioncomborelated')}</p>
					</div>
					{elseif $currentstep=='gallery'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Gallery')}: {$core->get_Lang('instructioncombogallery')}</p>
					</div>
					{elseif $currentstep=='price'}
					<div class="content_box">
						<p class="mb0">{$core->get_Lang('Price Tabel')}: {$core->get_Lang('instructioncombopricetable')}</p>
					</div>
					{elseif $currentstep=='seo'}
					<div class="content_box">
						<p class="mb20">{$core->get_Lang('Meta Title')}: {$core->get_Lang('instructionmetatitle')}</p>
						<p class="mb20">{$core->get_Lang('Meta Description')}: {$core->get_Lang('instructionmetadescription')}</p>
						<p class="mb0">{$core->get_Lang('Image Share Social')}: {$core->get_Lang('instructionmetaimage')}</p>
					</div>
					{else}
					
					{/if}
				</div>
			</div>
		</div>
	</div>
</form>
{literal}
<script>
if($('.textarea_intro_editor').length > 0){
	$('.textarea_intro_editor').each(function(){
		var $_this = $(this);
		var $editorID = $_this.attr('id');
		$('#'+$editorID).isoTextArea();
	});
}
</script>
{/literal}