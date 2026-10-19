<div class="searchBox">
	<div class="container">
		<form class="find__trip--form" id="form_avaiable" method="post" action="">
			{if $act ne 'detail'}
			<div class="input_key_word">
				<input type="search" class="form-control" name="keyword" autocomplete="off" role="presentation" id="searchkey" value="{if $hotel_id}{$clsHotel->getTitle($hotel_id)}{else}{$clsCity->getTitle($city_id)}{/if}" placeholder="{$core->get_Lang('Bạn muốn đi hay ở  đâu?')}....">
				<div class="autosugget" id="autosugget" style="display: none">
					<ul class="HTML_sugget"></ul>
				</div>
			</div>
			{/if}
			<div class="form-group">
				<input readonly id="checkin" type="text" value="{$clsISO->converTimeToText5($now)}" class="form-control" placeholder="{$core->get_Lang('Check in')}" />
			</div>
			<div class="form-group">
				<input readonly id="checkout" type="text" value="{$clsISO->converTimeToText5($now_next)}" class="form-control" placeholder="{$core->get_Lang('Check in')}" />
			</div>
			<div class="form-group"></div>
			<div class="form_select form_select_people">
				<div class="pick_travellers" id="pick_travellers">
					<span id="people_text">2 {$core->get_Lang('Adults')}, 0 {$core->get_Lang('Children')}</span>
					<span id="room_text">1 {$core->get_Lang('room')}</span>
				</div>
				<div id="check_number_travellers" class="check_number_travellers" style="display:none;">
					<div id="listRoom">
						<div class="form-group pick_number">
							<label>{$core->get_Lang('Adults')}</label>
							<div class="choose_right">
								<a class="unNum2 unNum_adults" data-type="adult" ></a>
								<input type="text" id="number_adult" min="1" class="input_number find_select"
									   value="2" name="number_adult"/>
								<a class="upNum2 upNum_adults" data-type="adult" ></a>
							</div>
						</div>
						<div class="form-group pick_number">
							<label>{$core->get_Lang('Children')}</label>
							<div class="choose_right">
								<a class="unNum2" id="unNum_children" data-type="child" ></a>
								<input type="text" class="input_number find_select" name="number_child" min="0" id="number_child" value="0"/>
								<a class="upNum2 " id="upNum_children" data-type="child" ></a>
							</div>
						</div>

						<div class="form-group pick_number">
							<label>{$core->get_Lang('Number Room')}</label>
							<div class="choose_right">
								<a class="unNum2" id="unNum_room" data-type="room"></a>
								<input type="text" class="input_number find_select" name="number_room"
									   min="1" id="number_room" value="1" max="10"/>
								<a class="upNum2 " id="upNum_room" data-type="room"></a>
							</div>
						</div>
					</div>
					<div class="form-group mb0">
						<button class="btn_submit btn_remove" type="button" onClick="$('#check_number_travellers').hide();">{$core->get_Lang('Remove')}</button>
						{if $act eq 'detail'}
						<button class="btn_submit btn_apply" id="ApplyCheckPrice" type="button" onClick="$('#check_number_travellers').hide();">{$core->get_Lang('Apply')}</button>
						{else}
						<button class="btn_submit btn_apply" type="submit" onClick="$('#check_number_travellers').hide();">{$core->get_Lang('Apply')}</button>
						{/if}
					</div>
				</div>
			</div>
			{if $act eq 'detail'}
			<button type="button" class="btn btn_find_trip" id="CheckPriceHomestay">{$core->get_Lang('Check')}</button>
			<input type="hidden" id="hotel_id" name="hotel_id" value="{$hotel_id}" />
			{else}
			<button type="submit" class="btn btn_find_trip" id="findtBtn">{$core->get_Lang('Search')}</button>
			{/if}
			<input type="hidden" name="hid_search" value="Search_Hotel_API" />
			<input type="hidden" name="keywordType" id="keywordType" value="" />
			<input type="hidden" name="checkin" id="check_in" value="{$clsISO->formatDateAPI($now)}" />
			<input type="hidden" name="checkout" id="check_out" value="{$clsISO->formatDateAPI($now_next)}" />
		</form>
	</div>
</div>
<script>
	var $hotel_id= '{$hotel_id}';
	var duration= '{$duration_1}';
	var number_adult= '{$number_adult}';
	var number_child= '{$number_child}';
	var number_room= '{$clsHotel->getOneField("number_stay",$hotel_id)}';
	var duration= '{$duration_1}';
	var mod = '{$mod}';
	var Loading = '{$core->get_Lang("Loading")}';
	var night='{$core->get_Lang("night")}';
	var nights='{$core->get_Lang("nights")}';
	var Today='{$core->get_Lang("Today")}';
	var Adult='{$core->get_Lang("Adult")}';
    var Child='{$core->get_Lang("Children")}';
    var Infant='{$core->get_Lang("Infant")}';
    var room='{$core->get_Lang("room")}';
	var checkin='{$checkin}';
	var checkout='{$checkout}';
	var checkin1='{$checkin1}';
	var checkout1='{$checkout1}';
	var Input_data_is_invalid='{$core->get_Lang("Input data is invalid")}';
</script>
{literal}
<script>
$(document).ready(function(){
	getNumberPerson();
	$('#checkin').datepicker({
		dateFormat: 'DD, dd/mm/yy',
		minDate: "+0D", maxDate: "+1Y",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		onSelect: function(dateStr) { 
			var date = $(this).datepicker('getDate'); 
			if(date){ 
				date.setDate(date.getDate() + 1); 
			} 
			loadTextDayCheckIn($(this).val());
			$('#checkout').datepicker('option', {minDate: date}).datepicker('setDate', date); 
		},
		onClose: function(dateText, inst) {
			$('#checkout').focus();
		}
	});
	$("#checkout").datepicker( { 
		dateFormat: 'DD, dd/mm/yy',
		minDate: new Date(), maxDate: "+1Y",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		onSelect: function(dateStr) { 
			loadTextDayCheckOut($(this).val());
		},
	});	
	$('.upNum2').click(function() {
		var number_person = $(this).val();
		var type = $(this).data('type');
		var val = parseInt($("#number_"+type).val());
		var max_number = parseInt($("#number_"+type).attr('max'));
		val = val + 1;
		if (val > max_number) {
			alert(Input_data_is_invalid);
			val = max_number;
		}
		$("#number_"+type).val(val);
		getNumberPerson();
	});
	$('.unNum2').click(function() {
		var number_person = $(this).val();
		var type = $(this).data('type');
		var val = parseInt($("#number_"+type).val());
		var min_number = parseInt($("#number_"+type).attr('min'));
		val = val - 1;
		if (val < min_number) {
			alert(Input_data_is_invalid);
			val = min_number;
		}
		$("#number_"+type).val(val);
		getNumberPerson();
	});
	$('.btn_remove').click(function() {
		$('#number_adult').val(1);
		$('#number_child').val(0);
		$('#number_infant').val(0);
		getNumberPerson();
	});
	$('#unNum_room').click(function() {
		$('#number_adult').val(1);
		$('#number_child').val(0);
		getNumberPerson();
	});
	
	$('#searchkey').click(function() { 
		search_place();
		$('.bg-black').show();
		if($('#pick_travellers').hasClass('open')){
			$('#check_number_travellers').hide();
			$('#pick_travellers').removeClass('open');
		}
	});
	
	$("#searchkey").on('keyup', delay(function(){
		var $_this=$(this),
			keySearch = $.trim($_this.val());
			search_place();
	},600));

	
	$('#pick_travellers').click(function(){
		$('.bg-black').show();
		$('#autosugget').hide();
		var  $_this=$(this);
		if($_this.hasClass('open')){
			$('#check_number_travellers').hide();
			$_this.removeClass('open');
		}else{
			$('#check_number_travellers').show();
			$_this.addClass('open');
		}
	});
	$('.bg-black').click(function () {
        $('.bg-black').hide();
		if($('#pick_travellers').hasClass('open')){
			$('#check_number_travellers').hide();
			$('#pick_travellers').removeClass('open');
		}
		$('#autosugget').hide();
    });
	
	$(document).on('click', ".select_item", function(ev) {	
		var keyword = $(this).data('name');
		var keywordType = $(this).data('type');
		$('#searchkey').val(keyword);
		$('#keywordType').val(keywordType);
		$('#autosugget').hide();
	});
	$('#CheckPriceHomestay,#ApplyCheckPrice').click(function () {
		$('.bg-black').hide();
		if($('#pick_travellers').hasClass('open')){
			$('#check_number_travellers').hide();
			$('#pick_travellers').removeClass('open');
		}
		var $_this=$(this),
		$number_adult=$('#number_adult').val(),
		$number_child=$('#number_child').val(),
		$number_room=$('#number_room').val(),
		$checkin=$('#checkin').val(),
		$checkout=$('#checkout').val();
		loadTablePrice();
	});
});
</script>
<script>

function delay(callback, ms) {
	var timer = 0;
	return function() {
	var context = this, 
		args = arguments;
	clearTimeout(timer);
	timer = setTimeout(() => {
		callback.apply(context, args); 
	}, ms || 2);
  }
}
function loadTextDayCheckIn(date){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod='+mod+'&act=loadCheckDate&lang='+LANG_ID,
		'data' : {"date":date},
		'dataType': 'html',
		'success':function(html){
			$("#check_in").val(html);
		}
	});
}
function loadTextDayCheckOut(date){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod='+mod+'&act=loadCheckDate&lang='+LANG_ID,
		'data' : {"date":date},
		'dataType': 'html',
		'success':function(html){
			$("#check_out").val(html);
		}
	});
}
function search_place(){
	$.ajax({
		type:'POST',
		url:path_ajax_script+'/index.php?mod=combo&act=ajGetSearchPlace&lang='+LANG_ID,
		data:{"keyword":$("#searchkey").val()},
		dataType:'html',
		success:function(html){
			if(html.indexOf('_EMPTY')>=0){
				$('#autosugget').hide();
			}else{
				$('#autosugget').stop(false,true).slideDown();
				$('#autosugget').find('.HTML_sugget').html(html);
			}
		}	
	});
}

function loadMaxPeople(homestay_id,number_adult,number_child,number_room){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=homestay&act=loadMaxPeople&lang='+LANG_ID,
		'data' : {"homestay_id":homestay_id,"number_adult":number_adult,"number_child":number_child,"number_room":number_room},
		'dataType': 'html',
		'success':function(html){
			var htm = html.split('|||');
			$("#number_adult").attr("max",htm[1]);
			$("#number_child").attr("max",htm[2]);
			
		}
	});
}
function getNumberPerson(){
	var number_adult=$('#number_adult').val();
	var number_child=$('#number_child').val();
	var number_infant=$('#number_infant').val();
	var number_room=$('#number_room').val();
	if(act=='detail'){
	   loadMaxPeople($hotel_id,number_adult,number_child,number_room);
	}
	
	$('#people_text').html( number_adult + ' ' +Adult+', ' +number_child+' '+Child);
	$('#room_text').html( number_room + ' ' +room);
}
function loadTablePrice(){
	$('#TablePrice').html('<div class="lazy_loading text-center"><img src="{/literal}{$URL_IMAGES}/icon/lazy_load_100_pink.svg{literal}" alt=""></div>');
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod='+mod+'&act=loadTablePrice&lang='+LANG_ID,
		data : $('#form_avaiable').serialize(),
		dataType:'html',
		success: function(html){
			$('#TablePrice').html(html);
			$('[data-toggle="popover"]').popover();
		}
	});
}

</script>
<style>
.searchBox{background: #20274d}
.hotel_detail_box .box_check_rates{display: inline-block; width: 100%; background: #f8f8f8; padding: 18px 18px 25px;}
.hotel_detail_box .searchBox{background: #f8f8f8;}
.hotel_detail_box .searchBox .container{width: 100%; padding: 0}
.find__trip--form{width:100%;display:flex;padding: 12px 0 16px; position: relative; z-index: 10}
.hotel_detail_box .find__trip--form{padding:0;}
.box_search_home{position:absolute;width:100%;bottom:-32px;z-index:1}
#autosugget{width:400px; position: absolute; z-index: 99}
#autosugget:before{
    display: block;
    width: 0;
    height: 0;
    border-left: 11px solid transparent;
    border-right: 11px solid transparent;
    border-bottom: 11px solid #fff;
    margin-left: 168px;
    content: "";
    transition: margin-left .3s ease-out;
}
#autosugget .listRoomDetail,#autosugget .totalRoom{font-size: 13px;color: #666}
.HTML_sugget {
position: relative;
z-index: 9;
background: #fff;
color: #333;
display: inline-block;
width: 100%;
margin: 0;
padding: 12px 15px 0;
}
.HTML_sugget .select_item{display: inline-block; width: 100%; cursor: pointer}
.HTML_sugget .select_item .location{display: inline-block; width: 100%;}
.select_item  .icon-Location{font-size: 24px; line-height: 24px; display: inline-block;color: rgb(128, 128, 128); vertical-align: middle}
.HTML_sugget .select_item .location .name_location{display: inline-block; float: left}
.HTML_sugget .select_item .location .type_location{display: inline-block; float: right}
.name_location .text_name{display: inline-block; line-height: 24px; font-weight: bold}
.type_location .text_type{color: #173d8f; font-size: 12px; line-height: 24px;}
.parent_location .text_parent{font-size: 12px;color: rgb(128, 128, 128)}
.find__trip--form .form-control{height:57px;background:#fff;color:#1c1c1c;padding-left: 63px; border: 1px solid #ccc}

.find__trip--form .form-control#searchkey:focus{ border-color:#ec1c47;}
.input_key_word{width:100%;max-width:360px;margin-right:5px;position: relative}
.input_key_word:before{position: absolute;content: "";background: url("/isocms/templates/default/skin/images/icon/sprite_icon_form_search.png") no-repeat;width: 30px;height: 25px;top: 15px;left: 20px}
.input_key_word .fa-search{position: absolute;top: 15px;left: 20px;color: #ccc;font-size: 22px}
.form_select{width:100%;margin-right:5px;height: 57px;max-width:350px;display: flex;}
.hotel_detail_box .form_select{margin-right: 10px;max-width:350px}
.date_local{background: #fff; border-radius: 4px;}
.form_select.form_select_people{max-width:285px;display: block;position: relative; background: #fff; border-radius: 4px; border: 1px solid #ccc}
.hotel_detail_box .form_select.form_select_people{max-width:calc(100% - 510px);display: block;position: relative; background: #fff; border-radius: 4px; border: 1px solid #ccc;}
.pick_travellers{display: inline-block;width: 100%;padding: 8px;padding-left: 57px;height: 55px;position: relative;border-radius: 4px;}
.pick_travellers.open{border: 1px solid #ec1c47;}
.pick_travellers:before {
    width: 33px;
    height: 26px;
    content: "";
    background: url(/isocms/templates/default/skin/images/icon/sprite_icon_form_search.png) no-repeat;
    background-position: 0 -28px;
    position: absolute;
    left: 20px;
    top: 14px;
}
#people_text{font-size: 15px;}
#room_text{position: absolute; bottom: 8px; left:57px; font-size: 13px; color: #666666;}
#check_number_travellers{position: absolute;background: white;width: 120%;text-align: center;z-index: 99;padding: 20px 20px 10px;top: 70px;}
#check_number_travellers:before {
	position: absolute;
	top:-11px;
	left: 0;
	right: 0;
	margin: 0 auto;
    display: block;
    width: 0;
    height: 0;
    border-left: 11px solid transparent;
    border-right: 11px solid transparent;
    border-bottom: 11px solid #fff;
    content: "";
    transition: margin-left .3s ease-out;
}
#check_number_travellers .form-group{display: inline-block;width: 100%;vertical-align: top;}
#check_number_travellers .form-group .choose_right{display: inline-block; width:115px; float: left}
#check_number_travellers .form-group .choose_right input{width: calc(100% - 70px);display: inline-block;float: left;line-height: 35px;padding: 0;text-align: center;border: 0;height: 35px;outline: none;color: #000;}
#check_number_travellers .form-group .choose_right a{display: inline-block;width: 35px;height: 35px;border: 1px solid #ccc;border-radius:100%;line-height: 35px;float: left;color: #666;font-size: 16px;vertical-align: top;font-weight: normal;position: relative}
#check_number_travellers .form-group .choose_right a.unNum2:before{position: absolute;content: "";background: url(/isocms/templates/default/skin/images/icon/sprite_icon_form_search.png) no-repeat;background-position: 3px -127px;width: 23px;height: 23px;top: 10px;left: 0}
#check_number_travellers .form-group .choose_right a.upNum2:before{position: absolute;content: "";background: url(/isocms/templates/default/skin/images/icon/sprite_icon_form_search.png) no-repeat;background-position: 3px -113px;width: 23px;height: 17px;top: 10px;left: 0}
#check_number_travellers .form-group label{display: inline-block;width:calc(100% - 115px);float: left;margin: 0;text-align: left;line-height: 35px;font-weight: 600;}
#check_number_travellers .form-group .btn_submit{border: 0;background: none;font-weight: bold;padding: 0;font-weight: 600;margin-top: 10px;}
#check_number_travellers .form-group .btn_submit.btn_remove{float: left; color: #989898; outline: none; font-size: 15px;}
#check_number_travellers .form-group .btn_submit.btn_apply{float: right; color: #eb1c46; outline: none; font-size: 15px;}
.btn_find_trip{width:120px;background:#ec1c47;height:57px;font-size:18px;font-weight:700;color: white;text-transform: uppercase}
.btn_find_trip:focus,.btn_find_trip:active:focus{outline: none}
</style>
{/literal}