{if $mod eq 'home'}
<section class="findSearchBox">
    <div class="inner">
        <h2 class="head">{$core->get_Lang('Search Your Cruise')}</h2>
        <div class="filter-box" id="findCruises">
            <form class="find_a_cruise_box" method="post" action="{$extLang}">
                <div class="col175 mrls fl">
                    <label class="title">{$core->get_Lang('Your length of trip')}</label>
                    <select class="slb" name="duration">{$clsCruiseItinerary->getSelectTripDuration($duration)}</select>
                </div>
                <div class="col236 mrls fl">
                    <label class="title">{$core->get_Lang('You prefer to visit')}</label>
                    <select class="slb" name="place">{$clsCruiseItinerary->getSelectTripAround($place)}</select>
                </div>
                <div class="col175 mrls fl">
                    <label class="title">{$core->get_Lang('Your travel as')}</label>
                    <select class="slb" name="travel_as">{$clsCruiseProperty->getSelectByProperty('TravelAs',$travel_as)}</select>
                </div>
                {if 1 eq 2}<div class="col138 mrls fl">
                    <label class="title">{$core->get_Lang('Your budget')}</label>
                    <select class="slb" name="budget">{$clsCruisePriceRange->getSelectPriceRange($budget)}</select>
                </div>{/if}
                <button class="btnsubmit mt32" type="submit">{$core->get_Lang('Search')}</button>
                <input type="hidden" name="hidFind" value="hidCruises" />
            </form>
        </div>
    </div>
</section>
{else}
<section class="search_box_cruise_detail">
	<div class="entry_header_box_search bg_main">
		<h2>{$core->get_Lang('Check availablity')}<span class="icon-crd ic-search"></span></h2>
	</div>
	<div class="entry_body_search">
		<p>{$core->get_Lang('Book now to get this fantastic price')}</p>
		<form class="find_a_cruise_box" method="post" action="{$extLang}">
			<div class="select_arow form-group {$cruise_itinerary_check_id}">
				<select class="form-control find_select" name="cruise_itinerary_id" id="seclect_cruise_itinerary_id" style="padding-right:25px">
					{if $lstItinerary_search ne ''}
					{section name=i loop=$lstItinerary_search}
					{assign var=cruise_itinerary_id value = $lstItinerary_search[i].cruise_itinerary_id}
					{assign var=lstDayItinerary value = $clsCruiseItineraryDay->getAll("is_trash=0 and cruise_itinerary_id='$cruise_itinerary_id' order by day ASC")}
					{if $lstDayItinerary}
						<option {if $cruise_itinerary_check_id eq $lstItinerary_search[i].cruise_itinerary_id}selected="selected"{/if} value="{$lstItinerary_search[i].cruise_itinerary_id}">{$clsCruiseItinerary->getTitleDay($lstItinerary_search[i].cruise_itinerary_id,$lstItinerary_search[i])}</option>
					{/if}
					{/section}
					{else}
					<option value="0">-- {$core->get_Lang('Itinerary')} --</option>
					{/if}
				</select>
			</div>
			<div class="form-group input-date">
				<input name="departure_date" id="departure_date" type="text" value="{$clsISO->formatTimeDate($now_next)}" class="form-control full-width" placeholder="{$core->get_Lang('Check in')}" />
			</div>
			<div class="form-group">
				<div class="select_arow">
					<input id="ip-room" value="1 {$core->get_Lang('Cabin')}, 2 {$core->get_Lang('Adults')}, 0 {$core->get_Lang('Children')}" class="form-control"/>
					<span id="show_check_rate"></span>
				</div>
				<div class="cd-sub cd-sub-room" style="display: none;"> <span class="fa fa-times cd-sub-close fr"></span>
					<div class="line width100 mb10">
						<label class="control-label">{$core->get_Lang('Cabin')}</label>
						<select class="form-control form-control-angle-down" name="number_cabin" id="number_cabin">
						{if $total_cabin gt 0}
							{section name=i loop=$total_cabin}
								<option value="{$smarty.section.i.iteration}">{$smarty.section.i.iteration}</option>
							{/section}
						{else}
							<option value="1" selected="selected">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						{/if}
						</select>
					</div>
					<div id="listRoom" class="mb20">
						<div class="room-chose">
							<h4 class="text-bold mb10">{$core->get_Lang('Cabin')} 1</h4>
							<div class="row">
								<div class="col-xs-3 line">
									<label class="control-label-sm">{$core->get_Lang('Adult(s)')}</label>
									<input type="number" class="form-control number_adult" value="{$number_adult_check}" name="number_adult_1" data-type_number="1" min="1" max="{$max_adult}" />
								</div>
								<div class="col-xs-3 line">
									<label class="control-label-sm">{$core->get_Lang('Child(ren)')}</label>
									<input type="number" class="form-control number_child" value="0" name="number_child_1" data-type_number="1" min="0" max="2" />
								</div>
								<div class="col-xs-3 line" id="conchild1s_1" style="display:none">
									<label class="control-label-sm">{$core->get_Lang('Child 1 Age')} *</label>
									<select class="form-control child_age" name="infant1s_1" id="infant1s_1"> 
										{$clsISO->makeSelectNumberAgeChild($clsConfiguration->getValue('ChildMaxAgePolicy'))}
									</select>
								</div>
								<div class="col-xs-3 line" id="conchild1s_2" style="display:none">
									<label class="control-label-sm">{$core->get_Lang('Child 2 Age')} *</label>
									<select class="form-control child_age" name="infant1s_2" id="infant1s_2"> 
										{$clsISO->makeSelectNumberAgeChild($clsConfiguration->getValue('ChildMaxAgePolicy'))}
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="room-chose">
						<button class="btn btn-style-1 z_14 text-bold text-center btn_main" type="button" onClick="$('.cd-sub-room').hide();">OK</button>
						<a href="javascript:void(0);" class="cp-dropdown inline-block color_144aa8">{$core->get_Lang('Child Policies')}</a>
						<div class="child_Police-detail" style="display: none;">
						{$clsCruise->getChildPolicy($cruise_id)}
						</div>
					</div>
				</div>
			</div>
			<div class="line txC">
				<input type="hidden" name="cruise_id" id="cruise_id" value="{$cruise_id}" />
				<input type="hidden" name="number_adult" id="number_adult" value="2" />
				<input type="hidden" name="number_child" id="number_child" value="0" />
				<input type="hidden" name="hidFind" value="hidCruises" />
				<input type="hidden" name="_LANG_ID" id="_LANG_ID" value="{$_LANG_ID}" />
				<input id="mrdt_button_submit" name="mrdt_button_submit" class="btn-find_cruise scollspy btn_main" type="button" value="{$core->get_Lang('Make reservations')}"/>
			</div>
		</form>
	</div>
</section>
{/if}
<script>
var max_adult = "{$max_adult}";
var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
var Room='{$core->get_Lang("Room")}';
var Cabin='{$core->get_Lang("Cabin")}';
var Adults='{$core->get_Lang("Adults")}';
var Children='{$core->get_Lang("Children")}';
var Child_1_Age='{$core->get_Lang("Child 1 Age")}';
var Child_2_Age='{$core->get_Lang("Child 2 Age")}';
var SelectAgeChild='{$clsISO->makeSelectNumberAgeChild($clsConfiguration->getValue("ChildMaxAgePolicy"))}';
</script>

{literal}
<script>
	$(function () {
		$('#departure_date').datepicker({
			dateFormat: 'dd/mm/yy',
			'minDate': new Date()
		});
	});
</script>
<script >
$(function(){
	loadPriceCabin($('select[name=cruise_itinerary_id]').val(),$('input[name=departure_date]').val(),$('select[name=cruise_property_id]').val(),$('input[name=number_adult]').val(),$('select[name=number_cabin]').val());
	
	
	getNumberPerson();
	$(document).on("change",".number_adult",function(){
		max_adult = (max_adult > 1)?max_adult:1;
		if(parseInt($(this).val()) >= 0 && parseInt($(this).val()) <= max_adult){
			getNumberPerson();
			}else{
			alert(Input_data_is_invalid);
			$(this).val(max_adult);
			getNumberPerson();
		}
		
	});
	$(document).on("change",".number_child",function(){
		if(parseInt($(this).val()) >= 0 && parseInt($(this).val()) <= 2){
			getNumberPerson();
			}else{
			alert(Input_data_is_invalid);
			$(this).val(2);
			getNumberPerson();
		}
	});
	$(document).on("change","#number_cabin",function(){
		appendRoom();
		getNumberPerson();
	});
	$(document).on("change",".number_child",function(){
		var $_this = $(this);
		var $room_index =$_this.attr("data-type_number");
		if($_this.val()==1){
			$('#conchild'+$room_index+'s_1').show();
			$('#conchild'+$room_index+'s_2').hide();
			$('#infant'+$room_index+'s_1').val(0);
			$('#infant'+$room_index+'s_2').val('');
		}else if($_this.val()==2){
			$('#conchild'+$room_index+'s_1').show();
			$('#conchild'+$room_index+'s_2').show();
			$('#infant'+$room_index+'s_2').val(0);
		}else{
			$('#conchild'+$room_index+'s_1').hide();
			$('#infant'+$room_index+'s_1').val('');
			$('#conchild'+$room_index+'s_2').hide();
			$('#infant'+$room_index+'s_2').val('');
		}
	});
	$('#ip-room').click(function(){
		if($(this).hasClass('open')){
			$('.cd-sub-room').hide();
			$(this).removeClass('open');
			$('#show_check_rate').removeClass('open');
		}else{
			$('.cd-sub-room').show();
			$(this).addClass('open');
			$('#show_check_rate').addClass('open');
		}
	});
	$('.cp-dropdown').click(function(){
		if($(this).hasClass('open')){
			$('.child_Police-detail').hide();
			$(this).removeClass('open');
		}else{
			$('.child_Police-detail').toggle(400);
			$(this).addClass('open');
		}
	});
	$('.cd-sub-close').click(function(){
		$('#ip-room').removeClass('open');
		$('#show_check_rate').removeClass('open');
		$('.cd-sub-room').hide();
	});
	$('.cp-detail-close').click(function(){
		$('.cp-dropdown').removeClass('open');
		$('.child_Police-detail').hide();
	});
	$('#mrdt_button_submit').click(function() {
		$('.cd-sub-room').hide();
		$('#show_check_rate').removeClass('open');
		var $cruise_itinerary_id = $('select[name=cruise_itinerary_id]').val();
		var $departure_date = $('input[name=departure_date]').val();
		var $cruise_property_id = $('select[name=cruise_property_id]').val();
		var $number_adult = $('input[name=number_adult]').val();
		var $number_cabin = $('select[name=number_cabin]').val();
		if($cruise_itinerary_id=='0'){
			 alert('Please select Cruise Itinerary!');
			 $('#seclect_cruise_itinerary_id').css({'color':'#f00'});
			 $('html, body').animate({
				scrollTop: $('#seclect_cruise_itinerary_id').offset().top - 10
				}, 1200, function(){
			 });
			  
		}else{
		var $ww = $(window).width();
		$('html, body').animate({
			scrollTop: $('#blockCheckRate').offset().top - 10
		 	}, 1200, function(){
		 });
		 loadPriceCabin($cruise_itinerary_id,$departure_date,$cruise_property_id,$number_adult,$number_cabin); 
		}
		
	});
	$(".tb-show-price a.scollspy").on('click', function(event) {
		if (this.hash !== "") {
			event.preventDefault();
			var hash = this.hash;
			$('html, body').animate({
				scrollTop: $(hash).offset().top - 70 
				}, 800, function(){
				window.location.hash = hash;
			});
		} 
	});
	var stickyOffsetSearch = $('.box_gallery').offset().top - 150;
	var stickyOffsetOutSearch =$('#show_check_rate').offset().top - 50;
	var $ww = $(window).width();
	var $wc = $('.container').width();
	var $wlf = ($ww - $wc)/2;
	var $width_box_search = $('.search_box_cruise_detail').width();
	if(1==2){
		if($ww >992){
			$(window).scroll(function(){
				var sticky = $('.cd-sub-room'),
				scroll = $(window).scrollTop();
				if (scroll >= stickyOffsetSearch && scroll <= stickyOffsetOutSearch){
				  sticky.addClass('fixed');
				  $('.search_box_cruise_detail .cd-sub-room.fixed').css({'right':'auto','left':($wlf+$width_box_search)});
				}
				else{
				  sticky.removeClass('fixed');
				   $('.search_box_cruise_detail .cd-sub-room').css({'right':'','left':''});
				}
			});
			
		}else{
			$(window).scroll(function(){
				var sticky = $('.cd-sub-room'),
				scroll = $(window).scrollTop();
				var offsetTop = $('#ip-room').offset().top;
				if (scroll >= stickyOffsetSearch && scroll <= stickyOffsetOutSearch){
				  sticky.addClass('fixed');
				  $('.search_box_cruise_detail .cd-sub-room.fixed').css({'right':'0','bottom':0,'top':64});
				}
				else{
				  sticky.removeClass('fixed');
				   $('.search_box_cruise_detail .cd-sub-room').css({'right':'','top':''});
				}
			});
		}
	}
});
</script>
{/literal}
{literal}
<script>
function loadPriceCabin($cruise_itinerary_id,$departure_date,$cruise_property_id,$number_adult,$number_cabin){
	var $_adata = {
		'cruise_id': $cruise_id,
		'cruise_itinerary_id': $cruise_itinerary_id,
		'departure_date' : $departure_date,
		'cruise_property_id': $cruise_property_id,
		'number_adult' : $number_adult,
		'number_cabin': $number_cabin,
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod=cruise&act=loadPriceCabin&lang='+LANG_ID,
		data : $('.find_a_cruise_box').serialize(),
		dataType:'html',
		success: function(html){
			$('#hiddenCheckRate').remove();
			$('#blockCheckRate').html(html);
		}
	});
}

function getNumberPerson(){
	var $totalAdult = 0;
	$('.number_adult').each(function() { 
		$totalAdult += parseInt($(this).val());
	});
	$('#number_adult').val($totalAdult);
	var $totalChild = 0;
	$('.number_child').each(function() { 
		$totalChild += parseInt($(this).val());
	});
	$('#number_child').val($totalChild);
	$('#ip-room').val(+$("#number_cabin").val()+' '+Cabin+', ' +$totalAdult+' '+Adults+', ' +$totalChild+' '+Children);
}

function appendRoom(){	
	var x = 0;
	var y = 1;
	$('#listRoom').html('');
	for(i = 1;i <=$('#number_cabin').val();i++){
		customer = new createCustomerInfo($('#listRoom'));
		x++;
		y++;
	}
}
function createCustomerInfo(obj){
	var $ww = $(window).width();
	this.div=$('<div class="room-chose mb20"><h4 class="text-bold mb10">'+Room+' '+i+'</h4><div class="row"><div class="col-xs-3 line"><label class="control-label-sm">'+Adults+'</label><input type="number" class="form-control number_adult" value="2" name="number_adult_'+i+'" data-type_number="1" min="1" max="'+max_adult+'" /></div><div class="col-xs-3 line"><label class="control-label-sm">'+Children+'</label><input type="number" class="form-control number_child" value="0" name="number_child_'+i+'" data-type_number="'+i+'" min="0" max="2" /></div><div class="col-xs-3 line" id="conchild'+i+'s_1" style="display:none"><label class="control-label-sm">'+Child_1_Age+' *</label><select class="form-control child_age" name="infant'+i+'s_1" id="infant'+i+'s_1">'+SelectAgeChild+'</select></div><div class="col-xs-3 line" id="conchild'+i+'s_2" style="display:none"><label class="control-label-sm">'+Child_2_Age+' *</label><select class="form-control child_age" name="infant'+i+'s_2" id="infant'+i+'s_2">'+SelectAgeChild+'</select></div><div></div>');
	obj.append(this.div);
}
</script>
<style >
#listRoom{display:inline-block!important;width:100%}
#listRoom .row{margin-left:-6px!important;margin-right:-6px!important}
#listRoom .control-label-sm{font-weight:400!important;font-size:12px!important}
#listRoom .col-xs-3{padding-left:6px!important;padding-right:6px!important}
.find_a_cruise_box .form-group{position:relative}
.find_a_cruise_box .form-group .cd-sub-room{padding:15px;position:absolute;display:block;right:-415px;z-index:3;width:400px;top:-232px;min-height:300px;color:#333;background-color:#f6f8f9;border:1px solid #ccc;-webkit-border-radius:5px;-khtml-border-radius:5px;-moz-border-radius:5px;-ms-border-radius:5px;-o-border-radius:5px;border-radius:5px;-webkit-box-shadow:0 6px 13px -4px rgba(24,22,24,0.3);-moz-box-shadow:0 6px 13px -4px rgba(24,22,24,0.3);box-shadow:0 6px 13px -4px rgba(24,22,24,0.3)}
.row-search .find_a_cruise_box .form-group .cd-sub-room{padding:15px;position:absolute;display:block;right:-415px;z-index:3;width:400px;top:52px;left:0;min-height:300px;color:#333;background-color:#f6f8f9;border:1px solid #ccc;-webkit-border-radius:5px;-khtml-border-radius:5px;-moz-border-radius:5px;-ms-border-radius:5px;-o-border-radius:5px;border-radius:5px;-webkit-box-shadow:0 6px 13px -4px rgba(24,22,24,0.3);-moz-box-shadow:0 6px 13px -4px rgba(24,22,24,0.3);box-shadow:0 6px 13px -4px rgba(24,22,24,0.3)}
.find_a_cruise_box .cd-sub-room .btn-style-1{width:130px;height:38px;margin-right:10px;}
#show_check_rate{position:absolute;right:0;top:17px}
.row-search #show_check_rate{position:absolute;right:auto;top:42px;left:50px}
#show_check_rate.open:before,#show_check_rate.open:after{bottom:100%;top:0;right:-16px;border:solid transparent;content:"";height:0;width:0;position:absolute;pointer-events:none;z-index:1}
#show_check_rate.open:before{border-right-color:#ccc;border-width:14px;margin-top:-14px}
#show_check_rate.open:after{border-right-color:#f6f8f9;border-width:13px;margin-top:-13px}
.row-search #show_check_rate.open:before,.row-search #show_check_rate.open:after{bottom:100%;top:-3px;right:-16px;border:solid transparent;content:"";height:0;width:0;position:absolute;pointer-events:none;z-index:4}
.row-search #show_check_rate.open:before{border-bottom-color:#ccc;border-width:14px;margin-top:-14px}
.row-search #show_check_rate.open:after{border-bottom-color:#f6f8f9;border-width:14px;margin-top:-13px}
.cd-sub-close,.cp-detail-close{font-size:18px;cursor:pointer}
.search_box_cruise_detail .fixed{position:fixed!important;top:85px!important}
@media (max-width: 991px) {
.find_a_cruise_box .form-group .cd-sub-room{padding:15px;position:absolute;display:block;right:0;z-index:9;width:100%;max-width:400px;top:-313px}
#show_check_rate{position:absolute;right:0;top:0}
#show_check_rate.open:before,#show_check_rate.open:after{bottom:100%;top:3px;right:300px;border:solid transparent;content:"";height:0;width:0;position:absolute;pointer-events:none;z-index:10;display:none}
#show_check_rate.open:after{border-top-color:#f6f8f9;border-width:13px;margin-top:-13px}
#show_check_rate.open:before{border-top-color:#ccc;border-width:14px;margin-top:-14px}
.row-search #show_check_rate.open:before,.row-search #show_check_rate.open:after{bottom:100%;top:-3px;right:-16px;border:solid transparent;content:"";height:0;width:0;position:absolute;pointer-events:none;z-index:4}
.row-search #show_check_rate.open:before{border-bottom-color:#ccc;border-width:14px;margin-top:-14px}
.row-search #show_check_rate.open:after{border-bottom-color:#f6f8f9;border-width:14px;margin-top:-13px}
}
@media (max-width:524px) {
.row-search .find_a_cruise_box .form-group .cd-sub-room{padding:15px;position:absolute;display:block;right:-415px;z-index:3;width:100%;max-width:400px}
}
@media (max-width:430px) {
.entry_body_search{padding:15px 8px}
.row-search .find_a_cruise_box .form-group .cd-sub-room{padding:15px 6px}
#listRoom .row{margin-left:-3px!important;margin-right:-3px!important}
#listRoom .col-xs-3{padding-left:3px!important;padding-right:3px!important}
}
</style>
{/literal}