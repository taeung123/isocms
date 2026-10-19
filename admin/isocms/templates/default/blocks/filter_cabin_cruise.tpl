{assign var=max_adult value=$clsCruise->getMaxAdult($cruise_id)}
{assign var=max_child value=$clsCruise->getMaxChild($cruise_id)}
<section id="price" class="price_box section__box">
	<div class="box_filter_cabin">				
		<h2 class="title_section">
			{$core->get_Lang('Cabin &amp; Prices')}
		</h2>
		<div class="filter_price">
			<label for="" class="lbl_filter_price">{$core->get_Lang('Fill in the box to get your group price')}</label>
			<form id="form__avaiable" class="form__avaiable" action="" method="post">
				<div class="form_filter">
					<div class="box_input box_input_departure">
						<input type="text" name="departure_date" id="departure_date" class="departure_date" value="{$format_time_now}" autocomplete="off" readonly>
						<i class="fa fa-caret-down" aria-hidden="true"></i>
					</div>
					<div class="box_input box_input_number_traveller">
						<input type="text" name="number_travellers" class="number_travellers" id="pick_travellers" placeholder="{$core->get_Lang('Adults')}" readonly>
						<i class="fa fa-caret-down" aria-hidden="true"></i>
						<div id="check_number_travellers" class="check_number_travellers">
							<ul class="check_number_travellers--ul list_style_none">
								<li class="inputTraveller" id="li_adult" data-tour_property_id="_adult">
									<div class="right__inputTraveller">
										<label>{$core->get_Lang('Adults')}</label>
										<span class="ui-spinner ui-corner-all ui-widget ui-widget-content">
											<button class="ui-spinner-button ui-spinner-down unNum" type="button" _type="number_adults" traveler_type_id="_adult">-</button>
											<input min-number="1" max-number="{$max_adult}" type="number" class="ui-spinner-input number_adults input_number find_select" id="national_visitor_adult" name="number_adult" value="{$number_adult_check}" readonly/>
											<button class="ui-spinner-button ui-spinner-up upNum" type="button" _type="number_adults" traveler_type_id="_adult">+</button>
										</span>
									</div>
								</li>
								<li class="inputTraveller">
									<div class="right__inputTraveller">
										<label>{$core->get_Lang('Children')}</label>
										<span class="ui-spinner ui-corner-all ui-widget ui-widget-content">
											<button class="ui-spinner-button ui-spinner-down unNum" type="button" _type="number_child" traveler_type_id="_child">-</button>
											<input min-number="0" max-number="{$max_child}" id="national_visitor_child" type="number" class="ui-spinner-input number_child input_number find_select" name="number_child" value="0" readonly/>
											<button class="ui-spinner-button ui-spinner-up upNum" type="button" _type="number_child" traveler_type_id="_child" >+</button>
										</span>
									</div>
									<div class="box_age_child" id="box_age_child"></div>
									<div class="txt_children">{$core->get_Lang("To find a property that suits your whole group at the exact same price, we need to know the children's ages at check-out")}</div>
								</li>								
								<li class="inputTraveller" id="li_room" data-tour_property_id="6">
									<div class="right__inputTraveller">
										<label>{$core->get_Lang('Cabin')}</label>
										<span class="ui-spinner ui-corner-all ui-widget ui-widget-content">
											<button class="ui-spinner-button ui-spinner-down unNum" traveler_type_id="_number_cabin" _type="number_cabin" type="button">-</button>
											<input min-number="0" max-number="{$total_cabin}" id="national_visitor_number_cabin" type="number" class="ui-spinner-input number_cabin input_number find_select" name="number_cabin" value="0" readonly/>
											<button class="ui-spinner-button ui-spinner-up upNum" type="button" _type="number_cabin" traveler_type_id="_number_cabin" >+</button>
										</span>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="box_input box_input_tour_guide">
						<input type="text" name="duration_cruise" class="duration_cruise" placeholder="{$core->get_Lang('Duration cruise')}" readonly>
						<i class="fa fa-caret-down" aria-hidden="true"></i>
						{if $listDuration}
						<div id="check_duration" class="check_duration">
							<ul class="check_tour_guide--ul list_style_none">
								{$listDuration}
							</ul>
						</div>
						{/if}
					</div>
					<div class="box_input box_input_book">						
						<input type="hidden" name="cruise_id" id="cruise_id" value="{$cruise_id}" />
						<input type="hidden" id="number_adult" value="2" />
						<input type="hidden" id="number_child" value="0" />
						<input type="hidden" name="hidFind" value="hidCruises" />
						<input type="hidden" name="_LANG_ID" id="_LANG_ID" value="{$_LANG_ID}" />
						<button id="btn_check_cabin" class="btn_book_tour" type="button">{$core->get_Lang('Check Prices')}</button>
					</div>
				</div>
			</form>

		</div>
	</div>
	<div id="TablePrice">
		{*<div class="box_item_cabin">
			<div class="box_right_item_cabin">
				<img src="/files/thumb/360/200/uploads/Cruises/Cruise-Halong/Valentine-junk/922-valentine-junk-cruise-halong-1.jpg" alt="" width="450" height="250">
			</div>
			<div class="box_left_item_cabin">
				<div class="box_info_cabin">
					<h3 class="title_cabin">Ocean Suite Balcony</h3>
					<div class="cabin_itinerary">
						<p class="item_info_cabin number_person">2 pax</p>
						<p class="item_info_cabin area_cabin">35.0 m2</p>
						<p class="item_info_cabin bed_cabin">Double/Twin</p>
					</div>
					<p class="item_info_cabin meals_cabin">All board - meals included</p>
					<p class="item_info_cabin promotion_cabin">{$core->get_Lang('Last Minute')}: 40$ OFF</p>
				</div>
				<div class="box_price_cruise">					
					<p class="price_from">Price</p>
					<p class="price_cruise">111$<span class="text_price"> /pax</span></p>
				</div>
				<div class="box_cabin_detail">												
					<div class="top_cabin_detail">
						<a class="btn_textCabinDetail collapsed" href="javascript:void(0)" role="button" data-bs-toggle="collapse" data-bs-target="#cabin_detail" aria-expanded="false">{$core->get_Lang('Cabin detail')} <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<button class="btn_viewMore">{$core->get_Lang('Book now')}</button>
					</div>
					<div class="box_overview collapse" id="cabin_detail" style="">
						<p>The boat was named Valentine in honor of Valentine's Day, aiming to provide a loving and private experience for all its guests. The ship's distinctive feature is its two orange-yellow sails, adorned with the name "Valentine's cruise," ensuring it stands out during its sea voyages.</p><p>Launched in June 2010, this two-story vessel offers two cabins in a compact design. While it may not be the largest 5-star Halong cruise, it is perfect for those seeking an intimate and private experience with their loved ones. As one of the pioneering yachts catering to small-group travel, Valentine is ideal for those who prefer a more personal touch.</p>
					</div>
				</div>
			</div>
		</div>*}
	</div>		
</section>
<script>
	var Adults='{$core->get_Lang("Adults")}';
	var Adult='{$core->get_Lang("Adult")}';
    var Children='{$core->get_Lang("Children")}';
    var Infants='{$core->get_Lang("Infants")}';
    var Cabin='{$core->get_Lang("Cabin")}';
	var getSelectAgeChild = `{$clsISO->getSelectAgeChild('','','Cruise')}`;
	var Warning='{$core->get_Lang("Warning")}';
	var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
</script>
{literal}
<script>

$(document).click(function (e){	
	var container1 = $("#check_number_travellers");
	var container2 = $("#check_duration");
	if (!container1.is(e.target) && container1.has(e.target).length === 0 && !$('#pick_travellers').is(e.target) ){
		container1.hide();
	}
	if (!container2.is(e.target) && container2.has(e.target).length === 0 && !$('.duration_cruise').is(e.target) ){
		container2.hide();
	}
});
$(document).ready(function(){	
	$("input[name='duration_cruise']").val($("input[name='cruise_itinerary_id']:checked").data('title'));
	$('input[name="number_travellers"]').click(function(){
		$("#check_number_travellers").toggle();
		$("#check_duration").hide();
	});
	if($("input[name='cruise_itinerary_id']").length > 1){
		$('input[name="duration_cruise"]').click(function(){
			$("#check_duration").toggle();
			$("#check_number_travellers").hide();
		});
	}
	
	$('input[name="cruise_itinerary_id"]').click(function(){
		var title = $(this).data('title');
		$('input[name="duration_cruise"]').val(title);
	});
	
	$('.number_adults').on('focusout',function(){
		var value = $(this).val();
		if(parseInt(value) < 1 || value == ''){
			$(this).val(1);
		}
		getNumberPerson();
	});
	$('.number_child').on('focusout',function(){
		var value = $(this).val();
		if(parseInt(value) < 0 || value == ''){
			value = 0;
			$(this).val(0);
		}
		/*$('#box_age_child').html('');
		for(var i=0; i<value; i++){
			$('#box_age_child').append(`<div class="item_age_child">`+getSelectAgeChild+`</div>`);
		}*/
		getNumberPerson();
	});
		
	$('.number_cabin').on('focusout',function(){
		var value = $(this).val();
		if(parseInt(value) < 0 || value == ''){
			$(this).val(0);
		}
		getNumberPerson();
	});
	$('.upNum').click(function() {
		var number_person = $(this).val();
		var departure_date = $("input[name=departure_date]").val();
		var traveler_type_id = $(this).attr('traveler_type_id');
		var val = parseInt($("#national_visitor"+traveler_type_id).val());
		var max_number = parseInt($("#national_visitor"+traveler_type_id).attr('max-number'));
		var _type=$(this).attr('_type');
		val = val + 1;
		if (val > max_number) {
			$.alert({
				title: Warning,
				type: 'red',
				typeAnimated: true,
				content: Input_data_is_invalid,
			});
			val = max_number;
		}
		$("#national_visitor"+traveler_type_id).val(val);
		$('#'+_type).val(val);				
		if(_type == 'number_adults'){
			$tour_id=$('#tour_id').val();					
		}
		/*if(_type == 'number_child'){
			$('#box_age_child').html('');
			for(var i=0; i<val; i++){
				$('#box_age_child').append(`<div class="item_age_child">`+getSelectAgeChild+`</div>`);
			}
		}*/
		if(_type == 'number_cabin'){
			var value = $('input[name="number_cabin"]').val();
			$('input[name="number_cabin"]').val(parseInt(value));
		}
		getNumberPerson();
		return false;
	});
	$('.unNum').click(function() {
		var number_person = $(this).val();
		var departure_date = $("input[name=departure_date]").val();
		var traveler_type_id = $(this).attr('traveler_type_id');
		var val = parseInt($("#national_visitor"+traveler_type_id).val());
		var min_number = parseInt($("#national_visitor"+traveler_type_id).attr('min-number'));
		var _type=$(this).attr('_type');
		val = val - 1;
		if (val < min_number) {
			$.alert({
				title: Warning,
				type: 'red',
				typeAnimated: true,
				content: Input_data_is_invalid,
			});
			val = min_number;
		}
		$("#national_visitor"+traveler_type_id).val(val);
		$('#'+_type).val(val);
		if(_type == 'number_adults'){
			$tour_id=$('#tour_id').val();					
		}

		/*if(_type == 'number_child'){
			$('#box_age_child').html('');
			for(var i=0; i<val; i++){
				$('#box_age_child').append(`<div class="item_age_child">`+getSelectAgeChild+`</div>`);
			}
		}*/

		if(_type == 'number_cabin'){
			var value = $('input[name="number_cabin"]').val();
			if(parseInt(value) > 0){
				$('input[name="number_cabin"]').val(parseInt(value));	
			}				
		}
		getNumberPerson();
		return false;
	});
	var numberMonth = 2;
	if ($( document ).width() <= 767){
		numberMonth = 1;
	}
	$('#departure_date').datepicker({
		dateFormat: 'M dd, yy',		
		numberOfMonths: numberMonth,
		minDate: new Date()
	});
		
	$('#book_cruise').click(function() {
		$('html, body').animate({
			scrollTop: $('.search_box_cruise_detail').offset().top - 10
			}, 1200, function(){
		 });
	});
	var departure_date = $('input[name=departure_date]').val();
	var cruise_itinerary_id = $('input[name=cruise_itinerary_id]:checked').val();
	var number_adult = $('#number_adult').val();
	var cruise_property_id = $('select[name=cruise_property_id]').val();
	loadPriceCabin(cruise_itinerary_id,departure_date,cruise_property_id,number_adult,1); 
	$('#btn_check_cabin').click(function() {
		var $departure_date = $('input[name=departure_date]').val();
		var $cruise_property_id = $('select[name=cruise_property_id]').val();
		var $cruise_itinerary_id = $('input[name=cruise_itinerary_id]:checked').val();
		var $number_adult = $('input[name=number_adult]').val();
		var $number_child = $('input[name=number_child]').val();
		var $number_cabin = $('input[name=number_cabin]').val();
		var check = 0;
		if(parseInt($number_child) > 0){
			$('#box_age_child').find('.slt_item_age_child').each(function(index,elm){
				console.log($(elm).val());
				if($(elm).val() == ''){
					++check;
					$(elm).addClass('error');
				}else{
					$(elm).removeClass('error');
				}
			});
		}
		if(check > 0){
			$("#check_number_travellers").show();
			return false;
		}
		var $ww = $(window).width();
		$('html, body').animate({
			scrollTop: $('#TablePrice').offset().top - 10
		 	}, 1200, function(){
		 });
		loadPriceCabin($cruise_itinerary_id,$departure_date,$cruise_property_id,$number_adult,$number_cabin); 
		
	});
	
}); 
function loadPriceCabin($cruise_itinerary_id,$departure_date,$cruise_property_id,$number_adult,$number_cabin){
	var $_adata = {
		'cruise_id': $cruise_id,
		'departure_date' : $departure_date,
		'cruise_property_id': $cruise_property_id,
		'cruise_itinerary_id': $cruise_itinerary_id,
		'number_adult' : $number_adult,
		'number_cabin': $number_cabin,
	};
	console.log($_adata);
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=cruise&act=loadPriceCabin&lang='+LANG_ID,
		data : $('#form__avaiable').serialize(),
		dataType:'html',
		success: function(html){
			$('#hiddenCheckRate').remove();
			$('#TablePrice').html(html);
		}
	});
}
function getNumberPerson(){
	var $totalAdult = 0;
	$('.number_adults').each(function() {
		$totalAdult += parseInt($(this).val());
	});
	var $totalChild = 0;
	$('.number_child').each(function() {
		$totalChild += parseInt($(this).val());
	});
	var $totalInfants = 0;
	$('.number_infants').each(function() {
		$totalInfants += parseInt($(this).val());
	});
	var $totalCabin = 0;
	$('.number_cabin').each(function() {
		$totalCabin += parseInt($(this).val());
	});
	if($totalAdult > 1){
		var value = $totalAdult+' '+Adults ;
	}else{
		var value = $totalAdult+' '+Adult ;
	}
	
	if($totalChild > 0){
		value += ', ' +$totalChild+' '+Children;
	}
	if($totalInfants > 0){
		value += ', ' +$totalInfants+' '+Infants;
	}
	if($totalCabin > 0){
		value += ', ' +$totalCabin+' '+Cabin;
	}
	$('#pick_travellers').val(value);
}
</script>
{/literal}
