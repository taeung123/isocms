<div id="ModalForgotPass" class="modal ng-scope" >
	<div class="boxResetPass">
		<div class="atlas_pop signin ng-scope" ng-controller="ForgotPasswordController">
			<div class="modal-header round-top pie-htc">
				<div class="media man">
					<button type="button" class="close z_16 text-normal text-uppercase" data-dismiss="modal" aria-label="Close">{$core->get_Lang('Close')} <span aria-hidden="true" class="fa fa-times z_18"></span></button>
					<div class="bd">
						<p class="h2 strong pas inverse-txt">{$core->get_Lang('Forgot Your Password')}?</p>
					</div>
				</div>
			</div>
			<div class="modal-body page-bg round-bottom pal">
				<p class="mhn mtn">{$core->get_Lang('We will send instruction for creating a new password to the email address associated with your account')}.</p>
				<div id="message_box" style="display:none"></div>
				<form novalidate="" class="ng-pristine ng-valid">
					<div class="mtm mbm">
						<label for="emailAddress">{$core->get_Lang('Email')}</label>
						<br>
						<input type="email" class="isoTxt required txt350" placeholder="{$core->get_Lang('Your Email')}" name="user_email" value="" />
					</div>
					<div class="line mt10">
						<div class="unitRight">
							<button type="button" id="forgotBtn" class="fl mr10 submitClick">{$core->get_Lang('Reset')} &raquo;</button>
							<input type="hidden" name="forgotVal" value="forgotVal" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var require_email = "{$core->get_Lang('Error &#33; Please enter your email.')}";
var require_invalid_email = "{$core->get_Lang('Error &#33; Please enter your email valid.')}";
var reset_success = "{$core->get_Lang('Reset success &#33; Please check your email and active your account.')}";
</script>
{literal}
<script type="text/javascript">
	$(document).on('click','#forgotBtn',function(e){
		var $_this = $(this);
		var $user_email = $('#ModalForgotPass input[name=user_email]');
		var $forgotVal = $('#ModalForgotPass input[name=forgotVal]');
		/* Valid */
		if($user_email.val()== '' || !checkVaidEmail($user_email.val())){
			$('#ModalForgotPass #message_box').html(require_invalid_email);
			$('#ModalForgotPass #message_box').addClass('message_box').show();
			$user_email.focus();
			return false;
		}
		/**/
		var adata = {
			'user_email': $user_email.val(),
			'forgotVal': $forgotVal.val(),
		};
		$.ajax({
			type: "POST",
			url: path_ajax_script+'/index.php?mod=member&act=ajAjaxForgotGlobal',
			data: adata,
			dataType: "html",
			success: function(html){
			if(html.indexOf('email_empty_error')>=0){
				$('#ModalForgotPass #message_box').html(require_email);
				$('#ModalForgotPass #message_box').addClass('message_box').show();
				$user_email.focus();
				return false;
			}
			if(html.indexOf('email_not_correct')>=0){
				$user_email.focus();
				$('#ModalForgotPass #message_box').html(require_invalid_email);
				$('#ModalForgotPass #message_box').addClass('message_box').show();
				return false;
				}
				if(html.indexOf('reset_success')>=0){
					$('#ModalForgotPass #message_box').html(reset_success);
					$('#ModalForgotPass #message_box').addClass('success_box').show();
					$('#ModalForgotPass input[class=isoTxt]').val('');
					$timer = setTimeout(function(){
						$_this.closest('#ModalForgotPass').find('.close').trigger('click');
					},3000);
				}
				}
		});
		return false;
	});
</script>
{/literal}