$().ready(function() {
	$(document).on('click', '.add_new_category_country', function (ev) {
		ev.preventDefault();
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/index.php?mod=' + mod + '&act=ajActionNewCategoryCountry',
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
		console.log(1);
		loadMainFormStep(table_id, currentstep);
		$('html,body').animate({scrollTop:0}, 500);
		window.history.pushState({href: href}, '', href);
		return false;
	});
	$_document.on('click','.js_save_continue_main_step,.js_save_back_main_step',function(){
		var $_this = $(this),
			$_form = $_this.closest('form'),
			table_id = $_this.data('table_id'),
			currentstep = $_this.data('currentstep'),
			nextstep = $_this.data('next_step');
		
		var _validated = 0;
		if($('input.required,select.required', $_form).length){
			$('input.required,select.required', $_form).each(function(){
				if($Core.util.isEmpty($(this).val())){
					_validated++;
					$(this).focus().addClass("error");
					return false;
				}
			});
		}
		if($_this.hasClass('js_save_back_main_step')){
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
		var currentpanel = $_this.data('panel'),
			nextpanel = $('.stepbar-list>li>a.active').attr('panel'),
			$_href = $('.stepbar-list>li>a.active').data('route');
		if(currentpanel != nextpanel){
			$('.panel--'+currentpanel).find('.panel-heading a').addClass('collapsed');
			$('.panel--'+currentpanel).find('.panel-collapse').removeClass('in');
			$('.panel--'+nextpanel).find('.panel-heading a').removeClass('collapsed');
			$('.panel--'+nextpanel).find('.panel-collapse').addClass('in');
		}
		
		console.log(_validated,'ssss');
		if(parseInt(_validated) == 0){
			$Core.util.toggleIndicatior(0);
			$_form.ajaxSubmit({
				type:'POST',
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajSaveMainStep', 
				data:$.extend(options,{"table_id":table_id,'currentstep':currentstep}),
				dataType:'html',
				success:function(html){
					$Core.util.toggleIndicatior(0);
					if(nextstep !=='_last' && nextstep !=='_first'){
						console.log(2);
						loadMainFormStep(table_id, nextstep);
					} else if(nextstep == '_last'){
						console.log(3);
						loadMainFormStep(table_id, 'generalinformation');

					}
				}
			});
			
			$('.stepbar-list>li>a.active').removeClass('active');
			$('.loadYieldStep[data-step='+nextstep+']').addClass('active');
			window.history.pushState({href: $_href}, '', $_href);
			return false;
		}
	});
});

function loadMainFormStep(table_id,currentstep){
	console.log(table_id,currentstep);
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