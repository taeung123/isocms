$().ready(function(){
	if(mod=='setting'){
		loadListIP('', 1, 100);
		// Setting IP
	}
	$('#keyword_ip').keyup(function() {
		var $_this = $(this);
		var $keyword = $_this.val();
		var $page = $_this.attr('page');
		var $number_per_page = $('.paginate_length').val();
		loadListIP($keyword, $page, $number_per_page);
	});
	$(document).on('click', '.ajaxConfigIPMode', function(ev){
		var _this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script + '/index.php?mod=setting&act=ajaxFrmCfgIPMode',
			dataType: 'html',
			success: function(html) {
				makepopup('30%', 'auto', html, 'frmLoadConfigBooking');
				vietiso_loading(0);
			}
		});
		return false;
	});
	$(document).on('click', '.ajSaveCfgIPMode', function(ev){
		var $_this = $(this);
		var $config_public_mode = $('input[name=config_public_mode]:checked').val();
		var adata = {'config_public_mode': $config_public_mode};
		/**/
		vietiso_loading(1);
		$.ajax({
			type: 'POST',
			url: path_ajax_script+'/index.php?mod=setting&act=ajaxSaveCfgIPMode',
			data: adata,
			dataType: 'html',
			success: function(html) {
				alertify.success('Save setting success!');
				vietiso_loading(0);
			}
		});
		return false;
	});
	$(document).on('click', '.btnCreateNewIP', function(ev){
		var $_this=$(this);
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+mod+"&act=ajaxFrmIP",
			data: {'tp': $_this.attr('tp')},
			dataType: 'html',
			success: function(html){
				makepopupnotresize(300,'auto',html,'frmPop_FrmIP');
				vietiso_loading(0);
			}
		});
		return false;
	});
	$(document).on('click', '.btn_edit_ip', function(ev){
		var _this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script + "/index.php?mod=" + mod + "&act=ajaxFrmIP",
			data: {"ip_id": _this.attr('data')},
			dataType: 'html',
			success: function(html) {
				makepopupnotresize('30%', 'auto', html, 'frmPop_FrmIP');
				vietiso_loading(0);
			}
		});
		return false;
	});
	$(document).on('click', '#ajSaveIP', function(ev){
		var $_this=$(this);
		var $ip_address = $('input[name=ip_address]');
		var $ip_id = $_this.attr('ip_id');
		/**/
		if($ip_address.val()==''){
			alertify.error(field_is_required);
			$ip_address.focus().addClass('errorRequired');
			return false;
		}
		/**/
		var adata={
			"ip_address"	:	$ip_address.val(),
			"ip_id"	:	$ip_id
		};
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod="+mod+"&act=ajaxSaveIP",
			data: adata,
			dataType: "html",
			success: function(html){
				vietiso_loading(0);
				if(html.indexOf('INSERT_SUCCESS')>=0){
					loadListIP('',1,100);
					alertify.success(insert_success);
				}
				if(html.indexOf('UPDATE_SUCCESS')>=0){
					var $keyword = $('#keyword').val();
					var $page = $('.paginate_current_page').val();
					var $number_per_page = $('.paginate_length').val();
					loadListIP($keyword,$page,$number_per_page);
					alertify.success(update_success);
				}
				if(html.indexOf('IP_EXIST')>=0){
					alertify.error(exist_error);
				}
				if(html.indexOf('ERROR')>=0){
					alertify.error(update_error);
				}
				$_this.closest('.frmPop').find('.close_pop').trigger('click');
			}
		});
		return false;
	});
	$(document).on('click', '.btn_delete_ip', function(ev){
		if (confirm(confirm_delete)) {
			var $_this = $(this);
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url: path_ajax_script + "/index.php?mod=" + mod + "&act=ajaxdeleteOneIP",
				data: {'ip_id': $_this.attr('data')},
				dataType: 'html',
				success: function(html) {
					var $keyword = $('#keyword').val();
					var $page = $('.paginate_current_page').val();
					var $number_per_page = $('.paginate_length').val();
					loadListIP($keyword, $page, $number_per_page);
					alertify.success(delete_success);
					vietiso_loading(0);
				}
			});
			return false;
		}
	});
	/* SEND TEST EMAIL */
	$(document).on("click", ".SiteSendTest", function (ev) {
        var $_this = $(this);
        let email_test = $("#email_test").val();
        if (email_test != "") {
            $("#testmail").html(
                '<i class="fa fa-circle-o-notch fa-spin spin"></i>'
            );
            $.ajax({
                type: "POST",
                url:
                    path_ajax_script +
                    "/index.php?mod=setting&act=ajaxSendMailTest",
                data: { email_test: email_test },
                dataType: "JSON",
                success: function (data) {
                    if (data.status == "success") {
                        $("#testmail").html(
                            '<span class="send_mail_success">Send email success</span>'
                        );
                    } else {
                        $("#testmail").html(
                            `<span class="send_mail_success">Send email error</span>`
                        );
                    }
                },
            });
        } else {
            alert("Please enter email to check send mail");
            $("#email_test").focus();
        }

        return false;
    });
	$(document).on('click', '.btnCreateNewMessage', function(ev){
		var $_this = $(this);
		var $_prefix = $_this.attr('prefix')!=undefined ? $_this.attr('prefix') : '';
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script + "/index.php?mod=setting&act=ajOpenSetting",
			data : {'tp':'F','prefix':$_prefix},
			success: function(html) {
				vietiso_loading(0);
				makepopupnotresize(400, 'auto', html, 'frmPop_FrmIP');
			}
		});
		return false;
	});
	$(document).on('click', '.btnSubmitMessage', function(ev){
		var $_this = $(this);
		var $setting = $('input[name=setting]');
		var $_prefix = $_this.attr('_prefix');
		if($setting.val() == ''){
			$setting.focus();
			alertify.error(field_is_required);
			return false;
		}
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script + "/index.php?mod=setting&act=ajOpenSetting",
			data : {
				'tp':'S',
				'prefix': $_prefix,
				'setting': $setting.val()
			},
			success: function(html) {
				vietiso_loading(0);
				window.location.reload(true);
			}
		});
		return false;
	});
});
function loadListIP($keyword, $page, $number_per_page) {
	var adata = {
		'keyword': $keyword,
		'page': $page,
		'number_per_page': $number_per_page
	};
	$.ajax({
		type: "POST",
		url: path_ajax_script + "/index.php?mod=" + mod + "&act=ajaxLoadListIP",
		data: adata,
		dataType: "html",
		success: function(html) {
			var htm = html.split('$$');
			$('#loadViewHolderBankAccount').html(htm[0]);
			$('#dataTable_paginate').html(htm[1]);
		}
	});
}