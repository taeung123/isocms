<button class="btn btn-primary hidden" data-toggle="modal" data-target="#ads-popup" >Large modal</button>
<section class="box_modal_pop" style="display:none">
	<div id="ads-popup" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-header">
				<button type="button" id="close_modal_reg" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<div class="modal-content">
				<img class="image_bner_pop" src="{$URL_IMAGES}/popup/giao-dien-webiste-du-lich.jpg" alt="" width="100%" height="auto">
				<div class="content_reg_advisory">
					<p class="title_reg_advisory">{$core->get_Lang('Hệ quản trị Website du lịch chuyên biệt')}</p>
					<div class="logo_reg_advisory">
						<img src="{$clsConfiguration->getValue('PopupLogo')}" alt="" width="100%" height="auto">
					</div>
					<div class="clearfix"></div>
					<div class="box_form_fillter_info_reg">
						<div class="col-sm-5 form_poop">
							<div class="form_fillter_info_reg">
								<div class="input-group-reg">
									<input type="text" class="form-control" name="full-name-reg" id="full-name-reg" value="" placeholder="{$core->get_Lang('full-name-reg')}">
									<div class="error_row_fullname_reg"></div>
								</div>
								<div class="input-group-reg">
									<input type="text" class="form-control" name="phone-reg" id="phone-reg" value="" placeholder="{$core->get_Lang('phone-reg')}">
									<div class="error_row_phone_reg"></div>
								</div>
								<div class="input-group-reg">
									<input type="text" class="form-control" name="email-reg" id="email-reg" value="" placeholder="{$core->get_Lang('email-reg')}">
									<div class="error_row_email_reg"></div>
								</div>
								<div class="input-group-reg">
									<textarea name="message-reg" id="message-reg" cols="30" rows="3" class="form-control" placeholder="Lời nhắn"></textarea>
									<div class="error_row_message_reg"></div>
								</div>
								<div class="btn_send_reg_advisory">
									<a href="javascript:void(0);" class="btn_send_info_reg">{$core->get_Lang('reg-advisory')}</a>
								</div>
							</div>
						</div>
						<div class="col-sm-7 hidden"></div>
					</div>
					<p class="hot-line-advisory">{$core->get_Lang('Hotline:')} <span><a href="tel:{$clsConfiguration->getValue('CompanyHotline')}">{$clsConfiguration->getValue('CompanyHotline')}</a></span></p>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="{$URL_JS}/jquery.cookie.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_JS}/jquery.session.js?v={$upd_version}"></script>
<script type="text/javascript">
    var msg_fullname_reg_required = '{$core->get_Lang("msg_fullname_reg_required")}';
    var msg_phone_reg_required = '{$core->get_Lang("msg_phone_reg_required")}';
    var msg_email_reg_required = '{$core->get_Lang("msg_email_reg_required")}';
    var msg_email_valid_reg_required = '{$core->get_Lang("msg_email_valid_reg_required")}';
    var msg_message_reg_required = '{$core->get_Lang("msg_message_reg_required")}';
</script>
{literal}
<script type="text/javascript">
$(function () {
    var date = new Date();
    var minutes = 30;
    date.setTime(date.getTime() + (minutes * 60 * 1000));
    if (!$.cookie("reg-advisory")) {
        setTimeout(function(){
            $('#ads-popup').modal('show');
        }, 10000);
        $('#ads-popup').on('shown.bs.modal', function () {
            $(this).find(".form_fillter_info_reg input[type=text],.form_fillter_info_reg textarea").val("");
            $.cookie("reg-advisory", 1, { expires : date });
        })
    } else {
        $('#clearCookie').show();
    }
    $('.ui-dialog-titlebar-close').click(function () {
        $.cookie("reg-advisory", 1, { expires : date});
    });

    $(".close_modal_reg").on("click",function () {
        $("#ads-popup").find(".form_fillter_info_reg input[type=text],.form_fillter_info_reg textarea").val("");
	});
	$(".btn_send_info_reg").on("click",function () {
		var full_name_reg =  $(".form_fillter_info_reg input[name=full-name-reg]").val();
		var phone_reg =  $(".form_fillter_info_reg input[name=phone-reg]").val();
		var email_reg =  $(".form_fillter_info_reg input[name=email-reg]").val();
		var message_reg =  $(".form_fillter_info_reg textarea[name=message-reg]").val();
		if(full_name_reg.length <=5 || full_name_reg.length >=255){
			$('.error_row_fullname_reg').html(msg_fullname_reg_required).fadeIn().delay(3000).fadeOut();
			return false;
		}
		if(phone_reg.length <=5 || phone_reg.length >=32){
			$('.error_row_phone_reg').html(msg_fullname_reg_required).fadeIn().delay(3000).fadeOut();
			return false;
		}
		if(email_reg.length <=5 || email_reg.length >=255){
			$('.error_row_email_reg').html(msg_email_reg_required).fadeIn().delay(3000).fadeOut();
			return false;
		}
		if(checkValidEmail(email_reg)==false){
			$('.error_row_email_reg').html(msg_email_valid_reg_required).fadeIn().delay(3000).fadeOut();
			return false;
		}
		$.ajax({
			type: 'POST',
			url: path_ajax_script+'/index.php?mod=home&act=ajSendRegAdvisory',
			data:{'fullname': full_name_reg,'phone':phone_reg,'email':email_reg,'message':message_reg},
			dataType:'json',
			success: function(json){
                $("#ads-popup").find(".form_fillter_info_reg input[type=text],.form_fillter_info_reg textarea").val("");
			    if(json.result == 'success'){
                    $(".box_form_fillter_info_reg_new").find(".col-sm-5").addClass("hidden");
					$(".box_form_fillter_info_reg_new").append("<p class='text_success_send_reg'>{/literal}{$core->get_Lang('text_succes_reg')}{literal}</p>");
                }
                setTimeout(function(){
                    $('#ads-popup').modal('hide');
                    $(".box_form_fillter_info_reg_new").find(".col-sm-5").removeClass("hidden");
                    $(".box_form_fillter_info_reg_new").find(".text_success_send_reg").addClass("hidden");
				}, 3000);

			}
		});
    });
    function checkValidEmail(email){
        var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
});
</script>
{/literal}