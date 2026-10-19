$().ready(function() {
    $(document).on('click', '.add_new_user:not(".disable")', function (ev) {
        $(this).addClass('disable');
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajActionNewUser',
			data: {
				'tp': 'S'
			},
			dataType: "json",
			success: function(json) {
				if(json.result == 'success'){
					window.location.href = json.link;
				}
			}
		});
	});
	$_document.on('click','.toggle_opt .online_tour',function(){
		var $_this = $(this);
		var is_online = $_this.data('val');
		var text_last = $_this.data('text_last');
		var text = $_this.text();
		console.log(text_last);
		var adata = {};
		adata['clsTable'] = $_this.data('clstable');
		adata['pkey'] = $_this.data('pkey');
		adata['pvalTable'] = $_this.data('sourse_id');
		adata['toField'] = $_this.attr('toField') != undefined ? $_this.attr('toField') : 'is_online';
		adata['val'] = parseInt(is_online)==0?1:0;
		adata['allowDuplicate'] = 1;
		
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod=home&act=saveField",
			data: adata,
			dataType: "html",
			success: function(html){
				var val = (is_online == 1)?0:1;
				if($_this.hasClass('private_tour')){
					$_this.removeClass('private_tour');
				}else{
					$_this.addClass('private_tour');
				}
				$_this.text(text_last);
				$_this.data({'val':html,'text_last':text});
			}
		});
	})

	$_document.on('keyup','.input-title',function(){
		var $_this = $(this),
			table_id = $_this.data('table_id'),
			_title = $_this.val();
		$('.table-title[table_id='+table_id+']').html(_title);
		return false;
	});
	$_document.on('keyup','.input_code',function(){
		var $_this = $(this),
			table_id = $_this.data('table_id'),
			_trip_code = $_this.val();
		$('.table_code[table_id='+table_id+']').html(_trip_code);
		return false;
	});
	$_document.on('click', '.panel-edited > .panel-heading', function(e){
		e.preventDefault();
		$('.panel-edited > .panel-heading').removeClass('current');
		$('.panel-edited > .panel-collapse').removeClass('in');
		$(this).toggleClass('current');
		var panel = $(this).closest('.panel');
		panel.find('.panel-collapse').addClass('in');
		panel.find('.panel-collapse>.panel-body>ul.stepbar-list>li:first-child>.loadYieldStep').trigger('click');
	});
	$_document.on('click', '.loadYieldStep', function(){
		var $_this = $(this),
			href = $_this.data('route'),
			table_id = $_this.data('table_id'),
			currentstep = $_this.data('step');
		$('.stepbar-list>li>a.active').removeClass('active');
		$_this.addClass('active');
		loadMainFormStep(table_id, currentstep);
		$('html,body').animate({scrollTop:0}, 500);
		window.history.pushState({href: href}, '', href);
		return false;
	});
	$_document.on('click','.js_save_continue,.js_save_back',function(){
		var $_this = $(this),
			$_form = $_this.closest('form'),
			table_id = $_this.data('table_id'),
			currentstep = $_this.data('currentstep'),
			nextstep = $_this.data('next_step');
		
		if($_this.hasClass('js_save_back')){
			nextstep= $_this.data('prevstep');
		}
		var options = {};
		if($('.textarea_intro_editor[table_id='+table_id+']').length){
			$('.textarea_intro_editor[table_id='+table_id+']').each(function(){
				var column = $(this).data('column'),
					editorId = $(this).attr('id');
				options[column] = $Core.util.getTextAreaContent(editorId);
			});
		}
		$('.stepbar-list>li>a.active').removeClass('active');
		$('.loadYieldStep[data-step='+nextstep+']').addClass('active');
		var currentpanel = $_this.data('panel'),
			nextpanel = $('.stepbar-list>li>a.active').attr('panel'),
			$_href = $('.stepbar-list>li>a.active').data('route');
		if(currentpanel != nextpanel){
			$('.panel--'+currentpanel).find('.panel-heading a').addClass('collapsed');
			$('.panel--'+currentpanel).find('.panel-collapse').removeClass('in');
			$('.panel--'+nextpanel).find('.panel-heading a').removeClass('collapsed');
			$('.panel--'+nextpanel).find('.panel-collapse').addClass('in');
		}

		var _validated = 0;
		if($('input.required,select.required', $_form).length){
			$('input.required,select.required', $_form).each(function(){
				if($Core.util.isEmpty($(this).val())){
					_validated++;
					$(this).focus();
					return false;
				}
			});
		}
		var input_name = $("input[name='user_name']");
		var input_pass = $("input[name='pass1']");
		var input_passComfirm = $("input[name='pass2']");
		var input_passAccount = $("input[name='pass3']");
		input_name.closest('.inpt_tour').find('.errorTxt').text('');
		input_passComfirm.closest('.inpt_tour').find('.errorTxt').text('');
		input_passAccount.closest('.inpt_tour').find('.errorTxt').text('');
		if(input_name.val() == ''){
			var $this = input_name;
			$this.closest('.inpt_tour').find('.errorTxt').text(error_user_name);
			_validated++;
			$this.focus();
			return false;
		}
		if(input_passComfirm.val() != input_pass.val()){
			var $this = input_passComfirm;
			$this.closest('.inpt_tour').find('.errorTxt').text(errorPasswordNotMatch);
			_validated++;
			$this.focus();
			return false;
		}

		if (is_type.trim() != "OKRS") {
			if (input_passAccount.val() == '') {
				var $this = input_passAccount;
				$this.closest('.inpt_tour').find('.errorTxt').text(error_pass3Valid);
				_validated++;
				$this.focus();
				return false;
			}
		}
		if(parseInt(_validated) == 0){
			$Core.util.toggleIndicatior(0);
			$_form.ajaxSubmit({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSaveMainStep', 
				data:$.extend(options,{"table_id":table_id,'currentstep':currentstep}),
				dataType:'json',
				success:function(json){
					if(json.result == false){
						if(json.type == '1'){
							input_name.closest('.inpt_tour').find('.errorTxt').text(json.message);
						}
						if(json.type == '2'){
							input_passComfirm.closest('.inpt_tour').find('.errorTxt').text(json.message);
						}
						if(json.type == '3'){
							input_passAccount.closest('.inpt_tour').find('.errorTxt').text(json.message);
						}
					}
					/*else if(json.result == true){
						window.location.href = path_ajax_script+"/user/insert/"+table_id+"/overview?message=updateSuccess";
					}*/
					else{
						window.location.href = path_ajax_script + "/?mod="+mod;
					}
					console.log(json);
					$Core.util.toggleIndicatior(0);
					
				}
			});
			window.history.pushState({href: $_href}, '', $_href);
			return false;
		}
	});
});

function loadMainFormStep(table_id,currentstep){
	$Core.util.toggleIndicatior(1);
	var $_adata = {"table_id":table_id,'currentstep':currentstep};
	$.post(path_ajax_script+'/index.php?mod='+mod+'&act=getMainFormStep', $_adata, function(html){
		$Core.util.toggleIndicatior(0);
			$('#'+'frmMainStep_'+table_id).html(html);
	});
}
function parentDropdownToggle(e){
	$(e).parent().toggleClass('open');
}
function checkAll(e){
	var chkitem = $(e).closest('.fill_data_box').find('.chkitem');
	console.log(chkitem);
	if($(e).is(':checked')){
		chkitem.attr('checked', true);
		chkitem.closest('tr').addClass('hightlight');
		setList();
	} else {
		chkitem.removeAttr('checked');
		chkitem.closest('tr').removeClass('hightlight');
		setList();
	}
}

function showDatepicker(e){
	$(e).datepicker({dateFormat: "dd/mm/yy"});
}

function searchRelateTour(e,type) {
	if ($(e).val() != '') {
		clearTimeout(aj_search);
		search_extension(type);
	} else {
		$("#autosuggetTour").stop(false, true).slideUp();
	}
}
function addRelateTour(e) {
	var $_this = $(e);
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajAddTourExtension',
		data: {
			'blog_id': blog_id,
			'tour_id': $_this.attr('data')
		},
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_SUCCESS') >= 0) {
				$_this.remove();
				loadTourExtension(blog_id);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
		}
	});
}

function addRelateHotel(e) {
	var $_this = $(e);
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajAddHotelExtension',
		data: {
			'blog_id': blog_id,
			'hotel_id': $_this.attr('data')
		},
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_SUCCESS') >= 0) {
				$_this.remove();
				loadHotelExtension(blog_id);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
		}
	});
}
function addRelateCruise(e) {
	var $_this = $(e);
	vietiso_loading(1);
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajAddCruiseExtension',
		data: {
			'blog_id': blog_id,
			'cruise_id': $_this.attr('data')
		},
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			if (html.indexOf('_SUCCESS') >= 0) {
				$_this.remove();
				loadCruiseExtension(blog_id);
			}
			if (html.indexOf('_EXIST') >= 0) {
				alertify.error(exist_error);
			}
		}
	});
}

function deleteBlogExtension(e) {
	if (confirm(confirm_delete)) {
		var _this = $(e);
		var tp = _this.attr("tp");
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajDeleteBlogExtension',
			data: {
				"blog_extension_id": _this.attr('data')
			},
			dataType: 'html',
			success: function(html) {
				vietiso_loading(0);
				if(tp=='tour')
					loadTourExtension(blog_id);
				if(tp=='cruise')
					loadCruiseExtension(blog_id);
				if(tp=='hotel')
					loadHotelExtension(blog_id);
			}
		});
		return false;
	}
}

function moveTourExtension(e) {
	console.log(e);
	var _this = $(e);
	vietiso_loading(1);
	var adata = {
		'blog_extension_id': _this.attr('data'),
		'blog_id': blog_id,
		'direct': _this.attr('direct')
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajMoveTourExtension',
		data: adata,
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			loadTourExtension(blog_id);
		}
	});
}
function moveHotelExtension(e) {
	var _this = $(e);
	vietiso_loading(1);
	var adata = {
		'blog_extension_id': _this.attr('data'),
		'blog_id': blog_id,
		'direct': _this.attr('direct')
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajmoveHotelExtension',
		data: adata,
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			loadHotelExtension(blog_id);
		}
	});
}
function moveCruiseExtension(e) {
	var _this = $(e);
	vietiso_loading(1);
	var adata = {
		'blog_extension_id': _this.attr('data'),
		'blog_id': blog_id,
		'direct': _this.attr('direct')
	};
	$.ajax({
		type: 'POST',
		url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajmoveCruiseExtension',
		data: adata,
		dataType: 'html',
		success: function(html) {
			vietiso_loading(0);
			loadCruiseExtension(blog_id);
		}
	});
}

function addDestination(e){
	var $_this = $(e);
	if($SiteModActive_continent == '1') {var $chauluc_id = $('#slb_Chauluc').val();}
	if($SiteModActive_country == '1') {
		var $country_id = $('#slb_Country').val();
		if($country_id!=undefined || $country_id==0){
			var $countryID = $('#slb_Country');
			setSelectOpen($countryID);
		}else{
			$country_id = 1;
		}
	}
	if($SiteActive_region == '1') {var $region_id = $('#slb_RegionID').val();}
	if($SiteActive_city == '1') {var $city_id = $('#slb_CityID').val();}

	/**/
	var adata = {};
	adata['chauluc_id'] = $chauluc_id;
	adata['country_id'] = $country_id;
	adata['region_id'] = $region_id;
	adata['city_id'] = $city_id;
	adata['blog_id'] = $blog_id;

	vietiso_loading(1);
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/?mod='+mod+'&act=ajaxAddMoreBlogDestination',
		data: adata,
		dataType: "html",
		success: function(html){
			vietiso_loading(0);
			if(html.indexOf('_SUCCESS')>=0){
				loadListDestination($blog_id);
			}
			if(html.indexOf('_EXIST')>=0){
				alertify.error(exist_error);
			}
		}
	});
	return 0;
}

function removeDestination(e){
	var $_this = $(e);
	if(confirm(confirm_delete)){
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/?mod='+mod+'&act=ajaxDeleteBlogDestination',
			data:{"blog_destination_id" : $_this.attr('data')},
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				var $country_id = $('#slb_Country').val();
				if($country_id==undefined){
					$country_id = $('#Hid_Country').val();
				}
				if($('#slb_CityID').is(':visible')){
					loadCity($country_id, $('#slb_RegionID').val());
				}
				loadListDestination($blog_id);
			}
		});
		return false;
	}
}
function removeAllDestination(e){
	var $_this = $(e);
	if(confirm(confirm_delete)){
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/?mod='+mod+'&act=ajaxDeleteAllBlogDestination',
			data:{"blog_id" : blog_id},
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				var $country_id = $('#slb_Country').val();
				if($country_id==undefined){
					$country_id = $('#Hid_Country').val();
				}
				if($('#slb_CityID').is(':visible')){
					loadCity($country_id, $('#slb_RegionID').val());
				}
				loadListDestination(blog_id);
			}
		});
		return false;
	}
}