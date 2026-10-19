$(document).ready(function(){	
	$("#full_name").combogrid({
		panelWidth:800,
		mode: 'remote',
		method:'post',
		multiple:true,
		url: path_ajax_script+"/index.php?mod=booking&act=load_customer",
		columns:[[
			{field:'add',title:'',width:30,align:'center'},
			{field:'id',title:'ID',width:30,align:'center'},
			{field:'name',title:'Tên',width:100},
			{field:'email',title:'Email',width:100,align:'left'},
			{field:'phone',title:'Điện thoại',width:80,align:'left'},
			{field:'address',title:'Địa chỉ',width:200,align:'left'},
		]],
		fitColumns: true,
		showFooter: true,
		pagination: true,
		pageSize: 20
	});
	$("#full_name").change(function(){
		$(this).combogrid('grid').datagrid('load', {'_reload':true});
	});
	
	$(".price_tour").priceFormat({
		thousandsSeparator: ' ',
		centsLimit: 0
	});
	
});
$(document).on('click', '.add_booking', function(ev){
	var $_this = $(this);
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=addBooking',
		data : {'blogcat_id':$_this.attr('data'),'tp':'F'},
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			makepopupnotresize('80%', 'auto', html, 'box_AddBooking');
			$('#box_AddBooking').css('top', '50px');
			$('select[name=product_group]').trigger('change');
			$('select[name=cat_id]').trigger('change');
			var $editorID = $('.textarea_blog_intro_editor').attr('id');
			$('#'+$editorID).isoTextAreaFix();
		}
	});
	return false;
});
$(document).on('change', 'input[name="ServicesBonus"]', function(ev){
	var services_id = $(this).val();
	var tour_id = $(this).data('tour_id');
	var combo_id = $(this).data('combo_id');
	var type = $(this).data('type');
	vietiso_loading(1);
	if(type == 'tour'){
		var table_id=tour_id;
		var service = $('#lst_service_bonus_'+tour_id).find(".service_"+services_id);
	}
	if(type == 'combo'){
		var table_id=combo_id;
		var service = $('#lst_service_bonus_combo_'+combo_id).find(".service_"+services_id);
	}
	if(service.length > 0){
		vietiso_loading(0);
		var numberService = parseInt(service.val());
		service.val(numberService + 1);
		loadTotalPrice($(this),type,table_id);
	}else{
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=booking&act=addServiceBooking',
			data : {'service_id':services_id,"type":type,"table_id":table_id},
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				if(type == 'tour'){
					$('#lst_service_bonus_'+tour_id).append(html);	
				}
				if(type == 'combo'){
					$('#lst_service_bonus_combo_'+combo_id).append(html);
				}
				loadTotalPrice($(this),type,table_id);

			}
		});
	}

	return false;
});
$(document).on('change, keyup','input[name="check_in"],input[name="check_out"],.number_persion_hotel',function(elm){
	$(this).closest(".box_content_book").find('.lst_service_bonus').html('');
	$(this).closest(".box_content_book").find('select[name="HotelRoom"]').val('');		
})
$(document).on('click','#btn_addHotelRoom',function(){
	var $_this = $(this);
	var roomHotel = $(this).closest('.box_content_right').find('select[name="HotelRoom"]');
	var room_id = roomHotel.val();
	var hotel_id = roomHotel.data('hotel_id');
	var box_parent = $(this).closest(".box_content_book");
	var check_in = box_parent.find('input[name="check_in"]').val();
	var check_out = box_parent.find('input[name="check_out"]').val();
	var number_adult = box_parent.find('input[name="number_adult"]').val();
	var number_child = box_parent.find('input[name="number_child"]').val();
	vietiso_loading(1);
	var room = $('#lst_hotel_room_'+hotel_id).find(".room_"+room_id);
	if(check_in == '' || check_out == '' || (number_adult < 1 && number_child < 1)){
		if(check_in == ''){
			box_parent.find('input[name="check_in"]').addClass('error');
		}else{
			box_parent.find('input[name="check_in"]').removeClass('error');
		}
		if(check_out == ''){				
			box_parent.find('input[name="check_out"]').addClass('error');
		}else{
			box_parent.find('input[name="check_out"]').removeClass('error');
		}
		if(number_adult < 1 && number_child < 1){				
			box_parent.find('.number_persion_hotel').addClass('error');
		}else{
			box_parent.find('.number_persion_hotel').removeClass('error');
		}
		$(this).val('');
		vietiso_loading(0);
		return false;
	}else{
		box_parent.find('input[name="check_in"],input[name="check_out"]').removeClass('error');
	}
	if(room.length > 0){
		vietiso_loading(0);
		var numberRoom = parseInt(room.val());
		room.val(numberRoom + 1);
		loadTotalPrice($_this,'hotel',hotel_id);
	}else{
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=booking&act=addHotelRoomBooking',
			data : {
				'room_id':room_id,
				check_in		:	check_in,
				check_out		:	check_out,
				number_adult	:	number_adult,
				number_child	:	number_child,
			},
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				$('#lst_hotel_room_'+hotel_id).append(html);
				loadTotalPrice($_this,'hotel',hotel_id);
			}
		});
	}

	return false;
});
/*$(document).on('change', 'select[name="HotelRoom"]', function(ev){
	var $_this = $(this);
	var room_id = $(this).val();
	var hotel_id = $(this).data('hotel_id');
	var check_in = $(this).closest(".box_content_book").find('input[name="check_in"]').val();
	var check_out = $(this).closest(".box_content_book").find('input[name="check_out"]').val();
	var number_adult = $(this).closest(".box_content_book").find('input[name="number_adult"]').val();
	var number_child = $(this).closest(".box_content_book").find('input[name="number_child"]').val();
	vietiso_loading(1);
	var room = $('#lst_hotel_room_'+hotel_id).find(".room_"+room_id);
	if(check_in == '' || check_out == '' || (number_adult < 1 && number_child < 1)){
		if(check_in == ''){
			$(this).closest(".box_content_book").find('input[name="check_in"]').addClass('error');
		}else{
			$(this).closest(".box_content_book").find('input[name="check_in"]').removeClass('error');
		}
		if(check_out == ''){				
			$(this).closest(".box_content_book").find('input[name="check_out"]').addClass('error');
		}else{
			$(this).closest(".box_content_book").find('input[name="check_out"]').removeClass('error');
		}
		if(number_adult < 1 && number_child < 1){				
			$(this).closest(".box_content_book").find('.number_persion_hotel').addClass('error');
		}else{
			$(this).closest(".box_content_book").find('.number_persion_hotel').removeClass('error');
		}
		$(this).val('');
		vietiso_loading(0);
		return false;
	}else{
		$(this).closest(".box_content_book").find('input[name="check_in"],input[name="check_out"]').removeClass('error');
	}
	if(room.length > 0){
		vietiso_loading(0);
		var numberRoom = parseInt(room.val());
		room.val(numberRoom + 1);
		loadTotalPrice($_this,'hotel',hotel_id);
	}else{
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=booking&act=addHotelRoomBooking',
			data : {
				'room_id':room_id,
				check_in		:	check_in,
				check_out		:	check_out,
				number_adult	:	number_adult,
				number_child	:	number_child,
			},
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				$('#lst_hotel_room_'+hotel_id).append(html);
				loadTotalPrice($_this,'hotel',hotel_id);
			}
		});
	}

	return false;
});*/
$(document).on('click','#btn_addCruiseCabin',function(){
	var $_this = $(this);
	var selectCabin = $(this).closest('.box_content_right').find('select[name="CruiseCabin"]');
	var cruise_cabin_id = selectCabin.val();
	var cruise_id = selectCabin.data('cruise_id');
	var box_parent = $(this).closest('.box_info_booking');
	var number_adult = box_parent.find('input[name="number_adult"]').val();
	var number_child = box_parent.find('input[name="number_child"]').val();
	var max_child = box_parent.find('input[name="number_child"]').attr('max');
	var departure_date = box_parent.find('input[name="departure_date"]').val();
	var infants = [];
	for(var i=1; i<= parseInt(max_child); i++){
		var infant = $("#infant1s_"+i).val();
		infants.push(infant);
	}
	var cabin = $('#lst_cruise_cabin_'+cruise_id).find(".cabin_"+cruise_cabin_id);
	if(cabin.length == 0){
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=booking&act=addCruiseCabinBooking',
			data : {'cruise_cabin_id':cruise_cabin_id,'number_adult':number_adult,'number_child':number_child,'cruise_id':cruise_id,'infants':infants,'departure_date':departure_date},
			dataType: 'html',
			success: function(html) {	
				vietiso_loading(0);
				$('#lst_cruise_cabin_'+cruise_id).append(html);
				loadTotalPrice(selectCabin,'cruise',cruise_id);
			}
		});
	}

	return false;
});
/*$(document).on('change', 'select[name="CruiseCabin"]', function(ev){
	var $_this = $(this);
	var cruise_cabin_id = $(this).val();
	var cruise_id = $(this).data('cruise_id');
	var box_parent = $(this).closest('.box_info_booking');
	var number_adult = box_parent.find('input[name="number_adult"]').val();
	var number_child = box_parent.find('input[name="number_child"]').val();
	var max_child = box_parent.find('input[name="number_child"]').attr('max');
	var departure_date = $(this).closest(".box_content_book").find('input[name="departure_date"]').val();
	var infants = [];
	for(var i=1; i<= parseInt(max_child); i++){
		var infant = $("#infant1s_"+i).val();
		infants.push(infant);
	}
	var cabin = $('#lst_cruise_cabin_'+cruise_id).find(".cabin_"+cruise_cabin_id);
	if(cabin.length == 0){
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=booking&act=addCruiseCabinBooking',
			data : {'cruise_cabin_id':cruise_cabin_id,'number_adult':number_adult,'number_child':number_child,'cruise_id':cruise_id,'infants':infants,'departure_date':departure_date},
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				$('#lst_cruise_cabin_'+cruise_id).append(html);
				loadTotalPrice($_this,'cruise',cruise_id);
			}
		});
	}

	return false;
});*/
$(document).on('focus keypress','#searchtour',function(){
	show_product('tour');
});
$(document).on('focus keypress','#searchhotel',function(){
	show_product('hotel');
});
$(document).on('focus keypress','#searchcruise',function(){
	show_product('cruise');
});
$(document).on('focus keypress','#searchcombo',function(){
	show_product('combo');
});
$(document).on('focus keypress','#searchvoucher',function(){
	show_product('voucher');
});
$(document).on('click','.btn_cancel_booking',function(){
	$('#addBooking').find("input,select").val('');
	$('#addBooking').find("select").trigger('change');		
	$("#box_booking").html('');

	booking_data = {"type":"delete_session"};	
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=updateSession',
		data : booking_data,
		dataType: 'html',
		success: function(html) {
		}
	});
});
$(document).on('click','.btnClickToSubmitBooking',function(e){
	e.preventDefault();
	var check=true;
	$("#addBooking").find("input,select").each(function(index,elm){
		if(($(elm).val() == '' || $(elm).val() == 0) && $(elm).hasClass('required')){
			$(elm).focus();
			$(elm).addClass('error');
			check = false;
			return false;
		}else{
			$(elm).removeClass('error');
		}
	});

	var email = $("#addBooking").find("input[name='email']").val();
	if(email != ''){
		if(checkValidEmail(email)==false){
			$("#addBooking").find("input[name='email']").addClass('error').focus();
			check = false;
			return false;
		}			
	}
	if(!check){
		return false;
	}
	if($("#addBooking").find(".box_info_booking").length == 0 && check){
		var text_error = $("#addBooking").find(".text_error").text();
		alert(text_error);
		return false;
	}
	if($("#addBooking").find(".box_info_booking").length > 0){
		$("#addBooking").find(".box_info_booking").each(function(index,elm){
			var type = $(elm).data('type');
			if(type == 'cruise'){
				if($(elm).find(".lst_service_bonus .form-item").length == 0 && $(elm).find(".changeServicesBonus").val() > 0){

					$(elm).find(".changeServicesBonus").addClass("error").val("").focus();
					return false
				}
			}
			if(type == 'hotel'){
				if($(elm).find(".lst_service_bonus .form-item").length == 0 && $(elm).find(".changeServicesBonus").val() > 0){

					$(elm).find(".changeServicesBonus").addClass("error").val("").focus();
					return false
				}
			}

		});

	}
	var data = {
		"full_name"				:	$("#addBooking").find("input[name='full_name']").val(),
		"birthday"				:	$("#addBooking").find("input[name='birthday']").val(),
		"email"					:	$("#addBooking").find("input[name='email']").val(),
		"phone"					:	$("#addBooking").find("input[name='phone']").val(),
		"country_id"			:	$("#addBooking").find("select[name='country_id']").val(),
		"address"				:	$("#addBooking").find("input[name='address']").val(),
		"address"				:	$("#addBooking").find("input[name='address']").val(),
		"price_total"			:	$("#addBooking").find("input[name='price_total']").val(),
		"price_deposit"			:	$("#addBooking").find("input[name='price_deposit']").val(),
		"price_final_payment"	:	$("#addBooking").find("input[name='price_final_payment']").val(),
		"price_total_payment"	:	$("#addBooking").find("input[name='price_total_payment']").val(),
		"payment_method"		:	$("#addBooking").find("input[name='payment_method']:checked").val(),
		"customer_note"			:	$("#addBooking").find("textarea[name='customer_note']").val(),
	};	
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=addNewBooking',
		data : data,
		dataType: 'html',
		success: function(link) {
			vietiso_loading(0);
//			location.href = link;
		}
	});

});
$(document).on('change keyup','input[name="departure_date"],input[name="departure"],input[name="number_adult"],input[name="number_child"],.child_age,.cruise_cabin',function(){
	var $_this = $(this);
	var elm_parent = $(this).closest('.box_info_booking');
	var type = elm_parent.data("type");
	var clssType = type+"_select";
	var type_id = elm_parent.find("."+clssType).val();

	if(type == 'cruise'){
		loadPriceCruise($_this);
	}else{
		loadTotalPrice($(this),type,type_id);
	}

});
$(document).on('click','.btnClickToSubmitAddCustomer',function(){
	var check = true;
	$("#frmAddCustomer").find("input,select").each(function(index,elm){
		if(($(elm).val() == '' || $(elm).val() == 0) && $(elm).hasClass('required')){
			console.log('sss');
			$(elm).focus();
			$(elm).addClass('error');
			check = false;
			return false;
		}else{
			$(elm).removeClass('error');
		}
	});
	var email = $("#frmAddCustomer").find("input[name='email_new']").val();
	if(email != ''){
		if(checkValidEmail(email)==false){
			$("#frmAddCustomer").find("input[name='email_new']").addClass('error').focus();
			check = false;
			return false;
		}			
	}
		
	var full_name = $("#frmAddCustomer").find('input[name="full_name_new"]').val();
	var email = $("#frmAddCustomer").find('input[name="email_new"]').val();
	var birthday =  $("#frmAddCustomer").find('input[name="birthday_new"]').val();
	var phone = $("#frmAddCustomer").find('input[name="phone_new"]').val();
	var country_id = $("#frmAddCustomer").find('select[name="country_id_new"]').val();
	var address = $("#frmAddCustomer").find('input[name="address_new"]').val();
	if(!check){
		return false;
	}else{
		var formData = new FormData(document.getElementById("frmAddCustomer"));
		$.ajax({
			type:"POST",
			dataType: "json",
			data: formData,
			processData: false,
			contentType:false,
			url:  path_ajax_script + "/index.php?mod=booking&act=ajAddCustomer",
			success: function(json){
				alertify.success(json.message);
				if(json.result){
					$("#addCustomer").modal('hide');
					$("#collapseContact").find(".textbox.combo input").val(full_name);
					$("#collapseContact").find("input[comboname='fullname']").val(full_name);
					$("input[name='full_name']").val(full_name);
					$("input[name='birthday']").val(birthday);
					$("input[name='email']").val(email);
					$("input[name='phone']").val(phone);
					$("input[name='address']").val(address);
					$("#country_id").val(country_id);
					$("#country_id").select2().trigger('change');
					
				}				
			}
		});
	}
});

/*function booking*/
function updateSession(elm,type,type_id,act=''){
	var elm_parent = $(elm).closest('.box_info_booking');
	var booking_data = '';
	if(type == 'tour'){
		var tour_id_z = type_id;
		var elm_parent = $("#tour_"+type_id);
		var tour__class = elm_parent.find('input[name="tour_option"]').val();
		
		var number_addon = {};
		var total_addon = 0;
		$('#lst_service_bonus_'+tour_id_z).find('.service_tour').each(function(index,elm1){
			var service_id = $(elm1).data('service');
			var number_service = $(elm1).val();
			var price_service = $(elm1).data('price');
			number_addon[service_id] = number_service;
			total_addon += parseInt(number_service);
		});
		var promotion = elm_parent.find('.promotion').val();
		promotion = (promotion > 0)?parseInt(promotion):0;
		var number_adults_z = elm_parent.find('input[name="adult_simple"]').val();
		number_adults_z = (number_adults_z > 0)?parseInt(number_adults_z):0;
		var number_child_z = elm_parent.find('input[name="children_simple"]').val();
		number_child_z = (number_child_z > 0)?parseInt(number_child_z):0;
		var number_infants_z = elm_parent.find('input[name="infants_simple"]').val();
		number_infants_z = (number_infants_z > 0)?parseInt(number_infants_z):0;
		
		var price_adults_z = elm_parent.find('input[name="adult_simple"]').data('price_adults_simple');
		price_adults_z = (price_adults_z > 0)?price_adults_z:0;
		var price_child_z = elm_parent.find('input[name="children_simple"]').data('price_child_simple');
		price_child_z = (price_child_z > 0)?price_child_z:0;
		var price_infants_z = elm_parent.find('input[name="price_infants_z"]').data('price_infants_simple');
		price_infants_z = (price_infants_z > 0)?price_infants_z:0;
		
		price_promotion = (price_adults_z + price_child_z + price_infants_z)*promotion/100;
		
		var total_price_adults = number_adults_z * parseInt(price_adults_z);
		var total_price_child = number_child_z * parseInt(price_child_z);
		var total_price_infants = number_infants_z * parseInt(price_infants_z);
		var check_in_book_z = elm_parent.find('input[name="departure"]').val();
		var deposit = elm_parent.find('.deposit').val();
		deposit = (deposit != 0)?parseInt(deposit):0;
		var price_deposit = ((total_price_adults + total_price_child + total_price_infants) * deposit * (100 - promotion)) / (100 * 100);
		var total_price_z = ((total_price_adults + total_price_child + total_price_infants) * (100 - promotion)) / 100;
		var data = {
			"tour__class"			:	tour__class,
			"number_addon"			:	Object.assign({}, number_addon),
			"tour_id_z"				:	tour_id_z,
			"promotion_z"			:	promotion,
			"price_promotion"		:	price_promotion,
			"number_adults_z"		:	number_adults_z,
			"number_child_z"		:	number_child_z,
			"number_infants_z"		:	number_infants_z,
			"price_adults_z"		:	price_adults_z,
			"price_child_z"			:	price_child_z,
			"price_infants_z"		:	price_infants_z,
			"total_price_adults"	:	total_price_adults,
			"total_price_child"		:	total_price_child,
			"total_price_infants"	:	total_price_infants,
			"check_in_book_z"		:	check_in_book_z,
			"deposit"				:	deposit,
			"price_deposit"			:	price_deposit,
			"total_price_z"			:	total_price_z,
			"total_addon"			:	total_addon,
			"BookingTour"			:	"BookingTour"
		};
		booking_data = {'data':data,"type":type,table_id:tour_id_z,act:act};	
	}
	if (type == 'voucher'){
		var elm_parent_voucher = $("#voucher_"+type_id);
		var voucherGroup_id = elm_parent_voucher.find('select[name="voucherGroup_id"]').val();
		var voucher_id_z = type_id;
		var data = {
			"voucherGroup_id"			:	voucherGroup_id,
			"voucher_id_z"				:	voucher_id_z,
			"BookingVoucher"			:	"BookingVoucher"
		};
		booking_data = {'data':data,"type":type,table_id:voucher_id_z,act:act};	
	}
	if (type == 'combo'){
		var elm_parent_combo = $("#combo_"+type_id);
		var combo_id = type_id;
		var price_booking = elm_parent_combo.find('input[name="price_booking"]').val();
		var departure_date = elm_parent_combo.find('input[name="departure_date"]').val();
		var data = {
			"combo_id"			:	combo_id,
			"price_booking"		:	price_booking,
			"departure_date"	:	departure_date,
			"BookingCombo"		:	"BookingCombo"
		};
		booking_data = {'data':data,"type":type,table_id:combo_id,act:act};	
	}
	if(type == 'hotel'){
		var hotel_id = type_id;
		var elm_parent = $("#hotel_"+type_id);
		
		var check_in = elm_parent.find('input[name="check_in"]').val();
		var check_out = elm_parent.find('input[name="check_out"]').val();
		var hotel_room_id = elm_parent.find('input[name="hotel_room_id"]').val();
		var number_adult = elm_parent.find('input[name="number_adult"]').val();
		number_adult = (number_adult > 0)?parseInt(number_adult):0;
		var number_child = elm_parent.find('input[name="number_child"]').val();
		number_child = (number_child > 0)?parseInt(number_child):0;
		
		var array_room = {};
		$('#lst_hotel_room_'+hotel_id).find(".room_hotel").each(function(index,elm2){
			var hotel_room_id = $(elm2).data('hotel_room_id');
			var number_room = $(elm2).val();
			var totalprice = $(elm2).data('price_simple');
			var number_nights = $(elm2).data('number_nights');
			var max_adult = $(elm2).data('max_adult');
			var max_child = $(elm2).data('max_child');
			array_room[hotel_room_id] = {
				"hotel_id": hotel_id,
				"hotel_room_id": hotel_room_id,
				"number_adult": number_adult,
				"number_child": number_child,
				"number_room": number_room,				
				"number_nights": number_nights,				
				"max_adult": max_adult,			
				"max_child": max_child,			
				"totalprice": totalprice				
			};
		});
		var data = {
			"hotel_id"			:	hotel_id,
			"check_in"			:	check_in,
			"check_out"			:	check_out,
			"BookingHotel"		:	"BookingHotel",
			"room"				:	JSON.stringify(array_room), 
		};	
		booking_data = {'data':data,"type":type,table_id:hotel_id,act:act};	
	}
	if(type == 'cruise'){			
		var cruise_id = type_id;
		var elm_parent = $("#cruise_"+type_id);
		var cruise_itinerary_id = elm_parent.find('select[name="cruise_itinerary_id"]').val();
		var departure_date = elm_parent.find('input[name="departure_date"]').val();
		
		var array_cabin = {};
		$('#lst_cruise_cabin_'+cruise_id).find(".box_price_by_option").each(function(index,elm2){
			var $cruise_cabin = $(elm2).find(".cruise_cabin");
			var cruise_cabin_id = $cruise_cabin.data('cruise_cabin_id');
			var number_cabin = $cruise_cabin.val();
			var totalprice = $cruise_cabin.data('price');
			var max_adult = $cruise_cabin.data('max_adult');
			var max_child = $cruise_cabin.data('max_child');
			
			var total_number_adult = 0, total_number_child = 0;
			var arrayChild = [],array_adult=[],array_child=[]
			$(elm2).find('.box_cabin_book .cabin_book').each(function(i,elm3){
				var array_infant=[];
				var number_adult = $(elm3).find('input[name="number_adult"]').val();
				array_adult[i] = number_adult;
				total_number_adult += parseInt(number_adult);
				
				var number_child = $(elm3).find('input[name="number_child"]').val();				
				array_child[i] = number_child;
				total_number_child += parseInt(number_child);
				
				if(number_child > 0){
					$(elm3).find(".child_age").each(function(ind,elm4){
						if(ind <= number_child){
							array_infant[ind]=$(elm4).val();
						}
					});
					arrayChild[i]= array_infant;
				}
			});
			
			
			array_cabin[cruise_cabin_id] = {
				"cruise_id": cruise_id,
				"cruise_itinerary_id": cruise_itinerary_id,
				"cruise_cabin_id": cruise_cabin_id,
				"number_adult": total_number_adult,
				"number_child": total_number_child,
				"array_adult"	:	array_adult,
				"array_child"	:	array_child,
				"array_infant"	: arrayChild,
				"number_cabin": number_cabin,					
				"max_adult": max_adult,			
				"max_child": max_child,			
				"totalprice": totalprice				
			};
		});
		console.log(array_cabin);
		var data = {
			"cruise_id"				:	cruise_id,
			"cruise_itinerary_id"	:	cruise_itinerary_id,
			"departure_date"			:	departure_date,
			"BookingCruise"		:	"BookingCruise",
			"cabin"				:	JSON.stringify(array_cabin), 
		};	
		booking_data = {'data':data,"type":type,table_id:cruise_id,act:act};	
	}
		
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=updateSession',
		data : booking_data,
		dataType: 'html',
		success: function(html) {
		}
	});
}
function show_option_product(e){
	var product_type = $(e).val();
	$('#box_option_product').html('<div class="loading text-center">Loading...</div>');
	$.post(path_ajax_script+"/index.php?mod=booking&act=handler_filter_objects", {
		'product_type' : product_type,
	}, function(respJson){
		$('#box_option_product').html(respJson.html);
		if(respJson.callback){
			eval(respJson.callback);
		}
	}, 'json');
}
function addServicesBooking(elm){
	var service_id = $(elm).val();
	var tour_id = $(elm).data('tour_id');
	var combo_id = $(elm).data('combo_id');
	var type = $(elm).data('type');
	if(type == 'tour'){
		var table_id=tour_id;
	}
	if(type == 'combo'){
		var table_id=combo_id;
	}
	if($(elm).is(":checked")){
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=booking&act=addServiceBooking',
			data : {'service_id':service_id,"type":type,"table_id":table_id},
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				if(type == 'tour'){
					$('#lst_service_bonus_'+tour_id).append(html);	
				}
				if(type == 'combo'){
					$('#lst_service_bonus_combo_'+combo_id).append(html);
				}
				loadTotalPrice(elm,type,table_id);

			}
		});		
		return false;
	}else{
		$("#lst_service_bonus_"+tour_id).find(".service_"+service_id).parent().remove();
		loadTotalPrice(elm,type,table_id);
	}
	
	
}
function show_product(product_type){
	var tour_select = hotel_select = cruise_select = combo_select = voucher_select = [];
	$('#box_booking').find('.tour_select').each(function(index){
		tour_select.push($(this).val());
	});
	$('#box_booking').find('.hotel_select').each(function(index){
		hotel_select.push($(this).val());
	});
	$('#box_booking').find('.cruise_select').each(function(index){
		cruise_select.push($(this).val());
	});
	$('#box_booking').find('.combo_select').each(function(index){
		combo_select.push($(this).val());
	});
	$('#box_booking').find('.voucher_select').each(function(index){
		voucher_select.push($(this).val());
	});
	if(product_type == 'tour'){
		var keyword = $("#searchtour").val();
	}
	if(product_type == 'voucher'){
		var keyword = $("#searchvoucher").val();
	}
	if(product_type == 'cruise'){
		var keyword = $("#searchcruise").val();
	}
	if(product_type == 'hotel'){
		var keyword = $("#searchhotel").val();
	}
	if(product_type == 'combo'){
		var keyword = $("#searchcombo").val();
	}
	aj_search = setTimeout(function() {
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=booking&act=load_search_product',
			data: {
				"keyword": keyword,
				"cat_id": $('#option_cat').val(),
				"country_id": $('#option_country').val(),
				"city_id": $('#option_city').val(),
				"cruise_cat": $('#cruise_cat').val(),
				"voucher_cat": $('#voucher_cat').val(),
				"tour_select":tour_select,
				"hotel_select":hotel_select,
				"cruise_select":cruise_select,
				"combo_select":combo_select,
				"voucher_select":voucher_select,
				"product_type":product_type
			},
			dataType: 'html',
			success: function(html) {
				if (html.indexOf('_EMPTY') >= 0) {
					$('#autosugget').hide();
				} else {
					$('#autosugget').stop(false, true).slideDown();
					$('#autosugget').find('.HTML_sugget').html(html);
				}
			}
		});
	}, 500);
}
function addBookingTour(el){
	var tour_id = $(el).data('tour_id');
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=addBookingTour',
		data: {
			"tour_id": tour_id
		},
		dataType: 'html',
		success: function(html) {
			if(html != ''){
				alertify.success('Thêm mới booking thành công!');
				$(el).remove();
				$('#box_booking').prepend(html);
				
				$('#box_option_product').find('select').val('');
				$('#box_option_product').find('select').select2().trigger('change');
				$('#autosugget').hide();
			}
		}
	});
}
function addBookingHotel(el){
	var hotel_id = $(el).data('hotel_id');
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=addBookingHotel',
		data: {
			"hotel_id": hotel_id
		},
		dataType: 'html',
		success: function(html) {
			if(html != ''){
				alertify.success('Thêm mới booking thành công!');
				$(el).remove();
				$('#box_booking').prepend(html);
				
				$('#box_option_product').find('select').val('');
				$('#box_option_product').find('select').select2().trigger('change');
				$('#autosugget').hide();
			}
		}
	});
}
function addBookingCruise(el){
	var cruise_id = $(el).data('cruise_id');
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=addBookingCruise',
		data: {
			"cruise_id": cruise_id
		},
		dataType: 'html',
		success: function(html) {
			if(html != ''){
				alertify.success('Thêm mới booking thành công!');
				$(el).remove();
				$('#box_booking').prepend(html);
				
				$('#box_option_product').find('select').val('');
				$('#box_option_product').find('select').select2().trigger('change');
				$('#autosugget').hide();
			}
		}
	});
}
function addBookingCombo(el){
	var $_this = $(el);
	var combo_id = $(el).data('combo_id');
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=addBookingCombo',
		data: {
			"combo_id": combo_id
		},
		dataType: 'html',
		success: function(html) {
			if(html != ''){
				alertify.success('Thêm mới booking thành công!');
				$(el).remove();
				$('#box_booking').prepend(html);
				loadTotalPrice($_this,'combo',combo_id);
				
				$('#box_option_product').find('select').val('');
				$('#box_option_product').find('select').select2().trigger('change');
				$('#autosugget').hide();
			}
		}
	});
}
function addBookingVoucher(el){
	var $_this = $(el);
	var voucher_id = $(el).data('voucher_id');
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=addBookingVoucher',
		data: {
			"voucher_id": voucher_id
		},
		dataType: 'html',
		success: function(html) {
			if(html != ''){
				alertify.success('Thêm mới booking thành công!');
				$(el).remove();
				$('#box_booking').prepend(html);
				loadTotalPrice($_this,'voucher',voucher_id);
				
				$('#box_option_product').find('select').val('');
				$('#box_option_product').find('select').select2().trigger('change');
				$('#autosugget').hide();
			}
		}
	});
}
function addPriceByOption(el){
	var tour_id = $(el).data('tour_id');
	var tour_option = $(el).val();
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=addPriceByOption',
		data: {
			"tour_id": tour_id,
			"tour_option": tour_option
		},
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			if(html != ''){
				$(el).closest('.box_content_book').find('.box_price_by_option').html(html);
			}
			loadTotalPrice(el,'tour',tour_id);
		}
	});
}
//check số phòng hotel
function checkNumberRoom(elm){
	var elm_parent = $(elm).closest('.lst_service_bonus');
	var elm_parent_booking = $(elm).closest('.box_info_booking');
	var number_people_max = 0,total_room=0,total_people=0,total_room_next = 0;
	total_people += parseInt(elm_parent_booking.find('input[name="number_adult"]').val());
	total_people += parseInt(elm_parent_booking.find('input[name="number_child"]').val());
	var room = $(elm).val();
	elm_parent.find('.form-item').each(function(index,element){
		var input = $(element).find('.room_hotel');
		number_people_max += parseInt(input.data('max_adult'));
		number_people_max += parseInt(input.data('max_child'));
		total_room += parseInt(input.val());
	});
	total_room_max = (total_people/number_people_max).toFixed();
	total_room_next = total_room - room;
	if(total_room < total_room_max){
		alertify.error("Số phòng không hợp lệ!");
		$(elm).val(total_room_max - total_room_next);
	}	
}
/*function show_customer(){
	$("#full_name").combogrid({
		panelWidth:450,
		value:'006',

		idField:'code',
		textField:'name',
		url: path_ajax_script+"/index?mod=booking&act=load_customer",
		columns:[[
			{field:'code',title:'Code',width:60},
			{field:'name',title:'Name',width:100},
			{field:'addr',title:'Address',width:120},
			{field:'col4',title:'Col41',width:100}
		]]
	});
}*/
/*function show_customer(){
	var keyword = $("input[name='full_name']").val();
	if(keyword.length >2){
		aj_search = setTimeout(function() {
			$.ajax({
				type: 'POST',
				url: path_ajax_script + '/index.php?mod=booking&act=load_customer',
				data: {
					"keyword": keyword,
				},
				dataType: 'html',
				success: function(html) {
					if (html.indexOf('_EMPTY') >= 0) {
						$('#autosugget_cus').hide();
					} else {
						$('#autosugget_cus').stop(false, true).slideDown();
						$('#autosugget_cus').find('.HTML_sugget').html(html);
					}
				}
			});
		}, 500);
	}	
}*/
function addCustomer(elm){
	var full_name = $(elm).data('full_name');
	var email = $(elm).data('email');
	var birthday = $(elm).data('birthday');
	var phone = $(elm).data('phone');
	var country_id = $(elm).data('country_id');
	var address = $(elm).data('address');
	/*$("#collapseContact").find("input[name='fullname']").val(full_name);*/
	$("#collapseContact").find("input[name='fullname']").prev().val(full_name);
	$("#collapseContact").find("input[comboname='fullname']").val(full_name);
	$("input[name='full_name']").val(full_name);
	$("input[name='birthday']").val(birthday);
	$("input[name='email']").val(email);
	$("input[name='phone']").val(phone);
	$("input[name='address']").val(address);
	$("#country_id").val(country_id);
    $("#country_id").select2().trigger('change');
	$('#full_name').combogrid('grid').datagrid('getPager').trigger('click');
}

function loadPriceCruise(elm){	
	var $this = $(elm);
	var elm_parent = $(elm).closest('.box_info_booking');
	var cruise_id = elm_parent.find('.cruise_select').val();
	var cruise_itinerary_id = elm_parent.find('select[name="cruise_itinerary_id"]').val();
	var departure_date = elm_parent.find('input[name="departure_date"]').val();
	var total_number_adult = 0, total_number_child = 0,number_cabin=0;
	var array_cabin = {};
	var parent_cabin = $(elm).closest('.box_price_by_option');
	parent_cabin.find(".cruise_cabin").data('price',0);
	parent_cabin.find(".cruise_cabin").each(function(index,elm2){
		var cruise_cabin_id = $(elm2).data('cruise_cabin_id');
		number_cabin = $(elm2).val();
		var max_adult = $(elm2).data('max_adult');
		var max_child = $(elm2).data('max_child');

		var arrayChild = [],array_adult=[],array_child=[]
		parent_cabin.find('.box_cabin_book .cabin_book').each(function(i,elm3){
			var array_infant=[];
			var number_adult = $(elm3).find('input[name="number_adult"]').val();
			array_adult[i] = number_adult;
			total_number_adult += parseInt(number_adult);

			var number_child = $(elm3).find('input[name="number_child"]').val();				
			array_child[i] = number_child;
			total_number_child += parseInt(number_child);

			if(number_child > 0){
				$(elm3).find(".child_age").each(function(ind,elm4){
					if(ind <= number_child){
						array_infant[ind]=$(elm4).val();
					}
				});
				arrayChild[i]= array_infant;
			}
		});
		array_cabin[cruise_cabin_id] = {
			"cruise_cabin_id"	: 	cruise_cabin_id,
			"array_adult"		:	array_adult,
			"array_child"		:	array_child,
			"array_infant"		: 	arrayChild,				
			"max_adult"			: 	max_adult,			
			"max_child"			: 	2,						
		};
	});
	var data = {
		"cruise_id"				:	cruise_id,
		"number_cabin"			: 	number_cabin,
		"number_adult"			: 	total_number_adult,
		"number_child"			: 	total_number_child,	
		"cruise_itinerary_id"	:	cruise_itinerary_id,
		"departure_date"		:	departure_date,
		"BookingCruise"			:	"BookingCruise",
		"cabin"					:	JSON.stringify(array_cabin), 
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=updatePriceCabin',
		data : data,
		dataType: 'html',
		success: function(price) {
			parent_cabin.find(".cruise_cabin").data('price',price);
			loadTotalPrice($this,"cruise",cruise_id);
		}
	});
}
function loadTotalPrice(elm,type,type_id,act=''){
	var total_price = 0;
	$(".inp_price").each(function(index,element){
		var type = $(element).closest('.box_info_booking').data('type');
		if($(this).hasClass('room_hotel')){
			var price = $(this).data('price')
			var parent_elm = $(this).closest('.box_info_booking');
			var check_in = parent_elm.find("input[name='check_in']").val();
			var check_out = parent_elm.find("input[name='check_out']").val();
			if(check_in != '' && check_out != ''){
				check_in = new Date(check_in.split("/").reverse().join("/"));
				check_out = new Date(check_out.split("/").reverse().join("/"));
				var number_night = (check_out.getTime()-check_in.getTime())/(1000 * 3600 * 24)
				number_night = (number_night < 1)?1:number_night;
			}else{
				var number_night = 1;
			}			
			var price_unit = parseInt(price) * number_night;
		}else{
			var price_unit = $(this).data('price');
		}
		
		var number = $(this).val();
		if(number == ''){
			number = 0;
		}
		if(type == 'cruise'){
			total_price += parseInt(price_unit);
		}else{
			total_price += parseInt(price_unit) * parseInt(number);	
		}		
	});
	
	str_total_price = total_price.toLocaleString().replaceAll('.',' ');
	var price_deposit = 0;
	$(".box_info_booking").each(function(index,element){
		var type = $(element).data('type');
		var total_price_booking = 0;
		$(this).find(".inp_price").each(function(index,elm){
			var price_unit_booking = $(elm).data('price');
			if(type == 'cruise'){
				total_price_booking += parseInt(price_unit_booking);
			}else{
				var number_booking = $(elm).val();
				if(number_booking == ''){
					number_booking = 0;
				}
				total_price_booking += parseInt(price_unit_booking) * parseInt(number_booking);
			}
			
		});
		$(this).find("input[name='price_booking']").val(total_price_booking);
		$(this).find(".price_tmp").text(total_price_booking.toLocaleString().replaceAll('.',' '));
		if($(this).find('.deposit').length > 0){
			var deposit = $(this).find('.deposit').val();
		}else{
			var deposit = 0;
		}
		price_deposit += total_price_booking * parseInt(deposit)/100;
		
	});
	$('#total_price').text(str_total_price); $('#inp_total_price').val(total_price);
	$('#price_total').text(str_total_price); $('#inp_price_total').val(total_price);
	$("#inp_price_deposit").val(price_deposit);
//	var price_deposit = $("#inp_price_deposit").val();
	var price_final_payment = parseInt(total_price) - parseInt(price_deposit);
	$("#price_deposit").text(price_deposit.toLocaleString().replaceAll('.',' '));
	$("#price_final_payment").text(price_final_payment.toLocaleString().replaceAll('.',' '));
	$("#inp_price_final_payment").val(price_final_payment);
	$("#price_total_payment,#price_total_payment_footer").text(price_deposit.toLocaleString().replaceAll('.',' '));
	$("#inp_price_total_payment").val(price_deposit);
	
	updateSession(elm,type,type_id,act);
}
function get_select_city(_this){
	var _country_id = $(_this).val(),
		_form = $(_this).closest('.modal');
	vietiso_loading(1);
	$.post(path_ajax_script+"/index.php?mod=booking&act=get_select_city", {
		'country_id' : _country_id
	}, function(html){
		vietiso_loading(0);
		$('.slb_City_Id').html(html);
	});
}
function show_child(el){
	var number_child = $(el).val();
	number_child = (number_child == '')?0:parseInt(number_child);
	var max_child = parseInt($(el).attr('max'));
	var parent = $(el).closest('.cabin_book');
	for(var i=1; i<= max_child; i++){
		if(number_child >= i){
			parent.find('.conchild1s_'+i).show();
		}else{
			parent.find('.conchild1s_'+i).find("select").val('');
			parent.find('.conchild1s_'+i).hide();
		}		
	}
	refresh_cruise_cabin(el);
}
function show_cabin_book(elm){
	var $_this = $(elm);
	var number_room = $(elm).val();
	if(number_room < 1){
		$(elm).val(1);
		number_room = 1;
	}
	var cruise_id = $_this.closest('.box_info_booking').find('.cruise_select').val();
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=booking&act=show_cabin_book',
		data: {
			"number_room": number_room,
			"cruise_id": cruise_id,
		},
		dataType: 'html',
		success: function(html) {
			$_this.closest('.box_price_by_option').find('.box_cabin_book').html(html);
		}
	});	
	
}
function refresh_cruise_cabin(el){
	var number_child = $(el).val();
	number_child = (number_child == '')?0:parseInt(number_child);
	var max_child = parseInt($(el).attr('max'));
	if(number_child > max_child){
		alert("Dữ liệu không tồn tại");
		$(el).val(max_child);
	}
	/*$("#lst_cruise_cabin_"+cruise_id).html('');
	$(el).closest('.box_content_book').find('select[name="CruiseCabin"]').val('');*/
}
function del_bonus(e,type='',type_id=0){
	var parent = $(e).closest('.box_info_booking');
	var service_id = $(e).closest('.form-item').find("input").data('service');
	
	if(type == 'cruise'){
		$(e).closest('.box_price_by_option').remove();
	}else{
		parent.find('.collapseServiceTour .item_service').each(function(index,elm){		
			if($(elm).find('input').val() == service_id){
				$(elm).find('input').removeAttr("checked");
			}
		});
	}
	$(e).closest('.form-item').remove();
	loadTotalPrice(e,type,type_id);
}
function del_product_booking(e,type,type_id,act="delete"){
	$(e).closest('.box_info_booking').remove();
	loadTotalPrice(e,type,type_id,act);
}
function checkValidEmail(email){
	var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}
/*end function booking*/