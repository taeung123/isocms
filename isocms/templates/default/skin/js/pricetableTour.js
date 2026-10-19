var people,kid,baby,total_tourist,people_price,child_price,baby_price;
var start_time = [];
//$.widget.bridge('uibutton', $.ui.button);
$(document).ready(function(){
	
	switch($('#time_start_repeat').val()) {
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
	}
	$( "#start_date" ).datepicker({
		dateFormat: "dd/mm/yy",
		beforeShowDay: DisableSpecificDates
	});
	national_people = $('#national_people');
	national_child = $('#national_child');
	national_baby = $('#national_baby');
	
	overseas_people = $('#overseas_people');
	overseas_child = $('#overseas_child');
	overseas_baby = $('#overseas_baby');
	
	foreigner_people = $('#foreigner_people');
	foreigner_child = $('#foreigner_child');
	foreigner_baby = $('#foreigner_baby');
	
	total_tourist = $('#result');

	people_price = parseInt($('#people_price').val());
	child_price = parseInt($('#kid_price').val());
	baby_price = parseInt($('#baby_price').val());
	
	tinh();

	national_people.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinh();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinh();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinh();
		}
	});
	national_child.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinh();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinh();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinh();
		}
	});
	national_baby.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinh();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinh();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinh();
		}
	});
	
	overseas_people.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinh();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinh();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinh();
		}
	});
	overseas_child.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinh();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinh();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinh();
		}
	});
	overseas_baby.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinh();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinh();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinh();
		}
	});
	
	foreigner_people.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinh();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinh();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinh();
		}
	});
	foreigner_child.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinh();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinh();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");

			$(this).val(1);
			tinh();
		}
	});
	foreigner_baby.change(function(){
		if(!isNaN(parseInt($(this).val()))){
			if(parseInt($(this).val()) >= 0){
				tinh();
			}else{
				alert("Dữ liệu nhập vào không hợp lệ");
				$(this).val(1);
				tinh();
			}
		}else{
			alert("Dữ liệu nhập vào không hợp lệ");
			$(this).val(1);
			tinh();
		}
	});
});

//Hàm tính kết quả
function tinh(){
	var national_people = document.getElementById("national_people");
	var national_child = document.getElementById("national_child");
	var national_baby = document.getElementById("national_baby");
	
	var overseas_people = document.getElementById("overseas_people");
	var overseas_child = document.getElementById("overseas_child");
	var overseas_baby = document.getElementById("overseas_baby");
	
	var foreigner_people = document.getElementById("foreigner_people");
	var foreigner_child = document.getElementById("foreigner_child");
	var foreigner_baby = document.getElementById("foreigner_baby");
	
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
	
	var national = parseInt(national_people.value) * people_price
		+ parseInt(national_child.value) * child_price
		+ parseInt(national_baby.value) * baby_price;
	
	var overseas = parseInt(overseas_people.value) * people_price
		+ parseInt(overseas_child.value) * child_price
		+ parseInt(overseas_baby.value) * baby_price;
	
	var foreigner = parseInt(foreigner_people.value) * people_price
		+ parseInt(foreigner_child.value) * child_price
		+ parseInt(foreigner_baby.value) * baby_price;
	
//	Gán giá trị vào ô thứ tu
		
//	Phải kiểm tra tổng hai số này có bị lỗi hay không
	
	if (!isNaN(tong)){
		$('#a').val(parseInt(national_people.value) + parseInt(overseas_people.value) + parseInt(foreigner_people.value));
		$('#b').val(parseInt(national_child.value) + parseInt(overseas_child.value) + parseInt(foreigner_child.value));
		$('#c').val(parseInt(national_baby.value) + parseInt(overseas_baby.value) + parseInt(foreigner_baby.value));
		result.value = tong;
//		tien.value = addCommas(tinh_tien);
		national_total.innerHTML = national.format() + ' đ';
		overseas_total.innerHTML = overseas.format() + ' đ';
		foreigner_total.innerHTML = foreigner.format() + ' đ';
		
		total.innerHTML = (national + overseas + foreigner).format() + ' đ';
		tien1.value = (national + overseas + foreigner).format();
		
		var x = 0;

		$('#customer_list').html('');
		for(i = 0;i < $('#national_people').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Người lớn");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national_child').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Trẻ nhỏ");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#national_baby').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Em bé");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#overseas_people').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Người lớn");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#overseas_child').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Trẻ nhỏ");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#overseas_baby').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Em bé");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#foreigner_people').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Người lớn");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#foreigner_child').val();i++){
			customer = new createCustomerInfo($('#customer_list'));
			customer.setId('input_' + x);
			customer.setTouristAgeType("Trẻ nhỏ");
			
			customer.birthday_input.datepicker({
				altFormat: "dd-mm-yy",
				dateFormat: "dd-mm-yy"
			});
			x++;
		}
		for(i = 0;i < $('#foreigner_baby').val();i++){
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
				'<option value="0">Nữ</option>' +
				'<option value="1">Nam</option>' +
			'</select></td>').appendTo($('<td>').appendTo(this.tr));
	

	this.tourist_type_input = $('<select class = "form-control input-sm" >' +
			'<option value="Việt Nam">Việt Nam</option>' +
			'<option value="Việt kiều">Việt kiều</option>' +
			'<option value="Nước ngoài">Nước ngoài</option>' +
		'</select>').appendTo($('<td></td>').appendTo(this.tr));
	
	this.tourist_age_type_input = $('<select class = "form-control input-sm" >' +
		'</select>').appendTo($('<td></td>').appendTo(this.tr));
	
	this.room_input = $('<select class = "form-control input-sm" >' +
			'<option value="0">Không</option>' +
			'<option value="1">Có</option>' +
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
		
		this.room_input.attr('name',id + '.room');
		this.room_input.attr('id',id + '.room');
	};
	this.setTouristAgeType = function(tourist_type){
		this.tourist_age_type_input.append($('<option value = "' + tourist_type + '">' + tourist_type + '</option>'));
	};
}
//	ham dinh dang so 1.000
	
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

/**
 * Number.prototype.format(n, x)
 * 
 * @param integer n: length of decimal
 * @param integer x: length of sections
 */

Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};
function DisableSpecificDates(date) {
	var m = ('0' + (date.getMonth() + 1)).slice(-2);
	var d = ("0" + date.getDate()).slice(-2);
	var y = date.getFullYear();

//	First convert the date in to the mm-dd-yyyy format
//	Take note that we will increment the month count by 1

	var currentdate = y + '-' + m + '-' + d;

	console.log(currentdate);
//	We will now check if the date belongs to disableddates array

	
	switch($('#time_start_repeat').val()) {
		case '1':
			if (start_time.indexOf(currentdate) != -1 ) {
				return [true, ""];
			}else{
				return [false,""];
			}
			break;
		case '2':
			if (start_time.indexOf(date.getDay()) != -1 ) {
				return [true, ""];
			}else{
				return [false,""];
			}
			break;
		case '3':
			if (start_time.indexOf(d) != -1 ) {
				return [true, ""];
			}else{
				return [false,""];
			}
			break;
		default:
			return [true, ""];
	}
	return [true, ""];
}
