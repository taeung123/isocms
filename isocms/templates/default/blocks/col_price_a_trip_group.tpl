{assign var=availableDate value=$clsTour->getDateDepartureGroup($tour_id)} 
{assign var=availableDate2 value=$clsTour->getDateDepartureGroup($tour_id,DATE)} 
{if $_LANG_ID eq 'en'}
{assign var=visitor_adult_id value=16}
{assign var=visitor_child_id value=17}
{assign var=visitor_infant_id value=18}
{else}
{assign var=visitor_adult_id value=13}
{assign var=visitor_child_id value=14}
{assign var=visitor_infant_id value=15}
{/if}
<div class="sb_tour_info">
	<div class="price_date">
		{assign var=getTripPrice value=$clsTour->getTripMinPriceTourGroup($tour_id,$availableDate)}
		<p class="price">
			<span>{$core->get_Lang('From USD')}:</span>
			<strong id="priceFrom">$ {$getTripPrice}</strong>
		</p>
		<p class="trip_code">
			{$core->get_Lang('Trip code')}: <b >{$clsTour->getTripCode($tour_id)}</b>
			<label class="rate-1">
				{$clsReviews->getStarNew($tour_id,$mod)}
			</label> 	
			<span class="review_text">{$clsReviews->getToTalReview($tour_id,$mod)} {$core->get_Lang('reviews')}</span>
		</p>
	</div>
	<div class="departure_date">
		<p class="clearfix row mt-15">
			<span class="col-md-6">{$core->get_Lang('Available')} :</span>
			<span class="col-md-6">
			{assign var=Available value=$clsTourStartDate->getAllotmentTourGroup2($tour_id,$availableDate)}
			{if $Available gt '1'}
			<span id="available_html">{$Available} {$core->get_Lang('seats')} </span>
			{else}
			<span id="available_html">{$Available} {$core->get_Lang('seat')} </span> 
			{/if}
			</span>
		</p>
		<p class="clearfix row">
			<span class="col-md-6">{$core->get_Lang('Sold')} :</span>
			<span class="col-md-6">
			{assign var=Sold value=$clsTourStartDate->getSoldAvailable($tour_id,$availableDate)}
			{if $Sold gt '1'}
			<span id="sold_html">{$Sold} {$core->get_Lang('seats')} </span>
			{else}
			<span id="sold_html">{$Sold} {$core->get_Lang('seat')} </span> 
			{/if}
			</span>
		</p>
		<p class="clearfix row">
			<span class="col-md-6">{$core->get_Lang('Latest Departure Date')} :</span>
			<span class="col-md-6"><span id="departure_date_html">{$clsTour->getDateDepartureGroup($tour_id)} </span>
			{if $clsTour->checkDepartureOtherGroup($tour_id)}
			<a href="#calendar" class="color_e4622a mgl10 underline" title="{$core->get_Lang('Others')}">{$core->get_Lang('Others')}</a>
			{/if}
			</span> 
		</p>
		{if 1 eq 2}
			{assign var=address value=$clsTour->getDepartureFrom($tour_id)}
			{if $address ne '' }
			<p class="clearfix row">
				<span class="col-md-6">{$core->get_Lang('Depart from')} :</span>
				<span class="col-md-6">{$address}</span>
			</p>
			{/if}
		{/if}
		<p class="clearfix row">
			<span class="col-md-6">{$core->get_Lang('Duration')} :</span>
			<span class="col-md-6">{$clsTour->getTripDuration($tour_id)}</span>
		</p>
	</div>
</div><!--end sb_tour_info--> 
<div class="priceTrip_Book mt-15">
	<form id="formBookTour" method="post" enctype="multipart/form-data">
	<div class="header">
		<h3>{$core->get_Lang('Price a Trip, Book Now')}</h3>
	</div>
	<div class="entry_priceBook">
		<div class="form-group entry_departure_date">
			<p><span class="bullet_num">1</span> {$core->get_Lang('Departure Date')}</p>
			<input id="departure_date" name="departure_date" value="{if $availableDate2 ne ''}{$availableDate2}{else}{$clsISO->formatTimeDateEn($now_next)}{/if}" autocomplete="off" maxlength="10" size="10" class="form-control isoshortdatepicker" placeholder="mm/dd/yyyy" />
			{literal}
			<script type="text/javascript">
				$(function(){
					var d = new Date();
					d.setDate(d.getDate() + 1);
					$('#departure_date').datepicker({
						minDate : d,
						dateFormat: "mm/dd/yy",
						numberOfMonths :1
					});
				});
				$('.has-feedback.wf2 input#ip-room').click(function() {
					if($('.cd-sub-room').is(':visible')){
						$('.cd-sub-room').hide();
					}else{
						$('.cd-sub-room').show();
					}
				});
			</script> 
			{/literal}
		</div><!--end entry_departure_date -->
		<div class="form-group entry_select_tour_class">
			<p><span class="bullet_num">2</span> {$core->get_Lang('Tour Class')} :</p>
			<div class="tourclass wap_select">
				<select class="selectbox appearance_none" name="tourclass" id="tourclass" style="width:100%; padding:4px">
					<option value="0">{$core->get_Lang('Select')}</option>
					{section name=i loop=$lstOption}
					<option value="{$lstOption[i]}" {if $tour_option_id eq $lstOption[i]} selected="selected" {/if}>{$clsTourOption->getTitle($lstOption[i])}</option>
					{/section}
				</select>
			</div>
		</div>
		<div class="form-group entry_select_people">
			<p><span class="bullet_num">3</span> {$core->get_Lang('Number of people')}: </p>
			<div class="clearfix select_people_box">
				<span>{$core->get_Lang('Adults')}:</span>
				<span class="wap_select" id="adult_select">
					<select class="selectbox appearance_none" name="adult" id="adult" tour_visitor_type_id="{$visitor_adult_id}" style="width:100%; padding:4px">
						{$clsISO->getSelect(1,$max_adult,$adult)}
					</select>
				</span>
				<span>{$core->get_Lang('Children')}:</span>
				<span class="wap_select">
					<select class="selectbox appearance_none" name="child" id="child" tour_visitor_type_id="{$visitor_child_id}" style="width:100%; padding:4px">
						{$clsISO->getSelect(0,$max_child,$child)}
					</select>
				</span>
				<span>{$core->get_Lang('Infant')}:</span>
				<span class="wap_select">
					<select class="selectbox appearance_none" name="infant" id="infant" tour_visitor_type_id="{$visitor_infant_id}" style="width:100%; padding:4px">
						{$clsISO->getSelect(0,$max_infant,$infant)}
					</select>
					<input type="hidden" name="price_adult" id="people_price_{$visitor_adult_id}" value="" />
					<input type="hidden" name="price_child" id="people_price_{$visitor_child_id}" value="" />
					<input type="hidden" name="price_infant" id="people_price_{$visitor_infant_id}" value="" />
					<input type="hidden" name="slot_available" id="slot_available" value="" />
				</span>
			</div>
		</div><!--end entry_select_people -->
		<div class="entry_total_price">
			<p><span class="bullet_triangular"></span> {$core->get_Lang('Total Fares')}: </p>
			<span style="margin-left:30px; font-size: 18px;font-weight: bold;color: #e4622a;">$</span><span id="total_price">0</span>
			
		</div>
		<div class="entry_mega_book mt-15 text-center">
			{if $availableDate2 ne ''}
			<button type="submit" class="btn_book_now color_fff" name="bookTourDeparture" value="bookTourDeparture">{$core->get_Lang('Book now')}</button>
			{/if}
			<button type="submit" class="btn_tailor_made color_fff" name="tailorMadeTour" value="tailorMadeTour">{$core->get_Lang('Tailor made')}</button>
		</div>
	</div><!--end entry_priceBook -->
	</form>
</div>
<!--end sb_tour_info--> 
<script type="text/javascript">
var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
var max_adult='{$max_adult}';
</script>
{literal}
<script type="text/javascript">
	if(LANG_ID=='en'){
		var visitor_adult_id=16;
		var visitor_child_id=17;
		var visitor_infant_id=18;
	}else{
		var visitor_adult_id=13;
		var visitor_child_id=14;
		var visitor_infant_id=15;
	}
	$(document).ready(function(){
		GetSlotAvailable($tour_id,$('#departure_date').val());
		GetSlectBoxClassTour($('#departure_date').val());
		GetSlotSold($tour_id,$('#departure_date').val());
		GetTourPriceByNumberGroup($tour_id,1,$('#tourclass').val(),visitor_adult_id,$('#departure_date').val());

		national_adults = $("#adult");
		national_child = $("#child");
		national_infant = $("#infant");

		tourclass = parseInt($("#tourclass").val());
		national_adults_price = parseInt($("#adultPrice").val());
		national_child_price = parseInt($("#childPrice").val());
		national_infant_price = parseInt($("#infantPrice").val());
		
			
		
		$(document).on('change','#departure_date',function(){
			$('#ui-datepicker-div').show();
			GetTourPriceByNumberGroup($tour_id,$("#adult").val(),$('#tourclass').val(),visitor_adult_id,$(this).val());
			GetTourPriceByNumberGroup($tour_id,$("#child").val(),$('#tourclass').val(),visitor_child_id,$(this).val());
			GetTourPriceByNumberGroup($tour_id,$("#infant").val(),$('#tourclass').val(),visitor_infant_id,$(this).val());
			GetSlotAvailable($tour_id,$('#departure_date').val());
			GetSlotSold($tour_id,$('#departure_date').val());
		});
		$(document).on('change','#tourclass',function(){
			GetTourPriceByNumberGroup($tour_id,$("#adult").val(),$(this).val(),visitor_adult_id,$('#departure_date').val());
			GetTourPriceByNumberGroup($tour_id,$("#child").val(),$(this).val(),visitor_child_id,$('#departure_date').val());
			GetTourPriceByNumberGroup($tour_id,$("#infant").val(),$(this).val(),visitor_infant_id,$('#departure_date').val());
		});
		$(document).on('change','#adult',function(){
		var number_person = $(this).val();
		var slotAvailable = $('#slot_available').val();
		var tour_visitor_type_id = $(this).attr('tour_visitor_type_id');
		if(!isNaN(parseInt(number_person))){
			if(parseInt(number_person) >= 0 && parseInt(number_person) <= parseInt(slotAvailable)){
				GetTourPriceByNumberGroup($tour_id,number_person,$('#tourclass').val(),tour_visitor_type_id,$('#departure_date').val());
			}else{
				alert(Input_data_is_invalid);
				$(this).val(1);
				GetTourPriceByNumberGroup($tour_id,1,$('#tourclass').val(),tour_visitor_type_id,$('#departure_date').val());
			}
		}else{
			alert(Input_data_is_invalid);
			$(this).val(1);
			GetTourPriceByNumberGroup($tour_id,1,$('#tourclass').val(),tour_visitor_type_id,$('#departure_date').val());
		}	
		});
		$(document).on('change','#child',function(){
			var number_person = $(this).val();
			
			var tour_visitor_type_id = $(this).attr('tour_visitor_type_id');
			if(!isNaN(parseInt(number_person))){
				if(parseInt(number_person) >= 0){
					GetTourPriceByNumberGroup($tour_id,number_person,$('#tourclass').val(),tour_visitor_type_id,$('#departure_date').val());
				}else{
					alert(Input_data_is_invalid);
					$(this).val(1);
					GetTourPriceByNumberGroup($tour_id,1,$('#tourclass').val(),tour_visitor_type_id,$('#departure_date').val());
				}
			}else{
				alert(Input_data_is_invalid);
				$(this).val(1);
				GetTourPriceByNumberGroup($tour_id,1,$('#tourclass').val(),tour_visitor_type_id,$('#departure_date').val());
			}	
		});
		$(document).on('change','#infant',function(){
			var number_person = $(this).val();
			var tour_visitor_type_id = $(this).attr('tour_visitor_type_id');
			if(!isNaN(parseInt(number_person))){
				if(parseInt(number_person) >= 0){
					GetTourPriceByNumberGroup($tour_id,number_person,$('#tourclass').val(),tour_visitor_type_id,$('#departure_date').val());
				}else{
					alert(Input_data_is_invalid);
					$(this).val(1);
					GetTourPriceByNumberGroup($tour_id,1,$('#tourclass').val(),tour_visitor_type_id,$('#departure_date').val());
				}
			}else{
				alert(Input_data_is_invalid);
				$(this).val(1);
				GetTourPriceByNumberGroup($tour_id,1,$('#tourclass').val(),tour_visitor_type_id,$('#departure_date').val());
			}	
		});
	});
	function GetTourPriceByNumberGroup(tour_id,number_person,tour_class_id,tour_visitor_type_id,departure){
		$.ajax({
			'type': 'POST',
			'url' : path_ajax_script+'/index.php?mod=ajax&act=getTourPriceByNumberGroup',
			'data' : {"tour_id":tour_id,"number_person":number_person,"tour_class_id":tour_class_id,"tour_visitor_type_id":tour_visitor_type_id,"departure":departure,"_LANG_ID": LANG_ID},
			'dataType': 'html',
			'success':function(html){
				var htm = html.split('|||');
				var price = parseInt(htm[1]).toFixed();
				$("#people_price_"+tour_visitor_type_id).val(price);
				$("#priceFrom").html(htm[4]);
				
				loadPrice();
			}
		});
	}
	function GetSlectBoxClassTour(departure){
		$.ajax({
			'type': 'POST',
			'url' : path_ajax_script+'/index.php?mod=ajax&act=getTourClassId',
			'data' : {"tour_id":$tour_id,"departure":departure,"_LANG_ID": LANG_ID},
			'dataType': 'html',
			'success':function(html){
				var htm = html;
				$("#tourclass").html(htm);
				GetTourPriceByNumberGroup($tour_id,1,$('#tourclass').val(),visitor_adult_id,$('#departure_date').val());
			}
			
		});
	}
	function GetSlectBoxAdult($available){
		$.ajax({
			'type': 'POST',
			'url' : path_ajax_script+'/index.php?mod=ajax&act=getAdultSelectHtml',
			'data' : {"available":$available,"max_adult":max_adult},
			'dataType': 'html',
			'success':function(html){
				var htm = html;
				$("#adult").html(htm);
			}
		});
	}
	function GetSlotAvailable(tour_id,departure){
		$.ajax({
			'type': 'POST',
			'url' : path_ajax_script+'/index.php?mod=ajax&act=getSlotAvailable',
			'data' : {"tour_id":tour_id,"departure":departure,"_LANG_ID": LANG_ID},
			'dataType': 'html',
			'success':function(html){
				var htm = html.split('|||');
				var slot = parseInt(htm[1]);
				$("#slot_available").val(slot);
				if(slot >1){
					$("#available_html").html(slot +' '+ seats);
				}else{
					$("#available_html").html(slot +' '+ seat);
				}
				GetSlectBoxAdult(slot)
			}
		});
	}
	function GetSlotSold(tour_id,departure){
		$.ajax({
			'type': 'POST',
			'url' : path_ajax_script+'/index.php?mod=ajax&act=getSlotSold',
			'data' : {"tour_id":tour_id,"departure":departure,"_LANG_ID": LANG_ID},
			'dataType': 'html',
			'success':function(html){
				var htm = html.split('|||');
				var slot = parseInt(htm[1]);
				if(slot >1){
					$("#sold_html").html(slot +' '+ seats);
				}else{
					$("#sold_html").html(slot +' '+ seat);
				}
			}
		});
	}
	function loadPrice(){
		national_adults = parseInt($("#adult").val());
		national_child = parseInt($("#child").val());
		national_infant = parseInt($("#infant").val());
		
		tourclass = parseInt($("#tourclass").val());
		national_adults_price = parseInt($("#people_price_"+visitor_adult_id).val());
		national_child_price = parseInt($("#people_price_"+visitor_child_id).val());
		national_infant_price = parseInt($("#people_price_"+visitor_infant_id).val());
		if(national_adults > 0 && national_adults_price >0){	
			var totalPriceAdult = national_adults * national_adults_price;
		}
		if(national_child > 0 && national_child_price >0){
			var totalPriceChild = national_child * national_child_price;
		}
		if(national_infant > 0 && national_infant_price >0){
			var totalPriceInfant = national_infant * national_infant_price;
		}
		var national_total = document.getElementById("total_price");
		var tong = national_adults + national_child + national_infant;
		var national = 0;
		if(totalPriceAdult > 0){
			national = national + totalPriceAdult;
		}
		if(totalPriceChild > 0){
			national = national + totalPriceChild;
		}
		if(totalPriceInfant > 0){
			national = national + totalPriceInfant;
		}
		if (!isNaN(tong)){
			national_total.innerHTML = national;
		}
	}
</script>
{/literal}