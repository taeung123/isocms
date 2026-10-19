$(function(){
	loadPriceTableDeparture(tour_id,departure_date);
	$('.datepicker').datepicker({
	minDate : new Date(),
	DateFormat: "mm-dd-yy",
	changeMonth: true,
	changeYear: true,
	});
});
var people,kid,baby,total_tourist,people_price,child_price,baby_price;
var start_time = [];
$(document).ready(function(){
	$(document).on('change','input[name=departure_date]',function(){
		loadPriceTableDeparture(tour_id,$(this).val());
	});
	$(document).on("change", "select[name=pay_deposit]", function(ev){
		var deposit = $(this).val();
		tinhtoan();
	});
});
Number.prototype.format = function(n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};
function loadPriceTableDeparture(tour_id,departure_in){
	$.ajax({
		'type': 'POST',
		'url' : path_ajax_script+'/index.php?mod=tour&act=loadPriceTableDeparture',
		'data' : {"tour_id":tour_id,"departure_in":departure_in},
		'dataType': 'html',
		'success':function(html){
			$('#priceTableDeparture').html(html);
		}
	});
}
function tinhtoan(){
	var national_adults = document.getElementById("national_visitor16");
	var national_child = document.getElementById("national_visitor17");
	var national_infant = document.getElementById("national_visitor18");

	var depositBook = document.getElementById("deposit");
	var deposit_price = document.getElementById("deposit_price");
	
	var result = document.getElementById("result");
	var balance_price = document.getElementById("balance_price");
	var deposit = document.getElementById("pay_deposit").value;
	
	var totalgrand = document.getElementById("totalgrand_price");
	var national_total = document.getElementById("national_total");
	var total_remaining = document.getElementById("total_remaining");
	
	var tong = parseInt(national_adults.value) + 
		parseInt(national_child.value) + 
		parseInt(national_infant.value);
		
	var national = parseInt(national_adults.value) * national_adults_price
		+ parseInt(national_child.value) * national_child_price
		+ parseInt(national_infant.value) * national_infant_price;

	if (!isNaN(tong)){
		$('#adult').val(parseInt(national_adults.value));
		$('#child').val(parseInt(national_child.value));
		$('#baby').val(parseInt(national_infant.value));
		result.value = tong;
		if(national>0){
			national=national
		}else{
			national=0;
		}
		national_total.innerHTML = national.format();
		totalgrand.value=national.format();
		total_remaining.innerHTML = (national-((deposit/100)*national).toFixed(2)).toFixed(2);
		balance_price.value = (national-((deposit/100)*national).toFixed(2)).toFixed(2);
		depositBook.innerHTML = ((deposit/100)*national).toFixed(2);
		deposit_price.value = ((deposit/100)*national).toFixed(2);
		
		var x = 0;
		var y = 1;
		$('#customer_list').html('');
		for(i = 0;i < $('#national_visitor16').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setStt(+ y);
			customer.setId('input_' + x);
			customer.setTouristAgeType(Adult);
			
			customer.birthday_input.datepicker({
				altFormat: "mm-dd-yy",
				dateFormat: "mm-dd-yy",
				changeMonth: true,
				changeYear: true,
				yearRange: '1900:Y',
				minDate: new Date(1900, 10 - 1, 25),
			});
			x++;
			y++;
		}
		for(i = 0;i < $('#national_visitor17').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setStt(+ y);
			customer.setTouristAgeType(Children);
			
			customer.birthday_input.datepicker({
				altFormat: "mm-dd-yy",
				dateFormat: "mm-dd-yy",
				changeMonth: true,
				changeYear: true,
				yearRange: '1900:Y',
				minDate: new Date(1900, 10 - 1, 25),
			});
			x++;
			y++;
		}
		for(i = 0;i < $('#national_visitor18').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setStt(+ y);
			customer.setTouristAgeType(Infant);
			
			customer.birthday_input.datepicker({
				altFormat: "mm-dd-yy",
				dateFormat: "mm-dd-yy",
				changeMonth: true,
				changeYear: true,
				yearRange: '1900:Y',
				minDate: new Date(1900, 10 - 1, 25),
			});
			x++;
			y++;
		}
	}else{
		alert('Error');
	}
}
function createCustomerInfo(obj){
	var $ww = $(window).width();
	this.div = $('<div></div>');
	this.stt_input =  $('<input type = "text" class = "form-control input-sm"/>');
	this.stt_input.appendTo($('<span class="mb10"><b class="block768" style="display:none">'+Traveller+'</b> </span>').appendTo(this.div));
	
	this.name_input = $('<input type = "text" class = "form-control input-sm"/>');
	this.name_input.appendTo($('<span class="mb10"><label class="block768" style="display:none">'+FullName+'</label></span>').appendTo(this.div));
	
	this.birthday_input = $('<input type = "text" class = "form-control input-sm datepicker inputDate" />').appendTo($('<span class="mb10"><label class="block768" style="display:none">'+DateofBirth+'</label></span>').appendTo(this.div));
	
	this.address_input = $('<input type = "text" class = "form-control input-sm" />').appendTo($('<span class="mb10"><label class="block768" style="display:none">'+Address+'</label></span>').appendTo(this.div));
	
	this.gender_input = $('<select class = "form-control input-sm" >' +
				'<option value="Female">'+Female+'</option>' +
				'<option value="Male">'+Male+'</option>' +
			'</select></span>').appendTo($('<span class="mb10"><label class="block768" style="display:none">'+Gender+'</label>').appendTo(this.div));
	this.tourist_age_type_input = $('<select class = "form-control input-sm appearance_none" >' +

		'</select>').appendTo($('<span class="mb10"><label class="block768" style="display:none">'+Traveller+'</label></span>').appendTo(this.div));
		
	obj.append(this.div);
	this.setId = function(id){
		this.name_input.attr('name',id + '.name');
		this.name_input.attr('id',id + '.name');
		
		this.birthday_input.attr('name',id + '.birthday');
		this.birthday_input.attr('id',id + '.birthday');

		this.address_input.attr('name',id + '.address');
		this.address_input.attr('id',id + '.address');

		this.gender_input.attr('name',id + '.gender');
		this.gender_input.attr('id',id + '.gender');
		
		this.tourist_age_type_input.attr('name',id + '.tourist_age_type');
		this.tourist_age_type_input.attr('id',id + '.tourist_age_type');
		
	};
	this.setStt= function(id){
		this.stt_input.attr('name',id);
		this.stt_input.attr('value',id);
	};
	this.setTouristAgeType = function(tourist_type){
		this.tourist_age_type_input.append($('<option value = "' + tourist_type + '">' + tourist_type + '</option>'));
	};
}
	
function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	console.log(x);
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}