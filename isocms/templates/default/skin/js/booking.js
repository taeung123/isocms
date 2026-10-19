$(function(){
	$('.datepicker').datepicker({
	minDate : new Date(),
	DateFormat: "%m/%d/%Y"
	});
});
var people,kid,baby,total_tourist,people_price,child_price,baby_price;
var start_time = [];
$(document).ready(function(){
	
	/*switch($('#time_start_repeat').val()) {
		case '1':
			start_time = $('#time_start').val().split(",");
			break;
		case '2':
			var tmp_array = $('#time_start').val().split(",");
			
			for(x in tmp_array){
				var dt1   = parseInt(tmp_array[x].substring(8,10));
				var mon1  = parseInt(tmp_array[x].substring(5,7));
				var yr1   = parseInt(tmp_array[x].substring(0,4));

				var date1 = new Date(yr1, mon1-1, dt1);

				start_time.push(date1.getDay());
			}
			break;
		case '3':
			var tmp_array = $('#time_start').val().split(",");
			for(x in tmp_array){
				var tmp = tmp_array[x].split('-');
				start_time.push(tmp[2]);
			}
			break;
		default:
			return [true, ""];
	}*/
	/*$( "#start_date" ).datepicker({
		dateFormat: "dd/mm/yy",
		beforeShowDay: DisableSpecificDates
	});*/
	national_people = $('#national10_visitor6');
	national_child = $('#national10_visitor7');
	national_baby = $('#national10_visitor8');
	
	overseas_people = $('#national11_visitor6');
	overseas_child = $('#national11_visitor7');
	overseas_baby = $('#national11_visitor8');
	
	
	foreigner_people = $('#national12_visitor6');
	foreigner_child = $('#national12_visitor7');
	foreigner_baby = $('#national12_visitor8');
	
	total_tourist = $('#result');

	national_people_price = parseInt($('#people10_price6').val());
	national_child_price = parseInt($('#people10_price7').val());
	national_baby_price = parseInt($('#people10_price8').val());
	national_surcharge_price = parseInt($('#people10_price9').val());
	
	overseas_people_price = parseInt($('#people11_price6').val());
	overseas_child_price = parseInt($('#people11_price7').val());
	overseas_baby_price = parseInt($('#people11_price8').val());
	overseas_surcharge_price = parseInt($('#people11_price9').val());
	
	foreigner_people_price = parseInt($('#people12_price6').val());
	foreigner_child_price = parseInt($('#people12_price7').val());
	foreigner_baby_price = parseInt($('#people12_price8').val());
	foreigner_surcharge_price = parseInt($('#people12_price9').val());
	
	tinhtoan();

	national_people.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});
	national_child.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});
	national_baby.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});
	overseas_people.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});
	overseas_child.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});
	overseas_baby.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});
	
	foreigner_people.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});
	foreigner_child.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});
	foreigner_baby.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinhtoan();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinhtoan();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinhtoan();
		}
	});
});

Number.prototype.format = function(n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

function tinhtoan(){
	var national_people = document.getElementById("national10_visitor6");
	var national_child = document.getElementById("national10_visitor7");
	var national_baby = document.getElementById("national10_visitor8");
	
	var overseas_people = document.getElementById("national11_visitor6");
	var overseas_child = document.getElementById("national11_visitor7");
	var overseas_baby = document.getElementById("national11_visitor8");
	
	var foreigner_people = document.getElementById("national12_visitor6");
	var foreigner_child = document.getElementById("national12_visitor7");
	var foreigner_baby = document.getElementById("national12_visitor8");
	
	var result = document.getElementById("result");
	var tien1 = document.getElementById("tien1");
	
	var national_total = document.getElementById("national_total");
	var overseas_total = document.getElementById("overseas_total");
	var foreigner_total = document.getElementById("foreigner_total");
	var total = document.getElementById("total");
	
	var tong = parseInt(national_people.value) + 
		parseInt(national_child.value) + 
		parseInt(national_baby.value) +
		
		parseInt(overseas_people.value) +
		parseInt(overseas_child.value) +
		parseInt(overseas_baby.value) +
		
		parseInt(foreigner_people.value) +
		parseInt(foreigner_child.value) +
		parseInt(foreigner_baby.value)
		;
		
	var national = parseInt(national_people.value) * national_people_price
		+ parseInt(national_child.value) * national_child_price
		+ parseInt(national_baby.value) * national_baby_price;
	
	var overseas = parseInt(overseas_people.value) * overseas_people_price
		+ parseInt(overseas_child.value) * overseas_child_price
		+ parseInt(overseas_baby.value) * overseas_baby_price;
	
	var foreigner = parseInt(foreigner_people.value) * foreigner_people_price
		+ parseInt(foreigner_child.value) * foreigner_child_price
		+ parseInt(foreigner_baby.value) * foreigner_baby_price;
		
	if (!isNaN(tong)){
		$('#adult').val(parseInt(national_people.value) + parseInt(overseas_people.value) + parseInt(foreigner_people.value));
		$('#child').val(parseInt(national_child.value) + parseInt(overseas_child.value) + parseInt(foreigner_child.value));
		$('#baby').val(parseInt(national_baby.value) + parseInt(overseas_baby.value) + parseInt(foreigner_baby.value));
		result.value = tong;
		if(national>0){
			national=national+national_surcharge_price
		}else{
		national=0;
		}
		national_total.innerHTML = national.format() + ',000 đ';
		if(overseas>0){
			overseas=overseas+overseas_surcharge_price
		}else{
			overseas=0;
		}
		overseas_total.innerHTML = overseas.format() + ',000 đ';
		if(foreigner>0){
			foreigner=foreigner+foreigner_surcharge_price
		}else{
			foreigner=0;	
		}
		foreigner_total.innerHTML = foreigner.format() + ',000 đ';
		
		total.innerHTML = (national + overseas + foreigner).format() + ',000 đ';
		tien1.value = (national + overseas + foreigner).format()+ ',000 đ';
		
		var x = 0;

		$('#customer_list').html('');
		for(i = 0;i < $('#national10_visitor6').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Người lớn");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national10_visitor7').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Trẻ nhỏ");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national10_visitor8').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Em bé");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national11_visitor6').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Người lớn");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national11_visitor7').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Trẻ nhỏ");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national11_visitor8').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Em bé");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national12_visitor6').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Người lớn");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national12_visitor7').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Trẻ nhỏ");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national12_visitor8').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Em bé");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
	}else{
		alert('Lỗi');
	}
}
function createCustomerInfo(obj){
	this.tr = $('<tr></tr>');
	
	this.name_input = $('<input type = "text" class = "form-control input-sm" />');
	this.name_input.appendTo($('<td></td>').appendTo(this.tr));
	
	this.birthday_input = $('<input type = "text" class = "form-control input-sm" />').appendTo($('<td></td>').appendTo(this.tr));
	
	this.address_input = $('<input type = "text" class = "form-control input-sm" />').appendTo($('<td></td>').appendTo(this.tr));
	
	this.gender_input = $('<select class = "form-control input-sm" >' +
				'<option value="Nữ">Nữ</option>' +
				'<option value="Nam">Nam</option>' +
			'</select></td>').appendTo($('<td>').appendTo(this.tr));
	

	this.tourist_type_input = $('<select class = "form-control input-sm" >' +
			'<option value="Việt Nam">Việt Nam</option>' +
			'<option value="Việt kiều">Việt kiều</option>' +
			'<option value="Nước ngoài">Nước ngoài</option>' +
		'</select>').appendTo($('<td></td>').appendTo(this.tr));
	
	this.tourist_age_type_input = $('<select class = "form-control input-sm" >' +
		'</select>').appendTo($('<td></td>').appendTo(this.tr));
		
	obj.append(this.tr);
	this.setId = function(id){
		this.name_input.attr('name',id + '.name');
		this.name_input.attr('id',id + '.name');
		
		this.birthday_input.attr('name',id + '.birthday');
		this.birthday_input.attr('id',id + '.birthday');

		this.address_input.attr('name',id + '.address');
		this.address_input.attr('id',id + '.address');

		this.gender_input.attr('name',id + '.gender');
		this.gender_input.attr('id',id + '.gender');

		this.tourist_type_input.attr('name',id + '.tourist_type');
		this.tourist_type_input.attr('id',id + '.tourist_type');

		this.tourist_age_type_input.attr('name',id + '.tourist_age_type');
		this.tourist_age_type_input.attr('id',id + '.tourist_age_type');
		
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