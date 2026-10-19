<div class="box_title_trip_code">
	<div class="row d-flex full-height">
		<div class="col-md-9">
			<div class="fill_data_box">
				<h3 class="title_box mb10">{$core->get_Lang('Duration Tour')}</h3>
				<p class="intro_box mb40">{$core->get_Lang('DurationTour_Notes')}</p>
				<div class="form_option_tour">
					<div class="inpt_tour">
						<label class="radio_type d-flex align-items-center duration_type_chosse_days{if $oneItem.duration_type eq '0'} c_selct{/if}" for="duration_type_chosse_days">
							<div class="radio-inline mr-half">
								<input type="radio" name="duration_type" value="0"{if $oneItem.duration_type eq '0'} checked="checked"{/if} id="duration_type_chosse_days" onClick="loadHelp(this)"> {$core->get_Lang('Choose days')}
								{assign var= choose_days_tour value='choose_days_tour'}
								{if $CHECKHELP|default:'' eq 1}
								<button data-key="{$choose_days_tour}" data-label="{$core->get_Lang('Choose days')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
								<div class="text_help" hidden="">{$clsConfiguration->getValue($choose_days_tour)|html_entity_decode}</div>
							</div>
							<div class="d-flex align-items-center number_duration_days mr-5">
								<div class="box_duration_in">
									<input min-number="1" max-number="999" {if $oneItem.yield_id}readonly{/if} type="text" class="input_number numberonly find_select"  name="number_day" id="duration_days" value="{$oneItem.number_day}"/>
									<a class="unNum number_day">{$clsISO->makeIcon('angle-down')}</a>
									<a class="upNum">{$clsISO->makeIcon('angle-up')}</a>
								</div>
								<label for="duration_days">{$core->get_Lang('days')}</label>
							</div>
							<div class="d-flex align-items-center number_duration_days">
								<div class="box_duration_in">
									<input min-number="0" max-number="999" {if $oneItem.yield_id}readonly{/if} type="text" class="input_number numberonly find_select"  name="number_night" id="duration_nights" value="{$oneItem.number_night}"/>
									<a class="unNumn">{$clsISO->makeIcon('angle-down')}</a>
									<a class="upNumn">{$clsISO->makeIcon('angle-up')}</a>
								</div>
								<label for="duration_nights">{$core->get_Lang('nights')}</label>
							</div>
						</label>
						<label class="d-flex align-items-center radio_type duration_type_opt{if $oneItem.duration_type eq '1'} c_selct{/if}" for="duration_type_opt">
							<span class="radio-inline mr-half"><input type="radio" name="duration_type" value="1"{if $oneItem.duration_type eq '1'} checked="checked"{/if} id="duration_type_opt" onClick="loadHelp(this)"> {$core->get_Lang('Option')}
							{assign var= option_tour value='option_tour'}
								{if $CHECKHELP|default:'' eq 1}
								<button data-key="{$option_tour}" data-label="{$core->get_Lang('Option')}" type="button" title="Thêm mô tả" onclick="open_texthelp(this, event)" class="btn btn-xs btn-default"><i class="fa fa-plus-circle"></i></button>
								{/if}
								<div class="text_help" hidden="">{$clsConfiguration->getValue($option_tour)|html_entity_decode}</div>
							</span>
							<input type="text" name="duration_custom" class="form-control w-300px"{if $oneItem.duration_type ne '1'} disabled="disabled"{/if} value="{$oneItem.duration_custom}"/>
							
						</label>
						<script>
							var message_confirm = '{$core->get_Lang("You need to delete the tour itinerary")}';
						</script>
						{literal}
						<script type="text/javascript">
							$(function () {
								var number_day = $("input[name='number_day']").val(),
									number_night = $("input[name='number_night']").val(),
									duration_type = $("input[name='duration_type']:checked").val();
								// console.log(number_day+','+ number_night);
								if(duration_type == 0){
									if(number_day>0 && number_night>0){
										$("input[name='dra_hours']").attr("disabled", "disabled");
										$("input[name='dra_min']").attr("disabled", "disabled");
									}else if (number_day>0 && number_night<1){
										$("input[name='dra_hours']").attr("disabled", "disabled");
										$("input[name='dra_min']").attr("disabled", "disabled");
									}else if (number_day<1 && number_night>0){
										$("input[name='dra_hours']").attr("disabled", "disabled");
										$("input[name='dra_min']").attr("disabled", "disabled");
									}else{
										$("input[name='dra_hours']").removeAttr("disabled");
										$("input[name='dra_min']").removeAttr("disabled");
									}
								}else{
									$("input[name='number_day']").attr("disabled", "disabled");
									$("input[name='number_night']").attr("disabled", "disabled");
									$("input[name='dra_hours']").attr("disabled", "disabled");
									$("input[name='dra_min']").attr("disabled", "disabled");
								}
								$("input[name='duration_type']").on("change", function(ev) {
									ev.preventDefault();
									var _this = $(this),
										_label = _this.closest('label'),
										_number_day = $("input[name='number_day']").val(),
										_number_night = $("input[name='number_night']").val(),
										_duration_type = $('input[name=duration_type]:checked').val();
									
									if(!_label.hasClass('c_selct')){
										$(".radio_type").removeClass('c_selct');
										_label.addClass('c_selct');
									}
									if (_duration_type == 1) {
										$("input[name='number_day']").val(1).attr("disabled", "disabled");
										$("input[name='number_night']").val(0).attr("disabled", "disabled");
										$("input[name='dra_hours']").val(0).attr("disabled", "disabled");
										$("input[name='dra_min']").val(0).attr("disabled", "disabled");
										$("input[name='duration_custom']").removeAttr("disabled").focus();
									} else {
										$("input[name='number_day']").removeAttr("disabled").focus();
										$("input[name='number_night']").removeAttr("disabled");
										$("input[name='duration_custom']").val("").attr("disabled", "disabled");
										if(_number_day > 0 && _number_night > 0){
											$("input[name='dra_hours']").attr("disabled", "disabled");
											$("input[name='dra_min']").attr("disabled", "disabled");
										}else if (_number_day>0 && _number_night<1){
											$("input[name='dra_hours']").attr("disabled", "disabled");
											$("input[name='dra_min']").attr("disabled", "disabled");
											// $("input[name='duration_type']").val(0);
										}else if (_number_day<1 && _number_night>0){
											$("input[name='dra_hours']").attr("disabled", "disabled");
											$("input[name='dra_min']").attr("disabled", "disabled");
											// $("input[name='duration_type']").val(0);
										}else{
											$("input[name='dra_hours']").removeAttr("disabled");
											$("input[name='dra_min']").removeAttr("disabled");
											// $("input[name='duration_type']").val(1);
										}

									}
								});
							});
							$('.upNum').click(function(ev) {
								ev.preventDefault();
								ev.stopPropagation();
								var number_day = parseInt($('input[name=number_day]').val()),
									max_number = parseInt($('input[name=number_day]').attr('max-number')),
									number_night = parseInt($('input[name=number_night]').val()),
									duration_type = $("input[name='duration_type']:checked").val();
								number_day = number_day + 1;
								if(duration_type == 0){
									if (number_day > max_number) {
										alert('Min days');
										number_day = max_number;
									}
									if(number_day>0){
										$("input[name='dra_hours']").attr("disabled", "disabled");
										$("input[name='dra_min']").attr("disabled", "disabled");
									}
									$("input[name=number_day]").val(number_day);
								}
								return false;
							});
							$('.unNum').click(function(ev) {
								ev.preventDefault();
								ev.stopPropagation();
								var number_day = parseInt($('input[name=number_day]').val()),
									min_number = parseInt($('input[name=number_day]').attr('min-number')),
									number_night = parseInt($('input[name=number_night]').val()),
									duration_type = $("input[name='duration_type']:checked").val();
								if($(this).hasClass('number_day') && number_day > 1){
									var check = 0;
									$.ajax({
										type: "POST",
										dataType: "JSON",
										data :	{number_day:number_day,tour_id:tour_id},
										url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajaxCheckNumberTourItinerary',
										async:false,
										success : function(res){
											if(res.result){
												if(confirm(message_confirm)){
													openURL('/admin/tour/edit/'+tour_id+'/itinerary/itinerary');
												}
											}else{
												check = 1;
											}
										}
									});
								}else{
									var check = 1;
								}
								
								if(check){
									number_day = number_day - 1;
									if(duration_type == 0) {
										if (number_day < min_number) {
											alert('Min days');
											number_day = min_number;
										}
										if (number_day < 1 && number_night < 1) {
											$("input[name='dra_hours']").removeAttr("disabled");
											$("input[name='dra_min']").removeAttr("disabled");
										}
										$("input[name=number_day]").val(number_day);
									}
								}
								
								return false;
							});
							$('.upNumn').click(function(ev) {
								ev.stopPropagation();
								var number_day = parseInt($('input[name=number_day]').val()),
									number_night = parseInt($('input[name=number_night]').val()),
									max_number = parseInt($('input[name=number_night]').attr('max-number')),
									duration_type = $("input[name='duration_type']:checked").val();
							
								number_night = number_night + 1;
								if(duration_type == 0) {
									if (number_night > max_number) {
										$Core.alert.alert(__['Message'], __['Min nights']);
										number_night = max_number;
									}
									if (number_night > 0) {
										$("input[name='dra_hours']").attr("disabled", "disabled");
										$("input[name='dra_min']").attr("disabled", "disabled");
									}
									$('input[name=number_night]').val(number_night);
								}
								return false;
							});
							$('.unNumn').click(function(ev) {
								ev.stopPropagation();
								var number_day = parseInt($('input[name=number_day]').val()),
									number_night = parseInt($('input[name=number_night]').val()),
									min_number = parseInt($('input[name=number_night]').attr('min-number')),
									duration_type = $("input[name='duration_type']:checked").val();
									
								number_night = number_night - 1;
								if(duration_type == 0) {
									if (number_night < min_number) {
										$Core.alert.alert(__['Message'], __['Max nights']);
										number_night = min_number;
									}
									if (number_night < 1 && number_day < 1) {
										$("input[name='dra_hours']").removeAttr("disabled");
										$("input[name='dra_min']").removeAttr("disabled");
									}
									$('input[name=number_night]').val(number_night);
								}
								return false;
							});
							$('.upNum-hours').click(function() {
								var number_person = $(this).val();
								var val = parseInt($("#duration_hours").val());
								var val1 = parseInt($("#duration_days").val());
								var val2 = parseInt($("#duration_nights").val());
								var max_number = parseInt($("#duration_hours").attr('max-number'));
								val = val + 1;
								if(val1 <= 0 && val2<=0 ){
									if (val > max_number) {
										alert('Min hours');
										val = max_number;
									}
									$("#duration_hours").val(val);
								}
								return false;
							});
							$('.unNum-hours').click(function() {
								var number_person = $(this).val();
								var val1 = parseInt($("#duration_days").val());
								var val2 = parseInt($("#duration_nights").val());
								var val = parseInt($("#duration_hours").val());
								var min_number = parseInt($("#duration_hours").attr('min-number'));
								val = val - 1;
								if(val1 <= 0 && val2<=0 ){
									if (val < min_number) {
										alert('Max hours');
										val = min_number;
									}
									$("#duration_hours").val(val);
								}
								return false;
							});
							$('.upNum-min').click(function() {
								var number_person = $(this).val();
								var val = parseInt($("#duration_minutes").val());
								var val1 = parseInt($("#duration_days").val());
								var val2 = parseInt($("#duration_nights").val());
								var max_number = parseInt($("#duration_minutes").attr('max-number'));
								val = val + 1;
								if(val1 <= 0 && val2<=0 ){
									if (val > max_number) {
										alert('Min Minutes');
										val = max_number;
									}
									$("#duration_minutes").val(val);
								}
								return false;
							});
							$('.unNum-min').click(function() {
								var number_person = $(this).val();
								var val1 = parseInt($("#duration_days").val());
								var val2 = parseInt($("#duration_nights").val());
								var val = parseInt($("#duration_minutes").val());
								var min_number = parseInt($("#duration_minutes").attr('min-number'));
								val = val - 1;
								if(val1 <= 0 && val2<=0 ){
									if (val < min_number) {
										alert('Max Minutes');
										val = min_number;
									}
									$("#duration_minutes").val(val);
								}
								return false;
							});
						</script>
						{/literal}
					</div>
					<div class="btn_save_titile_trip_code">
						<a tour_id="{$pvalTable}" cat_run="{$cat_run}" prev_step="{if empty($child_cat_menu_j_index_prev)}{if empty($list_cat_menu_prev)}{$child_cat_menu_j}{/if}{if !empty($list_cat_menu_prev)}{$list_cat_menu_prev}/{$child_cat_menu_prev[$count_child_cat_menu_prev]}{/if}{else}{$child_cat_menu_j_index_prev}{/if}" class="back_step">{$core->get_Lang('Back')}</a>
						<a id="btn-save-img-file"  tour_id="{$pvalTable}" cat_run="{$cat_run}" status="" present_step="{$child_cat_menu_j}" next_step="{if empty($child_cat_menu_j_index_next)}{if empty($list_menu_tour_i_index_next.cat_menu)}SaveAll{/if}{if !empty($list_menu_tour_i_index_next.cat_menu)}{$list_cat_menu_next}/{$child_cat_menu_next[0]}{/if}{else}{$child_cat_menu_j_index_next}{/if}" class="save_and_continue_tour">{$core->get_Lang('Save &amp; Continue')}</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="instruction_fill_data_box">
				<p class="title_box"><i class="fa fa-question-circle text-red " aria-hidden="true"></i> {$core->get_Lang('Instructions')}</p>
				<div class="content_box">{$clsConfiguration->getValue($choose_days_tour)|html_entity_decode}</div>
			</div>
		</div>
	</div>
</div>